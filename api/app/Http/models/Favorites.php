<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class Favorites extends BaseModel
{
    public $timestamps= false;
    protected $guarded = [];
    public $dateFormat='U';
    public function product()
    {
        return $this->belongsTo('App\Http\models\goods','fav_id','goods_id');
    }
    public function favimg()
    {
        return $this->belongsTo('App\Http\models\Image','img_id','id');
    }

    /**
     * 添加收藏
     * @param $data
     * @return mixed
     */
    public static function addFavorites($data){
        $res=self::where(['uid'=>$data['uid'],'fav_id'=>$data['fav_id']])->first();
        if($res){
            throw new BaseException('已收藏过了');
        }
        $data['ucid']=Token::getCurrentTokenVar('ucid');
        $res2=self::create($data);
        return $res2;
    }
    /**
     * 查询某商品是否已收藏
     * @param $id
     * @param $uid
     * @return int
     */
    public static function getFavTypeByID($id,$uid)
    {
        $where['fav_id']=$id;
        $where['uid']=$uid;
        $count=self::where($where)->count();
        if($count<1){
            return 0;
        }
        return 1;
    }

    /**
     * 获取该用户所有收藏
     * @param $uid
     * @return array
     */
    public static function getFavoriteByUid($uid)
    {
        $data=self::with(['product'=>function($query){
            $query->select('goods_id','goods_name','price','img_id');
        }])->where('uid',$uid)->get();
        $api_url = SysConfig::where('key','api_url')->value('value');
        foreach ($data as $k=>$v){
            $url=Image::where('id',$v['product']['img_id'])->value('url');
            $data[$k]['imgs']=$url?$url:'';
        }
        if(!$data){
            throw new BaseException('无收藏数据或查询失败');
        }
        $arr=[];
        foreach ($data as $k=>$v){
            if($v['type']=='goods'){
                $arr['goods'][]=$v;
            }else{
                $arr['shop'][]=$v;
            }
        }
        return $arr;
    }

}