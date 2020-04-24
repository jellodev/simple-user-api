<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'profile';
    protected $primaryKey = 'id';

    /**
     * 유효성 체크
     * 비밀번호에 포함 시킬 수 있는 특수문자는 !@#$%^&*+ 만 가능 
     * gender 는 F/M 만 허용, (빈값 가능) 
     */
    protected $validationRules  = [
        'name'         => 'required|max_length[20]|regex_match[/^[가-힣a-zA-Z]+$/]',//20, 한글, 영문 대소문자만 혀용
        'nickname'     => 'required|max_length[30]|regex_match[/^[a-z]+$/]', // 30, 영문 소문자만 허용
        'password'     => 'required|regex_match[/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*+]).{10,}/]', // 최소 10자 이상, 영문 대문자, 영문 소문자, 특수 문자, 숫자 각 1개 이상씩 포함
        'email'        => 'required|valid_email|is_unique[profile.email]|max_length[100]', // 100, 이메일형식
        'tel'          => 'required|is_natural_no_zero|max_length[20]', // 20, 숫자
        'gender'       => 'permit_empty|regex_match[/[F,M]/]' // 필수아님 
    ];
   
    protected $allowedFields = ['name', 'nickname', 'password', 'tel', 'email', 'gender'];

    /** 
     * 비밀번호 해쉬처리 
     * 신규 회원 생성 시 자동으로 해쉬처리함 
    */
    protected $beforeInsert = ['hashPassword'];
    protected function hashPassword(array $data){
            if(!isset($data['data']['password'])) 
                return $data;

            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            return $data;
    }

    /**
     * id로 회원정보 찾기 
    */
    public function getbyid($id){  
        return $this->find($id);
    } 

    /** 
     * email로 회원정보 찾기 
    */
    public function getbyemail($email){
        return $this->asArray()
            ->where(['email' => $email])
            ->first(); 
    }
    /**
     * 여러 회원 목록 조회 
     * limit 기본값 1000
     * 페이징 검색, 이름, 이메일 검색(부분검색 허용x)
     */
    public function fetch($params){
        if(empty($params['limit']))
            $params['limit'] = 1000;
        if(empty($params['offset']))
            $params['offset'] = 0;   
        
        if(!empty($params['name']) && !empty($params['email'])){
            return $this->where(['name' => $params['name'], 'email' => $params['email']])
                ->findAll($params['limit'], $params['offset']);
        }else{
            if(!empty($params['name'])){
                return $this->where(['name' => $params['name']])
                    ->findAll($params['limit'], $params['offset']);
            }
            if(!empty($params['email'])){
                return $this->where(['email' => $params['email']])
                    ->findAll($params['limit'], $params['offset']);             
            }
            return $this->findAll($params['limit'], $params['offset']);
        }        
    
    }
}
?>