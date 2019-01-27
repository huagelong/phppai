<?php
/**
 *  数据服务
 *
 * User: wangkaihui
 * Date: 2017/11/10
 * Time: 16:24
 */

namespace Admin\Service\Base;


use Lib\Base\BaseService;
use Admin\Dao\System\OptionDao;
use Admin\Dao\System\OptionGroupDao;

final class DataService extends BaseService
{

    /**
     * @var \Admin\Dao\System\OptionGroupDao
     */
    public $optionGroupDao;

    /**
     * @var \Admin\Dao\System\OptionDao
     */
    public $optionDao;


    public function addGroup($name, $key)
    {
        $data = [];
        $data['group_name'] = $name;
        $data['group_key'] = $key;
        return $this->optionGroupDao->autoAdd($data);
    }


    public function checkGroupKey($groupKey, $id=0)
    {
        $data = [];
        $data['group_key'] = $groupKey;
        if($id) $data['id'] = ["!=", $id];
        return $this->optionGroupDao->get($data);
    }

    public function checkOptionKey($groupId, $optionKey, $id=0)
    {
        $data = [];
        $data['option_key'] = $optionKey;
        $data['group_id'] = $groupId;
        if($id) $data['id'] = ["!=", $id];
        return $this->optionDao->get($data);
    }

    public function updateGroup($id, $name, $key)
    {
        $where = [];
        $where['id']=$id;

        $data = [];
        $data['group_name'] = $name;
        $data['group_key'] = $key;
        return $this->optionGroupDao->autoUpdate($data, $where);
    }

    public function getById($id)
    {
        $where = [];
        $where['id']=$id;
        return $this->optionGroupDao->get($where);
    }


    public function getOptionById($id)
    {
        $where = [];
        $where['id']=$id;
        return $this->optionDao->get($where);
    }

    /**
     * 删除组
     */
    public function delGroup($id)
    {
        $where = [];
        $where['id']=$id;
        $this->clearDbOptionsById($id);
        return $this->optionGroupDao->delete($where);
    }

    protected function clearDbOptionsById($id)
    {
        $groupDao = new  OptionGroupDao();
        $gk = $groupDao->getField("group_key", ['id'=>$id]);
        return $this->clearDbOptions($gk);
    }


    public function getOptions($id)
    {
        $where = [];
        $where['group_id']=$id;
        return $this->optionDao->gets(['group_id'=>$id]);
    }

    public function delOption($id)
    {
        $where = [];
        $where['id']=$id;
        $this->clearDbOption($id);
        return $this->optionDao->delete($where);
    }

    protected function clearDbOption($id)
    {
        $groupId = $this->optionDao->getField("group_id", ['id'=>$id]);
        return $this->clearDbOptionsById($groupId);
    }

    public function addOption($groupid, $name, $key, $value)
    {
        $data = [];
        $data['option_name'] = $name;
        $data['option_key'] = $key;
        $data['option_value'] = $value;
        $data['group_id'] = $groupid;
        return $this->optionDao->autoAdd($data);
    }


    public function updateOption($id, $name, $key, $value)
    {
        $data = [];
        $data['option_name'] = $name;
        $data['option_key'] = $key;
        $data['option_value'] = $value;
        $this->clearDbOption($id);
        return $this->optionDao->autoUpdate($data, ['id'=>$id]);
    }

    public function getList($searchField, $searchValue, $page, $pageSize)
    {
        $data = [];
        if($searchValue) $data[$searchField] = ["like", "%".$searchValue."%"];
        list($list,$count, $totalPage) =  $this->optionGroupDao->pager($data, $page, $pageSize, "created_at DESC");
        if($list){
            foreach ($list as $k=>&$v){
                $optionList = $this->optionDao->gets(['group_id'=>$v['id']], "id ASC");
                $v['option_list'] = $optionList;
            }
        }
        return [$list, $totalPage];
    }

}