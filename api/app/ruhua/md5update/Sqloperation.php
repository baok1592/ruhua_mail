<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/7 0007
 * Time: 8:40
 */

namespace App\ruhua\md5update;


use App\Exceptions\BaseException;
use App\Exceptions\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;
use App\Http\models\SysConfig as SysConfigModel;

class Sqloperation
{
    private $username='';
    private $password='';
    private $databases='';
    private $servername="localhost";
    private $dht;

    public function __construct()
    {

        $this->username=config('database.connections.mysql.username');
        $this->password=config('database.connections.mysql.password');
        $this->databases=config('database.connections.mysql.database');
        $this->dht=new PDO("mysql:host={$this->servername};dbname={$this->databases}",$this->username,$this->password);
        $this->dht->query('set names utf8');
        if(!is_dir(ROOT."/backup"))
            mkdir(ROOT."/backup");

    }

    public function update_sql_file()
    {

        $content=array();
        $sql=" show tables";
        $data=$this->query($sql);
        $tables=array();
        DB::beginTransaction();
        try{
            foreach ($data as $k=>$v){
                $tables[$k]['name']=$v[0];
                $sql="show create table {$v[0]}";
                $show_data=$this->query_fetch($sql);
                $tables[$k]['create_sql']=$show_data['Create Table'];
            }
            $content['tables']=$tables;
            $sql="SELECT TABLE_NAME,COLUMN_TYPE,COLUMN_COMMENT,column_name,NUMERIC_SCALE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$this->databases}'";
            $data=$this->query($sql);
            $content['data']=$data;
            $old_version=ROOT."/app/version.txt";
            $old_version = file_get_contents($old_version);
            $filename=VAE_ROOT."/backup/".config('version.wm.version').".sql";
            $filename1=VAE_ROOT."/backup/".$old_version.".sql";
           /* $sql="select *from rh_sys_config";
            $sys=$this->query($sql);
            foreach ($sys as $k=>$v){
                $sys[$k]['value']=0;
            }
            $content['sys']=$sys;
*/
            $str=json_encode($content);
            $str1=$str;
            $handle=fopen($filename,"w");
            $str=fwrite($handle,$str);
            fclose($handle);
            
             $handle1=fopen($filename1,"w");
            $str1=fwrite($handle1,$str1);
            fclose($handle1);
        DB::commit();

        }catch (Exception $e) {
            // 回滚事务
        DB::rollback();
            throw new BaseException(['msg' => '数据库更新失败' . $e->getMessage()]);
        }
    }


    public function cms_update_sql($url)
    {

     
        $handle = fopen($url, "r");//读取二进制文件时，需要将第二个参数设置成'rb'

        //通过filesize获得文件大小，将整个文件一下子读到一个字符串中
        $contents = fread($handle, filesize ($url));
        fclose($handle);
        $contents=json_decode($contents);
        DB::beginTransaction();
        try {
            $contents=(array)$contents;
        
            $sql="show tables";
            $old_table_data=$this->query($sql);
           $table_arr=array();
            foreach ($old_table_data as $k=>$v)
                $table_arr[$k]=$v[0];
            $new_table_data=$contents['tables'];
              
            $new_table_data=(array)$new_table_data;

            foreach ($new_table_data as $k=>$v){
                $v=$this->obj_to_arr($v);

                if(!in_array($v['name'],$table_arr)){
                    $sql=$v['create_sql'];
                    $this->exec($sql);
                }
            }




            $field=(array)$contents['data'];
            $old_field=$this->query("SELECT TABLE_NAME,COLUMN_TYPE,COLUMN_COMMENT,column_name,NUMERIC_SCALE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$this->databases}'");
            foreach ($old_field as $k=>$v){
                $flg=1;
                foreach ($field as $key=>$val){
                    $val=(array)$val;
        
                    if($v['TABLE_NAME']==$val['TABLE_NAME']&&$v['column_name']==$val['column_name']){
                        $flg=0;
                        break;
                    }

                }
                if($flg==1){
                    $sql="ALTER TABLE {$v['TABLE_NAME']} ADD `{$v['column_name']}` {$v['COLUMN_TYPE']} DEFAULT  '{$v['NUMERIC_SCALE']}'";

                    $res=$this->dht->exec($sql);
                }
            }





            DB::commit();

        } catch (Exception $e) {
            // 回滚事务
            DB::rollback();
            Log::error("数据库更新失败:".$e->getMessage());
            throw new BaseException(['msg' => '数据库更新失败' . $e->getMessage()]);
        }

    }

    private function obj_to_arr($obj)
    {
        $arr=array();
        foreach ($obj as $k=>$v){
            $arr[$k]=$v;
        }
        return $arr;
    }



    private function query($sql)
    {
        return $this->dht->query($sql)->fetchAll();
    }

    private function query_fetch($sql)
    {
        return $this->dht->query($sql)->fetch();
    }

    private function exec($sql){
        $res=$this->dht->exec($sql);
    }
}