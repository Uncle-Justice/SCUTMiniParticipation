<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/3
 * Time: 20:59
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}