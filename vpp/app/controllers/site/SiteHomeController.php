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

    public function offSite(){
        $url_src_icon = URL::to('/').'/images/cap-nhat-va-bao-tri-web.jpg';
        $today = time();
        $end_time = '31-08-2015';//d/m/Y
        $deline = strtotime($end_time.' 23:59:59');
        $date_off = $this->timeLifeWithToday($today,$deline);
        return View::make('site.offSite')->with('url_src_icon',$url_src_icon)->with('date_off',$date_off);
    }

    function timeLifeWithToday($startDay, $endDay) {
        $date_start = date('Y-m-d', $startDay);
        $date_end = date('Y-m-d', $endDay);
        $diff_start = abs(strtotime($date_end) - strtotime($date_start));
        //$khoang_cach_date = $this->getDateToDate($diff_start);
        return $diff_start;
    }

    function getDateToDate($diff) {
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        return $days;
    }
}
