<?php


namespace App\Http\Controllers\common;


use App\Http\Controllers\server\OrderService;
use App\Http\Controllers\server\Xcx as app;
use App\Http\models\Rate;
use App\Http\models\Region;
use App\Http\models\SysConfig;
use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Request;
use App\Http\models\SysConfig as SysConfigModel;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Common extends BaseController
{
    //扫码点餐，生成二维码
    public function addCode(){
        $xcx=(new app())->Xcx_App();
        $id=Request::input('id');
        $appurl=SysConfig::where('key','api_url')->value('value');
        $domain=URL::full();
        QrCode::encoding('UTF-8')->format('png')->size(200)->generate($appurl."#/pages/index/index?type=code_order&table_num=".$id,public_path('img/'.$id.'test.png'));
        $xcx=$xcx->app_code->getQrCode('/pages/index/index?type=code_order&table_num='.$id);
        if ($xcx instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $filexcx = $xcx->saveAs(VAE_ROOT.'/img', $id."xcxtest.png");
        }

        $data['h5_img']=WEB_ROOT.'/img/'.$id.'test.png';
        $data['xcx_img']=WEB_ROOT.'/img/'.$id.'xcxtest.png';
        return $this->success($data);
    }
    //验证token
    public function verifyToken(){
        $token=Request::header('token');
        $res1=(new Token())->verifyToken($token);
        if($res1){
            return $this->success(true);
        }
    }
    /**
     * 前端获取部分配置信息
     */
    public function getSysConfig()
    {
        // 购物车16、客服18、分销25、会员36、登录方式37、发票38
        $res = SysConfigModel::where(['id' => [16, 18, 25, 36, 37,38,44,45,52,53,54]])->select('key','desc','value')->get();
        return app('json')->success($res);
    }
    /**
     * 前端获取商家信息
     */
    public function getMerchant()
    {
        $res = SysConfigModel::where(['type' => 6])->select('id','key','desc','value')->get();
        //dump($res);
        return $this->go($res);
    }
    //获取地址列表
    public function getAddress(){
        $Res=Region::all();
        $data=[];
        foreach ($Res->toArray() as $v){
            if($v['level']==1){
                array_push($data,$v);
                foreach ($Res->toArray() as $j){
                    if($j['pid']==$v['id']){
                        array_push($data,$j);
                    }
                }
            }

        }
        return $this->go($data);
    }
    //计算订单总价
    public function get_Order_Money(){
        $uid = Token::getCurrentTokenVar('id');
        $post =Request::toArray();
        $this->validate($post,['json'=>'required']);
        $data=(new OrderService())->vipMoney($uid,$post['json']);
        return $this->go($data);
    }
    /**
     * 获取某个商品的所有评价
     * @param $id
     * @return \think\response\Json
     */
    public function getGoodsRate()
    {
        $id=Request::input('id');
        $pj=Rate::with(['user'])->where('goods_id',$id)->orderByDesc('id')->get();
        return $this->success($pj);
    }

}