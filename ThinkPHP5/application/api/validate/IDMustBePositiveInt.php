<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 15:39
 */

namespace app\api\validate;
use think\Validate;

class IDMustBePositiveInt extends BaseValidate
{
    //自定义验证规则
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id'=> 'id必须是正整数'
    ];

}