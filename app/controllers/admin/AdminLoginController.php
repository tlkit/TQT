<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/13/14
 * Time: 11:39 AM
 */

class AdminLoginController extends \BaseController {
    protected $layout = "admin.AdminLayouts.login";
    public function __construct()
    {
       //parent::__construct();
    }

    public function login($url=''){
        $submit = Request::get('submit',0);
        $username = Request::get('user_name','');
        $password= Request::get('password','');
        $error['mess'] = '';
        if (Session::has('user')) {
            if ($url === '' || $url === 'login') {
                return Redirect::route('admin.dashboard');
            } else {
                return Redirect::to(FunctionLib::buildUrlDecode($url));
            }

        } else {
            if ($submit > 0) {
                if ($username && $password) {
                    if (strlen($username) < 3 || strlen($username) > 50 || preg_match('/[^A-Za-z0-9_\.@]/', $username) || strlen($password) < 5) {
                        $error['mess'] = 'Không tồn tại tên đăng nhập!';
                    } else {
                        $user = User::getUserByName($username);
                        if($user !== NULL){
                            if($user->user_status == 0){
                                $error['mess'] = 'Tài khoản bị khóa';
                            }elseif($user->user_status == 1){
                                if($user->user_password == User::encode_password($password)){
                                    $permission_code = array();
                                    $group = explode(',',$user->user_group);
                                    if($group){
                                        $permission = GroupUserPermission::getListPermissionByGroupId($group);
                                        if($permission){
                                            foreach($permission as $v){
                                                $permission_code[] = $v->permission_code;
                                            }
                                        }
                                    }
                                    $data = array(
                                        'user_id' => $user->user_id,
                                        'user_name' => $user->user_name,
                                        'user_full_name' => $user->user_full_name,
                                        'user_email' => $user->user_email,
                                        'user_employee_id' => $user->user_employee_id,
                                        'user_is_admin' => $user->user_is_admin,
                                        'user_permission' =>$permission_code
                                    );
                                    Session::put('user', $data,1000000);
                                    User::updateLogin($user);
                                    //echo FunctionLib::buildUrlDecode($url); die('xxx');
                                    if ($url === '' || $url === 'login') {
                                        return Redirect::route('admin.dashboard');
                                    } else {
                                        return Redirect::to(FunctionLib::buildUrlDecode($url));
                                    }
                                }else{
                                    $error['mess'] = 'Mật khẩu không đúng';
                                }
                            }
                        }else{
                            $error['mess'] = 'Không tồn tại tên đăng nhập!';
                        }
                    }
                } else {
                    $error['mess'] = 'Chưa nhập mật khẩu hoặc tên đăng nhập!';
                }
            }
        }

        $this->layout->content = View::make('admin.AdminLogin.login')
            ->with('error', $error['mess'])->with('username', $username);
    }

    public function logout(){
        if(Session::has('user')){
           // Session::forget('key');
            Session::forget('user');
        }
        return Redirect::route('admin.login',array('url'=>base64_encode(URL::previous())));
    }

}