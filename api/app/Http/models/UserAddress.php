<?php


namespace App\Http\models;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserAddress extends BaseModel
{
    protected $dateFormat='U';
    public $incrementing=true;
    public $guarded=[];
    protected $hidden = ['created_at', 'updated_at', 'user_id'];


    /**
     * 创建用户地址
     * @param $uid
     * @param $post
     * @return mixed
     * @throws BaseException
     */
    public static function CreateOne($uid, $post)
    {
        $count = self::where('user_id', $uid)->count();
        if ($count >= 5) {
            throw new BaseException('最多只能创建5个地址');
        } else {
            DB::beginTransaction();
            try {
                $post['user_id'] = $uid;
                $post['is_default'] = 1;
                $region=DB::table('region')->where('name',$post['province'])->where('level',1)->first();
                if(!$region){
                    throw new BaseException('地区不存在');
                }
                //$post['region_id']=$region->pid;
                Log::error(json_encode($post));
                $Address=self::create($post); //直接通过关联模型来新增
                self::setOnlyAddress($Address->id, $uid);//将指定地址设为唯一
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();// 回滚事务
                throw new BaseException($e->getMessage());
            }
            return true;
        }
    }

    /**
     * 修改地址
     * @param $id
     * @param $uid
     * @param $data
     * @return int
     */
    public static function editAddress($uid, array $data)
    {
        $id=$data['id'];
        $res = self::where(['id' => $id, 'user_id' => $uid])->first();
        unset($data['id']);
        if ($res->count()<1) {
            throw new BaseException('没有这个地址');
        }
        $region=Db::table('region')->where('name',$data['province'])->where('level',1)->first();
        if(!$region){
            throw new BaseException('地区不存在');
        }
        if($data['is_default'])
            self::where("user_id",'=', $uid)->where("id", "<>", $id)->update(["is_default" => 0]);
        $status = self::where('id',$id)->update($data);

        return $status;
    }

    /**
     * 获取指定地址
     * @param $id
     * @param $uid
     * @return array|null|\think\Model
     */
    public static function getAddressOne($id, $uid)
    {
        $data = self::where(['id' => $id, 'user_id' => $uid])->first();
        if (!$data) {
            throw new BaseException('地址不存在');
        }
        //return app('json')->success($data);
        return $data;
    }

    /**
     * 将指定地址设为唯一
     * @param $id
     * @param $uid
     * @return static
     */
    public static function setOnlyAddress($id, $uid)
    {
        self::where("user_id",'=', $uid)->where("id", "<>", $id)->update(["is_default" => 0]);
        return self::where("user_id", $uid)->where("id", $id)->update(["is_default" => 1]);
    }

    /**
     * 默认地址
     * @param $uid
     * @return array
     * @throws BaseException
     */
    public static function getUserInfo($uid)
    {

        $data = [];
        $address = self::where('user_id', $uid)->where('is_default', 1)->first();
        if (!$address) {
            throw new BaseException('地址错误');
        }
        $data['receiver_name'] = $address['name'];
        $data['receiver_mobile'] = $address['mobile'];
        $data['receiver_province'] = $address['province'];
        //$data['receiver_district'] = $address['country'];
        $data['receiver_city'] = $address['province'] . $address['city'] . $address['county'];
        $data['receiver_address'] = $address['detail'];
        $data['region_id'] = $address['region_id'];
        return $data;
    }

}