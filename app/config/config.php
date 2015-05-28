<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/14/14
 * Time: 3:50 PM
 */
$webroot=str_replace('\\','/','http://'.$_SERVER['HTTP_HOST'].(dirname($_SERVER['SCRIPT_NAME'])?dirname($_SERVER['SCRIPT_NAME']):''));
$webroot.=$webroot[strlen($webroot)-1]!='/'?'/':'';
$strWebroot = $webroot;
unset($webroot);


return array(
    'TIME_NOW'=> time(),
    'DEVMODE'=> false,
    'WEB_ROOT' => $strWebroot,
    //'URL_API_LOCAL' => 'http://api.plaza.muachung.vn/index.php/',
    //'URL_CLIENT_LOCAL' => 'http://api.plaza.muachung.vn/index.php/',

    'URL_API_LOCAL' => 'http://api.plaza.todo.vn/index.php',
    'URL_CLIENT_LOCAL' => 'http://api.plaza.todo.vn/index.php',

    'DOMAIN_COOKIE_SERVER_DEV' => '.muachung.vn',
    'DOMAIN_COOKIE_SERVER' => '.muachung.vn',
    'URL_API_LIVE' => 'http://api.plaza.todo.vn/index.php',
    'WEB_ROOT' => $strWebroot
);

/*return array(
    'TIME_NOW'=> time(),
    'DEVMODE'=> true,
    'WEB_ROOT' => $strWebroot,
    'URL_API_LOCAL' => 'http://apiplaza.local/public/index.php/',
    'URL_CLIENT_LOCAL' => 'http://apiplaza.local/public/index.php/',
    'URL_API_LIVE' => '',
    'WEB_ROOT' => $strWebroot
);*/


//return array(
//    'TIME_NOW'=> time(),
//    'DEVMODE'=> true,
//    'WEB_ROOT' => $strWebroot,
//    'URL_API_LOCAL' => 'http://localhost/api_plaza/public/index.php/',
//    'URL_CLIENT_LOCAL' => '',
//    'URL_API_LIVE' => '',
//    'WEB_ROOT' => $strWebroot
//);