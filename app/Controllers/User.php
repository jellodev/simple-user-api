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
 */
class User extends Controller
{
    //fetch
    public function index()
    {
        $model = new UserModel();

        $data = [
            'users'  => [], //user fetch
            //'users'  => $model->getUser(), //user fetch
            'accesskey' => 'valid access!', // accesskey?
        ];
        print_r($data);
        //echo view('templates/header', $data);
        //echo view('user/list', $data);
        //echo view('templates/footer', $data);
    }
    // 한명만 
    public function view($id = null)
    {
        $model = new UserModel();

        //$data['user'] = $model->getUser($id);
        $data['user'] = 'mihee';
        if (empty($data['user']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the user: '. $id);
        }
        print_r($data);
        //echo view('templates/header', $data);
        //echo view('user/list', $data);
        //echo view('templates/footer', $data);
    }
    //put - insert 
    public function create()
    {
        $model = new UserModel();
        $params = $_REQUEST;
        // 유효성체크 - 되나확인하기(form만 될수도)
        if (! $this->validate([
            'name' => 'required|max_length[20]',
            'nickname'  => 'required|max_length[30]',
            'password' => 'required|min_length[10]|max_length[20]',
            'tel' => 'required|max_length[20]',
            'email' => 'required|max_length[100]',
            //'gender' => 'max_length[1]'
        ])){
            echo "유효성 탈락!!";
        }else{
            echo "post in";
            $result=$model->save([
                'title' => $params['name'],
                'nickname'  => $params['nickname'],
                'password'  => $params['password'], 
                'tel'  => $params['tel'],
                'email'  => $params['email'],
                'gender'  => $params['gender']
            ]);
            print_r($result);
            //echo view('user/success');
        }
    }
    //login
    public function login(){

    }
    //logout
    public function logout(){

    }

}