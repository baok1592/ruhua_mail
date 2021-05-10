<?php


namespace App\Http\models;


use App\ruhua\bases\BaseModel;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BaseException;

class Region extends BaseModel
{
    public $timestamps= false;
    protected $guarded = [];
    /**
     * 录入地址
     * @return array
     */
    public function enterAddress($post){
        $region=new self();
        $arry=explode('@',$post['name']);
        if ($post['pid'] == "0") {
            DB::beginTransaction();
            try {
                foreach ($arry as $item) {
                    $data['pid'] = 0;
                    $data['name'] = $item;
                    $data['merger_name'] = $item;
                    $data['level'] = 1;
                    $region->create($data);
                }
                DB::commit();
                return true;
            } catch (\Exception $e) {
                DB::rollback();
                throw new BaseException($e->getMessage());
                //return false;
            }
        }

        DB::beginTransaction();
        $pname=$region->where('id',$post['pid'])->value('name');
        if(!$pname){
            throw new BaseException('没有这个一级地址！');
        }
        try {
            foreach ($arry as $item) {
                $data['pid']=$post['pid'];
                $data['name']=$item;
                $data['merger_name']=$pname.",".$item;
                $data['level']=2;
                $res[]=$region->create($data);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new BaseException($e->getMessage());
            //return false;
        }
    }

}