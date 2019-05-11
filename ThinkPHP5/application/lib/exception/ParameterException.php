<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 22:35
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}