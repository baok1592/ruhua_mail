<?php


namespace App\ruhua\bases;

use App\Exceptions\BaseException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; //授权请求、作业调度器、验证请求

    /**
     * 验证数据
     * @param array $request 数据
     * @param array $rules 规则
     * @param array $messages 错误信息
     * @param array $customAttributes 自定义属性
     * @return bool
     */
    public function validate(array $data, array $rules, array $messages = [])
    {
        $validate=$this->getValidationFactory()->make($data,$rules,$messages);
        if($validate->fails()){
            throw new BaseException($validate->errors()->first());
        }
        //return $validate->validate();
    }

    public function code(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    //创建响应
    public function make(int $status, string $msg, $data = null)
    {
//        if(is_object($data)){
//            $data=json_decode(json_encode($data), true);
//        }
        $result = [
            "status" => $status,
            "msg" => $msg,
            "data" => $data
        ];
        return Response()->json($result);
    }

    public function go($data)
    {
        if (is_array($data)) {
            return $this->success('操作成功', $data);
        }
        if (is_string($data) || !$data) {
            return $this->fail('操作失败');
        } else {
            return $this->success('操作成功', $data);
        }
    }

    //操作成功
    public function success($obj = '操作成功', $data = 1)
    {
        if (!is_string($obj) || is_numeric($obj)) {
            $data = $obj;
            $obj = '操作成功';
        }
        return $this->make(200, $obj, $data);
    }

    //操作错误
    public function fail($msg = '操作失败', $data = null)
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg = '操作失败';
        }

        return $this->make(400, $msg, $data);
    }
}