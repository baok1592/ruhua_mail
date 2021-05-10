<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class Banner extends BaseModel
{
    public $timestamps= false;
    protected $guarded = [];
    public function items()
    {
        return $this->hasMany('App\Http\models\BannerItem', 'banner_id', 'id');
    }
    public function imgs()
    {
        return $this->hasMany('App\Http\models\Image', 'img_id', 'id');
    }

    /**
     * 获取某个广告
     * @param $id
     * @return \think\response\Json
     */
    public static function getBannerByID($id)
    {
        $data = self::with(['items', 'items.imgs'])->find($id);
        return $data;
    }

}