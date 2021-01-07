<?php


namespace App\Http\Controllers\cms;


use App\Exceptions\BaseException;
use App\Http\models\Admin as AdminModel;
use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class Admin extends  BaseController
{
    /**
     * 管理员登录
     */
    public function login(){
        $post=Request::toArray();
        $rule=['username'=>'required','psw'=>'required'];
        $msg=['username.required'=>'username不能为空','psw.required'=>'psw不能为空'];
        $this->validate($post,$rule,$msg);
        $psw=md5($post['psw']);
        $res=AdminModel::where(['username'=>$post['username'],'password'=>$psw])->first();
        $res=json_decode(json_encode($res),true);
        //dump($res);
        if(!$res)
            throw new BaseException('用户名或密码错误！');
        if($res['state']==0)
            throw new BaseException('账号被禁用！');
        $cachedValue = $this->setWxCache($res);//仅组合
        $token['token'] = (new Token())->createToken($cachedValue);
        return $this->go($token);
    }
    /**
     * 修改密码
     * @param $form
     * @return mixed
     */
    public function editUserPwd()
    {
        $form=Request::input('form');
        $uid = Token::getCurrentTokenVar('aid');
        $user = AdminModel::find($uid);
        if (!$user) {
            return $this->fail('用户信息错误');
        }
        if ($user->password != md5($form['old_psw'])) {
            return $this->fail('原密码错误');
        }
        $user->password = md5($form['new_psw']);
        $res = $user->save();
        if (!$res) {
            return $this->fail();
        }
        return $this->success();
    }
    /**
     * 获取所有管理员
     */
    public function getAll(){
        $data=AdminModel::with(['group'])->where('state',1)->get();
        return $this->go($data);
    }
    /**
     * 添加管理员
     */
    public function addAdmin(){
        $data=Request::all();
        $data['password']=md5($data['password']);
        $res=AdminModel::create($data);
        return $this->go($res);
    }
    /**
     * 删除管理员
     */
    public function delAdmin(){
        $aid=Request::input('id');
        $data=AdminModel::destroy($aid);
        return $this->go($data);
    }
    /**
     * 组合uid，username，权限
     * @param $user
     * @return mixed
     */
    private function setWxCache($user)
    {
        if (array_key_exists('uniacid', $user)) {
            $cache['uniacid'] = $user['uniacid'];
        }
        $cache['aid'] = $user['id'];
        $cache['username'] = $user['username'];
        $cache['scope'] = 16;  // scope=16 代表App用户的权限数值
        return $cache;
    }

}