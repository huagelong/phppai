<?php
/**
 * User: Peter Wang
 * Date: 17/1/9
 * Time: 上午10:05
 */

namespace Lib\BladexEx;


class Option
{

    public function perform($param)
    {
        return '<?php \Lib\BladexEx\Option::deal('.$param.'); ?>';
    }

    public static function deal($inputData, $tag=[0=>"否", 1=>"是"]){
        $result = isset($tag[$inputData])?$tag[$inputData]:"";
        echo $result;
    }

}