<?php


namespace App\Exceptions;


class Exception extends \Exception
{
    // HTTP 状态码 404,200
    public $code = 400;
    // 错误具体信息
    public $message = '未知错误--Base';
    // 自定义的错误码
    public $errorCode = 9999;

    public function __construct($params = []){
        if( !is_array($params)){
            return ;
        }
        if(array_key_exists('status',$params)){
            $this->code = $params['status'];
        }
        if(array_key_exists('msg',$params)){
            $this->message = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }

}