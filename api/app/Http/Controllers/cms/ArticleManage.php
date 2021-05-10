<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use Illuminate\Support\Facades\Request;
use App\Http\models\Article as ArticleModel;

class ArticleManage extends BaseController
{
    /**
     * 添加文章
     * @return mixed
     */
    public function addArticle()
    {
        $rule = ([
            'title' => 'required',
            'content' => 'required'
        ]);
        $post = Request::toArray();
        $this->validate($post, $rule);
        $res=ArticleModel::addArticle($post);
        return $this->go($res);
    }

    /**
     * 修改文章
     * @return mixed
     */
    public function editArticle()
    {
        $data = Request::toArray();
        $res=ArticleModel::editArticle($data);
        return $this->go($res);
    }

    /**
     * 删除文章
     * @param int
     * @return mixed
     */
    public function deleteArticle()
    {
        $id=Request::input('id');
        $res=ArticleModel::deleteArticle($id);
        return $this->go($res);
    }

    /**
     * cms 获取所有文章
     * @return mixed
     */
    public function adminGetAllArticle()
    {
        $data=ArticleModel::with('img')->get();
        return $this->success($data);
    }

    /**
     * cms获取所有文章名称ID
     * @return \think\Collection
     */
    public function allArticleName()
    {
        $res = ArticleModel::select('id','title')->get();
        return $this->success($res);
    }

}