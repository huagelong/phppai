<?php
/**
 * 权限检查
 * Date: 16/12/19
 * Time: 下午4:30
 */

namespace Admin\Middleware;


use Admin\Service\AccountService;
use Lib\Base\BaseController;
use Trensy\Mvc\Route\RouteMatch;
use Trensy\Flash;
use Trensy\Di;

final class AdminAccess extends Base
{
    private $accountService;
    /**
     * @var \Admin\Service\Base\UserService
     */
    public $userService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function before()
    {
        $request  = $this->getRequest();
        $response  = $this->getResponse();

        $login = $this->accountService->getLogin();
        if($login){
            $uid = $login['id'];
            $definition = [];
            $definition['request'] = $request;
            $definition['response'] = $response;
            $definition['view'] = $response->view;
            $controllerObj = Di::get(BaseController::class,[],$definition);
            if(!$login['is_admin']){
                if($request->isXmlHttpRequest()){
                    $controllerObj->responseError("你没有权限进行此操作!", $this->url('admin::account/login'));
                }else{
                    return $response->redirect($this->url("admin::account/login"));
                }
            }
            $check = $this->checkRight($uid);
            if(!$check){
                if($request->isXmlHttpRequest()){
                    $controllerObj->responseError("你没有权限进行此操作!", $this->url('admin::index/msg'));
                    return false;
                }else{
                    Flash::error("你没有权限进行此操作!");
                    $response->redirect($this->url("admin::index/msg"));
                }
            }
            return true;
        }
        return false;
    }

    protected function checkRight($uid)
    {
        $match = RouteMatch::getDispatch();
        $routeName = isset($match['routeName'])?$match['routeName']:null;
        if($routeName){
            $access = $this->userService->getUserAccess($uid);
            return in_array($routeName, $access);
        }
        return true;
    }

    public function after()
    {
    }
}