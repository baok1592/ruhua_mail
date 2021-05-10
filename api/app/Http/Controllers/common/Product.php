<?php


namespace App\Http\Controllers\common;


use App\Http\models\Image;
use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\Goods as GoodsModel;
use App\Http\models\Category as CategoryModel;
use App\Http\models\Rate as RateModel;

class Product extends BaseController
{
    /**
     * 获取某商品详情
     * @param string $id
     * @return \think\response\Json
     */
    public function getProduct()
    {
        $id=Request::input('id');
        $good=GoodsModel::getProduct($id);
        //$data=gettype($good);
        return $this->go($good);
    }

    /**
     * 获取最新商品
     * @param string $type
     * @return \think\Collection|void
     */
    public function getRecent()
    {
        $type=Request::input('type');
        $data = GoodsModel::getRecentAll($type);
        return $this->success($data);
    }


    /**
     * 获取所有商品
     * @param $id
     * @return \think\Collection
     */
    public function getProducts()
    {
        $data = GoodsModel::getGoods();
        return $this->success($data);
    }

    /**
     * 获取某分类下所有商品
     * @param string $id
     * @return \think\response\Json
     */
    public function getCatePros()
    {
        $id=Request::input('id');
        $ids=CategoryModel::where(['pid'=>$id])->get('category_id')->toArray();
        $ids=array_column($ids,'category_id');
        if(count($ids)){
            array_push($ids,$id);
            $data = GoodsModel::with('sku')->where('state',1)->whereIn('category_id',$ids)->select('goods_id','goods_name','img_id','market_price','price','description')->get();
        }else{
            $ids=$id;
            $data = GoodsModel::with('sku')->where('state',1)->where('category_id',$ids)->select('goods_id','goods_name','img_id','market_price','price','description')->get();
        }
        return $this->success($data);
    }

    /**
     * 获取某个商品的所有评价
     * @param $id
     * @return \think\response\Json
     */
    public function getEvaluate()
    {
        $id=Request::input('id');
        $list=RateModel::where('goods_id',$id)->orderByDesc('id')->limit(20)->get();
        foreach ($list->toArray() as $v){
            $imgids=explode(',',$v['imgs']);
            $imgs=Image::whereIn('id',$imgids)->get();
            $v['imgs']=[];
            if($imgs->count()){
                foreach ($imgs->toArray() as $k){
                    array_push($v['imgs'],$k['url']);
                }
            }
            $data[]=$v;
        }
        return $this->success($data);
    }

}