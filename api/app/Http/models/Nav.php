<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;

class Nav extends BaseModel
{
    use SoftDeletes;
    protected $guarded = [];
    public $dateFormat='U';
    /**
     * 添加分类
     * @param $post
     * @return int
     */

    //关联图片
    public function imgs()
    {
        $res=$this->belongsTo('App\Http\models\Image', 'img_id', 'id');
        return $res;
    }
    public static function getNavAll(){
        return self::with('imgs')->where('is_visible',1)->orderBy('sort','asc')->get();
    }
    public static function addNav($post)
    {
        $post['sort'] = 0;
        $post['is_visible'] = 1;
        $res=self::where('nav_name',$post['nav_name'])->first();
        if($res){
            throw new BaseException('重复添加');
        }
        $res = self::create($post);
        if (!$res) {
            return false;
        }
        return true;
    }

    /**
     * 修改导航
     * @param $post
     * @return int
     */
    public static function editNav($post)
    {
        $res = self::where(['id' => $post['id']])->update($post);
        if($res){
            return true;
        }
        return false;
    }

    /**
     * 删除分组
     * @param $id
     * @return int
     */
    public static function deleteNav($id)
    {
        $result = self::where(['id' => $id])->delete();
        if (!$result) {
            return false;
        }
        return true;
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
        foreach ($arr as $k=>$v){
            self::where(['id'=>$k])->update(['sort'=>$v]);
        }
        return true;
    }

}