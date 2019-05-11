<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/3/21
 * Time: 21:12
 */

namespace app\sample\controller;

use think\Request;
class Test
{
//    http://localhost/zerg/public/index.php/sample/test/hello
//    E:\Study\xmapp\apache\conf\extra
//          httpd-vhosts.conf
//  C:\Windows\System32\drivers\etc
    public function hello(){

        $all = input('param.');
        var_dump($all);
//        $id = Request::instance()->param('id');
//        $name = Request::instance()->param('name');
//        $age = Request::instance()->param('age');
//        echo $id;
//        echo '|';
//        echo $name;
//        echo '|';
//        echo $age;

//        return "hello 51";
    }
}