<?php


namespace App\Http\Controllers\common;


use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\Category as CategoryModel;

class Category extends BaseController
{
    /**
     * 获取X级分类信息
     * @param $id
     * @return \think\Collection|void
     */
    public function getCateLevel()
    {
        $id=Request::input('id');
        $res=CategoryModel::getCategoryLevel($id);
        return $this->go($res);
    }

    /**
     * 获取所有分类信息
     * @return mixed
     */
    public function getAllCategory()
    {
        $data=CategoryModel::all();
        return $this->success($data);
    }


    /**
     * 获取分类下所有子类与广告图
     * @param string $id
     * @return \think\response\Json
     */
    public function getCateChildImg()
    {

        $id=Request::input('id');
        $res=CategoryModel::getCateChildImg($id);
        return $this->go($res);
    }

}