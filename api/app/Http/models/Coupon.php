<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;

class Coupon extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dateFormat='U';
    /**
     * 关联CouponGoods
     * @return \think\model\relation\HasMany
     */
    public function couponGoods()
    {
        return $this->hasMany('App\Http\models\CouponGoods', 'coupon_id', 'id');
    }

    /**
     *添加优惠卷
     * @param $post
     * @return mixed
     */
    public static function addCoupon($post)
    {
        if ($post['status'] != 1 && $post['status'] != 2) {
            throw new BaseException('优惠券status错误');
        }
        $data = self::setCouponDate($post);
        $res = self::create($data);
        return $res['id'];
//        return $res->id;
    }

    //组装数据
    private static function setCouponDate($post)
    {
        if (array_key_exists('status', $post)) {
            $data['status'] = $post['status'];
        }
        if ($post['stock_type']) {
            $data['stock_type'] = 1;
        } else {
            $data['stock_type'] = 0;
            if (!array_key_exists('stock', $post)) {
                throw new BaseException( 'stock未填');
            }
            $data['stock'] = $post['stock'];
        }
        $data['full'] = $post['full'];
        $data['reduce'] = $post['reduce'];
        $data['name'] = $post['name'];
        if ($post['start_time']) {
            $data['start_time'] = strtotime($post['start_time']);
            if (!$post['end_time']) {
                throw new BaseException( 'end_time未填');
            }
            $data['end_time'] = strtotime($post['end_time']);
        }
        if ($post['day']) {
            $data['day'] = $post['day'];
        }
        return $data;
    }
    public function getEndTimeAttribute($value)
    {
        if($value)
            return date('Y-m-d',$value);
        else
            return $value;
    }
    public function getStartTimeAttribute($value)
    {
        if($value)
            return date('Y-m-d',$value);
        else
            return $value;
    }

}