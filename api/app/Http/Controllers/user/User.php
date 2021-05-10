<?php


namespace App\Http\Controllers\user;


use App\Http\Controllers\server\Xcx as app;
use App\Http\models\SysConfig;
use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Request;
use App\Http\models\User as UserModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class User extends BaseController
{
    /**
     * 模拟用户登录获取TOKEN
     * @return mixed
     */
    public function userLogin()
    {
        $rule=['user_name'=>'required','psw'=>'required'];
        $post=Request::toArray();
        $this->validate($post,$rule);
        $data= UserModel::where(['user_name'=>$post['user_name']])->first();
        if(!$data){
            return $this->fail('用户名或密码错误！');
        }
        $data=json_decode(json_encode($data),true);
        $cache=$this->setWxCache($data);
        $token['token']=(new Token())->createToken($cache);
        return $this->success('登录成功',$token);
    }

    /**
     * 获取用户基础信息
     */
    public function getInfo()
    {
        $uid = Token::getCurrentTokenUid();
        $res=UserModel::with('level','Money_log')->where('id',$uid)->select('id','nickname','headpic','mobile','invite_code','level_id','points','money','invite_url')->first();
        if($res['nickname']==""&&$res['openid_gzh']!=""){
            $user=Token::getCurrentTokenOpenInfor();
         
            $res->headpic=$user['headimgurl'];
            $res->nickname=base64_encode($user['nickname']);
            $res->save();
            $res=UserModel::with('level','Money_log')->where('id',$uid)->select('id','nickname','headpic','mobile','invite_code','level_id','points','money','invite_url')->first();
        }
    
        $ewm=$this->getQrCode();
        $res=array_merge($res->toArray(),$ewm);
         $appurl=SysConfig::where('key','api_url')->value('value');
         $res['invite_url']=$appurl.$res['invite_url'];
        return $this->success($res);
    }
    /**
     * 获取小程序二维码
     */
    public function getQrCode(){
      
        $appurl=SysConfig::where('key','api_url')->value('value');
        $xcx=(new app())->Xcx_App();
        $uid = Token::getCurrentTokenVar('id');
        $user=UserModel::find($uid);
        $xcx=$xcx->app_code->getQrCode('pages/home/home?sfm='.$user['invite_code']);
        if ($xcx instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $filexcx = $xcx->saveAs(VAE_ROOT.'/img', $uid.'xcx.png');
        }
        
        UserModel::where('id',$uid)->update(['invite_url'=>'/img/'.$filexcx]);
        $fileh5='/img/'.$uid.'h5.png';
        $code=QrCode::encoding('UTF-8')->format('png')->size(200)->generate($appurl.'/h5?sfm='.$user['invite_code'],VAE_ROOT.$fileh5);

        $res['h5']=$fileh5;
        $res['xx']='/img/'.$filexcx;
        return $res;
        //$res['h5']=$xcx->app_code->getQrCode('/pages/home/home?sfm='.$res['invite_code']);
    }
    /**
     * 修改
     * @return mixed
     */
    public function editCpy(){
        $uid = Token::getCurrentTokenVar('id');
        $post=Request::toArray();
        $this->validate($post,['email'=>'required','user_name'=>'required']);
        $res=UserModel::editCpy($post,$uid);
        return $this->success();
    }
    private function setWxCache($data)
    {
        $cache=$data;
        $cache['scope'] = 9;
        return $cache;
    }


}