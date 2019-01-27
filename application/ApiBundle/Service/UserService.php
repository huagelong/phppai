<?php

namespace Api\Service;

use Lib\Base\BaseService;
use Lib\Support\Error;


final class UserService extends BaseService
{
    /**
     * @var \Site\Dao\UsersDao
     */
    public $usersDao;


    /**
     * @var \Site\Service\AccountService
     */
    public $accountService;

    /**
     * @param $where
     * @param $user_info
     * @return bool
     */
    public function updateUser($where, $user_info)
    {
        $check = $this->usersDao->getField("id", $where);
        if (!$check) {
            return Error::add("用户不存在!");
        }
        $do = $this->usersDao->autoUpdate($user_info, $where);
        if ($do) {
            return true;
        }
        return false;
    }

    /**
     * @param $where
     * @return mixed
     */
    public function user_info($where)
    {
        $user_info = $this->usersDao->get($where);
        if (!$user_info) {
            return Error::add("用户不存在!");
        }
        unset($user_info['passwd']);
        return $user_info;
    }
}

