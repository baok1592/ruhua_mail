<?php


namespace App\Http\Controllers\cms;


use App\Http\models\Banner;
use App\Http\models\BannerItem;
use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\BannerItem as BannerItemModel;

class BannerManage extends BaseController
{
    /**
     * 添加广告
     * @return int
     */
    public function addBanner()
    {
        $rule = ([
            'img_id' => 'required|numeric',
            'banner_id' => 'required|numeric',
            'key_word' => 'required'
        ]);
        $post = Request::toArray();
        $this->validate($post, $rule);
        $res= BannerItemModel::addBanner($post);
        return $this->go($res);
    }

    /**
     * 删除广告
     * @param $id
     * @return int
     */
    public function deleteBanner()
    {
        $id=Request::input('id');
        $res = BannerItemModel::where('id', $id)->delete();
        return $this->go($res);
    }

    /**
     * 修改广告
     * @return int
     */
    public function editBanner()
    {
        $post = Request::toArray();
        $res = BannerItemModel::where('id',$post['id'])->update($post);
        return $this->go($res);
    }

    /**
     * 更新排序
     * @return int
     */
    public function setSort()
    {
        $arr = Request::toArray();
        $res=BannerItemModel::setSort($arr);
        return $this->go($res);
    }

    /**
     * cms获取所有广告
     * @return mixed
     */
    public function adminAllBanner()
    {
        $data=BannerItemModel::with(['banner', 'imgs'])->orderBy('sort')->get();
        return $this->go($data);
//        return json($data);
    }

}