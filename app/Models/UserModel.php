<?php
namespace App\Models;
use CodeIgniter\Model;
/**
 * TO DO LIST
 *  유효성검사 분리 
 *   - 메일 
 *   - 비밀번호
 *   - 개행문자 등 
*/
class UserModel extends Model
{
    protected $table = 'profile';
    protected $primaryKey = 'id';
    /*
    protected $validationRules  = [
        'name'     => 'required|alpha_numeric_space|min_length[1]|max_length[20]',//20, 한글, 영문 대소문자만 혀용
        'nickname' => 'equired|alpha_numeric_space|min_length[1]|max_length[30]', // 30, 영문 소문자만 허용
        'password'     => 'required|min_length[10]', // 최소 10자 이상, 영문 대문자, 영문 소문자, 특수 문자, 숫자 각 1개 이상씩 포함
        'email'        => 'required|valid_email|is_unique[users.email]|min_length[100]', // 100, 이메일형식
        'tel' => 'required|max_length[20]', // 20, 숫자
        'gender' => 'min_length[1]|max_legnth[1]', // 필수아님 
        'accesskey' => ''
    ];
    */
    protected $allowedFields = ['name', 'nickname', 'password', 'tel', 'email', 'gender'];
    // 비밀번호 해쉬처리 
    protected $beforeInsert = ['hashPassword'];


    protected function hashPassword(array $data){
            if(!isset($data['data']['password'])) 
                return $data;
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            return $data;
    }

    
    public function getbyid($id){  
        return $this->asArray()
        ->where(['id' => $id])
        ->first();  
    } 
    
    public function getbyemail($email){  
        return $this->asArray()
        ->where(['email' => $email])
        ->first();  
    } 
    
    // fetch
    public function fetch($params){
        if(!isset($params['limit']))
            $params['limit'] = 0;
        if(!isset($params['offset']))
            $params['offset'] = 0;   

        if(isset($params['name']) && isset($params['email'])){
            return $this->where(['name' => $params['name'], 'email' => $parmas['email']])->findAll($params['limit'], $params['offset']);
        }else{
            if(isset($params['name'])){
                return $this->where(['name' => $params['name']])->findAll($params['limit'], $params['offset']);
            }
            if(isset($params['email'])){
                return $this->where(['email' => $params['email']])->findAll($params['limit'], $params['offset']);             
            }
            return $this->findAll();
        }        
    }
}
?>