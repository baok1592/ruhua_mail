<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use App\Http\models\Image;

class Rate extends BaseModel
{
    //public $timestamps=false;
    protected $dateFormat='u';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo('App\Http\models\User','user_id','id')->select('id','nickname','headpic');
    }

    public function goods()
    {
        return $this->belongsTo('App\Http\models\Goods','goods_id','goods_id');
    }
    /**
     * cms添加评价
     * @param $post
     * @return mixed
     */
    public static function addRate($post){
        $post['user_id'] = 0;
        $post['order_id'] = 0;
        $imgmodel=new Image();
        if($post['headpic']) {
            $post['headpic'] = $imgmodel->where('id', $post['headpic'])->value('url');
        }
        if($post['imgs']) {
            $img=explode(',',$post['imgs']);
            $url_list=$imgmodel->whereIn('id',$img)->get(['url']);
            $url_list=json_decode(json_encode($url_list),TRUE);
            $post['imgs']=implode(",",array_column($url_list,'url'));
        }
        $post['created_at']=strtotime($post['created_at']);
        $res=self::create($post);
        return $res;
    }

    /**
     * 添加回复
     * @param $post
     * @param  $aid
     * @return mixed
     */
    public static function addReply($post,$aid){
        $data['aid'] = $aid;
        $data['reply_content'] = $post['reply_content'] ;
        $data['reply_time']=time();
        $res=self::where('id',$post['id'])->update($data);
        if($res){
            return true;
        }else{
            return false;
        }
    }

}