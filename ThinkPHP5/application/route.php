<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];

use think\Route;

//Route::rule('路由表达式','路由地址','请求类型','路由参数（数组）','变量规则（数组）');
//请求类型：GET,POST,DELETE,PUT,*, 默认是*
//Route::rule('hello','sample/test/hello','GET|POST',['https'>=false]);
//Route::post('hello/:id','sample/Test/hello');
//Route::post();
//Route::any();


//路由地址三段式：模块名，控制器名，操作方法名，在这里多出了一个v1的层级，反正就是要这么写
//:version--动态选择版本

//控制器每写一个公共函数，就要在Router里定义一次
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');
Route::get('api/:version/Theme/','api/:version.Theme/getSimpleList');
Route::get('api/:version/Theme/:id','api/:version.Theme/getComplexOne');
Route::get('api/:version/recent/:count','api/:version.Activity/getRecent');

Route::group('api/:version/product',function (){//路由分组，把相同的URL前缀统一在一起，方便以后更改
    Route::get('/by_category','api/:version.Product/getAllProductsInCategory');
//变量规则：这里   :id  这个路由，需要加后面那些参数，否则，当我们要访问recent的时候，会报错
//因为是按路由文件顺序选择路由
    Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
    Route::get('/recent','api/:version.Product/getRecent');
});

Route::get('api/:version/category/all','api/:version.Category/getAllCategories');

Route::post('api/:version/activity','api/:version.Activity/createActivity');
Route::get('api/:version/activity/:id','api/:version.Activity/getActivity');

Route::post('api/:version/upload','api/:version.Activity/upload');

Route::post('api/:version/token/user','api/:version.Token/getToken');//使用post提高一些安全性

Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');//使用post提高一些安全性

Route::post('api/:version/order','api/:version.Order/placeOrder');//使用post提高一些安全性

Route::post('api/:version/userquestionnaire','api/:version.UserQuestionnaire/fillQuestionnaire');//使用post提高一些安全性
Route::post('api/:version/questionnaire','api/:version.Questionnaire/createQuestionnaire');//使用post提高一些安全性
Route::post('api/:version/deleteuserquestionnaire','api/:version.UserQuestionnaire/deleteUserQuestionnaire');
Route::get('api/:version/getuserquestionnaire','api/:version.UserQuestionnaire/getUserQuestionnaire');//使用post提高一些安全性
Route::get('api/:version/getnotification','api/:version.Notification/getRecent');
Route::post('api/:version/releasenotice','api/:version.Notification/releaseNotice');//使用post提高一些安全性
Route::post('api/:version/alreadyread','api/:version.Notification/alreadyRead');//使用post提高一些安全性
Route::post('api/:version/approve','api/:version.Manage/approve');//使用post提高一些安全性
//validate
Route::get('api/:version/excel','api/:version.Manage/excel_down');