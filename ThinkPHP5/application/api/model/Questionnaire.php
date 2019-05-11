<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/10
 * Time: 21:08
 */

namespace app\api\model;


class Questionnaire extends BaseModel
{
    protected $hidden = ['update_time', 'extend','delete_time'];
    protected $autoWriteTimestamp = true;
}