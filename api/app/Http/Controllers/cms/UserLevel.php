<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\Http\models\UserLevel as UserLevelModel;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Request;

class UserLevel extends BaseController
{
    /**
     * 新增用户等级
     */
    public function addLevel(){
        $rule=[
            'name_l'=>'required',
            'discount'=>'required',
            'sort'=>'required',
        ];
        $post=Request::toArray();
        $this->validate($post,$rule);
        $res=UserLevelModel::create($post);
        return $this->go($res);
    }
    /**
     * 获取所有用户等级
     */
    public function getALLLevel(){
        $res=UserLevelModel::all();
        return $this->go($res);
    }

    /**
     * @param $id
     * @return mixed
     * 删除用户等级
     */
    public function delLevel(){
        $id=Request::input('id');
        $res=UserLevelModel::destroy($id);
        return $this->go($res);
    }
    /**
     * 修改用户等级
     */
    public function editLevel(){
        $post=Request::toArray();
        $res=UserLevelModel::where('id',$post['id'])->update(['name_l'=>$post['name_l'],'discount'=>$post['discount']]);
        return $this->go($res);
    }

}