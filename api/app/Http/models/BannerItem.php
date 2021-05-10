<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class BannerItem extends BaseModel
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    use SoftDeletes;
    public $timestamps= true;
    public $dateFormat='U';
    protected $guarded = [];
    public function imgs()
    {
        return $this->belongsTo('App\Http\models\Image','img_id','id');
    }
    public function banner()
    {
        return $this->belongsTo('App\Http\models\Banner','banner_id','id');
    }

    /**
     * 添加广告
     * @param $post
     * @return mixed
     */
    public static function addBanner($post){
        $res = self::create($post);
        return $res;
    }

    /**
     * 排序
     * @param $arr
     * @return int
     */
    public static function setSort($arr){
        if(!is_array($arr)){
            return false;
        }
        Log::error($arr);
        foreach ($arr as $k=>$v){
            self::where(['id' => $k])->update(['sort' => $v]);
        }
        return true;
    }

}