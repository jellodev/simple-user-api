<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
/**
 * TO DO LIST 
 * 1. create user API
 * 2. user login API
 * 3. user logout API
 * 4. user GET API
 * 5. user FETCH API - SERACH BY PAGENATION OR NAME OR EMAIL 
 * ----
 * login accesskey 
 * pw 암호화
 * login logout 처리는 무엇으로 할까? 
 * email name 부분검색 허용?
 */

$debugmode = true;

if($debugmode)
    error_reporting(E_ALL); ini_set("display_errors", 1);

function reply_json($s){
    echo json_encode($s, JSON_UNESCAPED_UNICODE);
}

class User extends Controller
{
    public function getbyid(){
        $params = $_REQUEST;
        try{
            if(!$params['id'])
                throw new \Exception("needed valid params");
            $model = new UserModel();
            $data=$model->get($params['id']);

            if(empty($data['user']))
                throw new \Exception('Cannot find the user');

            reply_json($data);
        }catch(\Exception $e){
            print_r($e->getMessage());
        }    
    }  

    public function fetch(){
        try {
            $model = new UserModel();
            $users = $model->fetch($_REQUEST);
            reply_json($users);
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function create(){
        $model = new UserModel();
        $params = $_REQUEST;
        $data = [
            'name' => $params['name'],
            'nickname'  => $params['nickname'],
            'password'  => $params['password'], 
            'tel'  => $params['tel'],
            'email'  => $params['email'],
            'gender'  => $params['gender']
        ];
        if ($model->save($data) === false){
            echo reply_json(['errors' => $model->errors()]);
        }else{
            echo reply_json(['success' => '200']);
        }       
    }
    //fetch
    public function index(){
        echo "index";
    }
}