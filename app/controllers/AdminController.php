<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/16/14
 * Time: 3:16 PM
 */

class AdminController extends \BaseController {

    /**
     * Initializer.
     *
     * @return \AdminController
     */
    protected $layout = "admin.AdminLayouts.default";
    protected $permission = array();
    protected $is_root = false;
    protected $user = array();

    public function __construct()
    {
        //Session::forget('user');
        if (!Authenticate::isLogin()) {
           return Redirect::route('admin.login',array('url'=>FunctionLib::buildUrlEncode(URL::current())));
        }

        $this->user = User::user_login();

        if($this->user && $this->user['user_is_admin'] == 1){
            $this->is_root = true;
        }
        if($this->user && sizeof($this->user['user_permission']) > 0){
            $this->permission = $this->user['user_permission'];
        }

        View::share('is_root',$this->is_root);
        View::share('aryPermission',$this->permission);

        View::share('user',$this->user);
    }

    function debug(){
        $curl = PlazaCurl::getInstance();
        View::share('api_query', $curl->build);
        View::share('total_time', $curl->timeTotal);
    }
}