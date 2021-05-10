<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\Coupon as CouponModel;

class CouponManage extends BaseController
{
    /**
     * 商家创建店铺优惠券
     * @return mixed
     */
    public function addCoupon()
    {
        $rule = [
            'full' => 'required|numeric',
            'reduce' => 'required|numeric',
            'name' => 'required|max:60',
            'status' => 'required',
        ];
        $post = Request::toArray();
        $this->validate($post, $rule);
        $res=CouponModel::addCoupon($post);
        return $this->go($res);
    }

    /**
     * cms查看优惠券
     * @return \think\response\Json
     */
    public function getCoupon()
    {
        $data=CouponModel::all();
        return $this->success($data);
    }

    /**
     * 删除优惠券
     * @param $id
     * @return int
     */
    public function deleteCoupon()
    {
        $id=Request::input('id');
        $res = CouponModel::where('id', $id)->delete();
        return $this->go($res);
    }

}