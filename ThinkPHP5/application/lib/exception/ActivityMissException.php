<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/12
 * Time: 21:26
 */

namespace app\lib\exception;


class ActivityMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Activity不存在';
    public $errorCode = 40000;
}