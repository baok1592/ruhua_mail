<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/13 0013
 * Time: 10:36
 */

namespace App\Http\Controllers\install;

use App\Http\models\SysConfig as SystemModel;
use App\ruhua\bases\BaseController;

class Check extends BaseController
{
    public function index()
    {
        try{
            $res=SystemModel::find(1);
        }catch (\Exception $e){
            return $this->fail('数据库连接错误');
        }
        if($res){
            return $this->success('安装成功');
        }
    }
}