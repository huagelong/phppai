<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2018/1/8
 * Time: 22:24
 */

namespace Admin\Service\Base;


use Lib\Base\BaseService;
use Admin\Dao\System\UserDao;

final class AdminLogService extends BaseService
{
    /**
     * @var \Admin\Dao\System\AdminActionLogDao
     */
    public $adminActionLogDao;

    /**
     * @var \Admin\Dao\System\UserDao
     */
    public $userDao;

    /**
     * @var \Admin\Service\AccessService
     */
    public $accessService;

    public function getList($searchField, $searchValue, $page, $pageSize)
    {
        $data = [];
        if($searchValue) $data[$searchField] = ["like", "%".$searchValue."%"];
        list($list,$count, $totalPage) =  $this->adminActionLogDao->pager($data, $page, $pageSize, "id DESC");
        if($list){
            $allAccess = $this->accessService->allAccess();
            foreach ($list as $k=>&$v){
                $user = $this->userDao->get(['id'=>$v['uid']]);
                $v['user'] = $user;
                $v['access_name'] = isset($allAccess[$v['route']])?$allAccess[$v['route']]:"";
            }
        }
        return [$list, $totalPage];
    }
}