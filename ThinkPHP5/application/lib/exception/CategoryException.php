<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/30
 * Time: 15:07
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = "指定类目不存在，请检查参数";
    public $errorCode = 50000;
}