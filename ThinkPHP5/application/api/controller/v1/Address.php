<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/3
 * Time: 20:17
 */

namespace app\api\controller\v1;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;

use app\api\validate\AddressNew;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use app\lib\ScopeEnum;
use think\Controller;

class Address extends BaseController
{
    //这是一个controller内置变量，目的是在创建地址时先检查用户权限
    //即只要执行createOrUpdateAddress()函数，一定要在它之前执行checkPrimaryScope()
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate->goCheck();

        //根据token获取UID
        //根据UID来查找用户数据，判断用户是否存在，如果不存在抛出异常
        //获取用户从客户端提交来的地址信息
        //根据用户信息是否存在，从而判断是添加地址还是更新地址

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);

        if(!$user){
            throw new UserException();
        }

        //这里获取的数据如果包含user_id，就可能覆盖缓存，
        //所以算异常，父类getDataByRule()可以防止这个问题并且按rule里面的参数返回data，很实用
        $dataArray = $validate->getDataByRule(input('post.'));

        $userAddress = $user->address;//使用Model里面我们自定义的address函数获取到数据库里的address数据
        if(!$userAddress){
            $user->address()->save($dataArray);
        }else{
            $user->address->save($dataArray);
        }
        return json(new SuccessMessage(),201);
    }
}