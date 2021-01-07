<?php


namespace App\Http\Controllers\cms;


use App\Http\Controllers\server\Payment;
use App\Http\models\Order as OrderModel;
use App\Http\models\Tui as TuiModel;
use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;

class TuiManage extends BaseController
{
    /**
     * cms 获取所有退款信息
     * @return mixed
     */
    public function getTuiAll()
    {
        $res = TuiModel::all();
        return $this->go($res);
    }

    /**
     * 微信退款
     * @param string $id
     * @return mixed
     */
    public function TuiMoney()
    {
        $data=Request::toArray();
        $config=["notify_url"=>'http://wodidewo.icu',"refund_account"=>'如花外卖点餐'];
        $res=(new Payment())->playConfig()->refund($data['order_num'],$data['tui_num'],$data['money'],$data['money'],$config);

        return $this->go($res);
    }

    /**
     * 退款申请驳回
     * @param $id
     * @param $msg
     * @return mixed
     */
    public function TuiBoHui()
    {
        $post=Request::toArray();
        $res=TuiModel::where('id',$post['id'])->update(['message'=>$post['message'],'status'=>2]);
        return $this->go($res);
    }


}