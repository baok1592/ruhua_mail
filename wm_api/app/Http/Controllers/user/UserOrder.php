<?php


namespace App\Http\Controllers\user;


use App\Http\models\Order as OrderModel;
use App\ruhua\bases\BaseController;
use App\Http\models\OrderGoods as OrderGoodsModel;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Request;

class UserOrder extends BaseController
{
    /**
     * 获取已完成订单
     * @return mixed
     */
    public function getUserOrderAll()
    {
        $uid=Token::getCurrentTokenVar('id');
       $data=OrderModel::with('ordergoods')->where('user_id',$uid)->where('state','!=',0)->orderByDesc('created_at')->get();
        return $this->success($data);
    }
    //获取未完成订单
    public function getUserOrder()
    {
        $uid=Token::getCurrentTokenVar('id');
        $data=OrderModel::with('ordergoods')->where('user_id',$uid)->where('state',0)->orderByDesc('created_at')->get();
        return $this->success($data);
    }


    /**
     * 统计订单数据
     * @return mixed
     */
    public function getOrderDate(){
        $uid = Token::getCurrentTokenVar('id');
        $data['no_payment'] = OrderModel::where(['user_id' => $uid,'state'=>0,'payment_state'=>0])->count();
        $data['no_shipment'] = OrderModel::where(['user_id' => $uid,'state'=>0,'payment_state'=>1])->count();
        $data['no_pj'] = OrderModel::where(['user_id' => $uid,'state'=>1])->count();
        return $this->success($data);
    }

    /**
     * 获取用户指定的一条订单信息
     * @param string $id
     * @return mixed
     */
    public function getUserOrderOne()
    {
        $id=Request::input('id');
        $uid=Token::getCurrentTokenVar('id');
        $data['order']=OrderModel::where(['order_id'=>$id,'user_id'=>$uid])->first();
        $data['order_goods']=OrderGoodsModel::where('order_id',$id)->get();
        return $this->go($data);
    }

    /**
     * 删除一条自己未支付的订单
     * @param string $id
     * @return int
     */
    public function deleteOrder($id = "")
    {
        $id=Request::input('id');
        $uid = Token::getCurrentTokenVar('id');
        $res=OrderModel::deleteOrder($id, $uid);
        return $this->go($res);
    }

    /**
     * 搜索订单
     * @param $name
     * @return mixed
     */
    public function SearchOrder()
    {
        $name=Request::input('name');
        $uid = Token::getCurrentTokenVar('id');
        $order_id = OrderGoodsModel::where('user_id', $uid)->where('goods_name', 'like', '%' . $name . '%')->get('order_id');
        $order_id=$order_id->toArray();
        $data=OrderModel::whereIn('order_id',$order_id)->get();
        return $this->success($data);
    }

    /**
     * 提交评价
     * @return mixed
     */
    public function set_pj()
    {
        $uid=Token::getCurrentTokenVar('id');
        $rule=[
            'id' => 'required',
            'goods_id' => 'required',
            'rate' => 'numeric',
            'content' => 'required',
            'imgs' => 'min:0',
        ];
        $post = Request::toArray();
        $this->validate($post,$rule);
        $post['rate']=$post['rate']<1?5:$post['rate'];
        $res= OrderModel::setPj($uid,$post);
        return $this->go($res);
    }

    /**
     * 提交退款申请
     * @return mixed
     */
    public function tuikuan_approve()
    {
        $post = Request::toArray();
        $uid = Token::getCurrentTokenVar('id');
        return (new OrderModel)->tuikuan_approve($uid,$post);

    }

    /**
     * 确认收货
     * @param $id
     * @return mixed
     */
    public function receive()
    {
        $id=Request::input('id');
        //$uid=Token::getCurrentTokenVar('id');
        $where['shipment_state'] = 1;
        $where['payment_state'] = 1;
        $where['state'] = 0;
        $where['order_id'] = $id;
        $order = OrderModel::where($where)->first();
        if (!$order) {
            return $this->fail('订单状态有误');
        }
        OrderModel::where('order_id',$id)->update(['state'=>1]);
        return $this->success();
    }

}