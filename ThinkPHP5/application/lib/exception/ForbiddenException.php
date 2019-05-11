<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/4
 * Time: 20:10
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}