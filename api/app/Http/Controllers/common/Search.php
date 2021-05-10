<?php


namespace App\Http\Controllers\common;


use App\Exceptions\BaseException;
use App\ruhua\bases\BaseController;
use App\Http\models\Goods as GoodsModel;
use App\Http\Controllers\server\SearchService;
use App\ruhua\server\Token;
use Illuminate\Support\Facades\Request;
use App\Http\models\Search as SearchModel;

class Search extends BaseController
{
    /**
     * 搜索商品
     * @param $name
     * @return mixed
     */
    public function searchGoods()
    {
        $name=Request::input('name');
    
        $name=trim(substr($name,0,7));
        $data=GoodsModel::getProductByName($name);

      
        return $this->success($data);
    }

    /**
     * 获取前十的搜索记录
     * @return mixed
     */
    public function getSearchRecord()
    {
        $res=SearchModel::orderBy('num','desc')->get();
        return $this->go($res);
       /* $res= SearchService::getSearchCache();
        return $this->success($res);*/
    }

    /**
     * cms新增记录
     * @param $name
     * @param $num
     * @return mixed
     */
    public function addSearchGoods()
    {
        $post=Request::toArray();
        $data=[
            'name'=>$post['name'],
            'num'=>$post['num']
        ];



        $res=SearchModel::create($data);
        return $this->success();
    }

    /**
     * 删除搜索记录
     * @param $name
     * @return mixed
     */
    public function deleteSearchGoods(){
        $name=Request::input('id');
        $res=SearchModel::where('id',$name)->delete();
        return $this->success($res);
    }

}