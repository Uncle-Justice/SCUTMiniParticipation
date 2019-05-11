<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/13
 * Time: 23:24
 */

namespace app\api\controller\v1;
use app\api\model\BannerItem as BannerItemModel;

class BannerItem extends BaseController
{
    protected $beforeActionList=[
        'checkSuperScope' => ['only'=>'createBannerItem']
    ];

    public function createBannerItem($dataArray){
        $bannerItem = new bannerItemModel();
        $bannerItem->save($dataArray);
        return [
            'id' => $bannerItem->id,
            'name'=> $bannerItem->name,
            'create_time' => $bannerItem->create_time
        ];
    }
}