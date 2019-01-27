<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2018/1/8
 * Time: 13:01
 */

namespace Admin\Service\Base;


use Lib\Base\BaseService;
use Lib\Support\Error;
use Admin\Dao\System\FileDao;
use Admin\Dao\System\FileGroupDao;
use Admin\Dao\System\FileUsedDao;
use Admin\Dao\System\UserDao;
use Trensy\Di;

final class AttachmentService extends BaseService
{

    /**
     * @var \Admin\Dao\System\FileDao
     */
    public $fileDao;

    /**
     * @var \Admin\Dao\System\FileGroupDao
     */
    public $fileGroupDao;

    /**
     * @var \Admin\Dao\System\FileUsedDao
     */
    public $fileUsedDao;

    /**
     * @var \Admin\Dao\System\UserDao
     */
    public $userDao;


    public function getList($code, $searchField, $searchValue, $page, $pageSize)
    {
        $groupId = $this->fileGroupDao->getField("id", ['code'=>$code]);

        $data = [];
        $data['group_id'] = $groupId;
        if($searchValue) $data[$searchField] = ["like", "%".$searchValue."%"];
        list($list,$count, $totalPage) =  $this->fileDao->pager($data, $page, $pageSize, "created_at DESC");

        if($list){
            foreach ($list as &$v){
                $uid = $v['uid'];
                if($uid){
                    $v['user'] = $this->userDao->get(['id'=>$uid]);
                }else{
                    $v['user'] = [];
                }
            }
        }
        return [$list, $totalPage];
    }


    public function totalNum($code)
    {
        $groupId = $this->fileGroupDao->getField("id", ['code'=>$code]);
        return $this->fileDao->getCount(["group_id"=>$groupId]);
    }

    public function totalSum($code)
    {
        $groupId = $this->fileGroupDao->getField("id", ['code'=>$code]);
        return $this->fileDao->getSum("size", ["group_id"=>$groupId]);
    }


    public function checkGroupKey($groupKey, $id=0)
    {
        $data = [];
        $data['code'] = $groupKey;
        if($id) $data['id'] = ["!=", $id];
        return $this->fileGroupDao->get($data);
    }


    public function getAllGroup()
    {
        return $this->fileGroupDao->gets([],"id ASC");
    }

    public function addGroup($name, $code)
    {
        $idata = [];
        $idata['name'] = $name;
        $idata['code'] = $code;
        return $this->fileGroupDao->autoAdd($idata);
    }

    public function deleteGroup($code)
    {
        $groupId = $this->fileGroupDao->getField("id", ['code'=>$code]);

        $check = $this->fileDao->getCount(["group_id"=>$groupId]);

        if($check) return Error::add("请确认组内文件是否全部已清空!");

        return $this->fileGroupDao->delete(['code'=>$code]);
    }

    public function deletefile($id)
    {
        $info = $this->fileDao->get(['id'=>$id]);
        if(!$info) return Error::add("文件不存在!");
        try{
            $objStr = $info['obj'];
            $obj = Di::get("\Lib\Service\FileService");
            $obj->delUrl($objStr);
        }catch (\Exception $e){
           return Error::add($e->getMessage());
        }
        return true;
    }


    public function getGroupName($id)
    {
        $info = $this->fileDao->get(['id'=>$id]);
        if(!$info) return Error::add("文件不存在!");
        $group = $this->fileGroupDao->get(['id'=>$info['group_id']]);
        return $group['code'];
    }

    public function getFileById($id)
    {
        $info = $this->fileDao->get(['id'=>$id]);

        $group = [];
        $used = [];

        if($info){
            $group = $this->fileGroupDao->get(['id'=>$info['group_id']]);
            $used = $this->fileUsedDao->gets(['file_id'=>$id]);
        }

        $info['group'] = $group;
        $info['used'] = $used;

        return $info;
    }

}