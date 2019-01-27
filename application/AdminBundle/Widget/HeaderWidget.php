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
use Trensy\Support\Flash;

final class HeaderWidget extends BaseWidget
{

    private $accountService;
    private $menuService;


    public function __construct(AccountService $accountService,
                                MenuService $menuService)
    {
        $this->accountService = $accountService;
        $this->menuService = $menuService;
    }

    /**
     * @param null $params
     */
    public function perform()
    {
        $request = $this->getRequest();
        $topmenu = $request->cookies->get("topmenu");
        $topmenu = $topmenu?$topmenu:"homepage";

        $login = $this->accountService->getLogin();

        $data =[];
        $data['topmenu'] = $topmenu;
        $data['objUser'] = $this->accountService;
        $data['userinfo'] = $login;
        $data['topNav'] = $this->menuService->loadTop($login['id']);
        $data['uri'] = $request->getRequestUri();

        return $this->render("admin::widget/header.blade.php", $data);
    }
}