<?php


namespace App\Http\Controllers\server;


use App\Exceptions\BaseException;
use App\Http\models\Goods as GoodsModel;
use App\Http\models\GoodsSku;
use App\Http\models\Reduction;
use App\Http\models\ReductionGoods;
use App\Http\models\SysConfig;
use App\Http\models\User;
use App\Http\models\UserAddress;
use App\Http\models\UserLevel;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\DB;
use App\Http\models\OrderGoods as OrderGoodsModel;
use App\Http\models\Order as OrderModel;
use App\Http\models\UserCoupon as UserCouponModel;

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
        }catch (\Exception $e) {
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
            $order_data['table_num']=$post['table_num'];
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
        $data['yzcode']=rand(100000,9999999);

        $data['user_id'] = $uid;
        if(isset($post['invite_code']))
            $data['invite_code']=$post['invite_code'];
        $post['user_id'] = $uid;            //uid 写入post
        //获取信息及用户地址
        if($post['table_num']!=null){
            $user_data['receiver_name']='';
            $user_data['receiver_mobile']='';
            $user_data['receiver_province']='';
            $user_data['receiver_city']='';
            $user_data['receiver_address']='';
            $user_data['region_id']=0;
            $shipping_dees=0;
        }else{
            $user_data = UserAddress::getUserInfo($uid);//直接用默认地址
            $shipping_dees=SysConfig::get('shipping_dees');
        }

        $to=$this->vipMoney($uid,$post['json']);//计算商品的总价
        $data['goods_money']=$to['money'];
        $data['coupon_money'] = $this->computeCouponMoney($post['coupon_id'], $uid,$to['total_money']);    //优惠券价格
        $data['reduction_money']=$to['reduce'];
        $data['order_money'] = $to['total_money'] - $data['coupon_money']+$shipping_dees;
        $dt = $data['order_money'] != $post['total_price'];
        $data['order_money']=round($data['order_money'],2);
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
        $level=User::where('id',$uid)->value('level_id');
        if(!$level) {
            $discount['discount'] = 1;
        }
        else
            $discount=UserLevel::where(['id'=>$level])->first();
        //$discount=$discount->toArray();
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
        $ids=array_column($goods,'goods_id');
        $rgm=new ReductionGoods();
        $rgm_h=$rgm->whereIn('goods_id',$ids)->groupBy('reduction_id')->get('reduction_id');
        $rm=new Reduction();
        $reduce=0.0;
        foreach ($rgm_h as $v){
            $rm_h=$rm->where('statu',1)->where('end_time', '>', time())->find($v['reduction_id']);
            $fmoney=0.0;
            if($rm_h) {
                foreach ($goods as $item) {
                    $l = $rgm->where(['reduction_id' => $v['reduction_id']])->where('goods_id', $item['goods_id'])->get();
                    if ($l) {
                        $fmoney += $item['money'];
                    }
                }
                if ($fmoney >= $rm_h['full'])
                    $reduce += $rm_h['reduce'];
            }
        }
        $m=$rm->where('statu',1)->where('end_time', '>', time())->get('id');
        $m=array_column($m->toArray(),'id');
        $rids=$rgm->whereIn('reduction_id',$m)->whereIn('goods_id',$ids)->get('goods_id');
        $rids=$rids->toArray();
        $data['reduce']=$reduce;
        $data['rids']=$rids;
        //$data['ids']=$ids;
        $data['goods']=$goods;
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
    //计算优惠券
    private function computeCouponMoney($coupon_id, $uid, $all_money)
    {
        if ($coupon_id) {
            $coupon = UserCouponModel::where(['coupon_id'=>$coupon_id,'user_id'=>$uid,'status'=>0])->where('end_time','>',time())->first();
            if (!$coupon) {
                throw new BaseException('优惠券使用错误');
            }
            if ($all_money < $coupon['full']) {
                throw new BaseException('优惠券使用错误');
            }

            (new UserCouponModel())->where(['coupon_id'=>$coupon_id,'user_id'=>$uid])->update(['status'=>1]);
            return $coupon['reduce'];
        }
        return 0;
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