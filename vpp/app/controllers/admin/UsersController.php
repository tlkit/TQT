<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 29/05/2015
 * Time: 6:33 SA
 */

class UsersController extends BaseController{

    protected $layout = "admin.AdminLayouts.login";
    public function __construct()
    {


    }

    public function login($url = '')
    {
        $this->layout->content = View::make('admin.UsersLayouts.login');
    }

}