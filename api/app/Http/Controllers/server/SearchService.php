<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/20 0020
 * Time: 8:59
 */

namespace App\Http\Controllers\server;


use Illuminate\Support\Facades\Cache;
use function PHPSTORM_META\type;

class SearchService
{
    /**
     * 设置搜索缓存
     * @param $name
     * @param $num
     */
    public static function setSearchCache($name,$num){
        $name=$name." ";
        $value[$name]=$num+1;
        $search = Cache::get('search');
        if(!$search){
            cache::put('search',$value);
        }else{
            if (!is_array($search)) {
                $search=unserialize($search);
                $search = json_decode($search, true);
            }
            if (array_key_exists($name, $search)) {
                $search[$name]=$search[$name]+$num;
            } else {
                if(count($search)==20){
                    array_pop($search);
                }
                $search[$name]=$num*1;
            }
            array_multisort($search,SORT_DESC );
            cache::put('search', $search);
        }
    }

    /**
     * 获取搜索记录前十
     * @return array|string
     */
    public static function getSearchCache()
    {
        //Cache::forget('search');
        $arr=[];
        $search = Cache::get('search');
        if(!$search){
            return false;
        }else{
            if (!is_array($search)) {
                $search = json_decode($search, true);
            }
            $search= array_slice($search,0,10);
            foreach ($search as $k=>$v){
                $k=trim($k);
                array_push($arr,$k);
            }
            return $arr;

        }
    }

    /**
     * 删除搜索记录
     * @param $name
     * @return mixed
     */
    public static function deleteSearchCache($name)
    {
        $search = Cache::pull('search');
        if(!$search){
            return false;
        }else{
            if (!is_array($search)) {
                $search = json_decode($search, true);
            }
            $search= array_diff_key($search,[$name=>1]);
            cache::put('search', $search);
            return true;
        }
    }
}