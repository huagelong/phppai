<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/7/3
 * Time: 21:58
 */

namespace Lib\BladexEx;


use Trensy\Shortcut;

class Paginator
{
    use Shortcut;

    public function perform($param)
    {
        return '<?php \Lib\BladexEx\Paginator::deal('.$param.'); ?>';
    }

    public static function deal($pageCount, $page, $route, $param){
        $page = $page < 0 ? 1 : $page;
        $previous = $page-1 < 0 ? 0 : $page-1;
        $next = $page+1 < $pageCount ? $page+1 : $pageCount;
        $current = $page;

        $str = "";
        if($pageCount && $pageCount > 1){
            $p = $current;
            $end = $p+3;
            $start = $p-3;
            $start = $start < 1 ? 1 : $start;

            $end = $end-$start<6?7:$end;
            $end = $end > $pageCount ? $pageCount+1 : $end;
            $str .='<ul class="pagination">';
            if($page >1){
                $param['p']=$previous;
                $url = self::url($route, $param);
                $str .='<li><a href="'.$url.'">&laquo;</a></li>';
            }

            for($start; $start <$end ; $start++){
                $param['p']=$start;
                $url = self::url($route, $param);
                if($page == $start){
                    $str .='<li class="active"><a href="'.$url.'">'.$start.'</a></li>';
                }else{
                    $str .='<li><a href="'.$url.'">'.$start.'</a></li>';
                }
            }
            if($next > $page){
                $param['p']=$next;
                $url = self::url($route, $param);
                $str .=' <li><a href="'.$url.'">&raquo;</a></li>';
            }
            $str .='</ul>';
            $param['p']=1;
            $url = self::url($route, $param);
            $html = <<<EOF
<div style=" display: inline-block;vertical-align: top;width: 120px;margin-left: 40px;margin-top: 18px;">
    <div class="input-group input-medium">
        <input type="text" name="searchValue" value="1" class="js_page_num search-value form-control input-medium" placeholder="">
        <span class="input-group-btn"><button data-href="{$url}" data-max="{$pageCount}" class="js_page_to btn btn-default btn-search">确定</button></span>
    </div>
</div>

EOF;
            $str .= $html;
        }

        echo $str;
    }
}