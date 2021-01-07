<?php


namespace App\Http\Controllers\cms;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseController;
use App\Http\models\SysConfig as SysConfigModel;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class System extends BaseController
{
    /**
     * 获取商城配置信息
     * @param $type
     * @return \think\response\Json
     */
    public function GetConfig()
    {
        $type=Request::input('type');
        Log::error($type);
        $data=SysConfigModel::where('type',$type)->orderBy('switch','desc')->get();
        return $this->success($data);
//        return json($data);
    }

    /**
     * 修改配置信息
     * @return int
     */
    public function edit_config()
    {
        $post = Request::toArray();
        $system = (new SysConfigModel());
        try {
            foreach ($post as $value) {
                $system->where('id',$value['id'])->update($value);
            }
        }catch (\Exception $exception){
            throw new BaseException($exception->getMessage());
            //throw new BaseException('修改失败！');
        }
        return $this->success();
    }

}