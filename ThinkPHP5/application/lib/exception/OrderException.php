<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/5
 * Time: 19:57
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}