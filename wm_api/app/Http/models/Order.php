<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\models\User as UserModel;

class Order extends BaseModel
{
    use SoftDeletes;
    public $dateFormat='U';
    protected $guarded = [];
    protected $deleteTime = 'delete_time';
    protected $hidden = ['delete_time'];

    /**
     * 用户删除订单
     * @param $uid
     * @param $id
     * @return int
     */
    public static function deleteOrder($id, $uid)
    {
        $res=false;
        $order = self::where(['order_id' => $id])->first();
        if ($order['user_id'] == $uid) {
            $res=self::where('order_id',$id)->delete();   //这里是软删除
        }
        return $res;
    }

    /**
     * 用户提交评价
     * @param $uid
     * @param $post
     * @return mixed
     * @throws
     */
    public static function setPj($uid, $post)
    {
        $where['user_id'] = $uid;
        $where['order_id'] = $post['id'];
        $order = self::where($where)->where(['state' => 1])->first();
        if (!$order) {
            throw new BaseException('评价出现错误');
        }
        $orderGoods = new OrderGoods();
        $order_id = $order['order_id'];
        $goods_ids = $orderGoods->where('order_id', $order_id)->get('goods_id');
        $goods_ids=array_column($goods_ids->toArray(),'goods_id');
        $user=UserModel::find($uid);
        //foreach ($post['goods_id'] as $v){
            if (in_array($post['goods_id'], $goods_ids)) {
                $data['user_id'] = $where['user_id'];
                $data['rate'] = $post['rate'];
                $data['content'] = $post['content'];
                $data['order_id'] = $order_id;
                $data['goods_id'] = $post['goods_id'];
                $data['headpic'] = $user['headpic'];
                $data['nickname'] = $user['nickname'];
                $data['ucid']=Token::getCurrentTokenVar('ucid');
                $data['imgs'] = implode(',',$post['imgs']);
                $data['created_at'] = time();
            }
            DB::beginTransaction();
            try {
                $i=OrderGoods::where(['order_id' => $post['id'], 'user_id' => $uid, 'goods_id' => $post['goods_id']])->update(['state' => 2]);
                $status=OrderGoods::Where(['order_id' => $post['id'],'state'=>1])->first();
                if(!$status){
                    $order->save(['state' => 2]);
                }
                Rate::create($data);
                DB::commit();
            } catch (\Exception $e) {
                Db::rollback();
                throw  new BaseException($e->getMessage());
            }
        //}
        return true;
    }



    /**
     * 申请退款
     * @param $uid
     * @param $post
     * @return mixed
     * @throws
     */
    public function tuikuan_approve($uid, $post)
    {

        $user = User::find($uid);
        $order = self::where('order_id',$post['order_id'])->first();
        $data['order_id'] = $order['order_id'];
        $data['nickname'] = $user['nickname'];
        $data['order_num'] = $order['order_num'];
        $data['money'] =$order['money'];
        $data['because'] = $post['radio'] ?: "";
        $data['message'] = $post['content'] ?: "";
        $data['ip'] =  $data['user_ip'] = (new Request())->ip(); //买家IP
        Db::startTrans();

        try {
            if($data['goods_id']==0){
                $order->save(['state' => -1]);
            }else{
                $goodsWhere['goods_id']=$post['goods_id'];
            }
            $goodsWhere['order_id']=$post['order_id'];
            $goodsWhere['user_id']=$uid;
            OrderGoods::where($goodsWhere)->update(['state' => -1]);
            $tui = Tui::create($data);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            throw new OrderException(['msg' => '更新失败']);
        }
        if ($tui) {
            return app('json')->success();
        } else {
            return app('json')->fail();
        }
    }
    /**
     * 添加订单备注信息
     * @param $param
     * @return mixed
     * @throws
     */
    public static function up_remark_model($param)
    {
        Db::startTrans();
        try {
            self::where('order_id', $param['order_id'])->update(['remark_one' => $param['remark']]);
            $save['order_id'] = $param['order_id'];
            $save['type_name'] = '添加备注';
            $save['content'] = $param['remark'];
            OrderLog::create($save);
            Db::commit();
            return app('json')->success();
//            return true;
        } catch (\Exception $e) {
            Db::rollback();// 回滚事务
            throw new OrderException(['msg' => '备注信息录入失败']);
        }
    }

    /**
     * 修改订单价格
     * @param $param
     * @return mixed
     * @throws
     */
    public static function edit_price_model($param)
    {
        Db::startTrans();
        try {
            $order = self::where('order_id', $param['order_id'])->find();
            $order['edit_money'] = $param['price'];
            $order['order_money'] = $order['order_money'] + $order['edit_money'];
            $order['order_num'] = $order['order_num'].'B';
            if ($order['order_money'] <= 0) {
                return app('json')->fail('价格错误');
            }
            $order->save();
            $save['order_id'] = $param['order_id'];
            $save['type_name'] = '修改订单金额';
            $save['content'] = $param['price'];
            OrderLog::create($save);
            Db::commit();
            return app('json')->success();
        } catch (\Exception $e) {
            Db::rollback();// 回滚事务
            throw new OrderException(['msg' => $e->getMessage()]);
        }
    }


    /**
     * 关闭订单
     */
    public static function closeOrder()
    {
        $where['state'] = 0;
        $where['payment_state'] = 0;
        $time = time() - 15 * 60; //1关闭15分钟未支付的订单
        self::where($where)->whereTime('create_time', '<', $time)->update(['state' => -3]);
    }

    /**
     * 获取订单指定字段
     * @param $id
     * @param $field
     * @return mixed
     */
    public static function getOrderAttr($id, $field)
    {
        $value = self::where('order_id', $id)->value($field);
        if (!$value) {
            throw new BaseException('获取字段失败');
        }
        return $value;
    }


    //关联规格模型
    public function sku()
    {
        return $this->hasMany('App\Http\models\GoodsSku', 'goods_id', 'goods_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Http\models\User', 'user_id', 'id');
    }

    //关联订单商品模型
    public function ordergoods()
    {
        return $this->hasMany('App\Http\models\OrderGoods', 'order_id', 'order_id');
    }

    //关联评价模型
    public function rate()
    {
        return $this->hasMany('App\Http\models\Rate', 'order_id', 'order_id');
    }

    //关联图片
    public function imgs()
    {
        return $this->belongsTo('App\Http\models\Image', 'goods_picture', 'id')->select('id','url');
    }
    public function invitecode()
    {
        return $this->belongsTo('App\Http\models\User','invite_code','invite_code');
    }

}