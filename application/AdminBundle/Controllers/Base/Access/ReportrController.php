<?php
/**
 * 汇报关系
 *
 * User: wangkaihui
 * Date: 2017/11/12
 * Time: 20:25
 */

namespace Admin\Controllers\Base\Access;


use Admin\Controllers\BaseController;

final class ReportrController extends BaseController
{

    /**
     * @var \Admin\Service\Base\AccessService
     */
    public $accessService;


    public function index()
    {
        $list = $this->accessService->getReportRelations();
        $this->view->list = json_encode($list, JSON_UNESCAPED_UNICODE);

        $allUsers = $this->accessService->getAllUser();
        $this->view->users =  json_encode($allUsers, JSON_UNESCAPED_UNICODE);

        $this->display("admin::base/access/reportr/index");
    }


    public function doEdit()
    {
        $reportUid = $this->getRequest()->get("report_uid");
        $uid = $this->getRequest()->get("uid");
        $this->accessService->updateReport($reportUid, $uid);
        return $this->responseSuccess('操作成功!');
    }

}