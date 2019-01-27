<?php
/**
 *  导航服务
 *
 * User: wangkaihui
 * Date: 2017/11/10
 * Time: 16:24
 */

namespace Admin\Service;


use Lib\Base\BaseService;

final class MenuService extends BaseService
{
    /**
     * @var \Admin\Service\Base\UserService
     */
    public $userService;

    public function loadTopName($key){
        $config = $this->config()->get("menu.menu");
        return isset($config[$key]) && $config[$key]?$config[$key]:[];
    }

    public function loadTop($uid){
        $userAccess = $this->userService->getUserAccess($uid);
        $menu = $this->config()->get("menu.menu");
        if($menu){
            foreach($menu as $menuKey =>&$menuV){
                $access = $this->config()->get("menu.".$menuKey);
                if(!$access){
                    unset($menu[$menuKey]);
                    continue;
                }
                $tmp=[];
                foreach ($access as $tmpv){
                    $tmp[] = current($tmpv);
                }
                if(!array_intersect($tmp, $userAccess)) unset($menu[$menuKey]);
            }
        }
        return $menu;
    }

    public function loadNav($key, $uid=0){
        $config = $this->config()->get("menu");
        $data = isset($config[$key]) && $config[$key]?$config[$key]:[];
        if(!$data) return ;
        $ret = [];
        $preKey = "";
        foreach ($data as $k=>$v){
            $first = $v[0];
            $second = $v[1];
            if($first == '-'){
                $preKey = $second;
            }
            if($preKey){
                $ret[$preKey][] = $v;
            }else{
                $ret[] = $v;
            }
        }

//        $this->debug($ret);
        //根据用户权限处理
        if($uid){
            $access = $this->userService->getUserAccess($uid);
            foreach ($ret as $k=>$v){
                if(!$v) continue;
                if(!is_array($v[0])){
                    if(!in_array($v[0], $access)) unset($ret[$k]);
                }else{
                    if(is_array($v)){
                        $scheck = 0;
                        foreach ($v as $sk=>$sv){
                            if($sv[0]=='-') continue;
                            if(in_array($sv[0], $access)){
                                $scheck++;
                            }else{
                                unset($ret[$k][$sk]);
                            }
                        }
                        if(!$scheck) unset($ret[$k]);
                    }

                }
            }
        }


        return $ret;
    }

}