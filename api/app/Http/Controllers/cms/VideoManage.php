<?php


namespace App\Http\Controllers\cms;


use App\Http\models\Video;
use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;

class VideoManage extends BaseController
{
    /**
     * 获取所有视频
     * @return mixed
     */
    public function getAllVideo(){
        $res=Video::where('is_visible',1)->orderByDesc('id')->get();
        return $this->success($res);
    }

    /**
     * 删除视频
     * @param $ids
     * @return mixed
     */
    public function editVideo(){
        $ids=Request::input('ids');
        $res=Video::whereIn('id',$ids)->update(['is_visible'=>0]);
        return $this->go($res);
    }

}