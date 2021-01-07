<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class Article extends BaseModel
{
    public $dateFormat='U';
    protected $guarded = [];
    /**
     * 添加文章
     * @return mixed
     */
    public static function addArticle($post){
        $res = self::create($post);
        return $res;
    }

    /**
     * 修改文章
     * @return mixed
     */
    public static function editArticle($data){
        $id=$data['id'];
        $res=self::where('id',$id)->update($data);
        return $res;
//        return $res?1:0;
    }

    /**
     * 删除文章
     * @return mixed
     */
    public static function deleteArticle($id){
        $res = self::where('id',$id)->delete();
        return $res;
    }

    /**
     * 获取某一篇公告
     * @return mixed
     */
    public static function getArticle(){
        $data = self::where('type',3)->orderByDesc('id')->first();
        return $data;
    }

    /**
     * 获取文章详情
     * @param int
     * @return mixed
     */
    public static function getOneArticle($id){
        $data = self::with('img')->where('id',$id)->first();
        return $data;
    }

    /**
     * 用户获取文章
     * @return mixed
     */
    public static function userArticle()
    {
        $data = self::where('is_hidden',0)->get();
        return $data;
    }

    public function img(){
        return $this->belongsTo('App\Http\models\image','image','id')->select('id','url');
    }

}