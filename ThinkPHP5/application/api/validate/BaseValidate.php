<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 16:37
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

//基础校验层：所有的验证器都继承于它
//然后直接第哦啊用goCheck()函数即可
class BaseValidate extends Validate
{
    public function goCheck(){
        //获取http传入的参数
        $request = Request::instance();
        $params = $request->param();

        //对这些参数做校验
        //但是如果接收多个参数，需要使用不同的验证规则,因此使用batch()函数
        $result = $this->batch()->check($params);//这里应该是就自己和子类定义的rule连接吧

        if(!$result){
            //如果验证规则没有符合
            //对于这样的一个异常，仅仅交给Handler是不够的，还要打印出具体是怎么出现的异常
            //因此再自定义一个ParameterException，并打印error信息
            $e = new ParameterException([
                'msg' => $this->error
            ]);
            throw $e;
//            $error = $this->error;
//            throw new Exception($error);//如果不符合验证条件会抛出异常
        }
        else{
            return true;
        }
    }

    //自定义判断规则与错误信息，参数列表是固定的
    //这个验证方法会被很多方法使用，所以最好拉到基类
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = ''){

        //参数列表中的value:元素的值，field:元素的名字

        if(is_numeric($value) && is_int($value + 0) &&($value + 0) > 0){//"+ 0"可以使字符串变成数字类型
            return true;
        }
        else{
            return false;
        }
    }

    protected function isNotEmpty($value, $rule='',$data='',$field=''){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }

    //这里获取的数据如果包含user_id，就可能覆盖缓存，
    //所以算异常，父类getDataByRule()可以防止这个问题并且按rule里面的参数返回data，很实用
    public function getDataByRule($arrays){
        if(array_key_exists('user_id',$arrays)|
            array_key_exists('uid', $arrays)){
            //不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException(
                [
                    'msg'=> '参数中包含有非法的参数名user_id或者uid'
                ]
            );
        }

        $newArray = [];
        foreach ($this->rule as $key => $value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    //是否为手机号
    public function isMobile($value){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
}