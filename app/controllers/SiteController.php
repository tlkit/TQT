<?php

class SiteController extends \BaseController {

    public function __construct() {

    }
    public function index()
    {
        return Redirect::route('admin.dashboard');
    }

}
