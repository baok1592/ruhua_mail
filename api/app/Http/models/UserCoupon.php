<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Http\models\UserCoupon as UserCouponModel;
use Illuminate\Support\Facades\Request;

class UserCoupon extends BaseModel
{
    protected $dateFormat='U';
    public $guarded=[];
    //优惠券列表
    public static function get_coupon_list()
    {
        $uid = Token::getCurrentTokenVar('id');
      
        $data['type'] = 1;
        $user_coupon = self::where('user_id', $uid)->get();
        $res = Coupon::get();
        foreach ($res as $k => $v) {
            $res[$k]['uesr_status'] = 1;
            if (strtotime($v['end_time']) && strtotime($v['end_time']) < time()) {
                unset($res[$k]);
                continue;
            }
            if ($v['goods_ids'] != 0) {
                $res[$k]['goods_ids'] = explode(',', $v['goods_ids']);
            }
            if ($v['status'] == 1) {
                foreach ($user_coupon as $value) {
                    if ($v['id'] == $value['coupon_id']) {
                        $res[$k]['uesr_status'] = 0;
                        break;
                    }
                }
            } else if ($v['status'] == 2) {

                foreach ($user_coupon as $value) {
                    if ($v['id'] == $value['coupon_id'] && $value['status'] < 2) {
                        $res[$k]['uesr_status'] = 0;
                        break;
                    }
                }
            }

        }
        $arr=array();
        $i=0;
        foreach ($res as $k=>$v){
            $arr[$i++]=$v;
        }
        
        return $arr;
    }
    /**
     * 用户领取优惠券
     * @param $id
     * @return mixed
     * @throws BaseException
     */
     
    public static function addUserCoupon($id)
    {
        $uid = Token::getCurrentTokenUid();
        $coupon = Coupon::where('id', $id)->first();
        $userCoupon = self::where('user_id', $uid)->where('coupon_id', $id)->orderByDesc('id')->first();
        if (!$coupon) {
            throw new BaseException('优惠卷错误！');
        }
        if ($coupon['stock_type'] == 0 && $coupon['stock'] == 0) {
            throw new BaseException('库存不够');
        } else if ($coupon['stock_type'] == 0) {
            $coupon['stock'] -= 1;
        }
        if ($coupon['status'] == 1 && $userCoupon) {
            throw new BaseException('该优惠券只能领取一次');
        } else if ($coupon['status'] == 2 && $userCoupon) {
            if ($userCoupon['status'] != 2 && $userCoupon['status'] != 3) {
                throw new BaseException('已领取');
            }
        }
        $data['user_id'] = $uid;
        $data['coupon_id'] = $id;
        $data['full'] = $coupon['full'];
        $data['reduce'] = $coupon['reduce'];
       // $data['ucid']=Token::getCurrentTokenVar('ucid');
       $data['ucid']=0;
        if ($coupon['end_time']) {
            $data['end_time'] = strtotime($coupon['end_time']);
        } else {
            $data['end_time'] = strtotime('+' . $coupon['day'] . ' day', time());
        }
        DB::beginTransaction();
        try {
            $res = self::create($data);
            $coupon->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new BaseException($e->getMessage());
        }
//        return app('json')->success($res['id']);
        return $res['id'];
    }

    /**
     * 用户查看自己的优惠券
     * @return \think\Collection
     */
    public function selectUserCoupon($uid)
    {
        $this->validateCoupon($uid); //验证过期
        $res = UserCouponModel::with('coupon')->where('user_id',$uid)->get();
        return $res;
    }
    public function coupon(){
        return $this->belongsTo('App\Http\models\Coupon', 'coupon_id', 'id');
    }
    /**
     * 验证是否过期
     * @param $uid
     * @return \app\controller\user\UserCoupon
     */
    private function validateCoupon($uid)
    {
        $res = UserCouponModel::where('user_id', $uid)->where('end_time', '<', time())->update(['status' => 3]);
        return $res;
    }
    /**
     * 用户查看订单可用优惠券
     * @param $uid
     * @param $ids
     * @return mixed
     */
    public static function  couponStatus($uid, $total_money)
    {
        $coupon = UserCouponModel::with('coupon')->where('user_id', $uid)->where('status', 0)
            ->where('end_time', '>', time())
            ->get();
        $arr=array();
        $i=0;
        foreach ($coupon as $k => $v) {
            if($total_money<$v['full']){
                unset($coupon[$k]);
            }else{
                $arr[$i++]=$v;
            }
        }
        return $arr;
    }
    /**
     * 删除用户过期优惠券
     */
    public static function delUserCoupon(){
        $time=time()-10*24*60*60;
        self::where('status',3)->whereTime('end_time','<',$time)->delete();
    }
    public function getEndTimeAttribute($value)
    {
        return date('Y-m-d',$value);
    }

}