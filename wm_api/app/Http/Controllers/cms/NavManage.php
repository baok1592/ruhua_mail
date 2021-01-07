<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\Nav as NavModel;

class NavManage extends BaseController
{
    /**
     * cms 新增导航
     * @return int
     */
    public function addNav()
    {
        $rule=[
            'nav_name'=> 'required',
            'img_id'=> 'required',
            'url'=> 'required',
        ];
        $post=Request::toArray();
        $this->validate($post,$rule);
        $res=NavModel::addNav($post);
        return $res?$this->success($res):$this->fail();
    }

    /**
     * cms更新导航
     * @param $id
     * @return int|\think\response\Json
     */
    public function editNav()
    {
        $post=Request::toArray();
        //unset($post['imgs']);
        $res=NavModel::editNav($post);
        return $res?$this->success($res):$this->fail();
    }

    /**
     * cms 删除导航
     * @param $id
     * @return \think\Collection|void
     */
    public function deleteNav()
    {
        $id=Request::input('id');
        $res=NavModel::deleteNav($id);
        return $res?$this->success($res):$this->fail();
    }


    /**
     * 获取所有导航
     * @return \think\response\Json
     */
    public function getNav()
    {
        $data=NavModel::getNavAll();
        return $this->success($data);
    }

    /**
     * 更新导航排序
     * @return int
     */
    public function setSort()
    {
        $arr=Request::toArray();
        $res=NavModel::setSort($arr);
        return $res?$this->success($res):$this->fail();
    }

}