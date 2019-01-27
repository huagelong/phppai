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

final class FooterWidget extends BaseWidget
{

    private $accountService;


    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @param null $params
     */
    public function perform()
    {
        $data =[];
        return $this->render("admin::widget/footer.blade.php", $data);
    }
}