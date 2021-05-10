<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class ImageCategory extends BaseModel
{
    public $timestamps=false;
    protected $guarded = [];
    /**
     * 添加分类
     * @param $data
     * @return mixed
     */
    public static function addCategory($data)
    {
        $res = self::create($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除分类
     * @param $id
     * @return mixed
     */
    public static function deleteCategory($id)
    {
        $res = self::where('id', $id)->delete();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}