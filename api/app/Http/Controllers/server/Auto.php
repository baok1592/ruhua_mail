<?php


namespace App\Http\Controllers\server;


use App\Exceptions\TokenException;
use App\Http\models\SysConfig;
use App\Http\models\User as UserModel;
use App\Http\Controllers\server\Xcx as app;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Auto
{
    public function getToken($code)
    {
        $xcx=new app();
        $wxResult=$xcx->Xcx_App()->auth->session($code);
        if (empty($wxResult)) {
            throw new TokenException('获取session_key及openID时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->WxError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }
    }
    public function gzhLogin(){
        $code=Request::input('code');
        $user=(new app())->gzh()->oauth->user();
        $data['openid']=$user->getId();
        Log::error($data);
        return $this->gzh_grantToken($user);

    }
    
    public function gzh_grantToken($user)
    {
        $openid=$user->getId();
        
        $dt=UserModel::where('openid_gzh',$openid)->first();
        if(!$dt){
            $data=[
                'openid_gzh'=>$openid,
                'nickname'=>base64_encode($user->getNickname()),
                'headpic'=>$user->getAvatar(),
                'invite_code'=>rand(1000000,9999999)
                ];
        $dt=UserModel::create($data);
        }
          $cachedValue = $this->setWxCache($user, $dt['id']);
           $token = (new Token())->createToken($cachedValue);
            return $token;
        
        
        
    }

    //openid，uid放入缓存，$token做缓存键名;
    private function grantToken($wxResult)
    {
        $mergeMode = SysConfig::where('key', 'merge_mode')->value('value');
        $data=[];
        if (array_key_exists('unionid', $wxResult) && $mergeMode == 1) {

            $user = UserModel::where('unionid', $wxResult['unionid'])->first();
            if ($user) {

                $opid = UserModel::where(['openid' => $wxResult['openid'], 'unionid' => $wxResult['unionid']])->first();
                if ($opid) {
                    $uid = $opid['id'];
                } else {
                    $user->save(['openid' => $wxResult['openid']]);
                    $uid = $user['id'];
                    //(new MergeService())->mergeUser($uid, 'openid', $wxResult['openid'], 2);//合并
                }
            } else {
                $opid = UserModel::where('openid', $wxResult['openid'])->first();
                if ($opid) {
                    $opid->save(['unionid' => $wxResult['unionid']]);
                    $uid = $opid['id'];
                } else {
                    $data['openid']=$wxResult['openid'];
                    $data['unionid']=$wxResult['unionid'];
                    if (array_key_exists('uniacid', $wxResult)) {
                        $data['uniacid'] = $wxResult['uniacid'];
                    }
                    $data['invite_code']=rand(1000000,9999999);
                    $new_user = UserModel::create($data);
                    $uid = $new_user['id'];
                }
            }
        } else {
            $user_id = UserModel::where('openid', $wxResult['openid'])->value('id');
            if ($user_id) {
                $uid = $user_id;
            } else {
                $data['openid']=$wxResult['openid'];
                if (array_key_exists('uniacid', $wxResult)) {
                    $data['uniacid'] = $wxResult['uniacid'];
                }
                $data['invite_code']=rand(1000000,9999999);
                $new_user = UserModel::create($data);
                $uid = $new_user['id'];
            }
        }
        $cachedValue = $this->setWxCache($wxResult, $uid);
        $token = (new Token())->createToken($cachedValue);
        return $token;
    }

    //组合uid，openid，权限
    private function setWxCache($wxResult, $uid)
    {
        $cache = $wxResult; //微信的3个返回值
        $cache['id'] = $uid;
        $cache['scope'] = 9;
        return $cache;
    }


    //微信错误信息解析后抛出
    private function WxError($wxResult)
    {
        throw new TokenException($wxResult['errmsg'],$wxResult['errcode']);
    }


}