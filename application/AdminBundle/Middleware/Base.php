<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2017/4/11
 * Time: 14:09
 */

namespace Admin\Middleware;


use Lib\Base\BaseMiddleware;
use Trensy\Shortcut;

abstract class Base extends BaseMiddleware
{
    use Shortcut;
}