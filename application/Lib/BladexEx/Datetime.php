<?php
/**
 * User: Peter Wang
 * Date: 17/1/7
 * Time: 下午4:23
 */

namespace Lib\BladexEx;


class Datetime
{

    public function perform($param)
    {
        return '<?php \Lib\BladexEx\Datetime::deal('.$param.'); ?>';
    }

    public static function deal($timestamp){
        echo date("Y-m-d H:i:s", $timestamp);
    }
}