<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/5
 * Time: 16:30
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id', 'delete_time', 'user_id'];
}