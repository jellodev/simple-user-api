<?php namespace App\Controllers;
require_once  APPPATH .'ThirdParty/jwt/src/BeforeValidException.php';
require_once  APPPATH .'ThirdParty/jwt/src/ExpiredException.php';
require_once  APPPATH .'ThirdParty/jwt/src/SignatureInvalidException.php';
require_once  APPPATH .'ThirdParty/jwt/src/JWT.php';


use App\Models\UserModel;
use CodeIgniter\Controller;
use \Firebase\JWT\JWT;

$debugmode = true;

if($debugmode)
    error_reporting(E_ALL); ini_set("display_errors", 1);

function reply_json($s){
    echo json_encode($s, JSON_UNESCAPED_UNICODE);
}

class Auth extends Controller
{
    public function login(){
        $stranger = $_REQUEST;        
        try {
            if(!isset($stranger['email']) || !isset($stranger['password']))
                throw new \Exception('needed valid params');

            $user = new UserModel();
            $customer = $user->getbyemail($stranger['email']);
            
            if(!$customer)
                throw new \Exception('cannot find user');

            if(password_verify($stranger['password'], $customer['password'])){
                unset($customer['password']);
                reply_json($customer);
            }else{
                reply_json(['error' => 'Access Denied']);
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        } 
    }

    public function logout(){
        echo "logout";
    }

    public function jwt_test(){
        $key = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000
        );

        $jwt = JWT::encode($payload, $key);
        print_r($jwt);
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        print_r($decoded);
    }
}