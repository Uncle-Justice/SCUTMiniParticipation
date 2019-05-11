<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/4
 * Time: 20:54
 */

namespace app\api\controller\v1;
use app\api\service\Token as TokenService;

class BaseController
{

    //很多函数都需要做接口权限校验，所以写在基类里
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }

    protected function checkSuperScope(){
        TokenService::needSuperScope();
    }
}