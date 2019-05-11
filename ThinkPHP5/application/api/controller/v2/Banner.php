<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/23
 * Time: 14:40
 */

namespace app\api\controller\v2;

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
        return 'This is V2 Version';
    }
}