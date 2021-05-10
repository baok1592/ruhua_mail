<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\Http\models\Rate as RateModel;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Request;

class RateManage extends BaseController
{
    /**
     * cms 获取所有评价
     * @return \think\Collection
     */
    public function getAllRate(){
        $data = RateModel::with(['user','goods'])->orderByDesc('created_at')->get();
        return $this->success($data);
    }

    /**
     * cms 删除评论
     * @param $id
     * @return int
     */
    public function deleteRate()
    {
        $id=Request::input('id');
        $result= RateModel::where('id',$id)->delete();//软删除
        if(!$result){
            return $this->fail();
        }
        return $this->success();
    }

    /**
     * 回复
     * @return mixed
     */
    public function addReply(){
        $aid=Token::getCurrentTokenVar('aid');
        $rule=['id'=>'required|numeric','reply_content'=>'required',];
        $post=Request::toArray();
        $this->validate($post,$rule);
        $res= RateModel::addReply($post,$aid);
        return $this->go($res);
    }

    /**
     * cms添加评价
     * @return mixed
     */
    public function addRate(){
        $rule=[
            'goods_id'=>'required|numeric',
            'rate'=>'required|numeric',
        ];
        $post=Request::toArray();
        $this->validate($post,$rule);
        $res=RateModel::addRate($post);
        return $res?$this->success($res):$this->fail();
    }

}