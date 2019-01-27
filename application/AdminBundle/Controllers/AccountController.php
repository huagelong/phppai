<?php
/**
 * 账户相关
 * User: Peter Wang
 * Date: 17/2/3
 * Time: 下午2:06
 */

namespace Admin\Controllers;


use Lib\Service\CaptchaService;
use Lib\Service\ValidateService;

final class AccountController extends BaseController
{
    /**
     * @var \Admin\Service\AccountService
     */
    public $accountService;

    /**
     * @var \Lib\Service\CaptchaService
     */
    public $captchaService;


    public function whiteActions(){
        return ["adminaccess"=>['login', 'logout'],"adminlogin"=>['login', 'logout']];
    }

    /**
     * 登录
     */
    public function login(){
        $this->accountService->logout();
        $check = $this->request->isMethod('post');
        $cookieMobile = $this->request->cookies->get("login_username");
        $goto = $this->getRequest()->get("goto");
        $mustRecaptcha = 0;
        if($cookieMobile){
            $mustRecaptcha = !$this->accountService->loginErrorCheck($cookieMobile)?1:0;
        }
        $this->view->loginUsername = $cookieMobile;
        $this->view->mustRecaptcha = $mustRecaptcha;
        $this->view->goto = $goto;

        if($check){

            $username = $this->getRequest()->get("username");
            $pwd = $this->getRequest()->get("pwd");
            $captcha = $this->getRequest()->get("captcha");
            if(!$username){
                return $this->responseError("账户不能为空!");
            }

            $this->response->cookie("login_username",$username);

            if(!$pwd){
                return $this->responseError("密码不能为空!");
            }

            if(!$captcha){
                return $this->responseError("验证码不能为空!");
            }

            $recaptchaCheck = $this->captchaService->check($captcha, 'site_login');
            if(!$recaptchaCheck) return $this->responseError('图形验证码错误!');

            if(!$userInfo=$this->accountService->loginCheck($username, $pwd)){
                return $this->responseError("账户或者密码错误!");
            }

            //判断用户是否被锁定
            if($userInfo['is_lock'])  return $this->responseError("用户已经被锁定，请联系管理员解锁!");

            //设置登录session
            $this->accountService->setLogin($userInfo['id']);

            $this->captchaService->clear("site_login");

            //清空错误次数
            $this->accountService->loginErrorClear($username);
            $this->accountService->setRememberMe($userInfo['id']);

            $goto = $goto?$goto:'/';
            $goto = urldecode($goto);

            return $this->responseSuccess("登录成功!正在跳转中...", $goto);
        }

        $this->display("admin::account/login");
    }

    /**
     * 退出
     */
    public function logout()
    {
        $this->accountService->logout();

        $this->response->cookie("topmenu", '', -1, "/");

        $this->response->redirect($this->url('admin::account/login'));
    }
}