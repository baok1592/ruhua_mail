<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\ImageCategory as ImageCategoryModel;
use App\Http\models\Image;



class ImageManage extends BaseController
{
    /**
     * 添加分类
     * @return mixed
     */
    public function addImageCategory()
    {
        $rule=['category_name'=>'required'];
        $post=Request::toArray();
        $this->validate($post,$rule);
        $res=ImageCategoryModel::addCategory($post);
        return $this->go($res);
    }

    /**
     * 删除分类
     * @param $id
     * @return mixed
     */
    public function deleteImageCategory()
    {
        $id=Request::input('id');
        $res=ImageCategoryModel::deleteCategory($id);
        return $this->go($res);
    }

    /**
     * 获取分类
     * @return mixed
     */
    public function getImageCategory()
    {
        $res=ImageCategoryModel::select()->get();
        return $this->success($res);
    }

    /**
     * 获取所有图片
     * @return mixed
     */
    public function getAllImage(){
        $res=Image::where('is_visible',1)->orderByDesc('id')->get();
        return $this->success($res);
    }

    /**
     * 隐藏图片
     * @param $ids
     * @return mixed
     */
    public function editImage(){
        $ids=Request::input('ids');
        $res=Image::whereIn('id',$ids)->delete();
        //$res=Image::whereIn('id',$ids)->update(['is_visible'=>1]);
        return $this->go($res);
    }

}