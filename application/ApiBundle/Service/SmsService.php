<?php
/**
 * Created by PhpStorm.
 * User: wangkh
 * Date: 2018/9/20
 * Time: 13:19
 */

namespace Glob\Service;

use Lib\Base\BaseService;
use Lib\Support\Error;

final class SmsService extends BaseService
{
    const SMS_KEY = "SMS_KEY";
    const SMS_TIME_KEY = "SMS_TIME_KEY";
    const SMS_TIME = 5;

    /**
     * @var \Lib\Service\CaptchaService
     */
    public $captchaService;


    /**
     * @var \Site\Dao\MobileSmsCodeDao
     */
    public $mobileSmsCodeDao;

    /**
     *  短信验证码
     *
     * @param $mobile
     * @param $type
     * @return bool
     */
    public function sendCaptcha($mobile, $type)
    {
//        $templateCode = "SMS_110835355";
        $templateCode = "SMS_147437862";
        $value = mt_rand(100000,999999);
        $templateParam = ["Code" => $value];
        $key = self::SMS_KEY."_".$mobile."_".$type;
        $this->cache()->set($key, $value, 70);

        //记录发送的验证码
        $data = [];
        $data['mobile'] = $mobile;
        $data['type'] = $type;
        $data['code'] = $value;
        $this->mobileSmsCodeDao->autoAdd($data);
        //检查手机发送次数
        if(!$this->checkTimes($mobile)) return Error::add(Error::getLast());
        $result = $this->send($mobile, $templateCode, $templateParam);
        if(!$result) return false;
        return $result;
    }

    protected function checkTimes($mobile)
    {
        $key = self::SMS_TIME_KEY."_".date('Y-m-d')."_".$mobile;
        $times = (int) $this->cache()->get($key);
        if($times > (self::SMS_TIME-1))  return Error::add("已超过当天准许该手机发送短信的最大次数!");
        $this->cache()->set($key,$times+1, 86400);
        return true;
    }

    public function clearImgCaptcha($type)
    {
        $this->captchaService->clear($type);
        return true;
    }

    public function checkSmsCaptcha($code, $mobile, $type)
    {
        $key = self::SMS_KEY."_".$mobile."_".$type;
        $oldCode = $this->cache()->get($key);
        if(!$oldCode) return Error::add("短信验证码错误或者已过期！");
        return $oldCode == $code;
    }

    public function checkImgCaptcha($code, $type)
    {
        return $this->captchaService->check($code, $type);
    }


    protected function send($mobile, $templateCode, $templateParam=[]){

        $config = $this->config()->get("app.alisms");
        if(!$config['enable']) return false;
        $params = array ();
        // *** 需用户填写部分 ***
        // fixme 必填：是否启用https
        $security = false;

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = $config['accessKeyId'];
        $accessKeySecret =  $config['accessKeySecret'];

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $mobile;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "东方尚学";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $templateCode;

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        if($templateParam) $params['TemplateParam'] = $templateParam;

        // fixme 可选: 设置发送短信流水号
//        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
//        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(isset($params["TemplateParam"]) && !empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"]);
        }

        // 此处可能会抛出异常，注意catch
        $content = $this->curlRequest(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            )),
            $security
        );
//        debug($content);
        if($content->Code != 'OK'){
            return Error::add($content->Message);
        }

        return $content->Code == 'OK';
    }


    /**
     * 生成签名并发起请求
     *
     * @param $accessKeyId string AccessKeyId (https://ak-console.aliyun.com/)
     * @param $accessKeySecret string AccessKeySecret
     * @param $domain string API接口所在域名
     * @param $params array API具体参数
     * @param $security boolean 使用https
     * @param $method boolean 使用GET或POST方法请求，VPC仅支持POST
     * @return bool|\stdClass 返回API接口调用结果，当发生错误时返回false
     */
    public function curlRequest($accessKeyId, $accessKeySecret, $domain, $params, $security=false, $method='POST') {
        $apiParams = array_merge(array (
            "SignatureMethod" => "HMAC-SHA1",
            "SignatureNonce" => uniqid(mt_rand(0,0xffff), true),
            "SignatureVersion" => "1.0",
            "AccessKeyId" => $accessKeyId,
            "Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
            "Format" => "JSON",
        ), $params);
        ksort($apiParams);

        $sortedQueryStringTmp = "";
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . $this->encode($key) . "=" . $this->encode($value);
        }

        $stringToSign = "${method}&%2F&" . $this->encode(substr($sortedQueryStringTmp, 1));

        $sign = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret . "&",true));

        $signature = $this->encode($sign);

        $url = ($security ? 'https' : 'http')."://{$domain}/";

        try {
            $content = $this->baseCurlGet($url, $method, "Signature={$signature}{$sortedQueryStringTmp}");
            return json_decode($content);
        } catch( \Exception $e) {
            return false;
        }
    }

    protected function baseCurlGet($url, $method, $body) {
//        debug(func_get_args());
        $method = strtoupper($method);
        $ch = curl_init();

        if($method == 'POST' || $method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
//            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
//        debug($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if(substr($url, 0,5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $rtn = curl_exec($ch);

        if($rtn === false) {
            // 大多由设置等原因引起，一般无法保障后续逻辑正常执行，
            // 所以这里触发的是E_USER_ERROR，会终止脚本执行，无法被try...catch捕获，需要用户排查环境、网络等故障
            trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        }
        curl_close($ch);

        return $rtn;
    }

    private function encode($str)
    {
//        debug($str);
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

}