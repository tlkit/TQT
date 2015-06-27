<?php

class SiteHomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

    public function __construct() {

    }

    public function index() {
        die('Đây là trang chủ');
    }

    public function offSite()
    {
        $url_src_icon = URL::to('/').'/images/cap-nhat-va-bao-tri-web.jpg';
        return View::make('site.offSite')->with('url_src_icon',$url_src_icon);
    }
}
