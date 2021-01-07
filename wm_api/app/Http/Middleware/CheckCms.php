<?php


namespace App\Http\Middleware;


use App\Exceptions\BaseException;
use App\Exceptions\TokenException;
use App\ruhua\server\Token;
use Closure;

class CheckCms
{
    public function handle($request, Closure $next)
    {
        $res = $this->GTadmimScope();//判断是否具有管理员权限
        if ($res == true ) {
            return $next($request);
        }
        throw new BaseException('没有权限！');
    }
    //判断权限，仅管理员可访问
     protected function GTadmimScope()
    {
        try {
            $scope = Token::getCurrentTokenVar('scope');
            if ($scope >= 16) { //判断权限值是否大于最低的用户权限
                return true;
            } else {
                throw new TokenException('无权限');
            }
        } catch (\Exception $ex) {
            throw new TokenException($ex->getMessage());
            //throw new TokenException(['msg'=>'无权限-'.$ex->getMessage(),'code'=>$ex->getCode()]);
        }
    }

}