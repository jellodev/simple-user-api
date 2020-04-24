<?php
namespace App\Models;
use CodeIgniter\Model;
use \Firebase\JWT\JWT;

require_once  APPPATH .'ThirdParty/jwt/src/BeforeValidException.php';
require_once  APPPATH .'ThirdParty/jwt/src/ExpiredException.php';
require_once  APPPATH .'ThirdParty/jwt/src/SignatureInvalidException.php';
require_once  APPPATH .'ThirdParty/jwt/src/JWT.php';
//스케줄러를 통해 blacklist의 유효시간 지난 토큰 삭제하기.. 

class AccessTokenModel extends Model
{
    protected $table = 'blacklist';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['token', 'expireTime'];
    private $secretKey = "backpacker";

    /**
     * blakclist 에 등록된 토큰인지 확인하기 
     */
    function isBlackList($accessToken){  
        $result = $this->asArray()
            ->where(['token' => $accessToken])
            ->first(); 

        if($result)
            return true;
        else
            return false;
    } 

    /** 
     * blacklist에 토큰 추가하기  
    */
    function insertBlacklist($accessToken, $exp){
        $result = $this->insert([ 
            "token" => $accessToken, 
            "expireTime" => $exp
        ]);
        return $result;
    }


    /**
     * 신규 토큰 생성 
     * 토큰 유효시간은 60분 
     */
    function make($userid){
        $now = strtotime("now");
        $expireTime = strtotime("+60 minutes"); // 60분 

        $payload = array(
            "iss" => "mihee", // 발행자
            "sub" => $userid, // Subject
            "iat" => $now, // Issue at(토큰 발행일자)
            "exp" => $expireTime // Expire (토큰 만료시간) 
        );
        $accessToken = JWT::encode($payload, $this->secretKey);

        $response=[
            "status" => 'success',
            "accessToken" => $accessToken,
            "tokenType" => "Bearer",
            "expireTime" => $expireTime
        ];

        return $response;       
    }

    /** 
     * 토큰 decode 
    */
    function decode($accessToken){
        $decoded = JWT::decode($accessToken, $this->secretKey, array('HS256'));
        return $decoded;
    }    
}
?>