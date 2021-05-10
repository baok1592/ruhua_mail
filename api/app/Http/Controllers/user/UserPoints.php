<?php


namespace App\Http\Controllers\user;


use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use App\Http\models\User as UserModel;

class UserPoints extends BaseController
{
    /**
     * 查看我的积分详情
     * @return mixed
     */
    public function getPoints(){
        $uid=Token::getCurrentTokenVar('id');
        $res=PointsRecordModel::where('user_id',$uid)->order('id','desc')->select();
        return $this->success($res);
    }

    /**
     * 获取用户的积分
     * @return mixed
     */
    public function getPointsNum(){
        $uid=Token::getCurrentTokenVar('id');
        $res=UserModel::where('id',$uid)->value('points');
        return $this->success($res);
    }

}