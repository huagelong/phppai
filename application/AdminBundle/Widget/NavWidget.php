<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/9/8
 * Time: 19:06
 */

namespace Admin\Widget;


use Lib\Base\BaseWidget;
use Admin\Service\AccountService;
use Admin\Service\MenuService;

final class NavWidget extends BaseWidget
{
    /**
     * @var \Admin\Service\MenuService
     */
    public $menuServce;

    /**
     * @var \Admin\Service\AccountService
     */
    public $accountService;

    /**
     * @param null $params
     */
    public function perform()
    {
        $topNav = $this->getCookie('topmenu');
        $sidebarClosed = $this->getCookie('sidebar_closed');
        $topNav = $topNav?$topNav:"other";

        $uid = 0;
        $userInfo = $this->accountService->getLogin();
        if($userInfo) $uid = $userInfo['id'];

        $nav = $this->menuServce->loadNav($topNav, $uid);
        $navName = $this->menuServce->loadTopName($topNav);

        $login = $this->accountService->getLogin();

        $data =[];
        $data['nav'] = $nav;
        $data['userinfo'] = $login;
        $data['navName'] = $navName;
        $data['sidebarClosed'] = $sidebarClosed;

        return $this->render("admin::widget/nav.blade.php", $data);
    }
}