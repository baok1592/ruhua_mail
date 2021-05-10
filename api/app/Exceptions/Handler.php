<?php

namespace App\Exceptions;

use App\Exceptions\Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psr\Log\LoggerInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *未报告的异常类型列表
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *从未闪现过验证异常的输入的列表
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *报告或记录异常
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldntReport($exception)) {
            return;
        }

        if (is_callable($reportCallable = [$exception, 'report'])) {
            $this->container->call($reportCallable);

            return;
        }

        try {
            $logger = $this->container->make(LoggerInterface::class);
        } catch (\App\Exceptions\Exception $ex) {
            throw $exception;
        }

        $logger->error(
            $exception->getMessage().'——'.$exception->getFile().'——'.$exception->getLine()
        );
        //parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *将异常呈现到HTTP响应中
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if(config('app.debug')) {
            return parent::render($request, $exception);
        }
        return $this->handle($request, $exception);
    }
    public function handle($request, Throwable $exception){
        if ($exception instanceof Exception){
            $status = $exception->getCode();
            $msg = $exception->getMessage();
        }else {
            $status = 500;
            $msg = $exception->getMessage();
        }
        $result = [
            'status' => $status,
            'msg' => $msg,
            'request_url' => $exception->getFile().$exception->getLine()  //获取当前访问的URL
        ];
        return response()->json($result);
        //return parent::render($request, $exception);
    }
}
