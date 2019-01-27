<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/4/13
 * Time: 11:18
 */

namespace Lib\Base;


use Lib\Support\Error;
use Lib\Support\Xtrait\Helper;
use Trensy\ServceAbstract;
use Trensy\Support\Arr;
use Trensy\Support\Dir;
use Trensy\Support\Tool;

class BaseService extends ServceAbstract
{
    use Helper;

    protected function getTablePre()
    {
        return $this->config()->get("storage.server.pdo.prefix");
    }

    /**
     *  @return \Trensy\Http\Request
     */
    public  function getRequest()
    {
        return \Trensy\Context::request();
    }

    /**
     * @return \Trensy\Http\response
     */
    public function getResponse()
    {
        return \Trensy\Context::response();
    }

    public function checkSign($args, $query=null)
    {
        if(!isset($args['clientId'])) return Error::add('clientId 不存在');
        if(!isset($args['sign'])) return Error::add('sign 不存在');
        if(!isset($args['stamp'])) return Error::add('stamp 不存在');

        $tmpArr = [];
        if($query){
            parse_str($query, $tmpArr);
        }

        $config = $this->config()->get('app.api_respone');

        $clientId = $args['clientId'];
        $clientKey = $config[$clientId];
        $sign = $args['sign'];
        unset($args['sign']);

        if (isset($args['stamp'])) {
            if (time() - $args['stamp'] > 300) {
                return Error::add('令牌已过期');
            }
        }
//        debug($args);
        $args = array_merge($args, $tmpArr);
        $newSign = $this->getSign($args,$clientKey);
//        debug($newSign);
//        debug($sign);
        return $sign == $newSign;
    }

    protected function getSign($args, $clientKey)
    {
        ksort($args);  //按数组的键正序排序
//        $sign = http_build_query($args);
        $sign = "";
        foreach ($args as $k => $v) {
            $sign .= "&".$k ."=".$v;
        }
        $sign .= $clientKey;
        $sign = trim($sign, '&');
//        debug($sign);
        $sign = strtoupper(sha1($sign));  //加密
        return $sign;
    }

    protected function rawApiGet($url, $method, $array, $clientKey)
    {
        $tmpArr = [];
        $tmpArr['stamp'] = time();
//        $tmpArr['stamp'] = '1540348551';
        $array = array_merge($array, $tmpArr);
        $array = array_merge($array, ['sign'=>$this->getSign($array, $clientKey)]);

        $headers = [];
        $headers['sign'] = $array['sign'];
        $headers['stamp'] = $array['stamp'];
        $headers['clientId'] = $array['clientId'];

        $query = parse_url($url, PHP_URL_QUERY);
//        debug($parseUrl);
        $tmpArr = [];
        if($query) parse_str($query, $tmpArr);
        if($tmpArr){
            foreach ($tmpArr as $k=>$v){
                unset($array[$k]);
            }
        }
        unset($array['sign'], $array['stamp'], $array['clientId']);

        $json = json_encode($array, JSON_UNESCAPED_UNICODE);
        $result = $this->curlGet($url, $method, $json, $headers);
        $result = json_decode($result, true);
        return $result;
    }


    protected function curlGet($url, $method, $body, $headers=[]) {
//        debug(func_get_args());
        $method = strtoupper($method);
        $ch = curl_init();
        $realHeaders = [];
        $realHeaders[] = 'Content-Type:application/json';
        $realHeaders[] = 'dc-authorize:'.json_encode($headers);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $realHeaders);
        if($method == 'POST' || $method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
//        debug($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if(substr($url, 0,5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $rtn = curl_exec($ch);
        if($rtn === false) {
            throw new \Exception("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch));
        }
        curl_close($ch);

        return $rtn;
    }



}