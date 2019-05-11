<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 19:37
 */
//******************************************
//数据库执行方法
//查询
//find()返回一维数组，是表内的属性
//select()返回二维数组，是符合查询条件的所有相关记录
//删除delete()
//更新update()
//插入insert()

//where('字段名',3s'表达式','查询条件')
//******************************************

namespace app\api\model;
use think\Db;
use think\Exception;
use think\Model;

//默认情况下Model模块下的类名会直接对应数据表名
class Banner extends BaseModel
{
    //将Banner的关联模型BannerItem与之相连接
    //一对多关系：hasMany()
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');//(关联模型的模型名,外键,当前模型的主键)
    }

    //    protected  $table = 'banner_item';//也可以手动设置和哪个数据表相连接
    public static function getBannerByID($id){

        if($id == 1){
        $banner = self::with(['items','items.img'])->find($id);//使用模块的静态写法，返回了一个对象
//        $banner = new BannerModel();//使用模块的动态写法，返回了一个对象
//        $banner = $banner->get($id);
        //get,all是模型特有的两个方法
        }

        if($id == 2){

        }
        return $banner;
    }

    protected $hidden = ['update_time', 'delete_time'];//内部隐藏模型的某个字段
//      protected $visible = ...//内部只让它显示某个字段
}