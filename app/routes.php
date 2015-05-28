
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
// used for dev by ThinhLK
$isDev = Request::get('is_dev','');
switch ($isDev) {
    case 'tech_plaza':
        //Session::put('is_dev_of_tech', '696969');
        Config::set('compile.debug',true);
        break;
    case 'res_on':
        Session::put('responsive_dev', true);
        Config::set('compile.res_on',true);
        break;
    case 'off_dev':
        Session::forget('is_dev_of_tech');
        Session::forget('responsive_dev');
        Config::set('compile.debug',false);
        Config::set('compile.res_on',false);
        break;
}

/*if($isDev == 'tech_plaza'){
    Session::put('is_dev_of_tech', '696969');
    Config::set('compile.debug',true);
}*/

if(Session::has('is_dev_of_tech')){
    Config::set('compile.debug',true);
}
if(Session::has('responsive_dev')){
    Config::set('compile.res_on',true);
}

//add by minhnv
if(Request::exists('is_demo')){
    $isDemo = (int)Request::get('is_demo', 0);
    if($isDemo == 1){
        Session::put('is_shop_demo', 1);
        Config::set('compile.demo', 1);
    }
    else {
        if(Session::has('is_shop_demo')) {
            Session::forget('is_shop_demo');
        }
        Config::set('compile.demo', 0);
    }
}
if(Session::has('is_shop_demo')) {
    Config::set('compile.demo', 1);
}
//end add by minhnv

///// end for dev
Route::get('/authtest', array('before' => 'auth.basic', function()
{
    return View::make('hello');
}));
Route::get('404',     array('as' => '404',       'uses' => 'NotFoundController@index'));

//Trang chu
Route::get('/',array('as' => 'site.index','uses' =>'SiteController@index'));

Route::group(array('prefix' => 'admin', 'before' => ''), function()
{
    Route::any('login/{url?}', array('as' => 'admin.login','uses' => 'AdminLoginController@login'));
    Route::any('logout', array('as' => 'admin.logout','uses' => 'AdminLoginController@logout'));
});


Route::group(array('prefix' => 'admin', 'before' => ''), function()
{
    //Man hinh dashboard
    Route::any('', array('as' => 'admin.dashboard','uses' => 'AdminDashboardController@index'));
    Route::any('adminDashboard', array('as' => 'admin.dashboard','uses' => 'AdminDashboardController@index'));
    Route::any('error', array('as' => 'admin.page_error','uses' => 'AdminDashboardController@page_error'));
    Route::get('adminDashboard/test', array('as' => 'admin.test','uses' => 'AdminDashboardController@test'));

    //QL website.
    Route::get('website', array('as' => 'website.index','uses' => 'AdminWebsiteController@index'));
    Route::get('website/getCreate/{id?}', array('as' => 'website.getCreate','uses' => 'AdminWebsiteController@getCreate'));
    Route::post('website/getCreate/{id?}', array('as' => 'website.postCreate','uses' => 'AdminWebsiteController@postCreate'));
    Route::post('website/del', array('as' => 'website.postCreate','uses' => 'AdminWebsiteController@del'));
    Route::post('website/status', array('as' => 'website.status','uses' => 'AdminWebsiteController@updateStatus'));

    //QL bai viet
    Route::get('posts', array('as' => 'posts.index','uses' => 'AdminPostsController@index'));
    Route::get('posts/getCreate/{id?}', array('as' => 'posts.getCreate','uses' => 'AdminPostsController@getCreate'));
    Route::post('posts/getCreate/{id?}', array('as' => 'posts.postCreate','uses' => 'AdminPostsController@postCreate'));
    Route::post('posts/del', array('as' => 'posts.postCreate','uses' => 'AdminPostsController@del'));
    Route::post('posts/status', array('as' => 'posts.status','uses' => 'AdminPostsController@updateStatus'));
    Route::get('posts/approve/{id?}', array('as' => 'posts.approve','uses' => 'AdminPostsController@approve'));
    Route::post('posts/uploadImageOther',array('as'=>'posts.uploadImageOther','uses'=>'AdminPostsController@uploadImageOther'));//upload ?nh other
    Route::post('posts/uploadMultipleImageOther',array('as'=>'posts.uploadMultipleImageOther','uses'=>'AdminPostsController@uploadMultipleImageOther'));//upload nhi?u ?nh cùng lúc

    //QL Log view cronjob
    Route::get('logCronjob', array('as' => 'logCronjob.index','uses' => 'AdminLogCronjobController@index'));
    Route::get('logCronjob/viewLog', array('as' => 'ajaxViewLog.index','uses' => 'AdminLogCronjobController@ajaxViewLog'));

    //QL danh muc category
    Route::any('adminCategory',array('as'=>'category.index','uses'=>'AdminCategoryController@index'));
    Route::get('adminCategory/getCreate/{id?}', array('as' => 'category.getCreate','uses' => 'AdminCategoryController@getCreate'));
    Route::post('adminCategory/getCreate/{id?}', array('as' => 'category.postCreate','uses' => 'AdminCategoryController@postCreate'));
    Route::post('adminCategory/del', array('as' => 'category.del','uses' => 'AdminCategoryController@del'));
    Route::post('adminCategory/status', array('as' => 'category.status','uses' => 'AdminCategoryController@updateStatus'));

    //QL sach
    Route::any('adminBook',array('as'=>'book.index','uses'=>'AdminBookController@index'));
    Route::get('adminBook/getCreate/{id?}', array('as' => 'book.getCreate','uses' => 'AdminBookController@getCreate'));
    Route::post('adminBook/getCreate/{id?}', array('as' => 'book.postCreate','uses' => 'AdminBookController@postCreate'));
    Route::post('adminBook/del', array('as' => 'book.del','uses' => 'AdminBookController@deleteItem'));
    Route::post('adminBook/status', array('as' => 'book.status','uses' => 'AdminBookController@updateStatus'));

    //QL Uploadfile
    Route::get('uploadfile/getCreate/{id?}', array('as' => 'upload.getCreate','uses' => 'AdminUploadController@getCreate'));
    Route::post('uploadfile/getCreate/{id?}', array('as' => 'upload.postCreate','uses' => 'AdminUploadController@postCreate'));
    Route::any('uploadfile/uploadFileOk', array('as' => 'upload.uploadFileOk','uses' => 'AdminUploadController@uploadFileOk'));

    //QL Project
    Route::any('adminProject',array('as'=>'project.index','uses'=>'AdminProjectController@index'));
    Route::get('adminProject/getCreate/{id?}', array('as' => 'project.getCreate','uses' => 'AdminProjectController@getCreate'));
    Route::post('adminProject/getCreate/{id?}', array('as' => 'project.postCreate','uses' => 'AdminProjectController@postCreate'));
    Route::post('adminProject/del', array('as' => 'project.del','uses' => 'AdminProjectController@deleteItem'));
    Route::post('adminProject/status', array('as' => 'project.status','uses' => 'AdminProjectController@updateStatus'));

    //QL phan quyen
    Route::any('permission', array('as' => 'admin.permission','uses' => 'AdminPermissionController@index'));
    Route::get('permission/createPermission',array('as' => 'admin.createPermission','uses' => 'AdminPermissionController@getCreatePermission'));
    Route::post('permission/createPermission','AdminPermissionController@postCreatePermission');
    Route::get('permission/editPermission/{id?}', array('as' => 'admin.getEditPermission','uses' => 'AdminPermissionController@getEditPermission'))->where('id', '[0-9]+');
    Route::post('permission/editPermission/{id?}', array('as' => 'admin.editPermission','uses' => 'AdminPermissionController@postEditPermission'))->where('id', '[0-9]+');
    Route::post('permission/updatePermissionStatus','AdminPermissionController@updatePermissionStatus');
    Route::post('permission/stripUnicode','AdminPermissionController@stripUnicode');

    //QL nhom quyen
    Route::any('groupUser', array('as' => 'admin.groupUser','uses' => 'AdminGroupUserController@index'));
    Route::get('groupUser/createGroupUser',array('as' => 'admin.getCreteGroupUser','uses' => 'AdminGroupUserController@getCreateGroupUser'));
    Route::post('groupUser/createGroupUser','AdminGroupUserController@postCreateGroupUser');
    Route::get('groupUser/editGroupUser/{id?}', array('as' => 'admin.geteditGroupUser','uses' => 'AdminGroupUserController@getEditGroupUser'))->where('id', '[0-9]+');
    Route::post('groupUser/editGroupUser/{id?}', array('before'=>'csrf','as' => 'admin.editGroupUser','uses' => 'AdminGroupUserController@postEditGroupUser'))->where('id', '[0-9]+');
    Route::post('groupUser/updateGroupUserStatus','AdminGroupUserController@updateGroupUserStatus');

    //QL user.
    Route::any('adminUser',array('as' => 'admin.adminUser_view','uses' => 'AdminAccountUserController@index'));
    Route::get('adminUser/create',array('as' => 'admin.createUser','uses' => 'AdminAccountUserController@getCreate'));
    Route::post('adminUser/create',array('before'=>'csrf','as' => 'admin.adminUser','uses' => 'AdminAccountUserController@postCreate'));
    Route::get('adminUser/editPass/{id}',array('as' => 'admin.getEditPass','uses' => 'AdminAccountUserController@getEditPass'))->where('id', '.*');
    Route::post('adminUser/editPass/{id}',array('as' => 'admin.adminUser','uses' => 'AdminAccountUserController@postEditPass'))->where('id', '.*');
    Route::get('adminUser/editUser/{id}',array('as' => 'admin.getEditUser','uses' => 'AdminAccountUserController@getEditGroupUser'))->where('id', '[0-9]+');
    Route::post('adminUser/editUser/{id}',array('as' => 'admin.adminUser','uses' => 'AdminAccountUserController@postEditGroupUser'))->where('id', '[0-9]+');
    Route::any('adminUser/getAjaxUpdateUserStatus',array('as' => 'admin.adminUser','uses' => 'AdminAccountUserController@getAjaxUpdateUserStatus'));// Ajax Update tr?ng thái

    // Ql campaign
    Route::any('campaign/view',array('as' => 'campaign.view','uses' => 'AdminSeoCampaignController@view'));
    Route::get('campaign/add/{id?}',array('as' => 'campaign.add','uses' => 'AdminSeoCampaignController@createCampaign'))->where('id', '[0-9]+');
    Route::post('campaign/add/{id?}',array('as' => 'campaign.post_add','uses' => 'AdminSeoCampaignController@postCreateCampaign'))->where('id', '[0-9]+');
    Route::get('campaign/detail/{id?}',array('as' => 'campaign.detail','uses' => 'AdminSeoCampaignController@detailCampaign'))->where('id', '[0-9]+');
    Route::post('campaign/del',array('as' => 'campaign.del','uses' => 'AdminSeoCampaignController@delCampaign'));


    //Test
    Route::get('test',array('as' => 'test.index','uses' => 'TestController@index'));

});

Route::group(array('prefix' => 'cronjobs', 'before' => ''), function()
{
    Route::get('posts',array('as' => 'cronjobs.posts','uses' =>'PostsController@index'));
});
