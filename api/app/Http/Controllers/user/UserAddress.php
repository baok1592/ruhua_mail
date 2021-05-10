<?php


namespace App\Http\Controllers\user;


use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use App\Http\models\UserAddress as UserAddressModel;
use Illuminate\Support\Facades\Request;

class UserAddress extends BaseController
{
    /**
     * 创建用户地址
     */
    public function addAddress()
    {
        $rule = [
        'name' => 'required',
        'mobile' => 'required',
        'province' => 'required', //一级地址
        'city' => 'required', //二级地址
        'detail' => 'required' //详细
    ];

        $message = [
        'mobile.required' => "手机号有误",
        'city.required' => "地区有误",
        'detail.required' => "详细地址有误"
    ];
        $uid = Token::getCurrentTokenVar('id');//接收token，获取uid
        $post = Request::toArray();
        $this->validate($post,$rule,$message);
        $res=UserAddressModel::CreateOne($uid, $post);
        return $this->go($res);
    }

    /**
     * 删除指定地址
     * @param string $id
     * @return mixed
     */
    public function DeleteAddress()
    {
        $id=Request::input('id');
        $uid = Token::getCurrentTokenVar('id');
        $res = UserAddressModel::where(['id' => $id, 'user_id' => $uid])->delete();
        return $this->go($res);
    }

    /**
     * 更新指定地址
     *  @param $id
     * @return \think\response\Json
     */
    public function editAddress()
    {
        $rule = [
            'name' => 'required',
            'mobile' => 'required',
            'province' => 'required', //一级地址
            'city' => 'required', //二级地址
            'detail' => 'required' //详细
        ];

        $message = [
            'mobile.required' => "手机号有误",
            'city.required' => "地区有误",
            'detail.required' => "详细地址有误"
        ];
        $uid = Token::getCurrentTokenVar('id');//接收token，获取uid
        $post = Request::toArray();
        $this->validate($post,$rule,$message);
        $res=UserAddressModel::editAddress($uid,$post);
        return $this->go($res);
    }


    /**
     * 获取用户所有地址
     * @return mixed
     */
    public function getAllAddress()
    {
        $uid = Token::getCurrentTokenVar('id');//接收token，获取uid
        $data = UserAddressModel::where('user_id', $uid)->orderBydesc('is_default')->get();
        return $this->go($data);
//        return $data;
    }

    /**
     * 获取指定地址
     * @param string $id
     * @return mixed
     */
    public function getOneAddress()
    {
        $id=Request::input('id');
        $uid = Token::getCurrentTokenVar('id');
        $res= UserAddressModel::getAddressOne($id, $uid);
        return $this->go($res);
    }

    /**
     * 获取用户默认地址
     * @return \think\response\Json
     */
    public function getAddressDefault()
    {
        $uid = Token::getCurrentTokenVar('id');
        $res = UserAddressModel::where(['is_default' => '1', 'user_id' => $uid])->first();
        if (!$res) {
            return $this->fail('地址不存在');
        }
        return $this->success($res);
//        return $res;
    }

    /**
     * 将用户指定地址设为默认
     * @param string $id
     * @return mixed
     */
    public function setUserAddressDefault()
    {
        $id=Request::input('id');
        $uid = Token::getCurrentTokenVar('id');
        $res = UserAddressModel::setOnlyAddress($id, $uid);
        return $this->go($res);
    }

}