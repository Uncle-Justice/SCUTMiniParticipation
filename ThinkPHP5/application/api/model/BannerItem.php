<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    //从内部隐藏一些永远不需要被外所需要的一些字段
    protected $hidden = ['id', 'img_id', 'banner_id','update_time', 'delete_time'];
    public function img(){
        //将BannerItem的关联模型Image与之相连
        //关联模型：一对一关系
        //当然，其实也可以在Image类中写一个关联BannerItem的函数，这个取决于业务逻辑+
        return $this->belongsTo('Image','img_id','id');}


}
