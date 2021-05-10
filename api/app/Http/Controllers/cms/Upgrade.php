<?php

namespace App\Http\Controllers\cms;

use App\ruhua\bases\BaseCommon;
use App\ruhua\md5update\Update;
use App\ruhua\version_update\Cloud;
use App\ruhua\version_update\Dir;
use App\ruhua\version_update\PclZip;
use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Log;
use App\Exceptions\BaseException;
use Illuminate\Support\Facades\Request;

class Upgrade extends BaseController
{
    public $identifier = 0;
    public $appVersion = '';
    private $rootPath;
    private $appPath;
    private $updatePath;
    private $cloud;
    private $cacheUpgradeList;

    protected function instantiable()
    {

       $this->rootPath         = ROOT;
        $this->appPath          = VAE_ROOT.'/app/';

        $this->updateBackPath   = $this->rootPath.'/backup/upback/';
        $this->updatePath       = $this->rootPath.'/backup/uppack/';
        $this->cloud            = new Cloud($this->updatePath);
        $this->cacheUpgradeList = 'upgrade_version_list'.$this->identifier;

        $this->appVersion = config('version.wm.version');
        if (!$this->appVersion) {
           return $this->fail('没有新版本');
       }
    }


    /**获取新版本
     * @return mixed
     */
    public function get_new_version()
    {

        $data=(new Update())->get_local_data();
        $common=new BaseCommon();
         $server=Request::server();
        $web_url=$server['HTTP_HOST'];
        $res=$common->curl_post(UPDATE_URL."cms/is_update",$data,$web_url);
        $res=json_decode($res);
         $res=(array)$res;
        $version=config('version.wm.version');
        $res['version']=$version;
        return $this->go($res);
    }

    public function del_zip()
    {
        $code=Request::input('code');
        if(!unlink(VAE_ROOT."/backup/".$code.".zip")){
            Log::error("删除失败");
        }
    }

    public function is_update()
    {
        
        $head=Request::header();
        Log::error($head);
      
      
        $head=$head['authorization'][0];
        $back=[
            'status'=>400,
            'msg'=>'错误'
            ];
         $data=explode(" ",$head);
        if(!is_array($data))
            return $this->fail($back);
            //throw new BaseException(['msg'=>'非授权站点']);
        if(count($data)!=2)
            return $this->fail($back);
            //throw new BaseException(['msg'=>'非授权站点']);

             $url=AUTH_URL."project/wm/is_auth?web=".$data[1];
     
        $res=$this->curl_get($url);
        Log::error($url);
        $res=json_decode($res);
        $res=(array)$res;
        $res=$res['data'];
         $res=(array)$res;
         $back['msg']="非授权站点";
         if($res['data']==0)
              return $this->fail($back);
        $data=Request::input('data');
        $version=Request::input('version');
        $data=(new Update())->get_serve_data($data,$version);
        
        return $this->go($data);
    }
    
     /**
     * 
     *获取文件大小 
     */
     public function get_file_size()
    { 
        $data=Request::input('code');
        $code=md5($data);
        $url=VAE_ROOT."/backup/".$code.".zip";
        $dt['size']=0;
        if(file_exists($url)){
       
            $dt['size']=filesize($url);
        }
        return   $dt['size'];
    }


    public function cms_download()
    {
        $code=Request::input('code');
        $recive_url=UPDATE_URL."cms/down_new_version?code=".$code;
     $code=md5($code);
        //Cache::put('code',$code);

        $save_url=VAE_ROOT."/backup/update.zip";
        $len=(new Update())->copy_stream($recive_url,$save_url,$code);

        //Cache::put('upload_finish',1);
        (new BaseCommon())->curl_get(UPDATE_URL."cms/back_code?code=$code");


        return $this->go(['data'=>$len]);
    }

    /**
     * 判断是否安装完成
     */
    public function is_update_finish()
    {
       $code=Request::input('code');
        $url=UPDATE_URL."cms/get_file_size?code=".$code;
        $new_data=$this->curl_get($url);
          if(file_exists(VAE_ROOT."/backup/update.zip"))
            $now=filesize(VAE_ROOT."/backup/update.zip");
        else
            $now=$new_data;
       
       // $new_data=json_encode($new_data);
         Log::error($url);
        Log::error($new_data);
        $state=0;
        $total=1;
        if($new_data==0)
            $state=1;
        else
            $total=$new_data;
        $finish=(float)$now/(float)$total;
        $finish=round($finish,2);

        return $this->go(['state'=>$state,'total'=>$total,'now'=>$now,'finish'=>$finish]);
    }


    public function down_new_version()
    {
        $code=Request::input('code');
      
        $path=(new Update())->download($code);
        
        return $this->go(['path'=>$path]);
    }


    public function download()
    {

        $this->cloud = new Cloud($this->updatePath);
        $version=Request::toArray();
        $version=$version['version'];
        if (empty($version)) {
            return $this->fail('参数传递错误');
        }

        if (!is_dir($this->updatePath)) {
            Dir::create($this->updatePath, 0755);
        }

        $lock = $this->updatePath.$this->identifier.'upgrade.lock';
        if (!is_file($lock)) {
            //file_put_contents($lock, time());
        } else {
            return $this->fail("升级任务执行中，请手动删除此文件后重试！<br>文件地址：/uppack/".$this->identifier."upgrade.lock");
        }

        $versions = $this->getVersion1();

        // 检查当前升级补丁前面是否还有未升级的补丁
        $tobe = [];
        $file = '';
        //$file = $this->cloud->data(['version' => '12.0.11'])->down('/upgrade/get_down');

        foreach ($versions['data'] as $k => $v) {

            if (version_compare($k, $version, '>=')) {

            //    if (version_compare($k, $version, '=')) {

                    $file = $this->cloud->data(['version' => $k])->down('wm/upgrade/get_down');

             //   }
                break;
            } else {

                $file = $this->cloud->data(['version' => $k])->down('wm/upgrade/get_down');

                if ($file === false) {
                    $this->clearCache($file);
                    return $this->fail('前置版本 '.$k.' 升级失败');
                } else {
//                    if (self::_install($file, $k, $this->appType) === false) {
//                        $this->clearCache($file);
//                        return app('json')->fail($this->error);
//                    }
                }
            }
        }

        if ($file === false || empty($file)) {
            $this->clearCache($file);
            return $this->fail('获取升级包失败');
        }

        return $this->go(['file'=>basename($file)]);
    }

  
    public function install($file = '', $version = '')
    {
        if (!$this->request->isPost()) {
            return $this->fail('参数传递错误');
        }
        $file = $this->updatePath.$file;
        if (!file_exists($file)) {
            $this->clearCache($file);
            return $this->fail($version.' 升级包异常，请重新升级');
        }

        if (self::_install($file, $version, $this->appType) === false) {
            $this->clearCache($file);
            return $this->fail($this->error);
        }
        $jumpUrl = '';
        if ($this->appType == 'theme') {
            $param                  = $this->request->param('');
            $param['app_version']   = $param['version'];
            $param['app_name']      = cookie('upgrade_app_name');
            unset($param['file'], $param['version']);
            $jumpUrl = url('lists?'.http_build_query($param));
        }
        return $this->success('升级包安装成功', $jumpUrl);
    }



    public function systemInstall()
    {

        $this->instantiable();
        $data=Request::toArray();
        $file=$data['file'];
        $version=$data['version'];

        $_version = cache($this->cacheUpgradeList);

        if (!is_dir($this->updateBackPath)) {
            Dir::create($this->updateBackPath);
        }
        $decomPath = $this->updatePath.basename($file,".zip");
        if (!is_dir($decomPath)) {
            Dir::create($decomPath, 0777);
        }

        // 解压升级包
        $archive = new PclZip();
        $archive->PclZip($file.'.zip');

        if(!$archive->extract(PCLZIP_OPT_PATH, $decomPath, PCLZIP_OPT_REPLACE_NEWER)) {
            $this->error = '升级失败，请开启[/backup/uppack]文件夹权限';
            return $this->fail($this->error);
        }
        // 备份需要升级的旧版本
        $upInfo = include_once $decomPath.'/upgrade.php';
        $backPath = $this->updateBackPath.config('version.wm.version').'/';
        if (!is_dir($backPath)) {
            Dir::create($backPath, 0777);
        }

        array_push($upInfo['update'], '/version.php');
        //备份旧文件
        foreach ($upInfo['update'] as $k => $v) {
            $v = trim($v, '/');
            $_dir = $backPath.dirname($v).'/';
            if (!is_dir($_dir)) {
                Dir::create($_dir, 0777);
            }

            if ($v == '/composer.json') {
                $newComposer = json_decode(file_get_contents($decomPath.'/upload/composer.json'), 1);
                $oldComposer = json_decode(file_get_contents($this->rootPath.'composer.json'), 1);
                foreach($newComposer['require'] as $kk => $vv) {
                    $oldComposer['require'][$kk] = $vv;
                }
                @file_put_contents($decomPath.'/upload/composer.json', json_encode($oldComposer, 1));
            }

            if (is_file($this->rootPath.$v)) {
                @copy($this->rootPath.$v, $_dir.basename($v));
            }
        }

        // 根据升级补丁删除文件
        if (isset($upInfo['delete'])) {
            foreach ($upInfo['delete'] as $k => $v) {
                $v = trim($v, '/');
                if (is_file($this->rootPath.$v)) {
                    @unlink($this->rootPath.$v);
                }
            }
        }
        // 更新升级文件
        Dir::copyDir($decomPath.'/upload', $this->rootPath);

    /*    // 导入SQL
        $sqlFile = realpath($decomPath.'/database.sql');
        if (is_file($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            $sqlList = parse_sql($sql, 0, ['rh_' => config('database.prefix')]);
            if ($sqlList) {
                $sqlList = array_filter($sqlList);
                foreach ($sqlList as $v) {
                    try {
                        Db::execute($v);
                    } catch(\Exception $e) {
                        $this->error = 'SQL更新失败';
                        return app('json')->fail();
                    }
                }
            }
        }*/
        $this->clearCache('', $version);
        return $this->success();
    }



    public function getVersion()
    {
        $this->appVersion = config('version.wm.version');
        $this->cacheUpgradeList = 'upgrade_version_list'.$this->identifier;
        $this->updatePath       = $this->rootPath.'backup/uppack/';
        $this->cloud            = new Cloud($this->updatePath);
        $cache = cache($this->cacheUpgradeList);

        if (isset($cache['data']) && !empty($cache['data'])) {
            return $cache;
        }
       // $result = $this->cloud->data(['version' => $this->appVersion])->api('wm/upgrade/get_list');
        $url=WEB_SERVER;
        $url.='wm/upgrade/get_list?version='.$this->appVersion;
        $result=$this->curl_get($url);
        $result=json_decode($result,true);
        if ($result['status'] != 200) {

            cache($this->cacheUpgradeList, $result, 3600);  
        }
        $result['vae_version']=VAE_VERSION;
        return $this->go(['data'=>$result['data'],'vae_version'=>$result['vae_version']]);
    }
    public function getVersion1()
    {
        $this->cacheUpgradeList = 'upgrade_version_list'.$this->identifier;
        $url=WEB_SERVER;
        $this->appVersion = config('version.wm.version');
        $url.='wm/upgrade/get_list?version='.$this->appVersion;
        $cache = cache($this->cacheUpgradeList);
        if (isset($cache['data']) && !empty($cache['data'])) {
            return $cache;
        }

        //$result = $this->cloud->data(['version' => $this->appVersion])->api('ruhua/upgrade/get_list');
        $result=$this->curl_get($url);
        $result=json_decode($result,true);

        if ($result['status'] != 200) {
            cache($this->cacheUpgradeList, $result, 3600);
        }

        return $result;
    }

    private function clearCache($file = '', $version = '')
    {
        if (is_file($this->updatePath.$this->identifier.'upgrade.lock')) {
            unlink($this->updatePath.$this->identifier.'upgrade.lock');
        }

        if (is_file($file)) {
            unlink($file);
        }

        // 在升级缓存列表里面清除已升级的版本信息
        if ($version) {
            $versionCache = cache($this->cacheUpgradeList);
            unset($versionCache['data'][$version]);
            cache($this->cacheUpgradeList, $versionCache, 3600);
        }

        // 删除升级解压文件
        if (is_dir($this->updatePath)) {
            Dir::delDir($this->updatePath);
        }

        // 删除系统缓存
        Dir::delDir(Env::get('runtime_path').'cache');
        Dir::delDir(Env::get('runtime_path').'temp');
    }
}
