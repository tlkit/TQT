<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});
Route::group(array('prefix' => 'admin', 'before' => ''), function()
{
    Route::get('login/{url?}', array('as' => 'admin.loginInfo','uses' => 'LoginController@loginInfo'));
    Route::post('login/{url?}', array('as' => 'admin.login','uses' => 'LoginController@login'));
    Route::get('logout', array('as' => 'admin.logout','uses' => 'LoginController@logout'));
    Route::get('dashboard', array('as' => 'admin.dashboard','uses' => 'DashBoardController@dashboard'));
    Route::get('user/view',array('as' => 'admin.user_view','uses' => 'UserController@view'));
    Route::get('permission/view',array('as' => 'admin.permission_view','uses' => 'PermissionController@view'));
    Route::get('user/create',array('as' => 'admin.user_create','uses' => 'UserController@createInfo'));
});
