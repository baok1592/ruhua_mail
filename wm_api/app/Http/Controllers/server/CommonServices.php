<?php


namespace App\Http\Controllers\server;


use App\Exceptions\BaseException;
use App\Http\models\Goods as GoodsModel;
use App\Http\models\Image as ImageModel;
use App\Http\models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class CommonServices
{
    /**
     * 更新不同模型的布尔字段
     * @param $id
     * @param $db
     * @param $field
     * @return int
     */
    public static function upValue($id, $db, $field)
    {
        switch ($db) {
            case 'order':
                $where['order_id'] = $id;
                break;
            case 'goods':
                $where['goods_id'] = $id;
                break;
            case 'category':
                $where['category_id'] = $id;
                break;
            case 'user':
                $where['id'] = $id;
                break;
            case 'article':
                $where['id'] = $id;
                break;
            case 'admins':
                $where['id'] = $id;
                break;
            default:
                throw new BaseException("没有这个模型！");
        }
        $vs = DB::table($db)->where($where)->value($field);
        Log::error($vs);
        if ($vs == 0) {
            $res = DB::table($db)->where($where)->update([$field => 1]);
        } else {
            $res = DB::table($db)->where($where)->update([$field => 0]);
        }
        if ($res) {
//            if ($db == 'goods' && $field == 'state') {
//                GoodsModel::destroy($id);
//            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 上传图片
     * @param string $use
     * @param string $back
     * @return mixed
     */
    public static function uploadImg($use, $back, $type = '', $cid = '')
    {
        $file = Request::file('img');
        if (!$file) {
            throw new BaseException('请上传文件img');
        }
        $name = uniqid() . '.'.$file->getClientOriginalExtension();
        $FilePath=public_path('/uploads/'. $use);
        $path = $file->move($FilePath, $name);//存储图片
        $res = self::img_save($use, $name, $cid);   //保存图片
        return $res;
    }

    /**
     * 上传视频
     * @return mixed
     */
    public static function uploadVideo()
    {
        $file = Request::file('video');
        if (!$file) {
            throw new BaseException('请上传视频文件');
        }
        $fileextension=$file->getClientOriginalExtension();
        if($fileextension!='mp4'){
            throw new BaseException('请上传MP4格式视频文件');
        }
        $FilePath=public_path('/uploads'.'/video');
        $name = uniqid() . '.'.$file->getClientOriginalExtension();
        $fileName = $file->move($FilePath, $name);//存储视频
        $res = self::video_save('video', $name);   //保存视频
        if ($res['id']) {
            return $res['id'];
        } else {
            return false;
        }
    }

    /**
     * 上传视频返回地址
     * @return mixed
     */
    public static function uploadVideoUrl()
    {
        $file = request()->file('file');
        if (!$file) {
            return app('json')->fail('请上传文件video');
        }
        validate(['file' => 'fileSize:10240000'])
            ->check(['file' => $file]);
        $fileName = Filesystem::putFile('video', $file, 'uniqid');
        $res = self::video_save('video', $fileName);   //保存视频
        if ($res['id']) {
            $arr[0]=$res['url'];
            return app('json')->go($arr);

        } else {
            return app('json')->fail();
        }
    }

    /**
     * 上传的图片信息，录入数据库
     * @param $name
     * @param $use
     * @param $cid
     * @return \think\Model|\app\services\CommonServices
     */
    private static function img_save($use, $name, $cid = '')
    {
        $data['use_name'] = $use;
        $data['url'] = '/uploads/'. $use . '/' . $name;
        $data['category_id'] = $cid;
        $res = ImageModel::create($data);
        return $res;
    }

    /**
     * 上传的视频信息，录入数据库
     * @param $name
     * @param $use
     * @param $cid
     * @return \think\Model|static
     */
    private static function video_save($use, $name)
    {
        $data['use_name'] = $use;
        $data['url'] = '/uploads/video/'.$name;
        $data['description'] = Request::input('description');
        $res = Video::create($data);
        return $res;
    }

    public static function downImg($url)
    {
        $res = file_get_contents($url);
        $name = uniqid() . '.png';
        $out = fopen('./uploads/product/' . $name, "a");
        fwrite($out, $res);
        fclose($out);
        $img = self::img_save('product', $name);   //保存图片
        return $img['id'];
    }

}