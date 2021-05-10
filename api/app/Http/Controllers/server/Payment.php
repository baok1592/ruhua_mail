<?php


namespace App\Http\Controllers\server;

use App\Exceptions\BaseException;
use App\Http\models\SysConfig;
use App\ruhua\server\Token;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;

class Payment
{
    private $config;
    public function playConfig(){
        $system=SysConfig::all();
        $system=$system->toArray();
        foreach ($system as $k=>$v){
            $arr[$v['key']]=$v['value'];
        }

        //dump($system);
        $config = [
            // 必要配置

            'app_id'             => $arr['wx_app_id'],
            'mch_id'             => $arr['pay_num'],
            'key'                => $arr['pay_key'],   // API 密钥
//            'app_id'             => $arr['wx_app_id'],
//            'mch_id'             => 1305638280,
//            'key'                => 013467007045764,   // API 密钥

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'          => VAE_ROOT.'/cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => VAE_ROOT.'/cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
            //'sandbox' => true,//沙盒模式
            'notify_url'         => $arr['api_url'].'/order/pay/notify',     // 你也可以在下单时单独设置来想覆盖它
        ];
        $this->config=$config;
        $payment =Factory::payment($config);

        //$jssdk = $payment->jssdk;
        return $payment;
    }

    public function playConfig_back(){
        $system=SysConfig::all();
        $system=$system->toArray();
        foreach ($system as $k=>$v){
            $arr[$v['key']]=$v['value'];
        }

        //dump($system);
        $config = [
            // 必要配置

            'app_id'             => $arr['wx_app_id'],
            'mch_id'             => $arr['pay_num'],
            'key'                => $arr['pay_key'],   // API 密钥
//            'app_id'             => $arr['wx_app_id'],
//            'mch_id'             => 1305638280,
//            'key'                => 013467007045764,   // API 密钥

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'          => VAE_ROOT.'/cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => VAE_ROOT.'/cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
            //'sandbox' => true,//沙盒模式
            'notify_url'         => $arr['api_url'].'/order/user/tui_back',     // 你也可以在下单时单独设置来想覆盖它
        ];
        $this->config=$config;
        $payment =Factory::payment($config);

        //$jssdk = $payment->jssdk;
        return $payment;
    }

    // 小程序支付
    public function play($money,$order_num){
        $payment=self::playConfig();
        $openid=Token::getCurrentTokenVar('openid');
        $res=$payment->order->unify([
            'body' => '如花外卖商城',
            'out_trade_no' => $order_num,
            'total_fee' => $money,
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $openid,
        ]);
        if ($res['return_code'] == 'SUCCESS' && $res['result_code'] == 'SUCCESS') {
            $prepayId = $res['prepay_id'];
            $json = $payment->jssdk->bridgeConfig($prepayId);
            return $json;
        } else {
            throw new BaseException('调起支付失败，请稍后尝试');
        }
        //return $res;
    }


    public function tui($transactionId,  $refundNumber, $totalFee, $refundFee, array $config = [])
    {
        $payment=self::playConfig_back();
        $res=$payment->refund->byOutTradeNumber($transactionId,$refundNumber,$totalFee,$refundFee,[]);

        return $res;
    }

    public function gzh_playConfig(){
        $system=SysConfig::all();
        $system=$system->toArray();
        foreach ($system as $k=>$v){
            $arr[$v['key']]=$v['value'];
        }
        //dump($system);
        $config = [
            // 必要配置

            'app_id'             => $arr['gzh_appid'],
            'mch_id'             => $arr['pay_num'],
            'key'                => $arr['pay_key'],   // API 密钥

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'          => '/cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => '/cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
            //'sandbox' => true,//沙盒模式
            'notify_url'         => $arr['api_url'].'/order/pay/notify',     // 你也可以在下单时单独设置来想覆盖它
        ];

        $payment =Factory::payment($config);
        //$jssdk = $payment->jssdk;
        return $payment;
    }


    // 公众号支付
    public function gzh_play($money,$order_num){
        $payment=self::gzh_playConfig();

        $openid=Token::getCurrentTokenOpenID();
        $res=$payment->order->unify([
            'body' => '如花外卖商城',
            'out_trade_no' => $order_num,
            'total_fee' => $money,
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $openid,
        ]);
        if ($res['return_code'] == 'SUCCESS' && $res['result_code'] == 'SUCCESS') {
            $prepayId = $res['prepay_id'];
            $json = $payment->jssdk->bridgeConfig($prepayId);
            return $json;
        } else {
            throw new BaseException('调起支付失败，请稍后尝试');
        }
        //return $res;
    }


}