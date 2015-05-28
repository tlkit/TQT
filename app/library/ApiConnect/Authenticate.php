<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/16/14
 * Time: 2:09 PM
 */
 class Authenticate{


     static function isLogin()
     {
         $result = false;
         if (Session::has('user')) {
             $result = true;
         }
         return $result;
     }
 }