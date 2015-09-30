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

//Route::get('/', function(){	return View::make('hello');});

//Trang chu
//Route::get('/',array('as' => 'site.index','uses' =>'SiteHomeController@index'));
Route::get('/',array('as' => 'site.index','uses' =>'SiteHomeController@offSite'));

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
    Route::get('user/create',array('as' => 'admin.user_create','uses' => 'UserController@createInfo'));
    Route::post('user/create',array('as' => 'admin.user_create','uses' => 'UserController@create'));
    Route::get('user/edit/{id}',array('as' => 'admin.user_edit','uses' => 'UserController@editInfo'))->where('id', '[0-9]+');
    Route::post('user/edit/{id}',array('as' => 'admin.user_edit','uses' => 'UserController@edit'))->where('id', '[0-9]+');
    Route::get('user/change/{id}',array('as' => 'admin.user_change','uses' => 'UserController@changePassInfo'));
    Route::post('user/change/{id}',array('as' => 'admin.user_change','uses' => 'UserController@changePass'));
    Route::post('user/remove/{id}',array('as' => 'admin.user_remove','uses' => 'UserController@remove'));
    /*thông tin quyền*/
    Route::get('permission/view',array('as' => 'admin.permission_view','uses' => 'PermissionController@view'));
    Route::get('permission/create',array('as' => 'admin.permission_create','uses' => 'PermissionController@createInfo'));
    Route::post('permission/create',array('as' => 'admin.permission_create','uses' => 'PermissionController@create'));
    Route::get('permission/edit/{id}',array('as' => 'admin.permission_edit','uses' => 'PermissionController@editInfo'))->where('id', '[0-9]+');
    Route::post('permission/edit/{id}',array('as' => 'admin.permission_edit','uses' => 'PermissionController@edit'))->where('id', '[0-9]+');
    /*thông tin nhóm quyền*/
    Route::get('groupUser/view',array('as' => 'admin.groupUser_view','uses' => 'GroupUserController@view'));
    Route::get('groupUser/create',array('as' => 'admin.groupUser_create','uses' => 'GroupUserController@createInfo'));
    Route::post('groupUser/create',array('as' => 'admin.groupUser_create','uses' => 'GroupUserController@create'));
    Route::get('groupUser/edit/{id}',array('as' => 'admin.groupUser_edit','uses' => 'GroupUserController@editInfo'))->where('id', '[0-9]+');
    Route::post('groupUser/edit/{id}',array('as' => 'admin.groupUser_edit','uses' => 'GroupUserController@edit'))->where('id', '[0-9]+');

    /*Quản lý danh mục SP*/
    Route::get('categories/view',array('as' => 'admin.categories_list','uses' => 'CategoriesController@view'));
    Route::get('categories/getCreate/{id?}', array('as' => 'admin.categories_edit','uses' => 'CategoriesController@createInfo'));
    Route::post('categories/getCreate/{id?}', array('as' => 'admin.categories_edit_post','uses' => 'CategoriesController@create'));
    Route::post('categories/deleteItem', array('as' => 'admin.deltete_categories_post','uses' => 'CategoriesController@deleteItem'));

    /*Quản lý Khách hàng*/
    Route::get('customers/view',array('as' => 'admin.customers_list','uses' => 'CustomersController@index'));
    Route::get('customers/getCreate/{id?}', array('as' => 'admin.customers_edit','uses' => 'CustomersController@getCreate'));
    Route::post('customers/getCreate/{id?}', array('as' => 'admin.customers_edit_post','uses' => 'CustomersController@postCreate'));

    /*Quản lý phiếu thu - chi*/
    Route::get('ticket/view',array('as' => 'admin.ticket_list','uses' => 'TicketController@index'));
    Route::get('ticket/ticket_export/{id?}', array('as' => 'admin.ticket_export','uses' => 'TicketController@ticket_export'));
    Route::get('ticket/getCreate/{id?}', array('as' => 'admin.ticket_edit','uses' => 'TicketController@getCreate'));
    Route::post('ticket/getCreate/{id?}', array('as' => 'admin.ticket_edit_post','uses' => 'TicketController@postCreate'));

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

    /*nhập kho*/
    Route::get('import/view',array('as' => 'admin.import_view','uses' => 'ImportController@view'));
    Route::get('import',array('as' => 'admin.import','uses' => 'ImportController@importInfo'));
    Route::get('import/restore/{id}',array('as' => 'admin.import_restore','uses' => 'ImportController@restore'));
    Route::post('import',array('as' => 'admin.import','uses' => 'ImportController@import'));
    Route::post('import/remove',array('as' => 'admin.import_remove','uses' => 'ImportController@remove'));
    Route::get('import/detail/{id}',array('as' => 'admin.import_detail','uses' => 'ImportController@detail'));
    Route::get('import/exportPdf/{id}',array('as' => 'admin.import_exportPdf','uses' => 'ImportController@exportPdf'));
    Route::post('import/addProduct', array('as' => 'admin.import_addProduct','uses' => 'ImportController@addProduct'));
    Route::post('import/removeProduct', array('as' => 'admin.import_removeProduct','uses' => 'ImportController@removeProduct'));
    Route::get('getProductByName', array('as' => 'admin.getProductByName','uses' => 'ProductController@getProductByName'));
    Route::get('getProviderInfo', array('as' => 'admin.getProviderInfo','uses' => 'ProvidersController@getProviderInfo'));
    /*Xuất kho*/
    Route::get('export/view',array('as' => 'admin.export_view','uses' => 'ExportController@view'));
    Route::get('export',array('as' => 'admin.export','uses' => 'ExportController@exportInfo'));
    Route::post('export',array('as' => 'admin.export','uses' => 'ExportController@export'));
    Route::post('export/addProduct', array('as' => 'admin.export_addProduct','uses' => 'ExportController@addProduct'));
    Route::post('export/removeProduct', array('as' => 'admin.export_removeProduct','uses' => 'ExportController@removeProduct'));
    Route::get('getCustomerInfo', array('as' => 'admin.getCustomerInfo','uses' => 'CustomersController@getCustomerInfo'));
    Route::get('export/detail/{id}',array('as' => 'admin.export_detail','uses' => 'ExportController@detail'));
    Route::get('export/exportPdf/{id}',array('as' => 'admin.export_exportPdf','uses' => 'ExportController@exportPdf'));
    Route::post('export/remove',array('as' => 'admin.export_remove','uses' => 'ExportController@remove'));
    Route::get('export/restore/{id}',array('as' => 'admin.export_restore','uses' => 'ExportController@restore'));
//    Route::get('getCustomersByName', array('as' => 'admin.getCustomersByName','uses' => 'CustomersController@getCustomersByName'));

    /*Quản lý nhân viên*/
    Route::get('personnel/view',array('as' => 'admin.personnel_list','uses' => 'PersonnelController@index'));
    Route::get('personnel/getCreate/{id?}', array('as' => 'admin.personnel_edit','uses' => 'PersonnelController@getCreate'));
    Route::post('personnel/getCreate/{id?}', array('as' => 'admin.personnel_edit_post','uses' => 'PersonnelController@postCreate'));
    Route::post('personnel/deleteItem', array('as' => 'admin.deltete_personnel_post','uses' => 'PersonnelController@deleteItem'));

    /*Quản lý Triết khấu % danh mục*/
    Route::get('discountCustomers/discountCategory/{customer_id?}',array('as' => 'admin.discountCategory','uses' => 'DiscountCustomersController@discountCategory'));
    Route::post('discountCustomers/updateCategory', array('as' => 'admin.updateCategoryDiscount','uses' => 'DiscountCustomersController@updateCategory'));

    /*Quản lý Triết khấu % sản phẩm*/
    Route::get('discountCustomers/discountProduct/{customer_id?}',array('as' => 'admin.discountProduct','uses' => 'DiscountCustomersController@discountProduct'));
    Route::post('discountCustomers/updateProduct', array('as' => 'admin.updateProductDiscount','uses' => 'DiscountCustomersController@updateProduct'));

    /*Thống kê*/
    Route::get('report/customer',array('as' => 'admin.report_customer','uses' => 'ReportController@reportCustomer'));
    Route::get('report/productHot',array('as' => 'admin.report_productHot','uses' => 'ReportController@reportProductHot'));
    Route::get('report/import',array('as' => 'admin.report_import','uses' => 'ReportController@reportImport'));
    Route::get('report/export',array('as' => 'admin.report_export','uses' => 'ReportController@reportExport'));
    Route::get('report/discount',array('as' => 'admin.report_discount','uses' => 'ReportController@reportDiscount'));
    Route::get('report/sale_list',array('as' => 'admin.report_sale_list','uses' => 'ReportController@reportSaleList'));
    Route::get('report/exportPdf_sale_list',array('as' => 'admin.report_sale_list_exportPdf','uses' => 'ReportController@exportPdf'));
    Route::get('report/store',array('as' => 'admin.report_store','uses' => 'ReportController@reportStore'));


});
