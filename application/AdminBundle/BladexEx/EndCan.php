<?php
/**
 * User: Peter Wang
 * Date: 17/1/9
 * Time: 上午10:05
 */

namespace Admin\BladexEx;

use Admin\Service\AccountService;
use Trensy\Di;

class EndCan
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function perform($param)
    {
        return '<?php \Admin\BladexEx\EndCan::deal('.$param.'); ?>';
    }

    public static function deal($param='')
    {
        $sectionStack = Can::$canStack;
        $routeName = array_pop($sectionStack);
        $content = ob_get_clean();
        $accountService = Di::get('\Admin\Service\AccountService');
        $userService = Di::get('\Admin\Service\Base\UserService');

        $login = $accountService->getLogin();
        if($login){
            $uid = $login['id'];
            $access = $userService->getUserAccess($uid);
            if(in_array($routeName, $access)){
                echo $content;
                return true;
            }
        }

        echo $param;
        return true;
    }

}