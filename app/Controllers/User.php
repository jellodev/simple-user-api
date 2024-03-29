<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

$debugmode = true;

if($debugmode) 
    error_reporting(E_ALL); ini_set("display_errors", 1);  //[error_reporting] 오류수준을 설정함 E_ALL은 모든 오류 , [ini_set] 화면에 error 표시 true  

function reply_json($s){
    echo json_encode($s, JSON_UNESCAPED_UNICODE);
}

class User extends Controller
{
    /**
     * 회원 아이디를 이용하여 단일 회원 정보 가져오기 
     */
    public function getbyid(){
        $params = $_REQUEST;
        try{
            if(!$params['id'])
                throw new \Exception("invalid_request");
            $model = new UserModel();
            $user=$model->getbyid($params['id']);

            if(empty($user))
                throw new \Exception('Not Found');

            reply_json([
                'status' => 'success',
                'user' => $user
            ]);
        }catch(\Exception $e){
            reply_json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ]);
        }    
    }
    /**
     *  여러 회원 목록 조회하기
     *  페이지네이션으로 일정단위 조회 가능
     *  이름, 이메일을 이용하여 검색 가능(부분검색x)
    */  
    public function fetch(){
        try {
            $model = new UserModel();
            $users = $model->fetch($_REQUEST);
            if(!empty($users)){
                reply_json([
                    'status' => 'success',
                    'users' => $users
                ]);
            }else
                throw new \Exception('Not Found');
        } catch (\Exception $e) {
            reply_json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ]);
        }
    }
    /**
     * 신규 회원 생성하기 
     * email 기준으로 회원 생성함   
     */
    public function create(){
        try {
            $model = new UserModel();
            $stranger = $_REQUEST;
            if(empty($stranger))
                throw new \Exception('invalid request');
    
            if ($model->save($stranger) === false){
                reply_json([
                    'status' => 'error',
                    'messages' => $model->errors()
                ]);
            }else{
                reply_json([
                    'status' => 'success',
                    'messages' => 'create new user. id: '.$model->insertID
                ]);
            }   
        } catch (\Exception $e) {
            reply_json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ]);
        }  
    }
}