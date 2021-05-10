<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;

class OrderGoods extends BaseModel
{
    use SoftDeletes;
    public $dateFormat='U';
    protected $guarded = [];
    public function imgs()
    {
        return $this->belongsTo('App\Http\models\Image','pic_id','id')->select('id','url');
    }
    //商品销售统计
    public static function order_stats(){
        $post=Request::toArray();
        if(isset($post['goods_id']) && !empty($post['goods_id'])) {
            $where=['goods_id','in',$post['goods_id']];
        }
        if(isset($post['stat_time'])&&!empty($post['stat_time'])&&isset($post['end_time'])&&!empty($post['end_time'])){
            $where=[['create_time','>=',$post['stat_time']],['create_time','<=',$post['end_time']]];
        }
        else{
            $post['stat_time']=strtotime(date("Y-m-d H:i:s", strtotime("-1 month")));
            $post['end_time']=time();
            $where=[['created_at','>=',$post['stat_time']],['created_at','<=',$post['end_time']]];
        }
        $data = self::where('state',1)->where($where)->groupBy('goods_id')->get('goods_id','goods_name','price','sum(num)');
        return $data;
    }


}