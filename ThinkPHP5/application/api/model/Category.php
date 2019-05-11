<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/30
 * Time: 14:58
 */

namespace app\api\model;


class Category extends BaseModel
{
    public function img(){
        return $this->belongsTo('Image', 'topic_img_id','id');
    }

    protected $hidden = ['delete_time','update_time', 'create_time'];


}