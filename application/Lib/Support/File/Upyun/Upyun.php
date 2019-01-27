<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2018/1/4
 * Time: 11:51
 */

namespace Lib\Support\File\Upyun;

use Lib\Support\Error;
use Lib\Support\File\FileAbstract;
use Lib\Support\Xtrait\Helper;

use Upyun\Upyun as BaseUpyun;
use Upyun\Config;
class Upyun extends FileAbstract
{
    use Helper;

    protected $return;

    /**
     * 删除文件
     *
     * @param $uri
     */
    public function delete($uri)
    {
        $client = $this->getClient();
        $key = $this->getObj($uri);
        return $client->delete($key);
    }


    public function getSignedUrl($uri, $timeout=10)
    {
       throw new \Exception("not support");
    }


    public function getObj($uri)
    {
        $temp = $this->getDbOption("upyun", "uss_endpoint");
        $pre = substr($uri,0,strlen($temp));
        if($temp == $pre){
            $key = substr($uri,strlen($temp));
            return ltrim($key,"/");
        }else{
            return ltrim($uri,"/");
        }
    }

    /**
     * 上传图片到upyun
     *
     * @param $remotePath
     * @param $localPath
     * @return string
     */
    public function save($remotePath,$localPath)
    {
        $client = $this->getClient();
        if(!is_file($localPath)) return Error::add("本地文件不存在!");
        $file = $file = fopen($localPath, 'r');
        $res = $client->write($remotePath, $file);
        $this->return = $res;
        if((isset($res['x-upyun-height']) && $res['x-upyun-height']) || (isset($res['x-upyun-content-length']) && $res['x-upyun-content-length'])){
            $endpoint = $this->getDbOption("upyun", "uss_endpoint");
            return $endpoint."/".ltrim($remotePath, "/");
        }else{
            return Error::add("上传失败");
        }
    }

    public function getReturn()
    {
        return $this->return;
    }

    /**
     * 获取对象
     *
     * @return
     * @throws \Exception
     */
    protected function getClient()
    {
//        $serviceName = $this->config()->get("app.upyun.serviceName");
        $serviceName = $this->getDbOption("upyun", "uss_serviceName");
//        $operatorName = $this->config()->get("app.upyun.operatorName");
        $operatorName = $this->getDbOption("upyun", "uss_operatorName");
//        $operatorPwd = $this->config()->get("app.upyun.operatorPwd");
        $operatorPwd = $this->getDbOption("upyun", "uss_operatorPwd");

        $serviceConfig = new Config($serviceName, $operatorName, $operatorPwd);
        $client = new BaseUpyun($serviceConfig);
        return $client;
    }
}