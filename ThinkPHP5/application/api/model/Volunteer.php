<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/10
 * Time: 21:09
 */

namespace app\api\model;


class Volunteer extends BaseModel
{
    protected $hidden = ['update_time', 'extend','delete_time'];
}