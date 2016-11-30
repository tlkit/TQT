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
$isOn = Request::get('on_web','');
if($isOn == 'sonnt_vpp'){
    Session::put('on_web', '999999');
}
Route::get('offline',     array('as' => 'offline',       'uses' => 'OfflineController@index'));

Route::group(array('prefix' => '', 'before' => ''), function()
{
    Route::get('/',array('as' => 'site.home','uses' =>'BaseSiteController@home'));
    Route::get('g{id}/{name}.html',array('as' => 'site.group','uses' =>'BaseSiteController@group'))->where('id', '[0-9]+');
    Route::get('g{gid}/c{id}/{name}.html',array('as' => 'site.cate','uses' =>'BaseSiteController@cate'))->where('id', '[0-9]+')->where('gid', '[0-9]+');
    Route::get('p{id}/{name}.html',array('as' => 'site.product','uses' =>'BaseSiteController@product'))->where('id', '[0-9]+');
    Route::get('s{id}/{name}.html',array('as' => 'site.page','uses' =>'BaseSiteController@page'))->where('id', '[0-9]+');
    Route::get('tim-kiem.html',array('as' => 'site.search','uses' =>'BaseSiteController@search'))->where('id', '[0-9]+');


    Route::get('dang-ky.html',array('as' => 'site.register','uses' =>'BaseSiteController@register'));
    Route::post('dang-ky.html',array('as' => 'site.register','uses' =>'BaseSiteController@submitRegister'));
    Route::get('dang-ky-thanh-cong.html',array('as' => 'site.register_success','uses' =>'BaseSiteController@registerSuccess'));
    Route::get('dang-nhap.html',array('as' => 'site.login','uses' =>'BaseSiteController@loginInfo'));
    Route::post('dang-nhap.html',array('as' => 'site.login','uses' =>'BaseSiteController@login'));
    Route::get('logout',array('as' => 'site.logout','uses' =>'BaseSiteController@logout'));


    Route::post('cart/add',array('as' => 'cart.add','uses' =>'AjaxSiteController@addCart'));
    Route::post('cart/remove',array('as' => 'cart.remove','uses' =>'AjaxSiteController@removeProduct'));
    Route::post('cart/update',array('as' => 'cart.update','uses' =>'AjaxSiteController@updateNumber'));
    Route::get('gio-hang.html',array('as' => 'cart.view_cart','uses' =>'BaseSiteController@viewCart'));
    Route::get('thanh-toan.html',array('as' => 'cart.checkout_cart','uses' =>'BaseSiteController@checkoutCart'));
    Route::post('thanh-toan.html',array('as' => 'cart.checkout_cart','uses' =>'BaseSiteController@submitCheckoutCart'));
    Route::get('thanh-toan-thanh-cong.html',array('as' => 'cart.checkout_cart_success','uses' =>'BaseSiteController@successOrder'));
    Route::get('thong-tin-tai-khoan.html',array('as' => 'site.changeInfo','uses' =>'BaseSiteController@changeInfo'));
    Route::post('thong-tin-tai-khoan.html',array('as' => 'site.changeInfo','uses' =>'BaseSiteController@submitChangeInfo'));
    Route::get('thay-doi-thong-tin-thanh-cong.html',array('as' => 'site.changeInfo_success','uses' =>'BaseSiteController@changeInfoSuccess'));

    Route::get('tai-khoan.html',array('as' => 'site.account','uses' =>'BaseSiteController@account'));
    Route::get('lich-su-don-hang.html',array('as' => 'site.order_history','uses' =>'BaseSiteController@orderHistory'));
    Route::get('o{id}/chi-tiet-don-hang.html',array('as' => 'site.order_detail','uses' =>'BaseSiteController@orderDetail'));
    Route::get('lich-su-xuat-kho.html',array('as' => 'site.export_history','uses' =>'BaseSiteController@exportHistory'));
    Route::get('e{id}/chi-tiet-xuat-kho.html',array('as' => 'site.export_detail','uses' =>'BaseSiteController@exportDetail'));
    Route::get('thay-doi-mat-khau.html',array('as' => 'site.changePass','uses' =>'BaseSiteController@changePass'));
    Route::post('thay-doi-mat-khau.html',array('as' => 'site.changePass','uses' =>'BaseSiteController@submitChangePass'));
    Route::get('thay-doi-mat-khau-thanh-cong.html',array('as' => 'site.changePass_success','uses' =>'BaseSiteController@changePassSuccess'));


});

Route::group(array('prefix' => 'admin', 'before' => ''), function()
{
    /*login logout*/
    Route::get('login/{url?}', array('as' => 'admin.login','uses' => 'LoginController@loginInfo'));
    Route::post('login/{url?}', array('as' => 'admin.login','uses' => 'LoginController@login'));
    Route::get('logout', array('as' => 'admin.logout','uses' => 'LoginController@logout'));
    /*màn hình chính*/
    Route::get('dashboard', array('as' => 'admin.dashboard','uses' => 'DashBoardController@dashboard'));
    Route::get('convert', array('as' => 'admin.convert','uses' => 'BaseAdminController@convert'));
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
    Route::get('ticket/groupMoney',array('as' => 'admin.groupMoney_list','uses' => 'TicketController@groupMoney'));
    Route::get('ticket/ticket_export/{id?}', array('as' => 'admin.ticket_export','uses' => 'TicketController@ticket_export'));
    Route::get('ticket/getCreate/{id?}/{type?}', array('as' => 'admin.ticket_edit','uses' => 'TicketController@getCreate'));
    Route::post('ticket/getCreate/{id?}/{type?}', array('as' => 'admin.ticket_edit_post','uses' => 'TicketController@postCreate'));

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
    Route::post('import/update_payment',array('as' => 'admin.import_update_payment','uses' => 'ImportController@updatePayment'));

    /*nhập kho ao*/
    Route::get('import_fake/view',array('as' => 'admin.import_fake_view','uses' => 'ImportFakeController@view'));
    Route::get('import_fake',array('as' => 'admin.import_fake','uses' => 'ImportFakeController@importInfo'));
    Route::get('import_fake/restore/{id}',array('as' => 'admin.import_fake_restore','uses' => 'ImportFakeController@restore'));
    Route::post('import_fake',array('as' => 'admin.import_fake','uses' => 'ImportFakeController@import'));
    Route::post('import_fake/remove',array('as' => 'admin.import_fake_remove','uses' => 'ImportFakeController@remove'));
    Route::get('import_fake/detail/{id}',array('as' => 'admin.import_fake_detail','uses' => 'ImportFakeController@detail'));
    Route::get('import_fake/exportPdf/{id}',array('as' => 'admin.import_fake_exportPdf','uses' => 'ImportFakeController@exportPdf'));
    Route::post('import_fake/addProduct', array('as' => 'admin.import_fake_addProduct','uses' => 'ImportFakeController@addProduct'));
    Route::post('import_fake/removeProduct', array('as' => 'admin.import_fake_removeProduct','uses' => 'ImportFakeController@removeProduct'));
    Route::post('import_fake/update_payment',array('as' => 'admin.import_fake_update_payment','uses' => 'ImportFakeController@updatePayment'));

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

    /* Bảng kê*/
    Route::get('sale_list/view',array('as' => 'admin.sale_list_view','uses' => 'SaleListController@view'));
    Route::get('sale_list/create',array('as' => 'admin.sale_list_create','uses' => 'SaleListController@createInfo'));
    Route::post('sale_list/create',array('as' => 'admin.sale_list_create','uses' => 'SaleListController@create'));
    Route::post('sale_list/update_payment',array('as' => 'admin.sale_list_update_payment','uses' => 'SaleListController@updatePayment'));
    Route::get('export/export_sale',array('as' => 'admin.export_sale_list','uses' => 'ExportController@getExportForSale'));
    Route::get('sale_list/detail/{id}',array('as' => 'admin.sale_list_detail','uses' => 'SaleListController@detail'));
    Route::get('sale_list/pdf/{id}',array('as' => 'admin.sale_list_pdf','uses' => 'SaleListController@exportPdf'));
    Route::get('exportExcelReportSaleList/{id}',array('as' => 'admin.exportExcelReportSaleList','uses' => 'SaleListController@exportExcelReportSaleList'));


    /*Xuất kho ảo*/
    Route::get('export_fake/view',array('as' => 'admin.export_fake_view','uses' => 'ExportFakeController@view'));
    Route::get('export_fake',array('as' => 'admin.export_fake','uses' => 'ExportFakeController@exportInfo'));
    Route::post('export_fake',array('as' => 'admin.export_fake','uses' => 'ExportFakeController@export'));
    Route::post('export_fake/addProduct', array('as' => 'admin.export_fake_addProduct','uses' => 'ExportFakeController@addProduct'));
    Route::post('export_fake/removeProduct', array('as' => 'admin.export_fake_removeProduct','uses' => 'ExportFakeController@removeProduct'));
    Route::get('export_fake/detail/{id}',array('as' => 'admin.export_fake_detail','uses' => 'ExportFakeController@detail'));
    Route::get('export_fake/exportPdf/{id}',array('as' => 'admin.export_fake_exportPdf','uses' => 'ExportFakeController@exportPdf'));
    Route::post('export_fake/remove',array('as' => 'admin.export_fake_remove','uses' => 'ExportFakeController@remove'));
    Route::get('export_fake/restore/{id}',array('as' => 'admin.export_fake_restore','uses' => 'ExportFakeController@restore'));

    /* Bảng kê ảo*/
    Route::get('sale_list_fake/view',array('as' => 'admin.sale_list_fake_view','uses' => 'SaleListFakeController@view'));
    Route::get('sale_list_fake/create',array('as' => 'admin.sale_list_fake_create','uses' => 'SaleListFakeController@createInfo'));
    Route::post('sale_list_fake/create',array('as' => 'admin.sale_list_fake_create','uses' => 'SaleListFakeController@create'));
    Route::post('sale_list_fake/update_payment',array('as' => 'admin.sale_list_fake_update_payment','uses' => 'SaleListFakeController@updatePayment'));
    Route::get('export_fake/export_sale',array('as' => 'admin.export_sale_list_fake','uses' => 'ExportFakeController@getExportForSale'));
    Route::get('sale_list_fake/detail/{id}',array('as' => 'admin.sale_list_fake_detail','uses' => 'SaleListFakeController@detail'));
    Route::get('sale_list_fake/pdf/{id}',array('as' => 'admin.sale_list_fake_pdf','uses' => 'SaleListFakeController@exportPdf'));
    Route::get('exportExcelReportSaleListFake/{id}',array('as' => 'admin.exportExcelReportSaleListFake','uses' => 'SaleListFakeController@exportExcelReportSaleList'));

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
    Route::get('report/import_fake',array('as' => 'admin.report_import_fake','uses' => 'ReportController@reportImportFake'));
    Route::get('report/export_fake',array('as' => 'admin.report_export_fake','uses' => 'ReportController@reportExportFake'));
    Route::get('report/discount',array('as' => 'admin.report_discount','uses' => 'ReportController@reportDiscount'));
    Route::get('report/discount_provider',array('as' => 'admin.report_discount_provider','uses' => 'ReportController@reportDiscountProvider'));
//    Route::get('report/sale_list',array('as' => 'admin.report_sale_list','uses' => 'ReportController@reportSaleList'));
    //Route::get('report/sale_list_not_vat',array('as' => 'admin.report_not_vat','uses' => 'ReportController@sale_list_not_vat'));
    Route::get('report/exportPdf_sale_list',array('as' => 'admin.report_sale_list_exportPdf','uses' => 'ReportController@exportPdf'));
    Route::get('report/store',array('as' => 'admin.report_store','uses' => 'ReportController@reportStore'));
    Route::get('report/store_fake',array('as' => 'admin.report_store_fake','uses' => 'ReportController@reportStoreFake'));

    /*Báo giá khách hàng*/
    Route::get('customers/bang-gia.html',array('as' => 'admin.cr_price_list','uses' => 'ReportController@priceListInfo'));
    Route::post('customers/price_list',array('as' => 'admin.price_list','uses' => 'ReportController@priceList'));
    Route::get('customers/bang-gia-{id}.pdf',array('as' => 'admin.price_list_pdf','uses' => 'ReportController@priceListPdf'));
    Route::post('customers/addProduct', array('as' => 'admin.customers_addProduct','uses' => 'ReportController@addProduct'));
    Route::post('customers/removeSessionPriceList', array('as' => 'admin.customers_removeSessionPriceList','uses' => 'ReportController@removeSessionPriceList'));
    Route::post('customers/removeProduct', array('as' => 'admin.customers_removeProduct','uses' => 'ReportController@removeProduct'));

    /*Công nợ*/
    Route::get('lia/customer',array('as' => 'admin.lia_customer','uses' => 'LiabilitiesController@liaCustomer'));
    Route::get('lia/provider',array('as' => 'admin.lia_provider','uses' => 'LiabilitiesController@liaProvider'));

    /*Quản trị site*/
    Route::get('manage_site/banner/view',array('as' => 'admin.mngSite_banner_view','uses' => 'SiteManageController@viewBanner'));
    Route::get('manage_site/banner/add/{id?}',array('as' => 'admin.mngSite_banner_add','uses' => 'SiteManageController@getAddBanner'))->where('id', '[0-9]+');
    Route::post('manage_site/banner/add/{id?}',array('as' => 'admin.mngSite_banner_add','uses' => 'SiteManageController@postAddBanner'))->where('id', '[0-9]+');

    Route::get('manage_site/group_category/view',array('as' => 'admin.mngSite_group_category_view','uses' => 'SiteManageController@viewGroupCategory'));
    Route::get('manage_site/group_category/add/{id?}',array('as' => 'admin.mngSite_group_category_add','uses' => 'SiteManageController@getAddGroupCategory'))->where('id', '[0-9]+');
    Route::post('manage_site/group_category/add/{id?}',array('as' => 'admin.mngSite_group_category_add','uses' => 'SiteManageController@postAddGroupCategory'))->where('id', '[0-9]+');

    Route::get('manage_site/carts/view',array('as' => 'admin.mngSite_carts_view','uses' => 'CartsController@view'));
    Route::post('manage_site/carts/export',array('as' => 'admin.mngSite_carts_export','uses' => 'CartsController@ajaxExport'));
    Route::get('manage_site/carts/export',array('as' => 'admin.mngSite_carts_export','uses' => 'CartsController@export'));
    Route::get('manage_site/carts/map',array('as' => 'admin.mngSite_carts_map','uses' => 'CartsController@mapDirection'));
    Route::get('manage_site/carts/detail/{id?}',array('as' => 'admin.mngSite_carts_detail','uses' => 'CartsController@detail'));
    Route::post('manage_site/carts/confirm',array('as' => 'admin.mngSite_carts_confirm','uses' => 'CartsController@confirm'));
    Route::post('manage_site/carts/deleteItem',array('as' => 'admin.mngSite_carts_deleteItem','uses' => 'CartsController@deleteItem'));

    Route::get('manage_site/page/view',array('as' => 'admin.mngSite_page_view','uses' => 'SiteManageController@viewpage'));
    Route::get('manage_site/page/add/{id?}',array('as' => 'admin.mngSite_page_add','uses' => 'SiteManageController@getAddPage'))->where('id', '[0-9]+');
    Route::post('manage_site/page/add/{id?}',array('as' => 'admin.mngSite_page_add','uses' => 'SiteManageController@postAddPage'))->where('id', '[0-9]+');
    Route::post('export/assignCoD',array('as' => 'admin.export_assignCoD','uses' => 'ExportController@assignCoD'));

    Route::get('manage_site/getProductNew',array('as' => 'admin.mngSite_getProductNew','uses' => 'SiteManageController@getProductNew'));
    Route::get('getProductNewById', array('as' => 'admin.getProductNewById','uses' => 'SiteManageController@getProductNewById'));
    Route::get('getProductNewByObject', array('as' => 'admin.getProductNewByObject','uses' => 'SiteManageController@getProductNewByObject'));
    Route::post('addProductNew', array('as' => 'admin.addProductNew','uses' => 'SiteManageController@addProductNew'));

    Route::get('manage_site/getProductHot',array('as' => 'admin.mngSite_getProductHot','uses' => 'SiteManageController@getProductHot'));
    Route::get('getProductHotById', array('as' => 'admin.getProductHotById','uses' => 'SiteManageController@getProductHotById'));
    Route::get('getProductHotByObject', array('as' => 'admin.getProductHotByObject','uses' => 'SiteManageController@getProductHotByObject'));
    Route::post('addProductHot', array('as' => 'admin.addProductHot','uses' => 'SiteManageController@addProductHot'));

    Route::get('manage_site/tag/view',array('as' => 'admin.mngSite_tag_view','uses' => 'SiteManageController@viewTag'));
    Route::get('manage_site/tag/add/{id?}',array('as' => 'admin.mngSite_tag_add','uses' => 'SiteManageController@getAddTag'))->where('id', '[0-9]+');
    Route::post('manage_site/tag/add/{id?}',array('as' => 'admin.mngSite_tag_add','uses' => 'SiteManageController@postAddTag'))->where('id', '[0-9]+');

});
