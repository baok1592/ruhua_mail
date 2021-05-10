<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;

class ReductionGoods extends BaseModel
{
    protected $guarded = [];
    public $timestamps=false;
    //protected $dateFormat='U';
    public function goods(){
        $data=$this->hasMany('App\Http\models\Goods','goods_id','goods_id');
        return $data;
    }

}