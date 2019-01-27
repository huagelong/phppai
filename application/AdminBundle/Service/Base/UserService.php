<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/12/19
 * Time: 21:42
 */

namespace Admin\Service\Base;

use Lib\Base\BaseService;
use Lib\Support\Error;
use Lib\Support\UUid;
use Md\MDAvatars;

final class UserService extends BaseService
{

    /**
     * @var \Admin\Dao\System\UserDao
     */
    public $userDao;

    /**
     * @var \Admin\Dao\Access\UserRoleDao
     */
    public $userRoleDao;

    /**
     * @var \Admin\Dao\Access\RoleDao
     */
    public $roleDao;

    /**
     * @var \Admin\Dao\Access\AccessDao
     */
    public $accessDao;

    /**
     * @var \Admin\Service\AccountService
     */
    public $accountService;

    /**
     * @var \Admin\Service\Base\AccessService
     */
    public $accessService;

    /**
     * @var \Lib\Service\FileService
     */
    public $fileService;

    const DEFAULE_ROLE_ID=1;//默认会员id


    public function getList($searchField, $searchValue, $page=1, $pageSize=20){
        $data = [];
        if($searchValue) $data[$searchField] = ["like", "%".$searchValue."%"];
        $data['is_admin'] = ["!=", 2];
        list($list,$count, $totalPage) =  $this->userDao->pager($data, $page, $pageSize, "created_at DESC");
        //角色
        if($list){
            foreach ($list as &$v){
                $uid = $v['id'];
                $rolesIds = $this->userRoleDao->getField("role_id", ['uid'=>$uid], true);
                $rolesInfo = [];
                if($rolesIds){
                    $where = [];
                    $where['id'] = ['in', $rolesIds];
                    $rolesInfo = $this->roleDao->gets($where);
                }
                $v['roles'] = $rolesInfo;
            }
        }

        return [$list, $totalPage];
    }

    public function getAllUsers()
    {
        $data = [];
        $data['is_admin'] = ["!=", 2];
        return $this->userDao->gets($data);
    }

    public function getUserById($uid)
    {
        $info = $this->userDao->get(['id'=>$uid]);
        if($info){
            $rolesIds = $this->userRoleDao->getField("role_id", ['uid'=>$uid], true);
            $rolesInfo = [];
            if($rolesIds){
                $where = [];
                $where['id'] = ['in', $rolesIds];
                $rolesInfo = $this->roleDao->gets($where);
            }
            $info['roles'] = $rolesInfo;
            $info['roles_id'] = $rolesIds;
        }
        return $info;
    }

    public function getUserAccess($uid)
    {
        $info = $this->userDao->get(['id'=>$uid]);
        if($info['is_admin'] == 2){
            $config = $this->config()->get("access");
            $access = [];
            if($config){
                foreach ($config as $k=>$v){
                    $first = $v[0];
                    if($first == '-'){
                        continue;
                    }
                    $access[] = $first;
                }
            }
            return $access;
        }else{
            $rolesIds = $this->userRoleDao->getField("role_id", ['uid'=>$uid], true);
            if(!$rolesIds) return [];
            $access = $this->accessDao->getField("access", ['role_id'=>["in",$rolesIds]], true);
            if(!in_array("admin::index/index", $access)) $access[]="admin::index/index";
            if(!in_array("admin::user@index/setting", $access)) $access[]="admin::user@index/setting";
            if(!in_array("admin::user@index/crop", $access)) $access[]="admin::user@index/crop";
            if(!in_array("admin::user@index/modifiPwd", $access)) $access[]="admin::user@index/modifiPwd";
            return $access;
        }

    }

    public function checkUsername($username, $id=0)
    {
        $where = [];
        $where['username'] = $username;
        if($id) $where['id'] = ['!=', $id];
        return $this->userDao->get($where);
    }

    public function checkNickname($nickName, $id=0)
    {
        $where = [];
        $where['display_name'] = $nickName;
        if($id) $where['id'] = ['!=', $id];
        $result = $this->userDao->get($where);
        if($result) return Error::add("昵称已存在!");

        $words = [
            "admin",
            "Admin",
            "超级管理员",
            "system",
            "System",
            "superadmin",
            "superAdmin"
        ];

        if(in_array($nickName, $words)) return Error::add("昵称已存在!");

        return false;
    }

    public function getUserByDisplayName($displayName)
    {
        $where = [];
        $where['display_name'] = $displayName;
        return $this->userDao->get($where);
    }

    public function getUserByEmail($email)
    {
        $where = [];
        $where['email'] = $email;
        return $this->userDao->get($where);
    }


    /**
     * 添加用户
     *
     * @param $email
     * @param $nickname
     * @param $pwd
     * @param $isGm
     * @param $report_uid
     * @return mixed
     */
    public function addUser($username, $nickname, $pwd, $isGm, $role, $report_uid)
    {
        if(!$role) $role=[self::DEFAULE_ROLE_ID];
        $data = [];
        $data['username'] = $username;
        $data['display_name'] = $nickname;
        $data['passwd'] = $this->accountService->md5($pwd);
        $data['is_admin'] = $isGm;
        $data['report_uid'] = $report_uid;
        $uid = $this->userDao->autoAdd($data);
        if(!$uid) return false;
        //插入角色表
        if($isGm && $role){
            foreach ($role as $roleId){
                $idata = [];
                $idata['uid'] = $uid;
                $idata['role_id'] = $roleId;
                $this->userRoleDao->autoAdd($idata);
            }
        }
        return $uid;
    }

    /**
     * 生成默认头像
     * @param $uid
     */
    public function createDefaultFace($uid)
    {
        $info = $this->userDao->get(['id'=>$uid]);
        if(!$info) return null;
        $displayName = $info['display_name'];
        $tmpPath = STORAGE_PATH."/tmp/upload/";

        if(!is_dir($tmpPath)){
            mkdir($tmpPath, 0777 , true);
        }
        try{
            $uuid = UUid::getUuid("face".$uid);
            $upfilePath = $tmpPath.$uuid.".png";
            $obj = new MDAvatars($displayName, 64);
            $filePath = $obj->Save($upfilePath);
            if($filePath){
                 $uri = $this->updateUserFace($uid, $upfilePath);
                 if($uri) return $uri;
            }
            $this->saveDefaultFace($uid);
            return null;
        }catch (\Exception $e){
            //更新
            $this->saveDefaultFace($uid);
            return null;
        }
    }

    public function updateUserFace($uid, $upfilePath)
    {
        $groupCode = "face";
        $originalName = pathinfo($upfilePath, PATHINFO_BASENAME);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $newFilename = sha1(uniqid() . $originalName);
        $remoteFilePath = $groupCode."/".date('Y/m/d')."/".$newFilename.".".$ext;
        list($fileId, $uri) = $this->fileService->push($upfilePath, $remoteFilePath, $groupCode, $uid, $originalName);
        if($uri){
            @unlink($upfilePath);
            $this->fileService->bindTarget($fileId, $groupCode, $uid);
            //更新
            $udata=[];
            $udata['face_img'] = $uri;
            $this->userDao->autoUpdate($udata, ['id'=>$uid]);
            return $uri;
        }
        return false;
    }

    protected function saveDefaultFace($uid)
    {
        $host = $this->getDbOption('base','site_host');
        $defaultUrl = "//".$host."/static/images/defaultFace.jpeg";
        //更新
        $udata=[];
        $udata['face_img'] = $defaultUrl;
        $this->userDao->autoUpdate($udata, ['id'=>$uid]);
    }


    public function updateUser($uid, $username, $nickname, $isGm, $role, $report_uid)
    {
        $data = [];
        $data['username'] = $username;
        $data['display_name'] = $nickname;
        $data['is_admin'] = $isGm;
        $data['report_uid'] = $report_uid;
        $this->userDao->autoUpdate($data, ['id'=>$uid]);
        //先删除角色
        $this->userRoleDao->delete(['uid'=>$uid]);
        //插入角色表
        if($isGm){
            if($role){
                foreach ($role as $roleId){
                    $idata = [];
                    $idata['uid'] = $uid;
                    $idata['role_id'] = $roleId;
                    $this->userRoleDao->autoAdd($idata);
                }
            }
        }
        return true;
    }

    public function updatePwd($uid, $pwd)
    {
        $data = [];
        $data['passwd'] = $this->accountService->md5($pwd);
        $this->userDao->autoUpdate($data, ['id'=>$uid]);
        return true;
    }

    public function checkPwd($uid, $pwd)
    {
        $data = [];
        $data['passwd'] = $this->accountService->md5($pwd);
        $data['id'] = $uid;
        return $this->userDao->get($data);
    }

    public function getRoles()
    {
        $data = $this->accessService->getRoles();
        if(!$data) return $data;
        $ret = [];
        foreach ($data as $v){
            $tmp = [];
            $tmp['id'] = $v['id'];
            $tmp['text'] = $v['name'];
            $ret[] = $tmp;
        }
        return $ret;
    }

    public function lock($uid)
    {
        $info = $this->userDao->get(['id'=>$uid]);
        $udata = [];
        $udata['is_lock'] = (int) !$info['is_lock'];
        return $this->userDao->autoUpdate($udata, ['id'=>$uid]);
    }
}

