<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/2
 * Time: 22:51
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
       return $this->belongsTo('Image', 'img_id','id');
    }
}