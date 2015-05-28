<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 7/2/14
 * Time: 1:49 PM
 * To change this template use File | Settings | File Templates.
 */
class Customer
{
    private static $client_id = '5e6e415783b7860e1d4b9ff908763686';

    public static function loginMC($email = '', $password = ''){
        $pass = md5($password . '-ShopTeam2010');
        $check = md5(self::$client_id . $email . $pass . '-ShopTeam2010');
        $link_api = Config::get('api.api_login_mc') ."&email={$email}&pass={$pass}&check={$check}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($link_api);
        $userData = json_decode($response);
        return $userData;
    }

    public static function getInforUserMC($user_id = 0, $password = ''){
        $link_api = Config::get('api.api_get_custome_mc') . "&user_id={$user_id}&pass={$password}";

        $curl = PlazaCurl::getInstance();
        $response = $curl->get($link_api);

        $userData = json_decode($response);
        return $userData;
    }

    public static function registerMC($email, $phone){
        //$link_api = "http://apimc.todo.vn/3.0/registerActive.json?client_id=". self::$client_id ."&action=register&email={$email}&phone={$phone}";
        $link_api = Config::get('api.api_get_register_active_mc') . "&action=register&email={$email}&phone={$phone}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($link_api);
        //return $response;
        $data = json_decode($response);
        return $data;
    }

    public static function forgetMC($email){
        $check = md5 ( self::$client_id  . $email . '-ShopTeam2010' );
        $link_api = Config::get('api.api_get_forgotpass_mc') . "&email={$email}&check={$check}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($link_api);
        $data = json_decode($response);
        return $data;
    }

    public static function verifyAccountMC($email, $password){
        //$link_api = "http://apimc.todo.vn/3.0/registerActive.json?client_id=". self::$client_id ."&action=active&email={$email}&pass={$password}";
        $link_api = Config::get('api.api_get_register_active_mc') . "&action=active&email={$email}&pass={$password}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($link_api);
        $data = json_decode($response);
        return $data;
    }

    public static function checkLogin($email = '', $password = ''){
        $check = array();
        if(Config::get('config.DEVMODE')){
            $site = Config::get('config.URL_API_LOCAL');
        }else{
            $site = Config::get('config.URL_API_LIVE');
        }
        $site .= "customerauthenticate/login";
        $curl = PlazaCurl::getInstance();
        $request = $curl->post($site,array('customer_alias'=>$email,'customer_password'=>$password));
        $check  = json_decode($request,true);
        return $check;
    }


    public static function createCustomer($email,$data = array()){
        $dataResponse = array();
        $site = FunctionLib::getUrlApi();
        $site .="api/site/customer/create/{$email}";
        $curl = PlazaCurl::getInstance();
        $request = $curl->post($site,$data);
        $dataResponse = json_decode($request,true);
        return $dataResponse;
    }
    
    public static function changePassCustomer($id=0, $data=array(), $key=''){
        $site = FunctionLib::getUrlApi();
        $site .="api/site/changePassCustomer/{$id}?key=$key";
        
        $curl = PlazaCurl::getInstance();
        $request = $curl->post($site, $data);
        $dataResponse = json_decode($request,1);
        return $dataResponse;      
    }
    
    public static function getCustomerByID($id=0, $key=''){
        $site = FunctionLib::getUrlApi();
        $site .="api/site/getCustomerByID/{$id}?key=$key";
        
        $curl = PlazaCurl::getInstance();
        $request = $curl->get($site);
        $dataResponse = json_decode($request,1);
        return $dataResponse;
    }

    public static function getCustomerByIdMC($id=0, $key=''){
        $site = FunctionLib::getUrlApi();
        $site .="api/site/getCustomerByIdMC/{$id}?key=$key";
        $curl = PlazaCurl::getInstance();
        $request = $curl->get($site);
        $dataResponse = json_decode($request,1);
        return $dataResponse;
    }
    public static function getCountOrderOfCustomer($key=''){
        $site = FunctionLib::getUrlApi();
        $site .= "api/site/getCountOrderOfCustomer?key=$key";
        $curl = PlazaCurl::getInstance();
        $request = $curl->get($site);
        $dataResponse = json_decode($request, 1);
        return $dataResponse;
    }
    public static function encode_password($password){
        return md5($password . '_mc_plaza!@#$%^');
    }

    public static function getCustomerByPhone($phone=null){
        $site = FunctionLib::getUrlApi();
        $site .="api/site/customer/getByCustomerPhone";

        $curl = PlazaCurl::getInstance();
        $request = $curl->post($site, array('phone'=>$phone));
        $dataResponse = json_decode($request,1);
        $data = array();
        if($dataResponse['intIsOK'] == 1 && !empty($dataResponse['data'])) {
            $data = $dataResponse['data'];
        }
        return $data;
    }

    public static function cennelOrdersCustomer($id,$key){
        if($id > 0){
            $action = 'cannelOrders';
            $site = FunctionLib::getUrlApi();
            $site .="api/site/{$action}";
            $site .="/{$id}?key=$key";

            $curl = PlazaCurl::getInstance();
            $request = $curl->get($site);
            $dataResponse = json_decode($request, 1);
            return $dataResponse;
        }
        return array();
    }

    public static function voteRating($id,$data,$content,$key=''){
        if($id > 0){
            $site = FunctionLib::getUrlApi();
            $site .="api/site/voteRating/{$id}?key={$key}";

            $curl = PlazaCurl::getInstance();
            $request = $curl->post($site, array('data'=>json_encode($data), 'content'=>$content));
            $dataResponse = json_decode($request, 1);
            return $dataResponse;
        }
        return array();
    }

    public static function getRating($id, $start = 0, $limit = 0){
        if($id > 0){
            $site = FunctionLib::getUrlApi();
            $site .="api/site/getRating/{$id}?start={$start}&limit={$limit}";
            $curl = PlazaCurl::getInstance();
            $request = $curl->get($site);
            $dataResponse = json_decode($request, 1);
            if(isset($dataResponse['code']) && $dataResponse['code'] == 200) {
                return $dataResponse['data'];
            }
        }
        return array();
    }

    public static function getRatingDetail($id, $type){
        if($id > 0){
            $site = FunctionLib::getUrlApi();
            $site .="api/site/getRatingDetail/{$id}/{$type}";
            $curl = PlazaCurl::getInstance();
            $request = $curl->get($site);
            $dataResponse = json_decode($request, 1);
            if(isset($dataResponse['code']) && $dataResponse['code'] == 200) {
                return $dataResponse['data'];
            }
        }
        return array();
    }

    public static function getRatingCustomerId($id, $product_id){
        if($id > 0){
            $site = FunctionLib::getUrlApi();
            $site .="api/site/getRatingCustomerId/{$id}/{$product_id}";
            $curl = PlazaCurl::getInstance();
            $request = $curl->get($site);
            $dataResponse = json_decode($request, 1);
            if(isset($dataResponse['code']) && $dataResponse['code'] == 200) {
                return $dataResponse['data'];
            }
        }
        return array();
    }
}


