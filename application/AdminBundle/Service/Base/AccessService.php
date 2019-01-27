<?php
/**
 *  导航服务
 *
 * User: wangkaihui
 * Date: 2017/11/10
 * Time: 16:24
 */

namespace Admin\Service\Base;


use Lib\Base\BaseService;

final class AccessService extends BaseService
{
    /**
     * @var \Admin\Dao\Access\RoleDao
     */
    public $roleDao;

    /**
     * @var \Admin\Dao\Access\AccessDao
     */
    public $accessDao;

    /**
     * @var \Admin\Dao\System\UserDao
     */
    public $userDao;

    public function allAccess()
    {
        $config = $this->config()->get("access");
        $ret = [];
        foreach ($config as $k=>$v){
            $ret[$v[0]] = $v[1];
        }
        return $ret;
    }

    public function loadAccess(){
        $config = $this->config()->get("access");
        if(!$config) return [];
        $ret = [];
        $preKey = "";
        foreach ($config as $k=>$v){
            $first = $v[0];
            $second = $v[1];
            if($first == '-'){
                $preKey = $second;
                continue;
            }
            if($preKey){
                $ret[$preKey][] = $v;
            }else{
                $ret['全局'][] = $v;
            }
        }
        return $ret;
    }

    public function checkRole($name, $id=0)
    {
        $data = [];
        $data['name'] = $name;
        if($id) $data['id'] = ['!=', $id];
        return $this->roleDao->get($data);
    }

    public function getList($searchField, $searchValue, $page=1, $pageSize=20)
    {
        $data = [];
        if($searchValue) $data[$searchField] = ["like", "%".$searchValue."%"];
        list($list,$count, $totalPage) =  $this->roleDao->pager($data, $page, $pageSize, "created_at DESC");

        return [$list, $totalPage];
    }

    public function getById($id)
    {
        $data = [];
        $data['id'] = $id;
        $ret = $this->roleDao->get($data);

        $access = $this->accessDao->getField("access", ['role_id'=>$id], true);

        $ret['access'] = $access;

        return $ret;
    }

    /**
     * 添加角色
     *
     * @param $name
     * @param $descr
     */
    public function addRole($name, $descr)
    {
        $data = [];
        $data['name'] = $name;
        $data['descr'] = $descr;
        return $this->roleDao->autoAdd($data);
    }

    public function updateRole($name, $descr, $id)
    {
        $data = [];
        $data['name'] = $name;
        $data['descr'] = $descr;
        return $this->roleDao->autoUpdate($data, ['id'=>$id]);
    }

    public function delById($id)
    {
        $data = [];
        $data['id'] = $id;
        return $this->roleDao->delete($data);
    }


    /**
     * 更新权限
     *
     * @param $roleId
     * @param $access
     * @return bool
     */
    public function updateAccess($roleId, $access)
    {
        $delWhere = [];
        $delWhere['role_id'] = $roleId;
        $this->accessDao->delete($delWhere);

        if($access){
            foreach ($access as $v){
                $insertData = [];
                $insertData['role_id'] = $roleId;
                $insertData['access'] = $v;

                $this->accessDao->autoAdd($insertData);
            }
        }

        return true;
    }

   public function getRoles()
   {
       return $this->roleDao->gets();
   }


   public function getReportRelations($reportUid=1)
   {
        if($reportUid ==1) {
            $allData = [];
            $allData['name'] = "管理员";
            $allData['id'] = 1;
            $allData['children'] = [];
            $uids = $this->userDao->getField("id", ["report_uid" => 1], true);
//            debug($uids);
            if ($uids) {
                foreach ($uids as $uid) {
                    $tmp = $this->getReportRelations($uid);
                    $allData['children'][] = $tmp;
                }
            }
            return $allData;
        }else{
                $userInfo = $this->userDao->get(["id"=>$reportUid]);
                 $allData = [];
                $allData['name'] = $userInfo['display_name'];
                $allData['id'] = $reportUid;
                $allData['children'] = [];
                $uids = $this->userDao->getField("id",["report_uid"=>$reportUid], true);
                if ($uids) {
                    foreach ($uids as $uid) {
                        $tmp = $this->getReportRelations($uid);
                        $allData['children'][] = $tmp;
                    }
                }
                return $allData;
        }

   }

   public function getAllUser()
   {
       $users = $this->userDao->gets();
       if($users){
           foreach ($users as &$v){
               unset($v['passwd']);
           }
       }
       return $users;
   }


   public function updateReport($reportUid, $uid)
   {
       $data = [];
       $data['report_uid'] = $reportUid;

       return $this->userDao->autoUpdate($data, ['id'=>$uid]);
   }


}