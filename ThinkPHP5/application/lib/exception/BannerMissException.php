<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 20:38
 */

namespace app\lib\exception;


class BannerMissException extends  BaseException
{
    public $code = 404;
    public $msg = '请求的Banner不存在';
    public $errorCode = 40000;
}