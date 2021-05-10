<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PointsPlay extends BaseModel
{
    protected $guarded = [];
    public function award(){
        return $this->hasMany('App\Http\models\PlayAward','type_id','id');
    }

    public static function editPlay($post){
        $id=$post['id'];
        $data['status'] =$post['status'];
        $data['use_points'] =$post['use_points'];
        $data['number'] =$post['number'];
        $award =$post['award'];
        try{
            Db::beginTransaction();
            $res= self::where('id',$id)->update($data);
            foreach ($award as $k=>$v){
                PlayAward::where('id',$k)->updata(['award'=>$v]);
            }
            DB::commit();
            return $res;
        }catch (\Exception $e){
            DB::rollback();
            throw new BaseException($e->getMessage());
        }
    }

}