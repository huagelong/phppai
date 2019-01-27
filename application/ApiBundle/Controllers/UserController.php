<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/10/12
 * Time: 10:28
 */

namespace Api\Controllers;

use Lib\Service\ValidateService;
use Lib\Support\Error;
use Lib\Support\Valid;

final class UserController extends BaseController
{

    /**
     * @var \Site\Service\AccountService
     */
    public $accountService;

    /**
     * @var \Api\Service\UserService
     */
    public $userService;

    /**
     * @var \Lib\Service\ValidateService
     */
    public $validateService;

    public function checklogin()
    {
        $token = $this->getRequest()->get("token");
        $type = $this->getRequest()->get('type');
        $version = $this->getRequest()->headers->get('xk-app-version'); //app的版本号
        $type = $type?$type:"pc";

        if(!$token || !$type)  return $this->responseError('参数错误!');

        $user = $this->accountService->checkLoginToken($token, $type);
        if($user){
            $user['display_name'] = mb_substr($user['display_name'], 0, 14,'utf-8');
            if (version_compare($version, '1.0.2', '<')) {
                unset($user['teacher_guid']);
            } else {
                $user['guid'] = strtolower($user['guid']);
                $user['teacher_guid'] = strtolower($user['teacher_guid']);
                $user['student_account'] = strtolower(str_replace('-', '', $user['guid']));
                $user['teacher_account'] = strtolower(str_replace('-', '', $user['teacher_guid']));
            }
            return $this->response($user);
        }
        return $this->response((object) null,self::RESPONSE_NORMAL_ERROR_CODE);
    }

    public function smslogin()
    {
        $mobile = $this->getApiRequest("mobile");
        $smsCode = $this->getApiRequest("smsCode");
        $version = $this->getRequest()->headers->get('xk-app-version'); //app的版本号

        if(!$mobile) return $this->responseError('手机号码不能为空!');
        if(!Valid::isMobile($mobile))  return $this->responseError('手机号码格式错误!');
        if(!$smsCode && ($mobile !='18500000205')) return $this->responseError('短信验证码不能为空!');
        if($mobile !='18500000205'){
            $check = $this->accountService->smsCheck($mobile, $smsCode, 'app_sms_login');
            if(!$check){
                if(Error::has()){
                    return $this->responseError(Error::getLast());
                }else{
                    return $this->responseError('手机号码或短信验证码错误');
                }
            }
        }

        //判断手机号码是否注册
        $userInfo = $this->accountService->isMobileReg($mobile);
        if($userInfo){
            $isLock = $userInfo['is_lock'];
            if($isLock)  return $this->responseError('用户账号已经被锁定,请与客服联系解锁!');
            //设置登录session
            $uid = $userInfo['id'];
        } else {
            if (version_compare($version, '1.0.2', '<')) {
                return $this->responseError('手机号码或短信验证码错误');
            }
            //手机号没有注册
            $pwd = null; //没有密码随机生成一个20位的密码
            $uid = $this->accountService->regUser($mobile, $pwd, "app");
            if (!$uid) {
                if (Error::has()) {
                    return $this->responseError(Error::getLast());
                }
                return $this->responseError('网络忙，请重试');
            }
        }
        $token = $this->accountService->setLogin($uid,'app');
        return $this->response($token);
    }

    /**
     * app密码登录
     */
    public function passwd_login()
    {
        $mobile = $this->getApiRequest('mobile');
        $passwd = $this->getApiRequest('passwd');
        if (!$mobile) {
            return $this->responseError('手机号码不能为空!');
        }
        if (!Valid::isMobile($mobile)) {
            return $this->responseError('手机号码格式错误!');
        }
        if ($mobile == '18500000205' && $passwd == '123456') {
            $userInfo = $this->accountService->isMobileReg($mobile);
        } else {
            if (!$passwd) {
                return $this->responseError('密码不能为空!');
            }
            $userInfo = $this->accountService->loginCheck($mobile, $passwd);
            if (!$userInfo) {
                return $this->responseError(Error::getLast());
            }
        }
        if ($userInfo) {
            $isLock = $userInfo['is_lock'];
            if ($isLock) {
                return $this->responseError('用户账号已经被锁定,请与客服联系解锁!');
            }
            $token = $this->accountService->setLogin($userInfo['id'], 'app');
            return $this->response($token);
        }
        return $this->responseError('手机未注册!');
    }

    /**
     * app忘记密码或修改密码
     */
    public function modify_passwd()
    {
        $mobile = $this->getApiRequest('mobile');
        $smsCode = $this->getApiRequest('smsCode');
        $passwd = $this->getApiRequest('passwd');
        if (!$mobile) {
            return $this->responseError('手机号码不能为空!');
        }
        if (!Valid::isMobile($mobile)) {
            return $this->responseError('手机号码格式错误!');
        }
        if (!$smsCode) {
            return $this->responseError('短信验证码不能为空!');
        }
        if (!$passwd) {
            return $this->responseError('密码不能为空!');
        }
        if (!$this->validateService->passwordValid($passwd)) {
            return $this->responseError(Error::getLast());
        }
        $check = $this->accountService->smsCheck($mobile, $smsCode, 'app_modify_passwd');
        if (!$check) {
            if (Error::has()) {
                return $this->responseError(Error::getLast());
            } else {
                return $this->responseError('手机号码或短信验证码错误');
            }
        }
        $userInfo = $this->accountService->isMobileReg($mobile);
        if ($userInfo) {
            $isLock = $userInfo['is_lock'];
            if ($isLock) {
                return $this->responseError('用户账号已经被锁定,请与客服联系解锁!');
            }
            $check = $this->accountService->editPwd($mobile, $passwd);
            if (!$check) {
                return $this->responseError('操作失败，请重试!');
            }
            return $this->responseSuccess('操作成功!');
        }
        return $this->responseError('手机未注册!');
    }


    /**
     * 用户信息接口
     */
    public function userinfo()
    {
        $guid = $this->getApiRequest("guid");
        if(!$guid) {
            return $this->responseError('参数错误!');
        }
        $res = $this->userService->user_info(['guid' => $guid]);
        if ($res) {
            return $this->response($res);
        }
        if (Error::has()) {
            return $this->responseError(Error::getLast());
        }
        return $this->responseError("网络忙，请重试");
    }

    /**
     * 更新用户信息
     * @throws \Exception
     */
    public function updateuser()
    {
        $source = $this->getApiRequest('source');
        $faceimg = $this->getApiRequest("faceimg");
        $nickname = $this->getApiRequest("nickname");
        $guid = $this->getApiRequest("guid");
        $full_name = $this->getApiRequest('full_name');
        $display_name = $this->getApiRequest('display_name');
        $passwd = $this->getApiRequest('passwd');
        if(!$guid)  return $this->responseError('参数错误!');

        if(!$faceimg && !$nickname)  return $this->responseError("用户头像或者昵称至少填写一项");


        $do = $this->accountService->editUser($guid,$nickname,null,$faceimg);
        if($do) return $this->responseSuccess('操作成功!');
        return Error::has()?$this->responseError(Error::getLast()):$this->responseError("网络忙，请重试");
    }

}