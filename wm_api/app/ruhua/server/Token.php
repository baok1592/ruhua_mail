<?php


namespace App\ruhua\server;
use App\Exceptions\BaseException;
use App\Exceptions\TokenException;
use Firebase\JWT;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Token
{
    public function createToken($data)
    {

        $key = '344'; //key，唯一标识
        $time = time(); //当前时间
        $token = [
            'iat' => $time, //签发时间
            'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time+17200, //过期时间,这里设置2个小时
            'data' => $data
        ];
        $token = JWT\JWT::encode($token, $key,'HS256'); //签发token
        //Cache::put($token,$data);
        return $token;
    }
    // $token：签发的token
    public function verifyToken($token)
    {
        $key = '344'; //key要和签发的时候一样，唯一标识
        try {
            JWT\JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT\JWT::decode($token, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            return $arr['data'];
        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            throw new TokenException('签名不正确');
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            throw new TokenException('签名在某个时间点之后才能用');
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            throw new TokenException('token过期');
        }catch(\Exception $e) {  //其他错误
            throw new TokenException('token不存在！');
        }
    }
    //根据token获取JWT中指定字段
    public static function getCurrentTokenVar($key1)
    {
        $token=Request::header('token');
        $key = '344'; //key要和签发的时候一样，唯一标识
        try {
            JWT\JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT\JWT::decode($token, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $res=json_decode(json_encode($arr['data']), true);
            //dump($res);
            return $res[$key1];
        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            throw new TokenException('签名不正确');
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            throw new TokenException('签名在某个时间点之后才能用');
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            throw new TokenException('token过期');
        }catch(\Exception $e) {  //其他错误
            throw new TokenException('token过期！');
        }
    }

}