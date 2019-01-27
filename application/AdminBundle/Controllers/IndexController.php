<?php

/**
 * User: Peter Wang
 * Date: 16/9/13
 * Time: 下午3:18
 */
namespace Admin\Controllers;

use Trensy\Flash;
use Trensy\FormBuilder\Form;
use Trensy\FormBuilder\Json;

final class IndexController extends BaseController
{

    /**
     * @var \Admin\Dao\System\UserDao
     */
    public $user;

    /**
     * @var \Admin\Service\CommonService
     */
    public $commonService;

    public function whiteActions(){
        return ["adminaccess"=>['msg']];
    }

    public function index()
    {
        //今日新增订单
        $now = time();
        $today = strtotime(date('Y-m-d 00:00:00', $now));
        $tomorrow = strtotime(date('Y-m-d 00:00:00', strtotime('+1 day', $now)));
        $today_where = array(
            'created_at' => array(
                array('>=', $today),
                array('<', $tomorrow),
            ),
        );

        //会员总数
        $users_count = $this->user->getCount();
        $this->view->users_count = $users_count;
        //今日新增会员
        $today_users = $this->user->getCount($today_where);
        $this->view->today_users = $today_users;

        $this->display("admin::index/index");
    }

    public function msg()
    {
        $this->view->flashMsg = Flash::get();
        if(!$this->view->flashMsg) $this->getResponse()->redirect($this->url('admin::index/index'));
        $this->display("admin::index/msg");
    }

}