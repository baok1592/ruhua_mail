<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Request;
use App\Http\models\ReductionGoods;
use App\Http\models\Goods as GoodsModel;

class ProductManage extends BaseController
{
    /**
     * cms 添加商品
     */
    public function addProduct()
    {
        $rule = [
            'goods_name' => 'required',
            'category_id' => 'required',  //分类id
            'description' => 'max:200', //描述
            'sales' => 'max:200',  //销量
            'market_price' => 'required', //市场价格
            'price' => 'required', //单价
            'stock' => 'required',  //库存
            'content' => 'min:0',  //商品详情
            'detailimgs'=>'required',  //商品详情图

        ];
        $post=Request::toArray();
        $this->validate($post,$rule);
        $res=GoodsModel::addProduct($post);
        return $res?$this->success():$this->fail();
    }

    /**
     * cms 修改商品
     * @return int
     */
    public function EditProduct()
    {
        $post = Request::toArray();
        $res=GoodsModel::editProduct($post);
        return $res?$this->success():$this->fail();
    }

    /**
     * cms 删除商品
     * @param string $id
     * @return int
     */
    public function deleteProduct()
    {
        $id=Request::input('id');
        $result = GoodsModel::where(['goods_id' => $id])->delete();   //这里是软删除
        if (!$result) {
            return $this->fail();
        }
        ReductionGoods::where('goods_id',$id)->delete();
        return $this->success();
    }

    /**
     * 更新分类排序
     * @return int
     */
    public function setSort()
    {
        $arr = Request::toArray();
        $res=GoodsModel::setSort($arr);
        return $res?$this->success():$this->fail();
    }

    /**
     * 获取所有上架商品，包含分页
     * @param string $key
     * @return \think\response\Json
     */
    public function getProduct()
    {
        $res=GoodsModel::getProductByPage();
        return $res?$this->success($res):$this->fail();
    }

    /**
     * 获取所有下架商品
     * @return \think\response\Json
     */
    public function getProductsDown()
    {
        $data = GoodsModel::with('imgs')->where('state', 0)->orderBy('created_at','asc')->get();
        return $this->success($data);
    }

    /**
     * mcms获取所有商品简略
     * @return \think\Collection
     */
    public function all_goods_info()
    {
        $res = GoodsModel::select('goods_id','goods_name','market_price','price','stock','sales','is_hot','is_recommend','is_new','state','img_id','sort')->orderBy('state','desc')
            ->orderBy('sort','asc')->get();
        return $this->success($res);
    }

    /**
     * mcms获取所有商品名称ID
     * @return \think\Collection
     */
    public function allGoodsName()
    {
        $res = GoodsModel::select('goods_id','goods_name')->get();
        return $this->success($res);
    }

    /**
     * 手机cms 修改商品
     * @return int
     */
    public function mEditProduct()
    {
        $rule = [
            'goods_id' => 'require',
            'goods_name' => 'require',//名称
            'stock' => 'require',  //库存
            'sales' => 'max:200',  //销量
            'market_price' => 'require', //市场价格
            'price' => 'require', //单价
        ];
        $post = input('post.');
        $this->validate($post, $rule);
        return GoodsModel::mobileEditProduct($post);
    }

    /**
     * 采集商品
     * @return \app\services\json
     */
    public function getCopyProductInfo(){
        return (new CopyProductService())->getRequestContents();
    }
    /**
     * 设置商品的属性
     */
    public function editGood(){
        $rule = [
            'goods_id' => 'required',
        ];
        $post = Request::toArray();
        $this->validate($post, $rule);
        $goods=GoodsModel::where('goods_id',$post['goods_id'])->update($post);
        return $this->go($goods);
    }

}