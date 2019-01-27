<?php
/**
 * app 相关接口
 * User: wangkh
 * Date: 2018/9/20
 * Time: 13:15
 */

namespace Api\Controllers;

use Lib\Support\Error;

final class AppController extends BaseController
{

    /**
     * @var \Admin\Service\VersionService
     */
    public $versionService;

    /**
     *  app版本更新
     */
    public function appupdate()
    {
        $type = $this->getApiRequest("type");
        $version = $this->getApiRequest("version");
        if(!$type || !$version) return $this->responseError("参数错误!");
        $con=[];
        if($type == 'ios'){
            $con['is_ios']=1;
            $url = "https://itunes.apple.com/cn/app/id1441752178?mt=8";
        }else{
            $con['is_android']=1;
            $url = "https://static.xkedu.org/dfsx/app-release.apk";
        }
        $con['is_show']=1;
        $res=$this->versionService->getVersionById($con,'created_at desc');
        $data=[];
        $data['current_version'] =$res['version_num'];
        $data['update_type'] = 0;
        $data['url'] = $url;
        $data['desc']=$res['description'];
        if($res){
            if(version_compare($version,$res['version_num'],'<')){
                if($res['is_update']==1){
                    $data['update_type'] = 2;
                }else{
                    $data['update_type'] = 1;
                }
            }
        }
        return $this->response($data);
    }

}