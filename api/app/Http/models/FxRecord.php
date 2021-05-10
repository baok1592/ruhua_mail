<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/1/30 0030
 * Time: 9:18
 */

namespace App\Http\models;


use App\ruhua\bases\BaseModel;

class FxRecord extends BaseModel
{
    public function goods()
    {
        return $this->belongsTo('App\Http\models\Goods','goods_id','goods_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Http\models\User','user_id','id','id,nickname,headpic');
    }
}