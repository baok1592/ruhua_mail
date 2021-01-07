<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\Category as CategoryModel;

class CategoryManage extends BaseController
{
    /**
     * cms 新增分类
     * @param $form
     * @return int
     */
    public function addCategory()
    {
        $form=Request::input('form');
        $rule=[
            'category_name'=> 'required|min:2',
            'pid'=> 'required|numeric'
        ];
        $this->validate($form,$rule);
        $res=CategoryModel::addCategory($form);
        return $this->go($res['id']);
    }

    /**
     * cms更新分类
     * @param $form
     * @return int|\think\response\Json
     */
    public function editCategory()
    {
        $form=Request::input('form');
        $rule=[
            'category_name'=> 'required|min:2',
            'pid'=> 'required|numeric'
        ];
        $this->validate($form,$rule);
        $res=CategoryModel::editCategory($form);
        return $this->go($res);
    }

    /**
     * cms 删除分类
     * @param $id
     * @return \think\Collection|void
     */
    public function deleteCategory()
    {
        $id=Request::input('id');
        $res=CategoryModel::deleteCategory($id);
        return $this->go($res);
    }


    /**
     * cms 获取所有分类并排好序，包括隐藏
     * @return \think\response\Json
     */
    public function getCateSort()
    {
        $data=CategoryModel::where('is_visible',1)->orderBy('category_id','desc')->get();
        return $this->success($data);
    }

    /**
     * 更新分类排序
     * @return int
     */
    public function setSort()
    {
        $arr=Request::toArray();
        $res=CategoryModel::setSort($arr);
        return $this->go($res);
    }

}