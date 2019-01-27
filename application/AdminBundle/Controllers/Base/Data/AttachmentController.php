<?php
/**
 * 附件管理
 * User: wangkaihui
 * Date: 2017/11/27
 * Time: 17:59
 */

namespace Admin\Controllers\Base\Data;



use Lib\Support\Error;
use Admin\Controllers\BaseController;

final class AttachmentController extends BaseController
{

    /**
     * @var \Admin\Service\Base\AttachmentService
     */
    public $attachmentService;

    public function index($code)
    {
        $searchField = $this->getRequest()->get("searchField");
        $searchValue = $this->getRequest()->get("searchValue");

        $page = (int) $this->getRequest()->get("p");
        $page = $page?$page:1;
        $pageSize = 10;

        list($list, $totalPage) = $this->attachmentService->getList($code, $searchField, $searchValue, $page, $pageSize);

        $this->view->totalNum = $this->attachmentService->totalNum($code);
        $this->view->totalSum = (int) $this->attachmentService->totalSum($code);

        $this->view->list = $list;
        $this->view->totalPage = $totalPage;
        $this->view->page = $page;
        $this->view->route = "admin::base@data@attachment/index";

        $params = [];
        if($searchValue) $params[$searchField] = $searchValue;
        $params["code"] = $code;
        $this->view->params = $params;

        $this->view->searchValue = $searchValue;
        $this->view->searchField = $searchField;

        $this->view->groups = $this->attachmentService->getAllGroup();
        $this->view->code = $code;

        $this->display("admin::base/data/attachment/index");
    }


    public function addgroup()
    {
        $this->display("admin::base/data/attachment/addgroup");
    }

    public function doaddgroup()
    {
        $name = $this->getRequest()->get("name");
        $key = $this->getRequest()->get("key");

        if($this->attachmentService->checkGroupKey($key)) return $this->responseError('key已存在!');

        $this->attachmentService->addGroup($name, $key);

        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@attachment/index'));
    }

    public function deletegroup($code)
    {
        $this->attachmentService->deleteGroup($code);

        if(Error::has()){
            return $this->responseError(Error::getLast());
        }
        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@attachment/index'));
    }

    public function deletefile($id)
    {
        $code = $this->attachmentService->getGroupName($id);

        $this->attachmentService->deletefile($id);
        if(Error::has()){
            return $this->responseError(Error::getLast());
        }

        return $this->responseSuccess("操作成功!", $this->url('admin::base@data@attachment/index',['code'=>$code]));
    }

    public function showbind($id)
    {
        $this->view->info = $this->attachmentService->getFileById($id);

        $content = $this->render("admin::base/data/attachment/showbind");

        return $this->response($content);
    }

}