<?php

namespace App\ruhua\version_update;

class Cloud {

    // 错误信息
    private $error = '未知错误';

    // 请求的数据
    private $data = [];

    // 接口
    private $api = '';

    // 站点标识
    private $identifier = '';

    // 升级锁
    public $lock = '';

    // 升级目录路径
    public $path = './';

    // 请求类型
    public $type = 'get';

    //服务器地址
    const API_URL = 'http://serve.thinkphpcode.com/';
    
    
    public function __construct($path = './') {
        $this->path = $path;
        $this->lock = './upload/cloud.lock';
    }

   
    public function apiUrl()
    {
        return self::API_URL;
    }

   
    public function getError()
    {
        return $this->error;
    }

   
    public function data($data = [])
    {
        $this->data = $data;
        return $this;
    }

    
    public function api($api = '')
    {
        $this->api = self::API_URL.$api;


        return $this->run($this->data);
    }

   
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    
    public function down($api)
    {
        $this->api  = self::API_URL.$api;

        $saveFile   = $this->path.time().'.zip';
        $request    = $this->run(true);

        // 执行下载
        $result = Http::down($request['url'], $saveFile, $request['params']);
        if (is_file($this->lock)) {
            @unlink($this->lock);
        }

        return $result;
    }

    
    private function run($down = false)
    {

        $params['version'] = config('version.wm');

        $params                 = array_merge($params, $this->data);
        $params                 = array_filter($params);

        if (is_file($this->lock)) {
            @unlink($this->lock);
        }

        @file_put_contents($this->lock, $params['timestamp']);

        if ($down === true) {
            $result             = [];
            $result['url']      = $this->api;
            $result['params']   = http_build_query($params);
            return $result;
        }

        $type   = $this->type;
        $result = Http::$type($this->api, $params);
        return self::_response($result);
    }

   
    private function _response($result = [])
    {

        if (is_file($this->lock)) {
            @unlink($this->lock);
        }
        
        if (!$result || isset($result['errno'])) {
            if (isset($result['msg'])) {
                return ['code' => 0, 'msg' => $result['msg']];
            }
            return ['code' => 0, 'msg' => '请求的接口网络异常，请稍后在试'];
        } else {
            return json_decode($result, 1);
        }
    }
}
