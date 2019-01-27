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
use Trensy\Mvc\Route\RouteMatch;

final class CommonService extends BaseService
{
    /**
     * @var \Admin\Dao\System\AdminActionLogDao
     */
    public $adminActionLogDao;

    /**
     * @var \Admin\Service\AccountService
     */
    public $accountService;


    public function logAction()
    {
        $match = RouteMatch::getDispatch();
        $routeName = isset($match['routeName'])?$match['routeName']:null;
        $user = $this->accountService->getLogin();
        if(!$user) return ;
        $uid = $user['id'];
        $get = $this->getRequest()->query->all();
        $post = $this->getRequest()->request->all();
        $request = array_merge($get,$post);
        $allData = json_encode($request, JSON_UNESCAPED_UNICODE);

        $data = [];
        $data['uid'] = $uid;
        $data['route'] = $routeName;
        $data['input_data'] = $allData;
        return $this->adminActionLogDao->autoAdd($data);
    }

    public function showCfg($varName)
    {
        switch($result = get_cfg_var($varName))
        {
            case 0:
                return '<font color="red">×</font>';
                break;

            case 1:
                return '<font color="green">√</font>';
                break;

            default:
                return $result;
                break;
        }
    }

    public function memory_usage()
    {
        $memory	 = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
        return $memory;
    }


   public function microtime_float()
    {
        $mtime = microtime();
        $mtime = explode(' ', $mtime);
        return $mtime[1] + $mtime[0];
    }

   //单位转换
    public function formatsize($size)
    {
        $danwei=array(' B ',' K ',' M ',' G ',' T ');
        $allsize=array();
        $i=0;

        for($i = 0; $i <4; $i++)
        {
            if(floor($size/pow(1024,$i))==0){break;}
        }

        for($l = $i-1; $l >=0; $l--)
        {
            $allsize1[$l]=floor($size/pow(1024,$l));
            $allsize[$l]=$allsize1[$l]-$allsize1[$l+1]*1024;
        }

        $len=count($allsize);
        $fsize = 0;
        for($j = $len-1; $j >=0; $j--)
        {
            $strlen = 4-strlen($allsize[$j]);
            if($strlen==1)
                $allsize[$j] = "<font color='#FFFFFF'>0</font>".$allsize[$j];
            elseif($strlen==2)
                $allsize[$j] = "<font color='#FFFFFF'>00</font>".$allsize[$j];
            elseif($strlen==3)
                $allsize[$j] = "<font color='#FFFFFF'>000</font>".$allsize[$j];

            $fsize=$fsize.$allsize[$j].$danwei[$j];
        }
        return $fsize;
    }
}