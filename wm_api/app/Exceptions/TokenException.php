<?php


namespace App\Exceptions;


use App\Exceptions\Exception;

class TokenException extends Exception
{
    // HTTP 状态码 404,200
    public $code = 400;

    // 错误具体信息
    public $message = '用户不存在';

    public function __construct($message='',$status=600)
    {
        $this->code=$status;
        $this->message=$message;
    }

}