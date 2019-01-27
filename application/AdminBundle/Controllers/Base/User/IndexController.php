<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/12/19
 * Time: 21:41
 */

namespace Admin\Controllers\Base\User;


use Lib\Service\ValidateService;
use Lib\Support\Valid;
use Admin\Controllers\BaseController;
use Lib\Support\UUid;

final class IndexController extends BaseController
{

    /**
     * @var \Admin\Service\Base\UserService
     */
    public $userService;

    /**
     * @var \Admin\Service\AccountService;
     */
    public $accountService;

    /**
     * @var \Admin\Service\Base\AccessService
     */
    public $accessService;


    public function index()
    {
        $searchField = $this->getRequest()->get("searchField");
        $searchValue = $this->getRequest()->get("searchValue");

        $page = (int) $this->getRequest()->get("p");
        $page = $page?$page:1;
        $pageSize = 20;
        list($list, $totalPage) = $this->userService->getList($searchField, $searchValue, $page, $pageSize);

        $this->view->list = $list;
        $this->view->totalPage = $totalPage;
        $this->view->page = $page;
        $this->view->route = "admin::base@user@index/index";
        $params = [];
        if($searchValue) $params[$searchField] = $searchValue;
        $this->view->params = $params;

        $this->view->searchValue = $searchValue;
        $this->view->searchField = $searchField;

        $this->display("admin::base/user/index/index");
    }

    public function add()
    {
        $allUsers = $this->accessService->getAllUser();
        $this->view->users =  json_encode($allUsers, JSON_UNESCAPED_UNICODE);
        $this->view->roleData = $this->userService->getRoles();

        $this->display("admin::base/user/index/add");
    }


    public function doadd()
    {
        $username = $this->getRequest()->get("username");
        $nickname = $this->getRequest()->get("nickname");
        $pwd = $this->getRequest()->get("pwd");
        $isgm = 1;
        $role = $this->getRequest()->get('role');
        $report_uid = $this->getRequest()->get('report_uid', '1');

        if(!$username) return $this->responseError("账号不能为空!");
        if(!$nickname) return $this->responseError("昵称不能为空!");
        if(!$pwd) return $this->responseError("密码不能为空!");

        if($isgm){
            if(!$role) return $this->responseError("您添加的是一个管理员，请给管理员赋一个角色!");
        }


        if($this->userService->checkUsername($username)){
            return $this->responseError("账号已存在!");
        }

        if($this->userService->checkNickname($nickname)){
            return $this->responseError("昵称已存在!");
        }


        $this->userService->addUser($username, $nickname, $pwd, $isgm, $role, $report_uid);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@user@index/index'));
    }

    public function edit($id)
    {
        $allUsers = $this->accessService->getAllUser();
        $this->view->users =  json_encode($allUsers, JSON_UNESCAPED_UNICODE);
        $info = $this->userService->getUserById($id);
        if(!$info) $this->responseRedirect($this->url('admin::base@user@index/index'));
        $report_info = $this->userService->getUserById($info['report_uid']);
        $info['report_name'] = '管理员';
        if (isset($report_info['display_name'])) {
            $info['report_name'] = $report_info['display_name'];
        }
        $this->view->info = $info;
        $this->view->roleData = $this->userService->getRoles();
        $this->display("admin::base/user/index/edit");
    }

    public function doedit($id)
    {
        $info = $this->userService->getUserById($id);
        if(!$info) $this->responseError("用户不存在",$this->url('admin::base@user@index/index'));

        $username = $this->getRequest()->get("username");
        $nickname = $this->getRequest()->get("nickname");
        $isgm = 1;
        $role = $this->getRequest()->get('role');
        $report_uid = $this->getRequest()->get('report_uid', '1');

        if(!$username) return $this->responseError("账号不能为空!");
        if(!$nickname) return $this->responseError("昵称不能为空!");

        if($isgm){
            if(!$role) return $this->responseError("您更新的是一个管理员，请给管理员赋一个角色!");
        }


        if($this->userService->checkUsername($username, $id)){
            return $this->responseError("账号已存在!");
        }

        if($this->userService->checkNickname($nickname, $id)){
            return $this->responseError("昵称已存在!");
        }

        $this->userService->updateUser($id, $username, $nickname, $isgm, $role, $report_uid);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@user@index/index'));
    }


    public function lock($id)
    {
        $info = $this->userService->getUserById($id);
        if(!$info) $this->responseError("用户不存在",$this->url('admin::base@user@index/index'));
        $this->userService->lock($id);
        return $this->responseSuccess("操作成功!", $this->url('admin::base@user@index/index'));
    }

    public function editpwd($id)
    {
        $info = $this->userService->getUserById($id);
        if(!$info) $this->responseRedirect($this->url('admin::base@user@index/index'));
        $this->view->info = $info;
        $this->display("admin::base/user/index/editpwd");
    }

    public function doeditpwd($id)
    {
        $info = $this->userService->getUserById($id);
        if(!$info) $this->responseError("用户不存在",$this->url('admin::base@user@index/index'));
        $newpwd = $this->getRequest()->get("newpwd");
        $pwd = $this->getRequest()->get("pwd");

        $currentUser = $this->getCurrentUser();

        $uid = $currentUser['id'];

        $checkPwd = $this->accountService->checkPwd($uid, $pwd);
        if(!$checkPwd) $this->responseError("操作人密码错误!");

        $this->userService->updatePwd($id, $newpwd);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@user@index/index'));
    }

    public function setting()
    {
        $this->view->userInfo = $this->getCurrentUser();
        $this->display("admin::base/user/index/setting");
    }

    public function crop()
    {
        $x = $this->getRequest()->get("x");
        $y = $this->getRequest()->get('y');
        $w = $this->getRequest()->get('w');
        $h = $this->getRequest()->get('h');
        $yunurl = $this->getRequest()->get('yunurl');

        if($x == "" ||$y == "" ||$w == "" ||$h == "" || $yunurl=='')
        {
            return $this->responseError('没有变更!');
        }

        try{
            $userInfo = $this->getCurrentUser();
            $uid = $userInfo['id'];

            $imgContent = file_get_contents("http:".$yunurl);

            $ext = pathinfo($yunurl,PATHINFO_EXTENSION);
            $uuid = UUid::getUuid();
            $src = STORAGE_PATH."/tmp/upload/".$uuid.".".$ext;
            file_put_contents($src, $imgContent);

            $targ_w = $targ_h = 64;
            $jpeg_quality = 9;

            $img = getimagesize($src);
            switch ($img[2]) {
                case 1:
                    $img_r = @imagecreatefromgif($src);
                    break;
                case 2:
                    $img_r = @imagecreatefromjpeg($src);
                    break;
                case 3:
                    $img_r = @imagecreatefrompng($src);
                    break;
                default:
                    $img_r = @imagecreatefromjpeg($src);
            }

            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

            imagecopyresampled($dst_r,$img_r,0,0,$x,$y,
                $targ_w,$targ_h,$w,$h);
            header('Content-type: image/jpeg');

            $uuid2 = UUid::getUuid();
            $src2 = STORAGE_PATH."/tmp/upload/".$uuid2.".png";
            imagepng($dst_r,$src2,$jpeg_quality);
            imagedestroy($dst_r);
            $this->userService->updateUserFace($uid, $src2);
            return $this->responseSuccess("保存成功!", $this->url('admin::base@user@index/setting'));
        }catch (\Exception $e){
            return $this->responseError("操作失败，请重试!".$e->getMessage());
        }
    }

    public function modifiPwd()
    {
        $oldpwd = $this->getRequest()->get('oldpwd');
        $pwd1 = $this->getRequest()->get('pwd1');
        $pwd2 = $this->getRequest()->get('pwd2');

        if(!$oldpwd) return $this->responseError("当前密码不能为空!");
        if(!$pwd1) return $this->responseError("新密码不能为空!");
        if($pwd1 != $pwd2)  return $this->responseError("两次密码不相等!");

        $userInfo = $this->getCurrentUser();
        if(!$this->userService->checkPwd($userInfo['id'], $oldpwd)) return $this->responseError("当前密码不正确!");
        $this->userService->updatePwd($userInfo['id'], $pwd2);
        return $this->responseSuccess("更改密码成功!", $this->url('admin::base@user@index/setting'));
    }
}