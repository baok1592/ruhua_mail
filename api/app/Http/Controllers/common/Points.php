<?php


namespace App\Http\Controllers\common;


use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use App\Http\models\PointsRecord;

class Points extends BaseController
{
    /**
     * 签到添加积分
     * @return mixed
     */
    public function signAddPoints(){
        $uid=Token::getCurrentTokenVar('id');
        (new PointsRecord)->sign($uid);
        return $this->success();
    }

}