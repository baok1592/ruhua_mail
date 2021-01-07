<?php


namespace App\Http\Controllers\common;


use App\Http\models\Goods;
use App\Http\models\OrderGoods;
use App\Http\Controllers\server\Payment;
use App\ruhua\bases\BaseController;
use App\Http\Controllers\server\PayService;
use App\Http\models\Order as OrderModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Pay extends BaseController
{
    private $orderID;
    //公众号-我的订单页面中进行支付
    public function gzhPaySecond($id)
    {
        (new IDPostiveInt())->goCheck();

        $order=OrderModel::where('order_id',$id)->find();

        $order_data['order_num']=$order['order_num'];
        $order_data['order_money']=$order['Order_money'];
        $openid=TokenService::getCurrentTokenVar('openid');
        $gzh['web_name']=SysConfig::where(['key'=>'web_name'])->value('value');
        $gzh['api_url']=SysConfig::where(['key'=>'api_url'])->value('value');
        $res=(new JsApi())->gzh_pay($openid,$order_data,$gzh);
        return $res;
    }
    //公众号回调
    public function gzh_back()
    {
        Log::error("公众号支付回调");
        $config = new WxPayConfig();
        $notify = new GzhNotifyService();
        $notify->Handle($config, false);
    }

    //公众号购买vip创建订单 在userVip控制器中createVipOrder(),与小程序是用函数
    //公众号购买vip拉起支付
    public function gzhVipPaySecond($id)
    {
        (new IDPostiveInt())->goCheck();
        $order=VipOrderModel::find(['order_id'=>$id]);
        $order_data['order_num']=$order['order_num'];
        $order_data['order_money']=$order['pay_money'];
        $openid=TokenService::getCurrentTokenVar('openid');
        $gzh['web_name']=SysConfig::where(['key'=>'web_name'])->value('value');
        $gzh['api_url']=SysConfig::where(['key'=>'api_url'])->value('value');
        $this->orderID=$id;
        $res=(new JsApi())->gzh_vippay($openid,$order_data,$gzh);
        return $res;
    }
    //公众号购买vip的支付回调
    public function gzh_vipback()
    {
        Log::error("公众号vip支付回调");

        $config = new WxPayConfig();
        $notify = new GzhVipNoticefyService();
        $notify->Handle($config, false);

    }


    //小程序支付
    public function getPreOrder()
    {
        $post=Request::toArray();
        $pay = new PayService($post['id']);
        if($post['pay_cate']==1){
            $res=$pay->pay();
            $res=json_decode($res);
            return $this->go($res);
        }
        else if($post['pay_cate']==2){
            $res=$pay-> balance();
            if($res){
                //Printer::order_printer($post['id']);
                return $this->success();
            }
        }
        return $this->success("暂不支付!");
    }
    //小程序支付回调:订单+vip
    public function receiveNotify()
    {

        $app=new Payment();
        Log::error('进入回调');
        $response = (new $app())->playConfig()->handlePaidNotify(function($message, $fail){
            $order =OrderModel::where('order_num',$message['out_trade_no'])->first();

            if (!$order || $order->payment_state) {
                return true;
            }
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    $order->payment_state = 1; // 更新支付时间为当前时间
                    $order->pay_time= time();

                    // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    $order->payment_state = 0;
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            $order->save(); // 保存订单
            $json=OrderGoods::where('order_id',$order->order_id)->select('goods_id')->get();
            $json=$json->toArray();
            //$ids=array_column($json,'goods_id');
            Goods::editStock($json);//修改库存

            return true; // 返回处理完成
        });
        Log::error('走出回调');
        return $this->go($response);
    }
    public function CloseOrder(){
        $order_num=Request::input('order_num');
        $app=new Payment();
        //$res=$app->playConfig()->order->close($order_num);
        $res=$app->playConfig()->order->queryByOutTradeNumber($order_num);
        return $this->go($res);
    }

    //小程序购买vip创建订单 在userVip控制器中
    //小程序开通会员拉起支付
    public function getPreVipOrder($id='')
    {
        (new IDPostiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->payvip();

    }
}