<?php
/**
 * 阿里云短信发送
 * User: wangkh
 * Date: 2018/9/20
 * Time: 13:15
 */

namespace Glob\Controllers;

use Lib\Support\Error;
use Lib\Support\Valid;

final class SmsController extends BaseController
{

    /**
     * @var \Glob\Service\SmsService
     */
    public $smsService;

    public function sendCaptcha()
    {
        $type = $this->getRequest()->get('type');
        $imgCode = $this->getRequest()->get('imgCode');
        $mobile = $this->getRequest()->get('mobile');

        if(!$type || !$imgCode || !$mobile) return $this->responseError("参数缺失!");

        if(!Valid::isMobile($mobile))  return $this->responseError('手机号码格式错误!');

        if(!$this->smsService->checkImgCaptcha($imgCode, $type)) return $this->responseError("图形验证码验证失败!");

        $result = $this->smsService->sendCaptcha($mobile, $type);
        if($result) $this->smsService->clearImgCaptcha($type);
        if(!$result)  return $this->responseError(Error::getLast());
        return $this->responseSuccess("短信发送成功!");
    }


    /**
     *  app 发送短信验证码
     */
    public function sendAppCaptcha()
    {
        $type = $this->getApiRequest('type');
        $mobile = $this->getApiRequest('mobile');
        if(!$type || !$mobile) return $this->responseError("参数缺失!");
        $result = $this->smsService->sendCaptcha($mobile, $type);
        if(!$result)  return $this->responseError(Error::getLast());
        return $this->responseSuccess("短信发送成功!");
    }

}