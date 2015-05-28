<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/1/2014
 * Time: 9:19 AM
 */

class HandlerException {

    public function __construct() {

    }
    public static function handlerException($exception) {
        if($_SERVER['HTTP_HOST'] == 'plaza.muachung.vn/') {
            Mail::send('emails.error.error', array('exception'=> $exception), function($message){
                $message->to('mc_plaza_error_tech@todo.vn', 'MCPlaza');
                $message->subject('Handler Exception ::'.time());
            });
        }
    }
}