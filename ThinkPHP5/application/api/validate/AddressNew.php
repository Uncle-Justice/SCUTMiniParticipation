<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/3
 * Time: 20:20
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' =>  'require|isNotEmpty',
        'country' => 'require|isNotEmpty',
        'detail' =>'require|isNotEmpty',
        //不能在这里传uid，容易发生A用户改了B用户信息的情况
    ];
}