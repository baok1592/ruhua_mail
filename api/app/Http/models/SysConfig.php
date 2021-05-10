<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;

class SysConfig extends BaseModel
{
    public $timestamps= false;
    protected $guarded = [];

    public static function get($key)
    {
        return self::where('key',$key)->value('value');
    }

}