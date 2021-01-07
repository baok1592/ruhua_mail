<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\Http\models\Order;
use Illuminate\Support\Facades\Request;


class EditOrder extends BaseController
{
    //获取所有暂不付款订单
    public function getAll(){
        $res=Order::where('pay_cate','=','3')->get();
        return $this->go($res);
    }
    public function editPay(){
        $id=Request::input('id');
        $order=Order::where(["order_id"=>$id,"pay_cate"=>"3",'pay_time'=>time()])->get();
        //return json($order);
        if(!$order)
            return $this->fail('无此订单！');
        $data['payment_state']=1;
        $res=order::where('order_id',$id)->update($data);
        return $this->go($res);
    }

}