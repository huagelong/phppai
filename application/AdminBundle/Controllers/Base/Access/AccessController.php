<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/11/12
 * Time: 20:25
 */

namespace Admin\Controllers\Base\Access;


use Admin\Controllers\BaseController;

final class AccessController extends BaseController
{

    /**
     * @var \Admin\Service\Base\AccessService
     */
    public $accessService;

    public function view()
    {
        $this->view->access = $this->accessService->loadAccess();
        $this->display("admin::base/access/access/view");
    }

}