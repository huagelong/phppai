<?php
/**
 * 数据字典
 *
 * User: wangkaihui
 * Date: 2017/11/27
 * Time: 17:59
 */

namespace Admin\Controllers\Base\Data;



use Admin\Controllers\BaseController;

final class MapController extends BaseController
{

    /**
     * @var \Admin\Service\Base\DataService
     */
    public $dataService;

    public function index()
    {
        $searchField = $this->getRequest()->get("searchField");
        $searchValue = $this->getRequest()->get("searchValue");

        $page = (int) $this->getRequest()->get("p");
        $page = $page?$page:1;
        $pageSize = 10;

        list($list, $totalPage) = $this->dataService->getList($searchField, $searchValue, $page, $pageSize);

        $this->view->list = $list;
        $this->view->totalPage = $totalPage;
        $this->view->page = $page;
        $this->view->route = "admin::base@data@map/index";

        $params = [];
        if($searchValue) $params[$searchField] = $searchValue;
        $this->view->params = $params;

        $this->view->searchValue = $searchValue;
        $this->view->searchField = $searchField;

        $this->display("admin::base/data/map/index");
    }

    /**
     * 新增字典
     */
    public function add()
    {
        $this->display("admin::base/data/map/add");
    }

    public function doadd()
    {
        $name = $this->getRequest()->get("name");
        $key = $this->getRequest()->get("key");

        if($name === null) return $this->responseError("字典名称不能为空!");
        if($key === null) return $this->responseError("字典key不能为空!");
        $check = $this->dataService->checkGroupKey($key);
        if($check) $this->responseError("字典key已存在!");

        $this->dataService->addGroup($name, $key);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@map/index'));
    }

    public function edit($id)
    {
        $this->view->info = $this->dataService->getById($id);

        $this->display("admin::base/data/map/edit");
    }

    public function doedit($id)
    {
        $name = $this->getRequest()->get("name");
        $key = $this->getRequest()->get("key");

        if($name === null) return $this->responseError("字典名称不能为空!");
        if($key === null) return $this->responseError("字典key不能为空!");

        $check = $this->dataService->checkGroupKey($key, $id);
        if($check) $this->responseError("字典key已存在!");

        $this->dataService->updateGroup($id, $name, $key);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@map/index'));
    }

    public function del($id)
    {
        $check = $this->dataService->getOptions($id);
        if($check)  return $this->responseError("操作失败，字典数据还没有清空");
        $this->dataService->delGroup($id);
        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@map/index'));
    }

    /**
     * 新增配置
     */
    public function addoption($groupid)
    {
        $this->view->groupid = $groupid;

        $this->display("admin::base/data/map/addoption");
    }

    public function doaddoption($groupid)
    {
        $name = $this->getRequest()->get("name");
        $key = $this->getRequest()->get("key");
        $value = $this->getRequest()->get("value");

        if($name === null) return $this->responseError("字典数据名称不能为空!");
        if($key === null) return $this->responseError("字典数据key不能为空!");
        if($value === null) return $this->responseError("字典数据值不能为空!");

        $check = $this->dataService->checkOptionKey($groupid, $key);
        if($check) $this->responseError("字典数据key已存在!");

        $this->dataService->addOption($groupid, $name, $key, $value);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@map/index'));
    }

    public function updateoption()
    {
        $id = $this->getRequest()->get("id");
        $name = $this->getRequest()->get("name");
        $key = $this->getRequest()->get("key");
        $value = $this->getRequest()->get("value");

        if($name === null) return $this->responseError("字典数据名称不能为空!");
        if($key === null) return $this->responseError("字典数据key不能为空!");
        if($value === null) return $this->responseError("字典数据值不能为空!");

        $info = $this->dataService->getOptionById($id);

        $check = $this->dataService->checkOptionKey($info['group_id'], $key, $id);
        if($check) $this->responseError("字典数据key已存在!");

        $this->dataService->updateOption($id, $name, $key, $value);

        return $this->responseSuccess("操作成功!");

    }

    public function deloption($id)
    {
        $this->dataService->delOption($id);
        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@map/index'));
    }

}