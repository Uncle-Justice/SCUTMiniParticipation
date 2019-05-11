<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/12
 * Time: 14:06
 */

namespace app\api\validate;


class UserQuestionnaireNew extends BaseValidate
{
    protected $rule = [
        'questionnaire_id' =>'require|isNotEmpty',
        'gender' => 'require|isNotEmpty',
        'institute' => 'require|isNotEmpty',
        'grade' => 'require|isNotEmpty',
        'campus' =>  'require|isNotEmpty',
        'student_id' => 'require|isNotEmpty',
        //不能在这里传uid，容易发生A用户改了B用户信息的情况
    ];
}