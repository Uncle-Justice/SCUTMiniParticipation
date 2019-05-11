<?php
/**
 * Created by PhpStorm.
 * User: 正义叔叔
 * Date: 2019/4/4
 * Time: 20:18
 */

namespace app\api\controller\v1;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\validate\OrderPlace;


class Order extends BaseController
{
    //用户在选择商品后，向API提交包含它所需要商品的相关信息
    //API在接收到信息后，需要检查订单相关信息的库存量
    //有库存，把订单数据存入数据库中，这相当于下单成功了，返回客户端消息，
    //告诉客户端可以支付了，调用支付接口，进行支付
    //还需要再次进行库存量检测
    //服务器这边就可以调用微信的支付接口进行支付
    //微信会返回一个支付的结果(异步)，成功：扣除库存量，失败：返回一个支付失败的结果


    protected $beforeActionList=[
      'checkExclusiveScope' => ['only'=>'placeOrder']
    ];
    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');//必须加‘/a’才能获取到数组形式的参数
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }

}