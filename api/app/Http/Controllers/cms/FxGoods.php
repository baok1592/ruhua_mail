<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/1/30 0030
 * Time: 10:00
 */

namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\FxGoods as FxGoodsModel;
use App\Http\models\Goods as GoodsModel;

class FxGoods extends BaseController
{
    /**
     * 添加分销商品
     */
    public function add_fxgoods()
    {
        $data=Request::toArray();
        $res=FxGoodsModel::add_fxgoods($data);
        return $this->go($res);
    }

    public function update_fx_goods()
    {
        $data=Request::toArray();
        $res=FxGoodsModel::update_fx($data);
        return $this->go($res);
    }

    public function get_fx_goods()
    {
        $res=FxGoodsModel::with('goods')->get();
        return $this->go($res);
    }

    public function del_fx_goods()
    {
        $data=Request::toArray();
        $res=FxGoodsModel::destroy($data['ids']);
        return $this->go($res);
    }

    public function get_no_fx_goods()
    {
        $fx_ids=FxGoodsModel::select(['goods_id'])->get();
        $ids=array();
        foreach ($fx_ids as $k=>$v){
            $ids[$k]=$v['goods_id'];
        }
        $goods=GoodsModel::with(['imgs','video'])->whereNotIn('goods_id',$ids)->get();



        return $this->go($goods);
    }
}