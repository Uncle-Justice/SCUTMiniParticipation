<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/30
 * Time: 14:57
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;
use think\Model;

class Category
{
    public function getAllCategories(){
        $categories = CategoryModel::all([],'img');
        if($categories->isEmpty()){
            throw new CategoryException();
        }
        return $categories;
    }
}