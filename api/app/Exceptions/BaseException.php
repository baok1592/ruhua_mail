<?php


namespace App\Exceptions;

use App\Exceptions\Exception;

class BaseException extends Exception
{
    public $code=100;
    public $message='操作失败';
    public function __construct($msg='')
    {
        $this->message=$msg;
        //Parent::__construct($msg);
    }

}