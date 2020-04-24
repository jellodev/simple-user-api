<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AccessTokenModel;
use CodeIgniter\Controller;


$debugmode = true;

if($debugmode)
    error_reporting(E_ALL); ini_set("display_errors", 1);

function reply_json($s){
    echo json_encode($s, JSON_UNESCAPED_UNICODE);
}

class Auth extends Controller
{
    /**
     * 회원 로그인 
     * 성공 시 토큰 리턴 
     */ 
    public function login(){
        $stranger = $_REQUEST;        
        try {
            if(!isset($stranger['email']) || !isset($stranger['password']))
                throw new \Exception('invalid request');

            $user = new UserModel();
            $customer = $user->getbyemail($stranger['email']);

            if(!$customer)
                throw new \Exception('Not Found');

            if(password_verify($stranger['password'], $customer['password'])){
                $accessToken = new AccessTokenModel();
                $token = $accessToken->make($customer['id']);
                reply_json($token);
            }else{
                throw new \Exception('Access Denied');
            }
        } catch (\Exception $e) {
            reply_json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ]);
        } 
    }
    /** 
     * 로그아웃 
     * access token 정보를 blacklist db insert 
     * header - Authorization
    */
    public function logout(){
        try {
            $headers = getallheaders();  
            if(isset($headers['Authorization'])){
                $accessToken = new AccessTokenModel();
                $authHeader  = $headers['Authorization'];  
                
                // 이미 로그아웃처리가 되어 blacklist에 들어간 token인지 확인 
                if($accessToken->isBlackList($authHeader))
                    throw new \Exception('Authentication failed');

                $payload = $accessToken->decode($authHeader);
                if(!empty($payload)){
                    $result=$accessToken->insertBlacklist($authHeader, $payload->exp);
                    if($result>0){
                        reply_json([
                            "status" => "success",
                            "message" => "logout"
                        ]);
                    }
                }    
            }else{
                throw new \Exception('Authentication header not exists.');          
            }
        } catch (\Exception $e) {
            reply_json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ]);
        }
    }
 
    /**
     * 토큰 재발행 
    */
    public function refreshToken(){
        try {
            $headers = getallheaders();  
            if(isset($headers['Authorization'])){
                $accessToken = new AccessTokenModel();
                $authHeader  = $headers['Authorization'];
                $payload = $accessToken->decode($authHeader);
                $newToken = $accessToken->make($payload->sub);
                reply_json($newToken);
            }else{
                throw new \Exception('Authentication header not exists.');
            }
        } catch (\Exception $e) {
            reply_json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ]);
        }
    }
}