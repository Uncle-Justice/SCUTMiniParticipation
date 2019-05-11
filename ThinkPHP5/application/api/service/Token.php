<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/31
 * Time: 17:04
 */

namespace app\api\service;
use app\api\service\Token as TokenService;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\ScopeEnum;
use think\Cache;
use think\Exception;
use think\Request;

class Token

{
    public static function generateToken(){
        //32个字符组成一组随机字符串
        $randChars = getRandChar(32);


        //用三组字符串，进行MD5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 盐
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key){
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }else{
            if(!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if(array_key_exists($key, $vars)){
                return $vars[$key];
            }else{
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    public static function getCurrentUid(){
        //token
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    //需要用户和CMS管理员都可以访问的权限
    public static function needPrimaryScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope >= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }}
        else{
            throw new TokenException();
        }
    }

    //只有用户才能访问的权限
    public static function needExclusiveScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope == ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }}
        else{
            throw new TokenException();
        }
    }

    //只有管理员才能访问的权限
    public static function needsuperscope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::Super) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }
}