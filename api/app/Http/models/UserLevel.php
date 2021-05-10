<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class UserLevel extends BaseModel
{
    use SoftDeletes;
    protected $hidden = ['deleted_at'];
    public $dateFormat='U';
    protected $guarded = ['created_at','updated_at'];
    public function setCreatedAtAttribute($value)
    {
        Log::error($value);
            return strtotime($value);
    }
    public function setUpdatedAtAttribute($value)
    {
        return strtotime($value);
    }

}