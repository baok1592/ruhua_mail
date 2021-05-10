<?php


namespace App\Http\Controllers\server;


use App\Http\models\SysConfig;
use EasyWeChat\Factory;

class Xcx
{
    public function Xcx_App(){
        $appid = SysConfig::where('key', 'wx_app_id')->value('value');
        $secret = SysConfig::where('key', 'wx_app_secret')->value('value');
        $config = [
            'app_id' => $appid,
            'secret' => $secret,

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => ROOT.'/storage/logs/wechat.log',
            ],
        ];
        //dump($config);
        $app=Factory::miniProgram($config);
        return $app;
    }
    public function gzh(){
        $appid = SysConfig::where('key', 'gzh_appid')->value('value');
        $secret = SysConfig::where('key', 'gzh_secret')->value('value');
        $config = [
            'app_id' => $appid,
            'secret' => $secret,
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => '/weixin/get_gzh_token',
            ],
        ];

        $app = Factory::officialAccount($config);
        return $app;
    }

}