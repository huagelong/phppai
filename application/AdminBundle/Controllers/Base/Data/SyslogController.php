<?php
/**
 * 系统日志
 *
 * User: wangkaihui
 * Date: 2017/11/27
 * Time: 17:59
 */

namespace Admin\Controllers\Base\Data;



use Admin\Controllers\BaseController;

final class SyslogController extends BaseController
{
    /**
     * @var \Admin\Service\Base\AdminLogService
     */
    public $adminLogService;


    public function index()
    {
        $searchField = $this->getRequest()->get("searchField");
        $searchValue = $this->getRequest()->get("searchValue");

        $page = (int) $this->getRequest()->get("p");
        $page = $page?$page:1;
        $pageSize = 10;

        list($list, $totalPage) = $this->adminLogService->getList($searchField, $searchValue, $page, $pageSize);

        $this->view->list = $list;
        $this->view->totalPage = $totalPage;
        $this->view->page = $page;
        $this->view->route = "admin::base@data@syslog/index";

        $params = [];
        if($searchValue) $params[$searchField] = $searchValue;
        $this->view->params = $params;

        $this->view->searchValue = $searchValue;
        $this->view->searchField = $searchField;

        $this->display("admin::base/data/syslog/index");
    }
}