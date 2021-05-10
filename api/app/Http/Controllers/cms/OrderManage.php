<?php


namespace App\Http\Controllers\cms;


use App\Http\models\OrderGoods;
use App\ruhua\bases\BaseController;
use App\Http\models\Order as OrderModel;
use Illuminate\Support\Facades\Request;
use App\Http\models\OrderLog;
use function PHPUnit\Framework\isEmpty;

class OrderManage extends BaseController
{
    /**
     * 代发货订单提醒
     * @return mixed
     */
    public function checkDrive()
    {
        $res = OrderModel::where(['state' => 0, 'payment_state' => 1, 'shipment_state' => 0])->count();
        return $this->success($res);
    }


    /**
     * cms删除订单
     * @param string $id
     * @return int
     */
    public function deleteOrder()
    {
        $id=Request::input('id');
        $result = OrderModel::where('order_id', $id)->delete(); //这里是软删除
        return $this->go($result);
//        return $result?1:0;
    }

    /**
     * CMS获取所有订单简要
     * @return string
     */
    public function getOrderAll()
    {
        $keyword=Request::input('wordkey');
        $playsate=Request::input('playstate');
        $starttime=Request::input('starttime');
        $endtime=Request::input('endtime');
        //$order_num=Request::input('order_num')?:'';
        $where1=null;
        $where=[];
//        if(!empty($keyword)){
//            $order_list=OrderGoods::WhereRaw("(concat(goods_name) like '%".$keyword."%')")->pluck('order_id');
//            $where1 = array_values($order_list->toArray());
//        }
//        else{
//            $order_list=OrderGoods::pluck('order_id');
//            $where1 = array_values($order_list->toArray());
//        }
        if($playsate!=''){
            $where[]=['payment_state','=',intval($playsate)];
        }
        if(!empty($starttime)){
            $where[]=['created_at','>=',strtotime($starttime)];
        }
        if(!empty($endtime)){
            $where[]=['created_at','<=',strtotime($endtime)];
        }
        if(!empty($keyword)){
            $where1="(concat(order_num,receiver_mobile) like '%".$keyword."%')";
            $data = OrderModel::with(['ordergoods.imgs', 'users' => function ($query) {
                $query->select('id','nickname','headpic');
            }])->where($where)->whereRaw($where1)->orderByDesc('created_at')->get();
            return $this->success($data);
        }
        else{
            //dump($where);
            $data = OrderModel::with(['ordergoods.imgs', 'users' => function ($query) {
                $query->select('id','nickname','headpic');
            }])->where($where)->orderByDesc('created_at')->get();
            return $this->success($data);
        }
    }
    /**
     * 商品销量统计
     * */
    public function order_stats(){
        $data = OrderGoods::order_stats();
        return $this->go($data);
    }

    /**
     * 获取指定订单详细--CMS
     * @param string $id
     * @return mixed
     */
    public function GetOrderOne()
    {
        $id=Request::input('id');
        $data['order'] = OrderModel::with(['imgs','users' => function ($query) {
            $query->select('id','nickname','headpic');
        }])->where(['order_id' => $id])->first();
        $data['log'] = OrderLog::where(['order_id' => $id])->orderByDesc('created_at')->get();
        return $this->success($data);
    }


    /**
     * 发货--更新订单配送信息
     * @return bool
     */
    public function editCourier()
    {
        $order_id = Request::input('id');
        $res=OrderModel::where('order_id',$order_id)->update(['shipment_state'=>1]);
        return $this->go($res);
    }

    /**
     * 添加订单备注信息
     * @return mixed
     */
    public function editRemark()
    {
        $rule = [
            'remark' => 'require',
            'order_id' => 'require|number',
        ];
        $param = Request::param();
        $this->validate($param, $rule);
        return OrderModel::up_remark_model($param);
    }

    /**
     * 修改订单价格
     * @return mixed
     */
    public function edit_price()
    {
        $rule = [
            'price' => 'require',
            'order_id' => 'require|number',
        ];
        $param = Request::param();
        $this->validate($param, $rule);
        return OrderModel::edit_price_model($param);
    }

}