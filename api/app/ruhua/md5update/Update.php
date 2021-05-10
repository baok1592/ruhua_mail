<?php
namespace App\ruhua\md5update;
use App\Exceptions\TokenException;
use App\ruhua\bases\BaseCommon;
use App\ruhua\databackup\ZipFolder;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use ZipArchive;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/2/20 0020
 * Time: 15:32
 */
class Update
{
    //需要更新的文件夹路径，可添加
    private $update_dir_urls=[
        'app/',
        'public/cms/',
        'public/h5/',
        'config/version.php',
        'route/',
        'resources/'
    ];
    private $dirs=[];
    private $dir_num=0;
    private $size=0;
    private $code='';
    private $bf_version_url='';
    
    function findNum($str=''){
        $str=trim($str);
        if(empty($str)){return '';}
        $temp=array('1','2','3','4','5','6','7','8','9','0');
        $result='';
        for($i=0;$i<strlen($str);$i++){
            if(in_array($str[$i],$temp)){
                $result.=$str[$i];
            }
        }
        return $result;
    }

    /**
     * 获取本地数据
     */
    public function get_local_data()
    {
        $root_url=ROOT;
        $version=config('version.wm.version');

        $bachup_url=VAE_ROOT."/backup_version";
        if(!is_dir($bachup_url))
            mkdir($bachup_url);

        $bachup_url.="/$version/";
        if(!is_dir($bachup_url))
            mkdir($bachup_url);
        if(!is_dir($bachup_url."/public/"))
            mkdir($bachup_url."/public/");
        if(!is_dir($bachup_url."/public/h5/"))
            mkdir($bachup_url."/public/h5/");
        if(!is_dir($bachup_url."/public/cms"))
            mkdir($bachup_url."/public/cms");
        foreach ($this->update_dir_urls as $k=>$v){

            $this->read_all($root_url.$v,$v);
        }
        $this->size=$this->size/1024;
        if($this->size<1024)
            $this->size=round($this->size,0)."KB";
        else{
            $this->size/=1024;
            $this->size=round($this->size,2)."MB";
        }
        return ['data'=>$this->dirs,'num'=>$this->dir_num,'size'=>$this->size,'version'=>$version];
    }

    /**获取服务器更新内容
     * @param $data
     */
    public function get_serve_data($data,$version){
       $sql_url=VAE_ROOT."/backup/$version.sql";
       if(!file_exists($sql_url)){
           (new Sqloperation())->update_sql_file();
       }
       $version_url=ROOT."/app/version.txt";
       $handle = fopen($version_url, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
        $versions = fread($handle, filesize ($version_url));
        
        fclose($handle);
        $new_data=$this->get_local_data();
        $versions=config('version.wm.version');
        $version=$this->findNum($version);
        $versions=$this->findNum($versions);
        $version=intval($version);
        $versions=intval($versions);
        Log::error($version);
        Log::error($versions);
        if($version==$versions){
           
             return ['update'=>0];
        }
           
        $new_data=$new_data['data'];
        $size=0;
        $num=0;
        $dt=array();
        foreach ($data as $k=>$v){
            $val=str_replace("//","/",$k);
            $dt[$val]=$v;
        }
        $data=$dt;
        $arr=array();
        $dir=array();
        

        foreach ($new_data as $k=>$v){
            $bk=$k;
            
           $k=str_replace("//","/",$k);

            if(!isset($data[$k])){
                $arr[$num]=$k;
                $dir[$num]=$v['dir'];
              
                
              
                $size+=filesize(ROOT.$k);
                $num++;
            }else{
                if($data[$k]['md5']!=$new_data[$bk]['md5']){
                  
                    $arr[$num]=$k;
                    $dir[$num]=$v['dir'];
                  
                    $size+=filesize(ROOT."/".$k);
                    $num++;
                }
            }
        }
        $cache=[
            'up_code'=>$arr,
            'up_dir'=>$dir
        ];

       // $code=(new Token())->createToken($cache);
        $code=Token::saveCache($cache);

        $version=config('version.wm.version');

        $size=$this->count_size($size);
        if($size=="0KB")
            $size="1KB";
        if($num==0){
            return ['update'=>0,'up_version'=>0];
        }else{
            return ['update'=>1,'size'=>$size,'num'=>$num,'update_code'=>$code,'version'=>$version,'content'=>config('version.wm.content')];
        }

    }

    /**下载在线升级文件
     * @param $code
     */
    public function download($code)
    {
         
        $dir=Token::getCacheDir($code);
      
        $document=Token::getCacheupDir($code);
      
        $root_url=ROOT;
        $dir_url =VAE_ROOT."/backup";
        $code=md5($code);
        if(!is_dir($dir_url))
            mkdir($dir_url);

        $dir_url.="/{$code}";
        if(!is_dir($dir_url))
            mkdir($dir_url);
        foreach ($document as $k=>$v){
            if($v=="config/version.php")
                continue;

            if(!is_dir($dir_url."/$v")){

                mkdir($dir_url."/$v",0777,true);
            }
        }

        if(!is_dir($dir_url."/config"))
            mkdir($dir_url."/config");


        foreach ($dir as $k=>$v){
            copy($root_url."/".$v,$dir_url."/".$v);
        }
        $zip_url=VAE_ROOT."/backup/$code";
        $download_url=VAE_ROOT."/backup/$code.zip";
        $zip=new ZipFolder();
        $zip->zip($download_url,$zip_url."/");
        $this->deldir($zip_url."/");
        $download_url=Request::server('HTTP_HOST')."/backup/$code.zip";
        return $download_url;
    }
    /**计算大小
     * @param $size
     */
    public function count_size($size){
        $size=$size/1024;
        if($size<1024)
            $size=round($size,0)."KB";
        else{
            $size/=1024;
            $size=round($size,2)."MB";
        }
        return $size;

    }


    /**文件流下载
     * @param $receive_url
     * @param $send_file_name
     * @return bool
     */
    function copy_stream($receive_url, $send_file_name,$code)
    {
        
        $common=(new BaseCommon());
      //  Cache::put('upload_finish',0,10);

        $bachup_url=VAE_ROOT."/backup_version";
        $version=config('version.wm.version');
        $bachup_url.="/$version/";
        $this->bf_version_url=$bachup_url;
        if(!is_dir(VAE_ROOT."/backup"))
            mkdir(VAE_ROOT. "/backup");
        $this->code=$code;

        $res=$common->curl_get($receive_url);

        $res=json_decode($res);
        $res=(array)$res;
        $res=$res['data'];
        $res=(array)$res;
        $url=$res['path'];
        $common->curl_download($url,$send_file_name);
       


        $zip=new ZipArchive();
        $dir_url=VAE_ROOT."/zip_dir";


        if ($zip->open($send_file_name) != TRUE) {
            $state=false;
        }else{

            $zip->extractTo($dir_url);
            $state=true;
            $zip->close();
        }
        //$dir_url.="/$code/";
        $dir1= $dir_url."/$code/";
        $this->copys($dir1);
        $this->deldir($dir_url."/");

        if(!unlink(VAE_ROOT."/backup/update.zip")){
            Log::error("删除失败");
        }

      //  Cache::put('upload_finish',1,10);
        $this->upload_sql();
        return $state;
    }

    /**
     * 数据库更新
     */
    public function upload_sql()
    {


        $url=UPDATE_URL."/backup/".config('version.wm.version').".sql";
        $save_url=VAE_ROOT."/backup/".config('version.wm.version').".sql";
        (new BaseCommon())->curl_download($url,$save_url);
        (new Sqloperation())->cms_update_sql($save_url);
    }




    public  function deldir($path){
        //如果是目录则继续
        if(is_dir($path)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            //如果 $p 中有两个以上的元素则说明当前 $path 不为空
            if(count($p)>2){
                foreach($p as $val){
                    //排除目录中的.和..
                    if($val !="." && $val !=".."){
                        //如果是目录则递归子目录，继续操作
                        if(is_dir($path.$val)){
                            //子目录中操作删除文件夹和文件
                            $this->deldir($path.$val.'/');
                        }else{
                            //如果是文件直接删除
                            unlink($path.$val);
                        }
                    }
                }
            }
        }
        //删除目录
        return rmdir($path);
    }
    
    public function create_dirs($url)
        {
            
            $dirs=explode('/',$url);

            $str=VAE_ROOT;
            for ($i=1;$i<count($dirs)-1;$i++){
                $str.="/".$dirs[$i];
               
                if(!is_dir($str)){
                    mkdir($str);

                }

            }


        }


    public  function copys($path){
        if(is_dir($path)){

            $p = scandir($path);
            if(count($p)>2){
                foreach($p as $val){

                    if($val !="." && $val !=".."){

                        if(is_dir($path.$val)){

                            $this->copys($path.$val.'/');
                        }else{
                            $url=$path.$val;
                            $urls=explode('/'.$this->code,$url);
                            if(is_array($urls)){
                                   $this->create_dirs($urls[1]);
                                    copy($url,$this->bf_version_url.$urls[1]);
                                    copy($url,ROOT.$urls[1]);

                                }
                            }


                        }
                    }
                }
            }
        }




    public function read_all ($dir,$urls){





        $version=config('version.wm.version');
        $bachup_url=VAE_ROOT."/backup_version/$version/";




        if($urls=="config/version.php"){

            if(!is_dir($bachup_url."/config/"))
                mkdir($bachup_url."/config/");

            $data=$this->dirs;
            $data[$urls]['md5']=md5_file(ROOT."/$urls");
            $data[$urls]['dir']=$urls;
            $this->size+=filesize(ROOT."/$urls");


            $this->dirs=$data;
            $this->dir_num++;
        }
        if(!is_dir($dir)) return false;


        $handle = opendir($dir);
      
        if(!is_dir($bachup_url."/$urls/")){
              //print_r($bachup_url."/$urls/");
            mkdir($bachup_url."/$urls/");
        }

        if($handle){



            while(($fl = readdir($handle)) !== false){
                $temp = $dir.DIRECTORY_SEPARATOR.$fl;

                //如果不加  $fl!='.' && $fl != '..'  则会造成把$dir的父级目录也读取出来
                if(is_dir($temp) && $fl!='.' && $fl != '..'){
                    $str=substr($urls,-1,1);
                    if($str!='/'){

                        $urls.="/";
                    }

                    $this->read_all($temp,$urls.$fl);
                }else{
                    if($fl!='.' && $fl != '..'){

                        $data=$this->dirs;
                        $data[$urls."/".$fl]['md5']=md5_file($temp);
                        $data[$urls."/".$fl]['dir']=$urls;


                        $this->size+=filesize($temp);

                        $this->dirs=$data;
                        $this->dir_num++;


                    }
                }
            }
        }
    }
}