<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Reduction extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dateFormat='U';
    protected $hidden = ['delete_time'];
    //关联满减活动商品
    public function reductionGoods()
    {
        $data=$this->hasMany('App\Http\models\ReductionGoods','reduction_id','id');
        return $data;
    }
    //添加满减活动
    public static function addReduction($post){
        $hd_res = self::where('name', $post['name'])->first();
        if ($hd_res) {
            throw new BaseException("活动已存在");
        }
        DB::beginTransaction();
        try {
            $post['start_time']=strtotime($post['start_time']);
            $post['end_time']=strtotime($post['end_time']);
            $data=$post;
            unset($data['goods_json']);
            $res = self::create($data);
            foreach ($post['goods_json'] as $k => $v) {
                $goods = Goods::where('goods_id', $v)->first();
                if (!$goods) {
                    throw new BaseException("没有这个商品");
                }
                $reduction_goods = ReductionGoods::where('goods_id', $v)->first();
                if ($reduction_goods) {
                    throw new BaseException("商品在其他活动中");
                }
                ReductionGoods::create([
                    'goods_id' => $v,
                    'reduction_id' => $res['id'],
                ]);
            }
            DB::commit();
            return $res['id'];
        } catch (\Exception $e) {
            DB::rollback();
            throw new BaseException($e->getMessage());
        }
    }
    //删除满减活动
    public static function delReduction($id){
        self::destroy($id);//软删除
        $res=Db::table('reduction_goods')->where('reduction_id',$id)->delete();
        if(!$res){
            throw new BaseException("删除满减活动商品失败");
        }
        return $res;
    }
    //修改满减活动
    public static function editReduction($post)
    {
        $res = self::where('id', $post['id'])->first();
        DB::beginTransaction();
        try {
            $post['start_time']=strtotime($post['start_time']);
            $post['end_time']=strtotime($post['end_time']);
            $data=$post;
            unset($data['goods_json']);
            self::where('id', $post['id'])->update($data);
            ReductionGoods::where('reduction_id', $post['id'])->delete();
            foreach ($post['goods_json'] as $k => $v) {
                $goods = Goods::where('goods_id', $v)->first();
                if (!$goods) {
                    throw new BaseException('商品不存在');
                }
                $reduction_goods = ReductionGoods::where('goods_id', $v['goods_id'])->first();
                if ($reduction_goods) {
                    throw new BaseException('商品在其他活动中');
                }
                ReductionGoods::create([
                    'goods_id' => $v,
                    'reduction_id' => $post['id'],
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new BaseException($e->getMessage());
        }
    }
    public function getEndTimeAttribute($value)
    {
        return date('Y-m-d h:i:s',$value);
    }
    public function getStartTimeAttribute($value)
    {
        return date('Y-m-d h:i:s',$value);
    }

}