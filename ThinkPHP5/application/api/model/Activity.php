<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/10
 * Time: 21:08
 */

namespace app\api\model;


class Activity extends BaseModel
{
    public function questionnaire(){
        return $this->hasOne('Questionnaire','id','questionnaire_id');//(关联模型的模型名,外键,当前模型的主键)
    }
    protected $hidden = ['update_time', 'extend','delete_time'];

    public static function getActivityByID($id){

//
        $activity = self::with(['questionnaire'])->find($id);//使用模块的静态写法，返回了一个对象

//        $banner = new BannerModel();//使用模块的动态写法，返回了一个对象
//        $banner = $banner->get($id);
        //get,all是模型特有的两个方法
        return $activity;
    }

    public function bannerItem(){
        return $this->hasOne('BannerItem','id','banner_item_id');
    }

    public static function getMostRecent($count){
//        $activities = self::limit($count)
//            ->order('create_time desc')
//            ->select();
        $activities = self::with(['questionnaire'])
                            ->limit($count)
                            ->order('create_time desc')
                            ->select();

        return $activities;
    }

    protected $autoWriteTimestamp = true;
}