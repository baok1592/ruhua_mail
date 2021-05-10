<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class PlayAward extends BaseModel
{
    protected $guarded = [];
    public $timestamps=false;

}