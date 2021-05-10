<?php


namespace App\Http\Controllers\common;


use App\Http\models\FxGoods;
use App\Http\models\Goods;
use App\Http\models\OrderGoods;
use App\Http\Controllers\server\Payment;
use App\ruhua\bases\BaseController;
use App\Http\models\UserCoupon;
use App\Http\Controllers\server\PayService;
use App\Http\models\Order as OrderModel;
use App\ruhua\Feie\FeieDy;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use App\ruhua\server\Token;
use App\Http\models\OrderGoods as OrderGoodsModel;

class Pay extends BaseController
{
    private $orderID;
    //公众号-我的订单页面中进行支付
    public function gzhPaySecond()
    {
        $post=Request::toArray();
        $pay = new PayService($post['id']);
        if($post['pay_cate']==1){
            $res=$pay->gzh_pay();
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
        Log::error('进入回调1');
        $response = (new $app())->playConfig()->handlePaidNotify(function($message, $fail){
            $order =OrderModel::where('order_num',$message['out_trade_no'])->first();
            Log::error($message);
            Log::error("回调数据2");
            if($order['coupon_id']!=""){
                UserCoupon::where(['user_id'=>$order['user_id'],'coupon_id'=>$order['coupon_id']])->update(['status'=>1]);
            }

            if (!$order || $order->payment_state) {
                return true;
            }

            if ($message['return_code'] == 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if ($message['result_code'] == 'SUCCESS') {
                    $order->payment_state = 1; // 更新支付时间为当前时间
                    $order->pay_time= time();

                    // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    $order->payment_state = 0;
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }
            Log::error("test1");
            OrderModel::where('order_id',$order->order_id)->update(['payment_state'=>1,'pay_time'=>time()]);
            Log::error("test2");
            $json=OrderGoods::where('order_id',$order->order_id)->select(['goods_id','number','sku_id'])->get();
            Log::error("test3");
            $json=$json->toArray();
            $print=(new FeieDy())->printMsg($message['out_trade_no'],1);
            Log::error("test4");
            //$ids=array_column($json,'goods_id');

            Log::error("test5");
            Log::error("order_invite_code****************");
            Log::error($order->invite_code);
            Log::error("order_invite_code****************");
            if($order->invite_code!=""){
                $goods_ids=OrderGoodsModel::where('order_id',$order->order_id)->select('goods_id')->get();
                $ids=array();
                foreach ($goods_ids as $k=>$v)
                    $ids[$k]=$v['goods_id'];
                Log::error("fx_ids****************");
                Log::error($ids);
                Log::error("fx_ids****************");
                Goods::add_fx($ids,$order->invite_code);
            }
            Goods::editStock($json);//修改库存


            return true; // 返回处理完成
        });
        Log::error('走出回调3243424');

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