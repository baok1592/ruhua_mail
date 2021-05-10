<?php


namespace App\Http\Controllers\user;


use App\Http\models\Coupon;
use App\ruhua\bases\BaseController;
use App\Http\models\UserCoupon as UserCouponModel;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Request;

class UserCoupon extends BaseController
{
    /**
     * 用户查看优惠券
     * @param string $type
     * @param int $shop
     * @return mixed
     */
    public function getCoupon()
    {
        $data=UserCouponModel::get_coupon_list();
        if(!$data){
            return $this->fail('暂无数据');
        }
        return $this->success($data);
//        return json($data);
    }

    /**
     * 用户领取优惠券
     * @param $id
     * @return mixed
     */
    public function addUserCoupon()
    {
        $id=Request::input('id');
     
        $res=UserCouponModel::addUserCoupon($id);
        return $this->go($res);
    }

    /**
     * 用户查看自己的优惠券
     * @return \think\Collection
     */
    public function selectUserCoupon()
    {
        $uid = Token::getCurrentTokenVar('id');
        $this->validateCoupon($uid); //验证过期
        $res= (new UserCouponModel())->selectUserCoupon($uid);
        return $this->go($res);
    }

    /**
     * 验证是否过期
     * @param $uid
     * @return static
     */
    private function validateCoupon($uid)
    {
        $res = UserCouponModel::where('user_id', $uid)->where('end_time', '<', time())->update(['status' => 3]);
        return $res;
    }

    /**
     * 用户查看订单可用优惠券
     * @return mixed
     */
    public function selectStatusCoupon()
    {
        $total_money=Request::input('total_money');
        $uid = Token::getCurrentTokenVar('id');

        $this->validateCoupon($uid);
        $res= UserCouponModel::couponStatus($uid,$total_money);
        return $this->go($res);
    }

}