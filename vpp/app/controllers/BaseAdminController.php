<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 29/05/2015
 * Time: 8:27 CH
 */
class BaseAdminController extends BaseController
{

    protected $layout = 'admin.AdminLayouts.index';
    protected $permission = array();
    protected $user = array();

    public function __construct()
    {
        if (!User::isLogin()) {

            Redirect::route('admin.login',array('url'=>self::buildUrlEncode(URL::current())))->send();
        }

        $this->user = User::user_login();
        if($this->user && sizeof($this->user['user_permission']) > 0){
            $this->permission = $this->user['user_permission'];
        }

        View::share('aryPermission',$this->permission);
        View::share('user',$this->user);

    }

}