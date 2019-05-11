<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/4
 * Time: 21:08
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    //对复杂的数组进行验证器操作
    protected $products = [
        [
            'product_id' => 1,
            'count' => 3
        ],
        [
            'product_id' => 2,
            'count' => 3
        ],
        [
            'product_id' => 3,
            'count' => 3
        ]
    ];


    protected $oProducts = [
        [
            'product_id' => 1,
            'count' => 2
        ],
        [
            'product_id' => 2,
            'count' => 3
        ],
        [
            'product_id' => 3,
            'count' => 3
        ]
    ];
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected function checkProducts($values){
        if(empty($values)){
            throw new ParameterException([
                'msg' => '商品列表不能为空'
            ]);
        }

        if(!is_array($values)){

            throw new ParameterException([
                'msg' => '商品参数不正确'
            ]);
        }

        foreach ($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }

    //对数组中的元素使用singleRule进行检验
    protected $singleRule = [
        'product_id' =>'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger',
    ];

    protected function checkProduct($values){
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($values);
        if(!$result){
            throw new ParameterException([
                'msg'=>'商品列表参数错误',
            ]);
        }
    }
}