<?php
namespace App\Models;
use CodeIgniter\Model;
/**
 * TO DO LIST
 * 1. 유효성검사 분리 
 *   - 메일 
 *   - 비밀번호
 *   - 개행문자 등 
*/
class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = ['name', 'nickname', 'password', 'tel', 'email', 'gender'];
    //get
    public function getUser($id = false)
    {
        if ($id=== false)
        {
            return $this->findAll();
        }
    
        return $this->asArray()
                ->where(['id' => $id])
                ->first();
    }     
}
?>