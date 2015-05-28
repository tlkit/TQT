<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/24/14
 * Time: 11:57 AM
 */
class AdminLogin {
    public static function checKLogin($username = '', $password = ''){
        $check = array();
        if(Config::get('config.DEVMODE')){
            $site = Config::get('config.URL_API_LOCAL');
        }else{
            $site = Config::get('config.URL_API_LIVE');
        }
        $site .= "authenticate/login";
        $curl = PlazaCurl::getInstance();
        $request = $curl->post($site,array('admin_username'=>$username,'admin_password'=>$password));
        $check  = json_decode($request,1);
        return $check;
    }
}