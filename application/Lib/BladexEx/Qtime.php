<?php
/**
 * User: Peter Wang
 * Date: 17/1/9
 * Time: 上午10:05
 */

namespace Lib\BladexEx;


class Qtime
{

    public function perform($param)
    {
        return '<?php \Lib\BladexEx\Qtime::deal('.$param.'); ?>';
    }

    public static function deal($time){
        $timeStr = self::qtime($time);
        echo $timeStr;
    }

    protected static function qtime($time){
//        if(!is_numeric($time)) $time = strtotime($time);
        $limit = time() - $time;

        if($limit<60)
            $time="{$limit}秒前";
        if($limit>=60 && $limit<3600){
            $i = floor($limit/60);
            $_i = $limit%60;
            $s = $_i;
            $time="{$i}分前";
        }
        if($limit>=3600 && $limit<3600*24){
            $h = floor($limit/3600);
            $_h = $limit%3600;
            $i = ceil($_h/60);
            $time="{$h}小时{$i}分前";
        }
        if($limit>=(3600*24) && $limit<(3600*24*30)){
            $d = floor($limit/(3600*24));
            $time= "{$d}天前";
        }
        if($limit>=(3600*24*30)){
            $time=gmdate('Y-m-d H:i', $time);
        }
        return $time;
    }

}