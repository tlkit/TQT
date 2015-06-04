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
    /*login logout*/
    Route::get('login/{url?}', array('as' => 'admin.login','uses' => 'LoginController@loginInfo'));
    Route::post('login/{url?}', array('as' => 'admin.login','uses' => 'LoginController@login'));
    Route::get('logout', array('as' => 'admin.logout','uses' => 'LoginController@logout'));
    /*màn hình chính*/
    Route::get('dashboard', array('as' => 'admin.dashboard','uses' => 'DashBoardController@dashboard'));
    /*thông tin tài khoản*/
    Route::get('user/view',array('as' => 'admin.user_view','uses' => 'UserController@view'));
    Route::get('permission/view',array('as' => 'admin.permission_view','uses' => 'PermissionController@view'));
    Route::get('groupUser/view',array('as' => 'admin.groupUser_view','uses' => 'GroupUserController@view'));
    Route::get('user/create',array('as' => 'admin.user_create','uses' => 'UserController@createInfo'));
    Route::post('user/create',array('as' => 'admin.user_create','uses' => 'UserController@create'));
    Route::get('user/edit/{id}',array('as' => 'admin.user_edit','uses' => 'UserController@editInfo'))->where('id', '[0-9]+');
    Route::post('user/edit/{id}',array('as' => 'admin.user_edit','uses' => 'UserController@edit'))->where('id', '[0-9]+');
    Route::get('user/change/{id}',array('as' => 'admin.user_change','uses' => 'UserController@changePassInfo'));
    Route::post('user/change/{id}',array('as' => 'admin.user_change','uses' => 'UserController@changePass'));
    /*thông tin quyền*/
    Route::get('permission/create',array('as' => 'admin.permission_create','uses' => 'PermissionController@createInfo'));
    Route::post('permission/create',array('as' => 'admin.permission_create','uses' => 'PermissionController@create'));
    Route::get('permission/edit/{id}',array('as' => 'admin.permission_edit','uses' => 'PermissionController@editInfo'))->where('id', '[0-9]+');
    Route::post('permission/edit/{id}',array('as' => 'admin.permission_edit','uses' => 'PermissionController@edit'))->where('id', '[0-9]+');
    /*thông tin nhóm quyền*/
    Route::get('groupUser/create',array('as' => 'admin.groupUser_create','uses' => 'GroupUserController@createInfo'));
    Route::post('groupUser/create',array('as' => 'admin.groupUser_create','uses' => 'GroupUserController@create'));
    Route::get('groupUser/edit/{id}',array('as' => 'admin.groupUser_edit','uses' => 'GroupUserController@editInfo'))->where('id', '[0-9]+');
    Route::post('groupUser/edit/{id}',array('as' => 'admin.groupUser_edit','uses' => 'GroupUserController@edit'))->where('id', '[0-9]+');

    /*Quản lý danh mục SP*/
    Route::get('categories/view',array('as' => 'admin.categories_list','uses' => 'CategoriesController@view'));
    Route::get('categories/getCreate/{id?}', array('as' => 'admin.categories_edit','uses' => 'CategoriesController@createInfo'));
    Route::post('categories/getCreate/{id?}', array('as' => 'admin.categories_edit_post','uses' => 'CategoriesController@create'));

    /*Quản lý Khách hàng*/
    Route::get('customers/view',array('as' => 'admin.customers_list','uses' => 'CustomersController@index'));
    Route::get('customers/getCreate/{id?}', array('as' => 'admin.customers_edit','uses' => 'CustomersController@getCreate'));
    Route::post('customers/getCreate/{id?}', array('as' => 'admin.customers_edit_post','uses' => 'CustomersController@postCreate'));

    /*Quản lý nhà cung cấp*/
    Route::get('providers/view',array('as' => 'admin.providers_list','uses' => 'ProvidersController@index'));
    Route::get('providers/getCreate/{id?}', array('as' => 'admin.providers_edit','uses' => 'ProvidersController@getCreate'));
    Route::post('providers/getCreate/{id?}', array('as' => 'admin.providers_edit_post','uses' => 'ProvidersController@postCreate'));
    Route::post('providers/deleteItem', array('as' => 'admin.deltete_post','uses' => 'ProvidersController@deleteItem'));

    /*Quản lý Sản Phẩm*/
    Route::get('product/view',array('as' => 'admin.product_list','uses' => 'ProductController@index'));
    Route::get('product/getCreate/{id?}', array('as' => 'admin.product_edit','uses' => 'ProductController@getCreate'));
    Route::post('product/getCreate/{id?}', array('as' => 'admin.product_edit_post','uses' => 'ProductController@postCreate'));
    Route::post('product/deleteItem', array('as' => 'admin.deltete_product_post','uses' => 'ProductController@deleteItem'));

    /*Xuất nhập kho*/
    Route::get('import',array('as' => 'admin.import','uses' => 'ImportController@import'));
    Route::get('getProductByName', array('as' => 'admin.getProductByName','uses' => 'ProductController@getProductByName'));

    /*Quản lý nhân viên*/
    Route::get('personnel/view',array('as' => 'admin.personnel_list','uses' => 'PersonnelController@index'));
    Route::get('personnel/getCreate/{id?}', array('as' => 'admin.personnel_edit','uses' => 'PersonnelController@getCreate'));
    Route::post('personnel/getCreate/{id?}', array('as' => 'admin.personnel_edit_post','uses' => 'PersonnelController@postCreate'));
});
