<?php


namespace App\Http\Controllers\server;


use App\Exceptions\BaseException;
use App\Http\models\Goods as GoodsModel;
use App\Http\models\GoodsSku;
use App\Http\models\User;
use App\Http\models\UserAddress;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\DB;
use App\Http\models\OrderGoods as OrderGoodsModel;
use App\Http\models\Order as OrderModel;

class OrderService
{
    /**
     * 创建公众号订单
     * @param $post
     * @return \GzhPay\json数据，可直接填入js函数作为参数|string
     * @throws OrderException
     */
    public function createGzhOrder($post)
    {
        $openid = TokenService::getCurrentTokenvar('openid');
        $uid = TokenService::getCurrentUid();
        Db::startTrans();
        try {
            $order_data = $this->CreateCartOrder($post, $uid); //创建订单
            $gzh['web_name'] = SysConfig::where(['key' => 'web_name'])->value('value');
            $gzh['api_url'] = SysConfig::where(['key' => 'api_url'])->value('value');
            $res = (new JsApi())->gzh_pay($openid, $order_data['order_data'], $gzh);
            $res = json_decode($res, true);
            Db::commit();
            return $res;
        } catch (\Exception $e) {
            Db::rollback();// 回滚事务
            throw new OrderException(['msg' => $e->getMessage()]);
        }
    }


    /**
     * 创建订单
     * @param $post
     * @param $uid
     * @return array|string
     * @throws OrderException
     */
    public function CreateCartOrder($post, $uid)
    {
        GoodsModel::checkStock($post['json']);
        $data=[];
        DB::beginTransaction();
        try {
            $order_data = $this->setOrderData($post, $uid);//组装订单数据
            foreach ($post['json'] as $v) {
                if ($v['goods_id'] == 66) {
                    $order_data['shipment_state'] = 1;
                }
            }
            $res_order = OrderModel::create($order_data);//创建订单
            $oid = $res_order->id;
            $goods = $this->setOrderGoods($oid, $post, $uid);//组装订单商品数据
            foreach ($goods as $good){
                OrderGoodsModel::create($good);
            }
            $data['id'] = $oid;
            $data['order_data'] = $order_data;
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollback();// 回滚事务
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * 组装订单数据
     * @param $post
     *
     * @param $uid
     * @return array
     * @throws OrderException
     */
    public function setOrderData($post, $uid)
    {
        $data = [];
        $data['order_num'] = $this->makeOrderNum();  //订单号
        $data['order_from'] = $post['order_from'];  //订单来源 0:小程序,1:wap
        $data['payment_type'] = $post['payment_type']; //支付来源
        $data['message'] = $post['msg'] ? $post['msg'] : ''; //留言
        $data['drive_type'] = $post['drive_type'];
        $data['pay_cate'] = $post['pay_cate'];
        $data['user_id'] = $uid;
        $post['user_id'] = $uid;            //uid 写入post
        //获取信息及用户地址
        $user_data = UserAddress::getUserInfo($uid);//直接用默认地址
        $to=$this->vipMoney($uid,$post['json']);//计算商品的总价
        $data['goods_money']=$to['money'];
        $data['coupon_money'] = 0;
        $data['reduction_money']=$to['reduce'];
        $data['order_money'] = $to['total_money'] - $data['coupon_money'];
        $dt = $data['order_money'] != $post['total_price'];
        if ($dt || $data['order_money']<=0) {//价格验证
            throw new BaseException('价格错误' . $data['order_money'] . '--' . $post['total_price'] . '--' . $data['goods_money']);
        }
        if ($post['coupon_id']) {
            $data['coupon_id'] = $post['coupon_id'];
        }
        unset($user_data['receiver_province']);
        unset($user_data['region_id']);
        $arr = array_merge($data, $user_data);
        return $arr;
    }

    /**
     * 组装普通商品订单的 商品数据
     * @param $order_id
     * @param $post
     * @param $uid
     * @return array
     */
    public function setOrderGoods($order_id, $post, $uid)
    {
        $data = [];
        foreach ($post['json'] as $k => $v) {
            $pinfo = GoodsModel::getProductByID($v['goods_id']);//获取商品及关联数据
            $data[$k]['goods_id'] = $v['goods_id'];
            $data[$k]['goods_name'] = $pinfo['goods_name'];
            $data[$k]['sku_id'] = $v['sku_id'];
            if ($v['sku_id']) {
                $list=json_decode($pinfo['sku'][0]['json'],true);
                foreach ($list['list'] as $key => $value) {
                    if ($value['id'] == $v['sku_id']) {
                        $data[$k]['price'] = $value['price'];
                        $data[$k]['sku_name'] = (array_key_exists('s1_name', $value) ? $value['s1_name'] : '')
                            . ' ' . (array_key_exists('s2_name', $value) ? $value['s2_name'] : '')
                            . ' ' . (array_key_exists('s3_name', $value) ? $value['s3_name'] : '');
                    }
                }
            } else {
                $data[$k]['price'] = $pinfo['price'];
            }
            $data[$k]['number'] = $v['num'];
            $data[$k]['user_id'] = $uid;

            $data[$k]['order_id'] = $order_id;
            $data[$k]['total_price'] = $data[$k]['price'] * $data[$k]['number'];
            $data[$k]['pic'] = $pinfo['img_id'];  //商品图片
        }
        return $data;
    }


    /**
     * 判断返回商品图片或规格图片
     * @param $pinfo
     * @param $post
     * @return bool
     */
    public function getGoodsImg($pinfo, $post)
    {
        //无规格的订单商品
        if (empty($post['sku_id'])) {
            return $pinfo['img_id'];
        } else {
            //有规格的订单商品
            foreach ($pinfo['sku'] as $k => $v) {
                if ($v['sku_id'] == $post['sku_id']) {
                    return $v['picture'];
                }
            }
        }
        return true;
    }
    //计算会员打折后的钱
    public function vipMoney($uid,$post){
        $data=$this->to_money($post);
        $discount['discount'] = 1;
        $total_money=0.0;
        $vmoney=0.0;
        foreach ($data['goods'] as $v){
            $total_money+=$v['money'];
            if(in_array($v['goods_id'],$data['rids'])){
                continue;
            }
            $vmoney+=$v['money'];
        }
        $vmoney=(1*100-$discount['discount']*100)/100*$vmoney;
        $data1['reduce']=round($data['reduce'],2);
        $data1['vmoney']=round($vmoney,2);
        $data1['money']=round($total_money,2);
        $data1['total_money']=round($total_money-$data['reduce']-$vmoney,2);
        //$data1['total_money']=0.01;
        return $data1;
    }

    //计算满减减的钱
    public function to_money($post){
        $goods=$this->goodsMoney($post);
        $rids=array();
        $data['rids']=$rids;
        $data['goods']=$goods;
        $data['reduce']=0;

        return $data;
    }
    //计算商品的价格返回每一个商品钱
    public function goodsMoney($post){
        if(!$post){
            throw new BaseException( '没有商品');
        }
        $data=[];
        $i=0;
        foreach ($post as $item){
            $data[$i]['goods_id']=$item['goods_id'];
            $goods = GoodsModel::with('goodsSku')->where('goods_id', $item['goods_id'])->first();
            $goods=$goods->toArray();
            if($item['sku_id']) {
                $skuPrice = GoodsSku::getSkuPrice($goods, $item['sku_id']);//获取规格价格
                if ($skuPrice) {
                    $data[$i]['money'] = $skuPrice * $item['num'];
                }
                else {
                    $data[$i]['money'] = $goods['price'] * $item['num'];
                }
            }
            else
                $data[$i]['money'] = $goods['price'] * $item['num'];
            $i++;
        }
        return $data;
    }
    //生成订单编号
    function makeOrderNum()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J','K');
        $orderSn =
            $yCode[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }


}