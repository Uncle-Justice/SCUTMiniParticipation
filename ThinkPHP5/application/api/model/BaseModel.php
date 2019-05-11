<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    //返回图片URL路径，分是本地服务器还是来自网络//这个函数是为Image子类做的
    protected function prefixImgUrl($value,$data){
        $finalUrl = $value;
        if($data['from'] == 1){//from为1，即为本地服务器图片，为2则为网络图片
            $finalUrl = config('setting.img_prefix').$value;
        }

        return $finalUrl;

    }
}
