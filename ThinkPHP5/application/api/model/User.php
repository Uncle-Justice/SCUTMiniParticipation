<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/31
 * Time: 13:42
 */

namespace app\api\model;


class User extends BaseModel
{

    public function address(){
        return $this->hasOne('UserAddress', 'user_id','id');
    }

    public function userQuestionnaire(){
        return $this->hasMany('UserQuestionnaire','user_id','id');
    }

    public static function getByOpenID($openid){
        $user = self::where('openid', '=',$openid)
        ->find();
        return $user;
    }


}