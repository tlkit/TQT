<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ThinhLk
 * Date: 07/01/14
 * Time: 10:29 AM
 * To change this template use File | Settings | File Templates.
 */

class BipBip
{

    private $httpUrlSend = 'http://api.bipbip.vn/api/send';
    private $httpUrlReport = 'http://api.bipbip.vn/api/report';
    private $httpUrlSchedule = 'http://api.bipbip.vn/api/schedule';
    private $httpUsername = 'MuaChung';
    private $httpPassword = 'RMvyUqln';
    private $httpBrandname = 'MuaChung';
    private $message_id = '';

    static $COUPONSMS = "%1 - %2.MSP: %3 HSD: %4";
    static $COUPONSMS2 = "%1.MSP: %2";

//    static $PENDING = "PENDING";
//    static $INVALID_NUMBER = "INVALID_NUMBER";
//    static $INVALID_MESSAGE_ID = "INVALID_MESSAGE_ID";
//    static $ERROR_NO_MESSAGE_CONTENT = "ERROR_NO_MESSAGE_CONTENT";
//    static $ERROR_NO_BRANDNAME = "ERROR_NO_BRANDNAME";
//    static $ERROR_AUTHEN = "ERROR_AUTHEN";
//    static $INVALID_BRANDNAME = "INVALID_BRANDNAME";

    /**
     * Gui SMS den mot so dien thoai
     * @param String $receiver
     * @param String $message
     */
    public function send($receiver, $message)
    {
        $arrRequest = array(
            "username" => $this->httpUsername,
            "password" => $this->httpPassword,
            "message" => $message,
            "brandname" => $this->httpBrandname,
            "recipients" => array(array("message_id" => $this->message_id, "number" => $receiver))
        );
        $dataSend = json_encode($arrRequest);
        $result = $this->callRequestApiSms($this->httpUrlSend, $dataSend);
        return $result;
    }
    public function reportSMS($aryMesId){
        $arrRespone = array(
            "username" => $this->httpUsername,
            "password" => $this->httpPassword,
            "message_ids" => $aryMesId
        );
        $dataSend = json_encode($arrRespone);
        $result = $this->callRequestApiSms($this->httpUrlReport, $dataSend);
        return $result;
    }

    public function callRequestApiSms($url, $data)
    {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_POST, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }
}

