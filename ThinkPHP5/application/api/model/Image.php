<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['id','from', 'delete_time','update_time'];

//    //返回图片URL路径，分是本地服务器还是来自网络
//    public function getUrlAttr($value,$data){
//        $finalUrl = $value;
//        if($data['from'] == 1){//from为1，即为本地服务器图片，为2则为网络图片
//            $finalUrl = config('setting.img_prefix').$value;
//        }
//
//        return $finalUrl;
//
//    }
    public function getUrlAttr($value, $data){
        return $this->prefixImgUrl($value, $data);
    }
}
