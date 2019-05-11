<?php

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;
use think\Controller;
use think\Request;
use app\api\model\Theme as ThemeModel;
class Theme
{
    /*
     * @url /theme?ids = id1, id2, id3.....
     * @return  一组Theme模型
     * */
    public function getSimpleList($ids = ''){
        (new IDCollection())->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::with('topicImg,headImg')
            ->select($ids);//数组用select，单个用find
        if($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

    /*
     * @url /theme/:id
     * */

    public function getComplexOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme){
            throw new ThemeException();
        }
        return $theme;
    }

    public function deleteOne($id){

    }
}
