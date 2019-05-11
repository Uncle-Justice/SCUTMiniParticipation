<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/5
 * Time: 21:41
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_timestamp';
}