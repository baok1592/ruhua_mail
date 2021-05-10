<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/1/30 0030
 * Time: 9:17
 */

namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BaseException;
use App\Http\models\Goods as GoodsModel;
use Illuminate\Support\Facades\Log;
use App\Http\models\Goods;

class FxGoods extends BaseModel
{

    protected $dateFormat='U';
    public $incrementing=true;
    public $guarded=[];
    protected $hidden = ['created_at', 'updated_at', 'user_id'];

    public function goods()
    {
        return $this->belongsTo('App\Http\models\Goods','goods_id','goods_id');
    }

    public static function add_fxgoods($data)
    {
        DB::beginTransaction();
        $res=array();
        try {
           foreach ($data as $k=>$v){
               $goods=GoodsModel::where('goods_id',$v['goods_id'])->first();
               if($goods){
                   if($goods['price']<$v['price'])
                       throw new BaseException('佣金不能大于价格');

                   $res=self::create($v);
               }




           }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();// 回滚事务
            throw new BaseException($e->getMessage());
        }
        return $res;
    }

    public static function update_fx($data)
    {
        DB::beginTransaction();
        $res=array();
        try {
            foreach ($data as $k=>$v){
                $goods=GoodsModel::where('goods_id',$v['goods_id'])->first();
                if($goods){
                    if($goods['price']<$v['price'])
                        throw new BaseException('佣金不能大于价格');

                    if(isset($v['created_at']))
                        unset($v['created_at']);
                    if(isset($v['updated_at']))
                        unset($v['updated_at']);
                    $res=self::where('id',$v['id'])->update($v);
                }


            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();// 回滚事务
            throw new BaseException($e->getMessage());
        }
        return $res;
    }
    
      public static function add_fx($data,$invite_code)
    {
        DB::beginTransaction();
        $res=array();
        $user=User::where('invite_code',$invite_code)->first();
        if(!$user){
            return false;
        }
        try {
            $moeny=$user['money'];
            foreach ($data as $k=>$v){
                $fx_goods=GoodsModel::where('goods_id',$v)->first();
                if($fx_goods['fx_money']>0){
                    $moeny=$fx_goods['fx_money'];
                }
            }
            User::where('id',$user['id'])->update(['money'=>$moeny]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();// 回滚事务
            throw new BaseException($e->getMessage());
        }
    }

}