<?php


namespace App\Http\Controllers\user;


use App\ruhua\bases\BaseController;
use App\ruhua\server\Token;
use App\Http\models\Favorites as FavoritesModel;
use Illuminate\Support\Facades\Request;

class UserFavorites extends BaseController
{
    /**
     * 查询某商品是否已收藏
     * @param string $id
     * @param string $type
     * @return mixed
     */
    public function scFavGood()
    {
        $id=Request::input('id');
        $uid = Token::getCurrentTokenVar('id');//接收token，获取uid
        $res = FavoritesModel::getFavTypeByID($id, $uid);
        return $this->success($res);
    }

    /**
     * 获取该用户所有收藏
     * @return \think\response\Json
     */
    public function getFavorite()
    {
        $uid = Token::getCurrentTokenVar('id');//接收token，获取uid
        $res=FavoritesModel::getFavoriteByUid($uid);
        return $this->go($res);
    }

    /**
     * 添加收藏
     * @return \think\response\Json
     */
    public function addFavorite()
    {
        $data=Request::toArray();
        $data['uid'] = Token::getCurrentTokenVar('id');//接收token，获取uid
        $res= FavoritesModel::addFavorites($data);
        return $this->go($res);
    }

    /**
     * 删除收藏
     * @param string $id
     * @return mixed
     */
    public function deleteFavorite()
    {
        $id=Request::input('id');
        $uid=Token::getCurrentTokenVar('id');
        $res = FavoritesModel::where(['fav_id' => $id, 'uid' => $uid])->delete();
        return $this->go($res);

    }

}