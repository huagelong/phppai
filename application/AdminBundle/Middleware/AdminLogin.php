<?php
/**
 * 登录检查
 * Date: 16/12/19
 * Time: 下午4:30
 */

namespace Admin\Middleware;


use Admin\Service\AccountService;
use Lib\Base\BaseController;
use Admin\Service\CommonService;
use Trensy\Di;
use Trensy\Log;

final class AdminLogin extends Base
{

    /**
     * @var \Admin\Service\AccountService
     */
    public  $accountService;

    public function before()
    {
        $request  = $this->getRequest();
        $response  = $this->getResponse();

        $login = $this->accountService->getLogin();
        if(!$login){
            $realUrl = $this->getRequest()->server->get('REQUEST_URI');
            $realUrl_arr = explode('?', $realUrl);
            $realUrl = $realUrl_arr[0];
            $query = $this->getRequest()->server->get('QUERY_STRING');
            if($query){
                $realUrl = $realUrl."?".$query;
            }
//            debug($this->getRequest()->server);
            $loginUrl = $this->url('admin::account/login');
            $realUrl = urlencode($realUrl);
            $goto = $loginUrl."?goto=".$realUrl;

            if($request->isXmlHttpRequest()){
                $definition = [];
                $definition['request'] = $request;
                $definition['response'] = $response;
                $definition['view'] = $response->view;
                $controllerObj = Di::get(BaseController::class,[],$definition);
                $controllerObj->responseError("请先登录!",$this->url('admin::account/login'));
            }else{
                if($request->getMethod() == 'GET'){
                    $response->redirect($goto);
                }else{
                    $response->redirect($loginUrl);
                }
            }
            return false;
        }
        return true;
    }

    public function after()
    {
    }
}