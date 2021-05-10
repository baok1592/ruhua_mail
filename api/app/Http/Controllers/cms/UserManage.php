<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\Http\models\MoneyLog;
use App\Http\models\User as UserModel;
use Illuminate\Support\Facades\Request;

class UserManage extends BaseController
{
    /**
     * 获取所有用户信息
     * @return mixed
     */
    public function getAllUser(){
        $res=UserModel::with('level')->get();
        //$res=(new Admin())->getTable();
        //$res=Request::all();
        if(!$res->count())
            return$this->fail('没有数据！');
        return $this->go($res);
    }
    /**
     * 修改用户信息
     */
    public function editUser(){
        $post=Request::all();
        $this->validate($post,['money'=>'required','level_id'=>'required','points'=>'required']);
        $res= (new UserModel())->editUser($post);
        return $this->go($res);
    }
    /**
     * 获取用户详情
     */
    public function getUser(){
        $id=Request::input('id');
        $res=UserModel::with('level')->where('id',$id)->select('id','nickname','points','headpic','mobile','money','level_id')->first();
        $res['log']=MoneyLog::where('uid',$id)->select('id','uid','type_name','content','created_at')->get();
        return $this->go($res);
    }
    /**
     * 删除用户
     */
    public function delUser(){
        $id=Request::input('id');
        $res=UserModel::destroy($id);
        return $this->go($res);
    }

}