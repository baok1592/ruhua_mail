<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;

class Admin extends BaseModel
{
    public $timestamps= false;
    protected $guarded = [];
    public function group(){
        return $this->hasOne('App\Http\models\Group','id','group_id');
    }
}