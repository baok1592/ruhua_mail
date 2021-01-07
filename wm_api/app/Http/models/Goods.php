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

class Goods extends BaseModel
{
    use SoftDeletes;
    protected $deleteTime = 'delete_time';
    protected $hidden = ['is_stock_visible', 'is_pre_sale', 'shipping_fee', 'is_bill'];
    protected $guarded = [];
    protected $dateFormat='U';
    /**
     * name获取某商品详情
     * @param $name
     * @return \think\Collection
     */
    public static function getProductByName($name)
    {
        $data = self::with(['sku'])->where('state', 1)->where('goods_name', 'like', '%' . $name . '%')
            ->orderByDesc('sales')->get();
        return $data;
    }
    /**
     * 获取某菜品详情
     * @param $id
     * @return \think\response\Json
     */
    public static function getProduct($id)
    {
        $res = self::with(['video','sku'])->where('goods_id', $id)->first();
        $res=$res->toArray();
        if(!$res){
            throw new BaseException( "没有这个商品");
        }
        //评论
        $res['rate'] = Rate::with('user')->where('goods_id', $id)->orderBy('id desc')->limit(1)->select();
        $num = Rate::where('goods_id', $id)->count();
        $res['rate_fen'] = 0;
        $res['rate_num'] = $num;
        if ($num > 0) {
            $fen = Rate::where('goods_id', $id)->sum('rate');
            $res['rate_fen'] = round($fen * 20 / $num, 2);
        }
        if (!empty($res['sku']) && count($res['sku']) > 0) {
            $sku_arr = json_decode($res['sku'][0]['json'],true);
            if ($sku_arr['tree']) {
                foreach ($sku_arr['tree'][0]['v'] as $k => $v) {
                    if (isset($v['img_id'])) {
                        $img_url = Image::where('id', $v['img_id'])->first();
                        $sku_arr['tree'][0]['v'][$k]['imgUrl'] = $img_url['url'];
                    }
                }
            }
            $res['sku_arr'] = $sku_arr;
        } else {
            $res['sku_arr'] = [];
        }
        return $res;
    }
    /**
     * 获取所有商品
     * @param $id
     * @return \think\Collection
     * @throws BaseException
     */
    public static function getGoods()
    {
        $data = self::with(['sku','category'])->where('state', 1)->orderByDesc('sort')->select('goods_id','goods_name','category_id','img_id','market_price','price','description')->get();
        if (!$data || count($data) < 1) {
            throw new BaseException('获取店铺商品失败或无数据');
        }
        return $data;
    }
    /**
     * 获取所有、最新、最热、推荐商品
     * @param $type
     * @return \think\Collection|void
     */
    public static function getRecentAll($type)
    {
        if ($type == 'new') {
            $data = self::with('sku')->where('is_new', 1)->where('state', 1)->select('goods_id','goods_name','img_id','market_price','price','description','bannerimgs','content','keywords')->orderByDesc('sort')->get();
        } else if ($type == 'hot') {
            $data = self::with('sku')->where('is_hot', 1)->where('state', 1)->select('goods_id','goods_name','img_id','market_price','price','description','bannerimgs','content','keywords')->orderByDesc('sort')->get();
        } else if ($type == 'recommend') {
            $data = self::with('sku')->where('is_recommend', 1)->where('state', 1)->select('goods_id','goods_name','img_id','market_price','price','description','bannerimgs','content','keywords')->orderByDesc('sort')->get();
        } else {
            $data = self::with('sku')->where('state', 1)->select('goods_id','goods_name','img_id','market_price','price','description','bannerimgs','content','keywords')->orderByDesc('sort')->get();
        }
        if (!$data || count($data) < 1) {
            throw new BaseException('获取最新商品失败或无数据');
        }
        return $data;
    }
    /**
     * 添加商品
     * @param $post
     * @return int
     * @throws BaseException
     */
    public static function addProduct($post)
    {
        DB::beginTransaction();// 启动事务
        try {
            $data['detailimgs']=implode(",",$post['detailimgs']);
            $data['bannerimgs']=implode(",",$post['bannerimgs']);
            $data['img_id']=$post['bannerimgs'][0];
            $data['goods_name']=$post['goods_name'];
            $data['category_id']=$post['category_id'];
            $data['market_price']=$post['market_price'];
            $data['price']=$post['price'];
            $data['stock']=$post['stock'];
            $data['description']=$post['description'];
            $data['sales']=$post['sales'];
            $data['content']=$post['content'];
            $res = self::create($data);
            if (Request::input('sku')) {
                $arr = Request::input('sku');
                $sku_img_ids = Request::input('sku_img_ids');
                (new GoodsSku())->addSku($res['id'], $arr, $sku_img_ids);//添加sku
            }
            DB::commit();
            if ($res) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            DB::rollback(); // 回滚事务
            throw new BaseException('商品添加失败'. $e->getMessage());
        }
    }
    /**
     * 修改商品
     * @param $post
     * @return int
     * @throws BaseException
     */
    public static function editProduct($post)
    {
        unset($post['sku']);
        unset($post['sku_img_ids']);
        DB::beginTransaction();// 启动事务
        try {
            $post['detailimgs']=implode(",",$post['detailimgs']);
            $post['bannerimgs']=implode(",",$post['bannerimgs']);
            $res = self::where(['goods_id' => $post['goods_id']])->update($post);
            if (!$res) {
                return false;
            }
            //删除未填写价格的规格参数行
            //如果用request()->param 数据对sku的操作会有问题
            if (Request::input('sku')) {
                $arr = Request::input('sku');
                $sku_img_ids = Request::input('sku_img_ids');
                (new GoodsSku())->editSku($post['goods_id'], $arr, $sku_img_ids); //修改sku
            }
            DB::commit();
            if (!$res) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollback();
            throw new BaseException('商品添加失败'. $e->getMessage());
        }
    }
    /**
     * 排序
     * @param $arr
     * @return int
     */
    public static function setSort($arr)
    {
        if (!is_array($arr)) {
            return false;
        }
        foreach ($arr as $k => $v) {
            self::where(['goods_id' => $k])->update(['sort' => $v]);
        }
        return true;
    }
    /**
     * 获取所有上架商品，包含分页
     * @param int $page
     * @param int $size
     * @param string $key
     * @return \think\response\Json
     */
    public static function getProductByPage()
    {

        $data = self::with(['imgs','video'])->where(['state' => 1])->orderBy('sort','asc')->get();
        return $data;
    }

    /**
     * 获取所有下架商品，包含分页
     * @param int $page
     * @param int $size
     * @return \think\response\Json
     */
    public static function getProductDownByPage()
    {
        $data = self::with(['imgs','video'])->where('state', 0)->order('create_time desc')->select();
        return app('json')->success($data);
    }
    //关联图片
    public function imgs()
    {
        return $this->belongsTo('App\Http\models\Image', 'img_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo('App\Http\models\Category', 'category_id', 'category_id')->select('category_id','pid');
    }

    //关联视频
    public function video()
    {
        return $this->belongsTo('App\Http\models\Video', 'video_id', 'id');
    }

    //关联评价
    public function rate()
    {
        return $this->belongsTo('App\Http\models\Rate', 'rate_id', 'id');
    }

    //关联规格
    public function sku()
    {
        return $this->hasMany('App\Http\models\GoodsSku', 'goods_id', 'goods_id');
    }

    public function goodsSku()
    {
        return $this->hasOne('App\Http\models\GoodsSku', 'goods_id', 'goods_id');
    }
    /**
     * 检测库存
     * @param $data
     * @return int
     * @throws OrderException
     */
    public static function checkStock($data)
    {
        foreach ($data as $v) {
            $goods = self::with('goodsSku')->where('goods_id', $v['goods_id'])->first();
            $goods=$goods->toArray();
            if ($v['sku_id']) {
                $list=json_decode($goods['goods_sku']['json'],true);
                foreach ($list['list'] as $key => $value) {
                    if ($v['sku_id'] == $value['id']) {
                        if ($value['stock_num'] < $v['num']) {
                            throw new BaseException( '库存不足');
                        }
                    }
                }
            } else if ($v['num'] > $goods['stock']) {
                throw new BaseException( '库存不足');
            }
        }
        return 1;
    }

    /**
     * 修改库存
     * @param $data
     * @return int
     * @throws OrderException
     */
    public static function editStock($data)
    {
        foreach ($data as $k => $v) {
            $goods = self::with('goodsSku')->where('goods_id', $v['goods_id'])->first();
            if ($v['sku_id']) {
                $list=json_decode($goods['goods_sku']['json'],true);
                foreach ($list as $key => $value) {
                    if ($v['sku_id'] == $value['id']) {
                        $goods['goods_sku']['json']['list'][$key]['stock_num'] = $value['stock_num'] - $v['num'];
                        if ($goods['goods_sku']['json']['list'][$key]['stock_num'] >= 0) {
                            $goods->save();
                        }
                    }
                }
            } else {
                $goods['stock'] = $goods['stock'] - $v['num'];
                if ($goods['stock'] >= 0) {

                    $goods->save();
                }
            }
        }
        return 1;
    }
    /**
     * ID获取某商品及关联详情
     * @param $id
     * @return array|null|\think\Model
     * @throws BaseException
     */
    public static function getProductByID($id)
    {
        $data = self::with(['sku'])->where('goods_id', $id)->first();
        if (!$data) {
            throw new BaseException(['商品不存在或数据错误']);
        }
        return $data;
    }
    public function getIsHotAttribute($value)
    {
        $status = [0=>false,1=>true];
        return $status[$value];
    }
    public function getIsRecommendAttribute($value)
    {
        $status = [0=>false,1=>true];
        return $status[$value];
    }
    public function getStateAttribute($value)
    {
        $status = [0=>true,1=>false];
        return $status[$value];
    }
    public function getIsNewAttribute($value)
    {
        $status = [0=>false,1=>true];
        return $status[$value];
    }

}