<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/28
 * Time: 20:41
 */

namespace app\api\model;


class Product extends BaseModel
{
    //pivot指的是多对多关系的中间表，虽然它不是Product的属性，但是会自动显示出来（就是theme_product那张表）
    //所以也需要隐藏
    protected $hidden = [
        'delete_time','main_img_id','pivot','from','category_id',
        'create_time','update_time'
    ];

    //这是一个自动调用的函数，直接可以根据属性名main_img_id,写这样一个函数名就可以自动实现拼接url的功能
    //但是函数名必须这样写才可以
    //tql
    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value, $data);
    }

    public static function getMostRecent($count){
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }

    //数据库的冗余：其实在product中"main_img_url"和"img_id"是等价的，但是由于Theme已经关联了太多模型
    //操作的时候需要很多次嵌套，出于性能考虑，这里设计了一个冗余（但是保持数据一致性会很麻烦）

    public static function getProductsByCategoryID($categoryID){
        $products = self::where('category_id','=',$categoryID)
            ->select();
        return $products;
    }

    public static function getProductDetail($id){
        $product = self::with([//输出img_url, 同时使之按order排序而非默认的id排序
            'imgs' => function($query){
                $query->with(['imgUrl'])
                ->order('order', 'asc');
            }
        ])
        ->with(['properties'])
        ->find($id);
        return $product;
    }
}