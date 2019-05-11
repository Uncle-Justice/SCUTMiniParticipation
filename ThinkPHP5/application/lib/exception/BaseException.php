<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 20:30
 */

namespace app\lib\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception//由用户行为导致的异常
{
    //HTTP状态码 404，200
    public $code = 400;
    //错误具体信息
    public $msg = '参数错误';
    //自定义的错误码
    public $errorCode = 10000;

    //构造函数
    public function __construct($params = [])
    {
        if(!is_array($params)){
            return ;
//            throw new Exception('参数必须是数组');
        }

        //这下面三个if的目的是，因为继承的子类一定会默认设置了code,msg和errorCode.
        //如果构造函数传进来的数组有新的，就更新，否则就使用默认的值
        if(array_key_exists('code', $params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg', $params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode', $params)){
            $this->errorCode = $params['errorCode'];
        }

    }

}