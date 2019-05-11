<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/3
 * Time: 20:49
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public  $msg = '用户不存在';
    public $errorCode = 60000;
}