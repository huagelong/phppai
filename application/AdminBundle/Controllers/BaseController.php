<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/11/12
 * Time: 20:27
 */

namespace Admin\Controllers;

use Lib\Base\BaseController as BaseC;
use Admin\Service\AccountService;

class BaseController extends BaseC
{
    /**
     * @var \Admin\Service\AccountService;
     */
    public $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    protected function getCurrentUser(){
        $login = $this->accountService->getLogin();
        return $login;
    }

}