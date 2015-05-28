<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/14/14
 * Time: 5:13 PM
 */

class AdminDashboardController extends  AdminController {
    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageTitle = "Quản trị Admin Plaza";
    }

    public function index(){
       if(!Session::has('user')){
           return Redirect::route('admin.logout');
       }
        else{
            $this->layout->content = View::make('admin.AdminHome.index');
        }
       parent::debug();
    }

    //QuynhTM add
    public function page_error(){
       if(!Session::has('user')){
           return Redirect::route('admin.logout');
       }
        else{
            $this->layout->content = View::make('admin.AdminHome.error');
        }
       parent::debug();
    }

}