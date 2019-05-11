<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/30
 * Time: 11:11
 */

namespace app\api\controller\v1;
use app\api\model\Product as ProductModel;

use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count = 15){
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);


        //database.php中修改resultset_type，使得返回类型为collection对象而非数组，这样就额可以很方便的对一组对象进行
        //hidden等操作（banner里面 那个是一个对象所以所以可以直接hidden）
        //所以以后对于一组对象的判空异常，要使用isEmpty()函数，因为一个collection肯定不是空的，
        //只可能是它里面的一个数组是空的
        if($products->isEmpty()){
            throw new ProductException();
        }


        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getAllProductsInCategory($id){
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }
}