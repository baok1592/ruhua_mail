<?php


namespace App\Http\Controllers\cms;


use App\ruhua\bases\BaseController;
use App\Http\models\Zhgl as ZhglModel;
use Illuminate\Support\Facades\Request;

class Zhgl extends BaseController
{
    public function getAllZZ(){
        $res=ZhglModel::all();
        return $this->go($res);
    }

    public function addZZ(){
        $post=Request::toArray();
        $res=ZhglModel::create($post);
        return $this->go($res);
    }
    public function delZZ(){
        $id=Request::input('id');
        $res=ZhglModel::destroy($id);
        return $this->go($res);
    }
    public function editZZ(){
        $post=Request::toArray();
        $res=ZhglModel::where('id',$post['id'])->update($post);
        return $this->go($res);
    }
    
    public function get_url()
    {
         $data=Request::toArray();
         $id=$data['id'];
        $res=ZhglModel::where('id',$id)->first();
        return $this->go($res);
    }

}