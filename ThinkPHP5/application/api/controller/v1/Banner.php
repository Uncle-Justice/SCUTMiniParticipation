<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 14:40
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;

class Banner
{
/*    获取指定的Banner信息
    @url banner/:id
    @http GET
    @id banner的id号
*/

    public function getBanner($id){
//        $data = [
//            'id' => $id
//        ];
//独立验证
//        $validate = new Validate([
//            'name' => 'require|max:10',
//            'email'=> 'email'
//            //还有很多的验证规则，官方文档的“内置规则”
//            //当然，也可以自定义规则，错误提示信息也是可以自定义的
//        ]);
//        $result = $validate->batch()->check($data);
//        var_dump($validate->getError()) ;

        //验证器，封装性会更好，所以最后选择使用验证器
        //验证id是否为正整数，是则继续，否则抛出异常并返回错误信息

        (new IDMustBePositiveInt())->goCheck();

        //with关联BannerModel里的items()函数，获取BannerModel的关联模型
        //嵌套关联模型，BannerItems类的关联模型Image(直接在with中使用数组)


          //find,select是Db特有的两个方法
        $banner = BannerModel::getBannerByID($id);
//        调用Banner Model函数，使用Db类闭包的写法
//        将数据封装成模型，有很多好的操纵数据的方法可以使用
//        $banner->hidden(['update_time']);//从外部隐藏字段，相当于“删除了”
//        $banner->visible(['id','delete_time']);//从外部只显示特定的字段,但是一般还是从内部直接隐藏复用性较强
        if (!$banner){
            throw new BannerMissException();
        }
        $c = config('setting.img_prefix');

        return $banner;//这里返回一个对象，可以不用json直接序列化
    }
}