<?php


namespace App\Http\Controllers\server;


use App\Exceptions\BaseException;
use App\Http\models\Order as OrderModel;
use App\ruhua\server\Token;
use Closure;
use EasyWeChat\Payment\Notify\Paid;

class PayService
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID)
        {
            throw new BaseException('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
        $this->orderNO=OrderModel::getOrderAttr($this->orderID,'order_num');//获取订单指定字段
    }

    //验证订单、支付、改变状态
    public function pay()
    {
        $this->checkOrderValid();
        //GoodsModel::checkStock();

        $order_money = OrderModel::getOrderAttr($this->orderID,'order_money');//获取订单指定字段
        $order_money=intval(100*$order_money);
        $result = (new Payment())->play($order_money,$this->orderNO);//进行微信支付
        //$result = (new Payment())->playConfig()->jssdk->appConfig($result['prepay_id']);
        //dump($result);
        return $result;
    }


    //验证订单、支付、改变状态
    public function gzh_pay()
    {
        $this->checkOrderValid();
        //GoodsModel::checkStock();

        $order_money = OrderModel::getOrderAttr($this->orderID,'order_money');//获取订单指定字段
        $order_money=intval(100*$order_money);
        $result = (new Payment())->gzh_play($order_money,$this->orderNO);//进行微信支付
        //$result = (new Payment())->playConfig()->jssdk->appConfig($result['prepay_id']);
        //dump($result);
        return $result;
    }

    //余额支付
    public function  balance(){
        $this->checkOrderValid();
        //进行库存量检测
        event('CheckStock',$this->orderID);
        $order_money = OrderModel::getOrderAttr($this->orderID,'order_money');//获取订单指定字段
        $uid=TokenService::getCurrentUid();
        $money=User::where('id',$uid)->field('money')->select();
        if($order_money>$money[0]['money']){
            throw new BaseException(['msg'=>'余额不足请充值']);
        }
        $paymoney['money']=$money[0]['money']-$order_money;
        OrderModel::where('order_id',$this->orderID)->update(['payment_state'=>1]);
        User::where('id',$uid)->update($paymoney);
        $data['uid']=$uid;
        $data['type_name']='money';
        $data['content']='购买-'.$order_money;
        MoneyLog::create($data);
        return true;
    }
    //会员开通支付
    public function payvip()
    {
        $this->chekVipOrderValid();
        $order_money = VipOrderModel::getOrderAttr($this->orderID,'pay_money');//获取订单指定字段
        $order_money=100*$order_money;
        $result = $this->makeWxPreOrder($order_money);//进行微信支付
        return json($result);


    }

    private function recordPreOrder($wxOrder)
    {
        OrderModel::where('order_id', $this->orderID)
            ->update(['prepay_id' =>$wxOrder['prepay_id']]);
    }
    private function chekVipOrderValid()
    {
        $vipOrder=VipOrderModel::where('id',$this->orderID)->where('order_status',1)->find();
        if(!$vipOrder){
            throw new BaseException(['msg' => '订单不存在或已过期']);
        }
        if (!TokenService::isValidOperate($vipOrder->user_id))
        {
            throw new BaseException(['msg' => '非法操作']);
        }
        if ($vipOrder->payment_state != OrderEnum::UNPAYID)
        {
            throw new BaseException(
                [
                    'msg' => '订单已支付过啦',
                    'errorCode' => 60003,
                    'code' => 400
                ]);
        }
        $this->orderNO = $vipOrder->order_num;
        return true;

    }
    private function checkOrderValid()
    {
        $uid=Token::getCurrentTokenVar('id');
        $order = OrderModel::where('order_id', $this->orderID)->where('state',0)->first();
        if (!$order->count())
        {
            throw new BaseException('订单不存在或已过期');
        }
        if ($uid!=$order->user_id)
        {
            throw new BaseException( '非法操作');
        }
        //非待支付状态，则终止
        if ($order->payment_state != 0)
        {
            throw new BaseException('订单已支付过啦');
        }
        $this->orderNO = $order->order_num;
        return true;
    }
    public function handlePaidNotify(Closure $closure)
    {
        return (new Paid($this))->handle($closure);
    }

}