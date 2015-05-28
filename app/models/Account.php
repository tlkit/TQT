<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 6/24/14
 * Time: 9:39 AM
 */

class Account {

    public static function getSearchAccount($dataSearch = array(),$limit = 30,$page_no){
        if (empty($dataSearch)){
            return array();
        }
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/account/search";
        $paramSearch =  FunctionLib::buildParams("&", $dataSearch);
        $site .= "?page_no={$page_no}&limit={$limit}&{$paramSearch}";
        $curl = PlazaCurl::getInstance();
        $request = $curl->get($site);
        return $dataResponse = json_decode($request, true);
    }

    public static function insertAccount($data = array()){
        $request = self::callCreateApiAccount($data);
        return $request;
    }

    public static function callCreateApiAccount( $data = array()){
        if(empty($data))
            return array();
        $action = 'create';
        $site = FunctionLib::getUrlApi();
        $site .="api/admin/account/{$action}";
        $curl = PlazaCurl::getInstance();;
        $request = $curl->post($site,$data);
        return $dataResponse = json_decode($request,1);
    }

    public static function checkUsername( $username){
        $key = Session::get('key');
        $action = 'byname';
        $site = FunctionLib::getUrlApi();
        $site .="api/admin/account/{$action}/{$username}?key={$key}";
        $curl = PlazaCurl::getInstance();;
        $request = $curl->get($site);
        return $dataResponse = json_decode($request,1);
    }


    public static function updatePassword($id,$data){
        if(empty($data))
            return array();
        if($id > 0){
            $action = 'updatepassword';
            $site = FunctionLib::getUrlApi();
            $site .="api/admin/account/{$action}";
            $site .="/{$id}";
            $curl = PlazaCurl::getInstance();;
            $request = $curl->post($site, $data);
            $dataResponse = json_decode($request,1);
            return $dataResponse;
        }
        return array();
    }
    public static function updateStatus($id,$data){
        if(empty($data))
            return array();
        if($id > 0){
            $action = 'updatestatus';
            $site = FunctionLib::getUrlApi();
            $site .="api/admin/account/{$action}";
            $site .="/{$id}";
            $curl = PlazaCurl::getInstance();;
            $request = $curl->post($site, $data);
            $dataResponse = json_decode($request,1);
            return $dataResponse;
        }
        return array();
    }

    public static function updateAcount($id = 0,$dataSave = array()){
        $dataResponse = array();
        $dataSave = FunctionLib::urlEncode($dataSave);
        $site = FunctionLib::getUrlApi();
        $site .="api/admin/account/updateUser/{$id}";
        $curl = PlazaCurl::getInstance();;
        $request = $curl->post($site,$dataSave);
        $dataResponse = json_decode($request,1);
        return $dataResponse;
    }

    public static function getAcountById($id) {
       $dataResponse = $data = array();
       if($id > 0){
           $key = Session::get('key');
           $site = FunctionLib::getUrlApi();
           $site .= "api/admin/account/getAcountById/".$id;
           $curl = PlazaCurl::getInstance();;
           $response = $curl->get($site."?key={$key}");
           $dataResponse = json_decode($response,1);
           if (isset($dataResponse['data']) && !empty($dataResponse['data'])) {
               $data = $dataResponse['data'];
           }
       }

       return array('data' => $data, 'dataResponse' => $dataResponse);
    }

}
