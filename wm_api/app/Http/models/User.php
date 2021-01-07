<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;

class User extends BaseModel
{
    use SoftDeletes;
    protected $dateFormat='U';
    public $incrementing=true;
    public $guarded=[];
    public function Money_log()
    {
        return $this->hasMany('App\Http\models\MoneyLog', 'id', 'uid');
    }
    public function getNicknameAttribute($v)
    {
        return base64_decode($v);
    }
    //修改用户信息
    public function editUser($post){
        $user = self::find($post['id']);
        if(!$user){
            throw new BaseException('没有这个用户！');
        }
        DB::beginTransaction();;
        try {
            $m = substr($post['money'], 0, 1);
            $p = substr($post['points'], 0, 1);
            if ((string)$m == "-" ||(string) $m == "+") {
                $user->money = $user['money'] + $post['money'];
                if ($user['money'] <= 0) {
                    throw new BaseException('余额错误！');
                }
                $data['uid']=$post['id'];
                $data['type_name']='money';
                $data['content']=$post['money'];
                MoneyLog::create($data);
            }
            if ((string)$p == "-" || (string)$p == "+") {
                $user->points = $user['points'] + $post['points'];
                if ($user['points'] <= 0) {
                    throw new BaseException('积分错误！');
                }
                $data['uid']=$post['id'];
                $data['type_name']='points';
                $data['content']=$post['points'];
                MoneyLog::create($data);
            }
            $res = $user->save();
            Db::commit();
            return $res;
        }
        catch (\Exception $e) {
            Db::rollback();// 回滚事务
            throw new BaseException( $e->getMessage());
            //throw new BaseException( '操作失败');
        }
    }


}