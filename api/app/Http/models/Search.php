<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/1/11 0011
 * Time: 9:12
 */

namespace App\Http\models;


use App\ruhua\bases\BaseModel;

class Search extends BaseModel
{
    protected $guarded = [];
    protected $dateFormat='U';
    public static function addsearch($data)
    {
        return self::create($data);
    }

}