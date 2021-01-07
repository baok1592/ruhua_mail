<?php


namespace App\Http\Controllers\common;


use App\ruhua\bases\BaseController;
use App\Http\models\Article as ArticleModel;
use Illuminate\Support\Facades\Request;

class Article extends BaseController
{
    /**
     *  获取所有文章
     * @return mixed
     */
    public function getAllArticle()
    {
        $data=ArticleModel::all();
        if(!$data){
            return $this->fail('暂无数据');
        }
        return $this->success($data);
    }



    /**
     * 获取某一篇公告
     * @return mixed
     */
    public function getArticle()
    {
        $res=ArticleModel::getArticle();
        return $this->go($res);
    }

    /**
     * 获取个人中心文章
     */
    public function getPersonArtical()
    {
        $res=ArticleModel::where('type',5)->get();
        return $this->go($res);
    }

    /**
     * 获取文章详情
     * @return mixed
     */
    public function getOneArticle()
    {
        $id=Request::input('id');
        $res=ArticleModel::getOneArticle($id);
        return $this->go($res);
    }

    /**
     * 用户分类文章
     * @param $type
     * @return mixed
     */
    public function getTypeArticle()
    {
        $type=Request::input('type');
        $res=ArticleModel::with('img')->where('is_hidden',0)->where('type',$type)->get();
        return $this->go($res);
    }

    /**
     * 用户获取文章
     * @return mixed
     */
    public function userArticle()
    {
       $res=ArticleModel::userArticle();
       return $this->go($res);
    }

}