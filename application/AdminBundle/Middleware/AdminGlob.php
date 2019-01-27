<?php
/**
 * User: Peter Wang
 * Date: 16/12/26
 * Time: 下午2:20
 */

namespace Admin\Middleware;


use Admin\Service\AccountService;
use Trensy\Mvc\Route\RouteMatch;

final class AdminGlob  extends Base
{

    private $accountService;


    public function __construct(AccountService $accountService)
    {

        $this->accountService = $accountService;
    }

    public function before()
    {
        $request  = $this->getRequest();
        $response  = $this->getResponse();

        $login = $this->accountService->getLogin();
        $response->view->objUser = $this->accountService;
        $response->view->userinfo = $login;

        $response->view->siteName = "后台管理系统";//todo

        //js
        $jsParams = [];
        $jsParams['welcome_page'] = $this->url("admin::index/index");
        $jsParams['upyun_url'] = $this->url("glob::file/upyun");

        $response->view->jsParams = $jsParams;

        $response->view->sidebarClosed = $this->getCookie('sidebar_closed');
//        vardump((int) $this->getCookie('sidebar-toggle'));
        if($request->cookies->has('sidebar-toggle')){
            $sidebarToggle = (int) $this->getCookie('sidebar-toggle')?"":"sidebar-collapse";
        }else{
            $sidebarToggle = "";
        }
        $response->view->sidebarToggle = $sidebarToggle;

        $match = RouteMatch::getDispatch();
        $routeName = isset($match['routeName'])?$match['routeName']:null;

        if($routeName == "admin::index/index"){
            $response->cookie('navactive',$routeName, 86400, '/');
        }

        $response->view->routeName = $routeName;

        return true;
    }

    public function after()
    {
    }
}