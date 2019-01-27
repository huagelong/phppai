<?php
/**
 * User: Peter Wang
 * Date: 17/1/9
 * Time: 上午10:05
 */

namespace Admin\BladexEx;


class Can
{
    public static $canStack = [];

    public function perform($param)
    {
        return '<?php \Admin\BladexEx\Can::deal('.$param.'); ?>';
    }

    public static function deal($routeName)
    {
        if (ob_start()) {
            self::$canStack[] = $routeName;
        }
    }

}