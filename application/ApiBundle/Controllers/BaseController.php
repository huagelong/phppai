<?php
/**
 * Created by PhpStorm.
 * User: wangkh
 * Date: 2018/9/20
 * Time: 13:37
 */

namespace Api\Controllers;


class BaseController extends \Lib\Base\BaseController
{

    /**
     * 成功
     * @param string $errorMsg
     * @param string $url
     */
    public function responseSuccess($errorMsg='', $url=''){
        $url = $url?$url:((object) null);
        return $this->response($url, self::RESPONSE_SUCCESS_CODE, $errorMsg);
    }

    /**
     * 跳转
     *
     * @param $url
     */
    public function responseRedirect($url)
    {
        return $this->response($url, self::RESPONSE_SUCCESS_CODE, '');
    }

    /**
     * 错误
     * @param string $errorMsg
     * @param string $url
     */
    public function responseError($errorMsg='', $url=''){
        $url = $url?$url:((object) null);
        return $this->response($url, self::RESPONSE_NORMAL_ERROR_CODE, $errorMsg);
    }

    /**
     * 警告
     * @param string $errorMsg
     * @param string $url
     */
    public function responseWarn($errorMsg='', $url=''){
        $url = $url?$url:((object) null);
        return $this->response($url, self::RESPONSE_NORMAL_ERROR_CODE, $errorMsg);
    }

    /**
     * 信息
     * @param string $errorMsg
     * @param string $url
     */
    public function responseInfo($errorMsg='', $url=''){
        $url = $url?$url:((object) null);
        return $this->response($url, self::RESPONSE_NORMAL_ERROR_CODE, $errorMsg);
    }

}