<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\Http\models\Reduction as ReductionModel;
use Illuminate\Support\Facades\Request;
use App\Http\models\ReductionGoods;
use App\Http\models\Goods;

class Reduction extends BaseController
{
    //获取满减活动
    public function getReduction(){
        $data=ReductionModel::where(['statu'=>1])->where('end_time','>',time())->get();
        if(!$data){
            return $this->fail('暂无数据');
        }

        return $this->success($data);
    }

    //获取某个满减活动
    public function getOneReduction(){
        $id=Request::input('id');
        $res['reduction']=ReductionModel::where(['id'=>$id,'statu'=>1])->where('end_time','>',time())->first();
        if(!$res['reduction']){
            return $this->fail('暂无数据');
        }
        $gs=ReductionGoods::where(['reduction_id'=>$id])->get('goods_id');
        if (!count($gs)>1)
            return $this->success();
        $ids=[];
        foreach ($gs as $i){
            array_push($ids,$i['goods_id']);
        }
        $res['goods']=Goods::with('sku')->whereIn('goods_id',$ids)->select('goods_id','goods_name','img_id','market_price','price','description')->get();
        return $this->success($res);
    }

    //添加满减活动
    public function addReduction(){
        $rule=[
            'name'=>'required',
            'full'=>'required',
            'reduce'=>'required',
            'end_time'=>'required',
        ];
        $post=Request::toArray();
        $this->validate($post,$rule);
        $data=ReductionModel::addReduction($post);
        return $this->success($data);
    }
    //删除满减活动
    public function deleteReduction(){
        $id=Request::input('id');
        $data=ReductionModel::delReduction($id);
        return $this->go($data);
    }
    //获取没有满减的商品
    public function getNoGoods(){
        $goods_ids=ReductionGoods::get('goods_id');
        $ids=[];
        foreach ($goods_ids as $id){
            array_push($ids,$id['goods_id']);
        }
        $data = Goods::whereNotIn('goods_id',$ids)->get();
        if(!$data){
            return $this->fail('暂无数据');
        }
        return $this->success($data);
    }
    //修改满减活动
    public function editReduction(){
        $post=Request::toArray();
        $res=ReductionModel::editReduction($post);
        return $this->go($res);

    }
    //获取所有满减商品
    public function getReductionGoods(){
        $reduction=new ReductionModel();
        $rids=$reduction->where(['statu'=>1])->where('end_time','>',time())->get('id');
        if(!$rids){
            return $this->fail('暂无数据');
        }
        $ids=ReductionGoods::whereIn('reduction_id',$rids)->select('goods_id','reduction_id')->get();
        //$ids->toArray();
        $ids=$ids->toArray();
        if(!$ids){
            return $this->fail();
        }
        $goods=new Goods();
        $i=0;
        $data=[];
        foreach ($ids as $v){
            $arr=$goods->with('sku')->where('goods_id',$v['goods_id'])->first();
            $r=$reduction->where('id',$v['reduction_id'])->first();
            $arr['reduction']=$r;
            $data[$i]=$arr;
            $i++;
        }
        return $this->go($data);
    }

}