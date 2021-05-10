<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/1/30 0030
 * Time: 10:43
 */

namespace App\Http\Controllers\common;


use App\ruhua\bases\BaseController;
use App\Http\models\FxRecord as FxRecordModel;
use App\ruhua\server\Token;

class FxRecord extends BaseController
{
    public function user_get_record()
    {
        $uid=Token::getCurrentTokenUid();
        $res=FxRecordModel::with('goods')->where('user_id',$uid)->get();
        return $this->go($res);
    }

    public function get_fx_record()
    {
        $res=FxRecordModel::with(['goods','user'])->get();
        return $this->go($res);
    }
}