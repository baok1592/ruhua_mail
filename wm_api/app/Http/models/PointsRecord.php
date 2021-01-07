<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\Http\models\User as UserModel;
use App\ruhua\server\Token;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PointsRecord extends BaseModel
{
    protected $guarded = [];
    public $dateFormat='U';
    public function user()
    {
        return $this->belongsTo('App\Http\models\User', 'uid', 'id')->select('id','nickname','headpic','points');
    }

    /**
     * 签到获取积分
     * @param $uid
     * @return mixed
     *
     */
    public function sign($uid)
    {
        $res = UserModel::where('id', $uid)->first();
        $time = $res['sign_time'] -strtotime(date('Y-m-d'));
        if ($time > 0) {
            throw new BaseException('今天已经签到过');
        }
        $last_sign = intval((strtotime(date('Y-m-d', time())) - $res['sign_time']) / (60 * 60 * 24));
        if (!$last_sign && $res['sign_day'] < 7) {
            $day =$res['sign_day'] + 1;
            $name= $this->numeral($res['sign_day']);
        } else {
            $day = 1;
            $name= $this->numeral(0);
        }
        $points=PlayAward::where('name',$name)->value('award');
        $res->points= $res['points'] + $points;
        $res->sign_time = time();
        $res->sign_day = $day;
        try {
            DB::beginTransaction();
            $res->save();
            self::addRecord($uid, $points, '签到');//积分记录
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            throw new BaseException($e->getMessage());
        }
        return true;
    }


    /**
     * 添加积分变动
     * @param $uid
     * @param $num
     * @param $from
     * @return mixed
     */
    public static function addRecord($uid, $num, $from)
    {
        $data['uid'] = $uid;
        $data['credittype'] = 'points';
        $data['num'] = $num;
        $data['module'] = 'qy2019_shop';
        $data['clerk_type'] = 1;
        $data['remark'] = $from . '获得积分，增加' . $num . '积分';
        self::create($data);
    }

    /**
     * 使用积分变动
     * @param $uid
     * @param $num
     * @param $from
     * @return mixed
     */
    public static function reduce($uid, $num, $from)
    {
        $data['uid'] = $uid;
        $data['credittype'] = 'points';
        $data['num'] = -$num;
        $data['module'] = 'qy2019_shop';
        $data['clerk_type'] = 1;
        $data['remark'] = '使用积分' . $from . '，减少' . $num . '积分';
        $res = self::create($data);
        if (!$res) {
            return app('json')->fail();
        }
        return app('json')->success($res['id']);
    }

    //阿拉伯转中文数字
    private function numeral($num)
    {
        $china = array('第一天', '第二天', '第三天', '第四天', '第五天', '第六天', '第七天');
        return $china[$num];
    }

}