<?php
/**
 * 角色
 *
 * User: wangkaihui
 * Date: 2017/11/12
 * Time: 20:25
 */

namespace Admin\Controllers\Base\Access;


use Admin\Controllers\BaseController;

final class RoleController extends BaseController
{

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

        list($list, $totalPage) = $this->accessService->getList($searchField, $searchValue, $page, $pageSize);

        $this->view->list = $list;
        $this->view->totalPage = $totalPage;
        $this->view->page = $page;
        $this->view->route = "admin::base@access@role/index";
        $params = [];
        if($searchValue) $params[$searchField] = $searchValue;
        $this->view->params = $params;
        $this->view->access = $this->accessService->allAccess();

        $this->view->searchValue = $searchValue;
        $this->view->searchField = $searchField;

        $this->display("admin::base/access/role/index");
    }

    public function add()
    {
        $this->display("admin::base/access/role/add");
    }

    public function edit($id)
    {
        $info = $this->accessService->getById($id);
        if(!$info) $this->getResponse()->redirect($this->url('admin::base@access@role/index'));
        $this->view->info =  $info;
        $this->view->id =  $id;

        $this->display("admin::base/access/role/edit");
    }

    public function doedit()
    {
        $name = trim($this->getRequest()->get("name"));
        $descr = $this->getRequest()->get("descr");
        $id = (int) $this->getRequest()->get("id");

        if(!$name){
            return $this->responseError("角色名称不能为空!");
        }

        if($this->accessService->checkRole($name, $id)){
            return $this->responseError("角色名称已存在!");
        }

        if(!$descr){
            return $this->responseError("描述不能为空!");
        }

        $this->accessService->updateRole($name, $descr, $id);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@access@role/index'));
    }

    public function doAdd()
    {
        $name = trim($this->getRequest()->get("name"));
        $descr = $this->getRequest()->get("descr");

        if(!$name){
            return $this->responseError("角色名称不能为空!");
        }

        if($this->accessService->checkRole($name)){
            return $this->responseError("角色名称已存在!");
        }

        if(!$descr){
            return $this->responseError("描述不能为空!");
        }

        $this->accessService->addRole($name, $descr);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@access@role/index'));
    }

    public function delete($id)
    {
        $this->accessService->delById($id);
        return $this->responseSuccess("操作成功!", $this->url('admin::base@access@role/index'));
    }

    public function accessMg($id)
    {
        $info = $this->accessService->getById($id);
        if(!$info) $this->getResponse()->redirect($this->url('admin::base@access@role/index'));

        $this->view->access = $this->accessService->loadAccess();
        $this->view->info = $info;
        $this->view->id = $id;

        $this->display("admin::base/access/role/accessmg");
    }

    public function accessSave($id)
    {
        $info = $this->accessService->getById($id);
        if(!$info) return $this->responseError("角色不存在!");

        $access = $this->getRequest()->get("access");

        $this->accessService->updateAccess($id, $access);

        return $this->responseSuccess("操作成功!", $this->url('admin::base/access@role/index'));
    }

}