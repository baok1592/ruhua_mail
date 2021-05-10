<?php


namespace App\Http\Controllers\common;


use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use App\Http\Controllers\server\OrderService;
use Illuminate\Support\Facades\Request;

class Order extends BaseController
{
    /**
     * 普通商品下单 - 公众号
     * @return \GzhPay\json数据，可直接填入js函数作为参数|string
     */
    public function CreateCartOrder()
    {
        (new ShoppingValidate())->goCheck();
        $post=input('post.');
        $res = (new OrderService)->createGzhOrder($post);//创建订单
        Log::error('end');
        return app('json')->success($res);
    }

    /**
     * 普通商品下单 - 小程序
     * @return mixed
     */
    public function CreateXcxOrder()
    {
        $rule = [
        'order_from' => 'required', //订单来源,0:小程序,1:wap
        'payment_type' => 'required', //支付方式 wx
        'json'=>'required',
        'total_price'=>'required',//总价
        'coupon_id'=>'min:0',//优惠卷ID
    ];
        $post=Request::toArray();
        $uid = Token::getCurrentTokenVar('id');
        $data =  (new OrderService)->CreateCartOrder($post, $uid);//创建订单
        $res['id']=$data['id'];
        $res['pay_cate']=$post['pay_cate'];
        return $this->success($res);

    }


}