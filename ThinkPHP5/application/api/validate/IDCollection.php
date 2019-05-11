<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/28
 * Time: 21:03
 */

namespace app\api\validate;




class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids'=>'ids参数 必须是以逗号分隔的多个正整数'
    ];//ids验证不通过生成的一个信息提示，父类变量

    protected function checkIDs($value){
        $values = explode(',',$value);
        if(empty($value)){
            return false;
        }
        foreach ($values as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}