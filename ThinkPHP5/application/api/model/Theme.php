<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/28
 * Time: 20:47
 */

namespace app\api\model;


class Theme extends BaseModel
{
    //Theme和Image是一对一关系
    //将Theme与Image关联起来

    protected $hidden = ['delete_time','update_time', 'topic_img_id', 'head_img_id'];
    //Theme的topic_img_id去索引Image中的id，即一对一（belongsTo）
    public function topicImg(){
        return  $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg(){
        return  $this->belongsTo('Image', 'head_img_id', 'id');
    }

    //products和theme是多对多关系，所以要用belongsToMAny()函数，第二个参数是中间表的名字
    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id', 'theme_id');
    }

    public static function getThemeWithProducts($id){
        $theme = self::with('products,topicImg,headImg')
            ->find();
        return  $theme;
    }
}