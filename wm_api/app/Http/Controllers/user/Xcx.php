<?php


namespace App\Http\Controllers\user;


use App\Exceptions\TokenException;
use App\Http\Controllers\server\Auto;
use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use App\Http\Controllers\server\Xcx as app;
use App\Http\models\User as UserModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Xcx extends BaseController
{
    //小程序登录
    public function XcxLogin(){
        $code=Request::input('code');
        $token['token']=(new Auto())->getToken($code);
        return $this->go($token);

    }
    //公众号获取code
    public function getcode(){
        //$response=(new app())->gzh()->getConfig();
        $response = (new app())->gzh()->oauth->redirect();
        Log::error($response);
        return $response;
    }
    //公众号登录
    public function gzhLogin(){
        $token['token']=(new Auto())->gzhLogin();
        return $this->go($token);
    }
    //更新用户昵称和头像
    public function xcx_upinfo()
    {
        $post=Request::toArray();
        $nickname=$post['nickName'];
        $headpic=$post['avatarUrl'];
        $id = Token::getCurrentTokenVar('id');
        $nickname = base64_encode($nickname);
        $user = UserModel::find($id);
        $data['nickname'] = $nickname;
        $data['headpic'] = $headpic;
        $user->update($data);
        return $this->go($user);
    }
}