<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/31
 * Time: 17:24
 */

namespace app\lib\exception;


class TokenException extends BaseException
 {
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}