<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/31
 * Time: 13:43
 */

namespace app\api\service;

use app\api\model\User as UserModel;
use app\api\model\User;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use app\lib\ScopeEnum;
use think\Exception;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppID,$this->wxAppSecret,$this->code);
    }

    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);//true返回数组，false返回对象
        if(empty($wxResult)){
            throw new Exception('获取session——key及openID时异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errCode', $wxResult);
            if($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult){
        //拿到openid
        //数据库里看一下，这个openid是否已经存在
        //如果存在则不处理，如果不存在 那么新增一条user记录
        //生成令牌，准备缓存数据，写入缓存  key:令牌 value:wxResult,uid,scope
        //把令牌返回到客户端去

        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if($user){
            $uid = $user->id;
        }
        else{
            $uid = $this->newUser($openid);
        }
        $cacheValue = $this->prepareCacheValue($wxResult,$uid);
        $token = $this->saveToCache($cacheValue);
        return $token;
    }

    private function saveToCache($cacheValue){
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key, $value,$expire_in);
        if(!$request){
            throw new TokenException([
                'msg' =>'服务器缓存异常',
                'errorCode' => 10005
            ]);
        }

        return $key;//即令牌
    }

    private function newUser($openid){
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

    private function prepareCacheValue($wxResult,$uid){
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = ScopeEnum::User;//数字越大权限越大,16指App用户的权限，32指CMS（管理员）用户的权限
        return $cacheValue;
    }

    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg'=> $wxResult['errmsg'],
            'errorCode'=>$wxResult['errcode']
        ]);
    }
}