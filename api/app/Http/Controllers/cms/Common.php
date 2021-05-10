<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\Http\models\Region;
use App\ruhua\Feie\FeieDy;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Uedit\controller as Contro;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\server\CommonServices;
use Illuminate\Support\Facades\DB;

class Common extends BaseController
{
    //录入地址
    public function enterAddress()
    {
        $post = Request::toArray();
        if(!$post['name']){
            return $this->fail('地址为空！');
        }
        $res=(new Region())->enterAddress($post);
        if(!$res)
            return $this->fail();
        return $this->success();
    }
    /**
     * 修改地址
     */
    public function editAddress(){
        $post=Request::toArray();
        $rule=[
            'id'=>'required',
            'pid'=>'required',
            'name'=>'required',
            'level'=>'required',
        ];
        $this->validate($post,$rule);
        $data= Region::where(['id'=>$post['id']])->update($post);
        return $this->go($data);
    }
    //删除地址
    public function delAddress(){
        $id=Request::input('id');
        $res=Region::destroy($id);
        return $this->go($res);
    }
    /**
     * 更新不同模型的布尔字段
     * @param $id
     * @param $db
     * @param $field
     * @return int
     */
    public function upValue()
    {
        $id=Request::input('id');
        $db=Request::input('db');
        $field=Request::input('field');
        $res=CommonServices::upValue($id, $db, $field);
        return $this->go($res);
    }

    /**
     *
     * @return mixed
     */
    public function ue_uploads()
    {
        $ue = new Contro;
        $res = $ue->show();
        return $res;
    }


    /**飞蛾打印机打印小票
     * @return mixed
     */
    public function print_order()
    {
        $order_num=Request::input('order_num');
        $print=(new FeieDy())->printMsg($order_num,1);
        return $this->success();
    }

    /**
     * 上传图片
     * @param string $use
     * @param string $back
     * @param  $cid
     * @return mixed
     */
    public function uploadImg($use = 'images', $back = 'url')
    {
        $cid=Request::input('cid');
        $res=CommonServices::uploadImg($use, $back, 0, $cid);
        return $this->go($res);
    }

    /**
     * 上传视频
     * @return mixed
     */
    public function uploadVideo()
    {
        $res= CommonServices::uploadVideo();
        return $this->go($res);
    }


    /**
     * 上传视频返回地址
     * @return mixed
     */
    public function uploadVideoUrl()
    {
        return CommonServices::uploadVideoUrl();
    }

    /**
     * 下载图片
     * @param  $url
     * @return mixed
     */
    public function downImg($url)
    {
        return CommonServices::downImg($url);
    }

    /**
     * 上传图片返还ID
     * @param string $use
     * @param string $back
     * @param  $cid
     * @return mixed
     */
    public function uploadImgID($use = 'other', $back = 'id', $cid = '')
    {
        $data = CommonServices::uploadImg($use, $back, 1, $cid);
        return json($data);
    }


    //获取环境信息
    public function systemInfo(){

        $laravel = app();
        $data=[
            ['操作系统',PHP_OS],
           ['php版本',PHP_VERSION],
            ['Laravel版本',$laravel::VERSION],
            ['上传附件限制',ini_get('upload_max_filesize')],
            ['执行时间限制',ini_get('max_execution_time').'秒'],
            ['剩余空间',round((disk_free_space(".")/(1024*1024)),2).'M'],
           ['程序运行目录',public_path()],
        ];
        return $this->go($data);
    }


    //一键清空日志
    public function clear_log()
    {
        $dir=storage_path('logs');

        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }

        closedir($dh);
        //删除当前文件夹：
        if(rmdir($dir)) {
            return $this->success();
        } else {
            return $this->fail();
        }

 /*       Artisan::command('logs:clear', function() {
            exec( "rm".storage_path('logs\laravel.log'));
        })->describe('Clear log files');
        return $this->success();*/

    }

    //批量清空回收站数据
    public function clear_cache()
    {
        Cache::flush();
        return $this->success();

    }


}