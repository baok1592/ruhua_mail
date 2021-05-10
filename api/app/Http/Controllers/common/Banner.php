<?php


namespace App\Http\Controllers\common;


use App\Http\models\BannerItem;
use App\ruhua\bases\BaseController;
use App\Http\models\Banner as BannerModel;
use Illuminate\Support\Facades\Request;

class Banner extends BaseController
{
    /**
     * 获取某个广告
     * @param $id
     * @return \think\response\Json
     */
    public function getBannerItem()
    {
        $id=Request::input('id');
        $res= BannerModel::getBannerByID($id);
        return $this->go($res);
    }


    /**
     * 获取所有广告
     * @return mixed
     */
    public function banner_all_item()
    {
        $data=BannerItem::all();
        return $this->go($data);
//        return json($data);
    }
    /**
     * 获取所有广告
     * @return mixed
     */
    public function getAllBanner()
    {
        $data=BannerModel::all();
        return $this->go($data);
//        return json($data);
    }


    /**
     * 获取广告详细
     * @param $id
     * @return \think\response\Json
     */
    public function get_banner_content()
    {
        $id=Request::input('id');
        $data = BannerItem::with('imgs')->find($id);
       return $this->go($data);
    }

}