<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;

class Group extends BaseModel
{
    public function admin(){
        return $this->belongsTo('App\Http\models\Admin','aid','id');
    }
//    public function autogroup(){
//        return $this->hasOne('App\Http\models\AuthGroup','id','group_id');
//    }

}