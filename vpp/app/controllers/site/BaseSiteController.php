<?php

/**
 * Created by PhpStorm.
 * User: tuanna
 * Date: 17/04/2016
 * Time: 3:29 CH
 */
class BaseSiteController extends BaseController
{
    protected $layout = 'site.SiteLayouts.index';

    public function __construct()
    {

    }

    public function home(){
        $this->layout->content = View::make('site.SiteLayouts.home');
    }

    public function group(){
        $this->layout->content = View::make('site.SiteLayouts.group');
    }

}