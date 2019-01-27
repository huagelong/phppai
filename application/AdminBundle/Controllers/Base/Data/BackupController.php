<?php
/**
 * 数据备份
 *
 * User: wangkaihui
 * Date: 2017/11/27
 * Time: 17:59
 */

namespace Admin\Controllers\Base\Data;



use Lib\Support\Error;
use Admin\Controllers\BaseController;

final class BackupController extends BaseController
{

    /**
     * @var \Admin\Service\Base\BackupService
     */
    public $backupService;

    /**
     * @var \Admin\Service\AccountService
     */
    public $accountService;

    public function index()
    {
        $this->view->tables = $this->backupService->getTables();
        $this->display("admin::base/data/backup/index");
    }


    public function backup()
    {
        $selecttable = $this->getRequest()->get("selecttable");
        if(!$selecttable) return $this->responseError("请至少选中一张数据表！");
        $this->backupService->backup($selecttable);
        if(Error::has()) return $this->responseError(Error::getLast());
        return $this->responseSuccess("操作成功,备份将在后台进行，请去还原列表查看备份状态!", $this->url('admin::base@data@backup/restore'));
    }

    public function restore()
    {
        $searchField = $this->getRequest()->get("searchField");
        $searchValue = $this->getRequest()->get("searchValue");

        $page = (int) $this->getRequest()->get("p");
        $page = $page?$page:1;
        $pageSize = 10;

        list($list, $totalPage) = $this->backupService->getList($searchField, $searchValue, $page, $pageSize);
        $this->view->list = $list;
        $this->view->totalPage = $totalPage;
        $this->view->page = $page;
        $this->view->route = "admin::base@data@backup/restore";

        $params = [];
        if($searchValue) $params[$searchField] = $searchValue;
        $this->view->params = $params;

        $this->view->searchValue = $searchValue;
        $this->view->searchField = $searchField;

        $this->display("admin::base/data/backup/restore");
    }

    public function upyun($id)
    {
        $info = $this->backupService->getById($id);
        if($info['status'] !=2) return $this->responseError("请确认数据库备份成功！");

        $userInfo = $this->accountService->getLogin();
        $uid = $userInfo['id'];
        $this->backupService->upyun($id, $uid);
        if(Error::has()) return $this->responseError(Error::getLast());
        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@backup/restore'));
    }

    public function doRestore($id)
    {
        $info = $this->backupService->getById($id);
        if($info['status'] !=2) return $this->responseError("请确认数据库备份成功！");
        $this->backupService->import($id);
        if(Error::has()) return $this->responseError(Error::getLast());
        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@backup/restore'));
    }

}