<?php

/*
 * link common cho admin
 * url cac controllers
 * $linkAdmin.{Controller/action}
 */
$key = '';
if(Session::has('key')){
    $key = Session::get('key');
}
$arrPermisson = FunctionLib::buildArrPermission($key);
if(!$arrPermisson)
    $arrPermisson = array();

$linkAdmin = Config::get('config.WEB_ROOT')."admin/";
$linkShop = Config::get('config.WEB_ROOT')."shop/";
$linkNoImager = Config::get('config.WEB_ROOT').'assets/admin/img/icons/non-existing.jpg';

$menuTop = array('btnLogout' => $linkAdmin."logout");

//check quyen hien menu
$linkSupplier = $linkAdmin."supplier";//link nha cung cap
$linkDeals = $linkAdmin."campaign";//link campaign
$linkdeals = $linkAdmin."deals";//link campaign
$linksales = $linkAdmin."sales";//link campaign
$linkRegister = $linkAdmin."register";//link dang ky shop
$linkGroupUser = $linkAdmin."groupUser";//link ql nhom quyen

$linkPermission = $linkAdmin."permission";//link ql nhom quyen
$linkAcount = $linkAdmin."adminUser";//link ql nhom quyen
$linkComment = $linkAdmin."comment";//link ql binh luan

$linkLogCallApi = $linkAdmin."adminLogRunApi";//link quan ly log call Api

$linkProduct = $linkAdmin."adminProduct";//link ql san pham
$linkProductGroup = $linkAdmin."adminProduct/group";//link ql group san pham
$linkProductSale = $linkAdmin."adminProductSale";//link ql san pham đăng bán

$linkAreaPage = $linkAdmin."areaPage";//link ql area home
$linkAdminAdver = $linkAdmin."adminAdver";//link ql Banner quảng cao
$linkAdminBanner = $linkAdmin."adminAdver/listBanner";//link ql Banner quảng cao

$linkLogInningsUp = $linkAdmin."adminLogInningsUp";//link ql san pham

$linkAreaPromotion = $linkAdmin."areaPromotion";//link ql area promotion
$linkOrder = $linkAdmin."adminOrder";//link ql order
$linkCategory = $linkAdmin."adminCategory";//link ql category
$linkFeedHome = $linkAdmin."feedHome";//link ql feed home
$linkLogCod = $linkAdmin."logCod";//link ql log cod
$linkLogSms = $linkAdmin."logSms";//link ql log SMS
$linkReportOrder = $linkAdmin."adminReportOrder";//link ql bán hàng
$linkPushMoneyShop = $linkAdmin."walletRequest";//link ql nap vi tại VP



$menuLeft = array(
    //QL nhà cung cấp
    'supplier' => $linkSupplier,

    //QL danh muc
    'category' => $linkCategory,

    //Log up tin SP
    'logInningsUp' => $linkLogInningsUp,

    //QL Sản phẩm
    'product' => $linkProduct,

    //QL call Api
    'adminLogRunApi' => $linkLogCallApi,

    //QL Sản phẩm
    'productGroup' => $linkProductGroup,

    //QL Sản phẩm
    'adminProductSale' => $linkProductSale,

    //QL Đơn hàng
    'order' => $linkOrder,

    //QL Page Home
    'areaPage' => $linkAreaPage,

    //QL quảng cáo banner
    'adminAdver' => $linkAdminAdver,

    'adminBanner' => $linkAdminBanner,

    //QL Page Home
    'feedhome' => $linkFeedHome,

    //QL log cod
    'logCod' => $linkLogCod,

    //QL log SMS
    'logSms' => $linkLogSms,

    //QL báo cáo bán hàng
    'adminReportOrder' => $linkReportOrder,

    //QL log nap vi VP
    'walletRequest' => $linkPushMoneyShop,

    //QL Page Promotion
    'areaPromotion' => $linkAreaPromotion,

    // ql campaign-promotion
    'campaign'=>$linkDeals,

    // ql campaign-promotion
    'deals'=>$linkdeals,

    // ql sales
    'sales'=>$linksales,

    // ql comment
    'comment'=>$linkComment,

    // ql đăng ký
    'register'=>$linkRegister,

    // ql nhom quyen
    'groupUser'=>$linkGroupUser,

    // ql quyen
    'permission'=>$linkPermission,

    // ql admin acount
    'acount'=>$linkAcount,
);

/*
 * QuynhTM
 * Hiển thị title site
 * currentRouteName => name title
 * */
$titleSiteAdmin = array(
    //QL nhà cung cấp
    'admin.supplier' => 'QL nhà cung cấp',

    //QL danh muc
    'adminCategory' => 'QL danh mục',

    //Log lượt up sản phẩm
    'adminLogInningsUp' => 'Log lượt up sản phẩm',

    //QL Sản phẩm
    'adminProduct' => 'QL sản phẩm',

    //QL Sản phẩm
    'productGroup' => 'QL Nhóm sản phẩm',

    //QL Sản phẩm
    'adminLogRunApi' => 'QL log call Api',

    //QL Sản phẩm đăng bán
    'adminProductSale' => 'QL sản phẩm đăng bán',

    //QL Đơn hàng
    'adminOrder' => 'QL đơn hàng',

    //QL Page Home
    'areaPage' => 'QL banner trang chủ',

    //QL Page Home
    'adminAdver' => 'QL Quảng cáo',

    //QL Page Home
    'adminBanner' => 'QL Banner ',

    //QL Page Home
    'feedHome' => 'QL trang Feed home',

    //QL log cod
    'logCod' => 'QL Log COD',

    //QL log SMS
    'logSms' => 'QL Log gửi SMS',

    'adminReportOrder' => 'Thống kê bán hàng',

    //QL log nap vi VP
    'walletRequest' => 'QL nạp ví tại VP',

    //QL Page Promotion
    'areaPromotion' => 'QL trang Promotion',

    // ql campaign-promotion
    'admin.campaign'=>'QL Deals',

    // ql sale
    'admin.sales'=>'QL Đăng bán',

    // ql comment
    'admin.comment'=>'QL bình luận',

    // ql đăng ký
    'admin.register'=>'Quản lý đăng ký shop',

    // ql nhom quyen
    'admin.groupUser'=>'QL nhóm quyền',

    // ql quyen
    'admin.permission'=>'QL Quyền',

    // ql admin acount
    'admin.adminUser'=>'QL User Admin',
);

return array(
    'MENU_TOP'=> $menuTop,
    'MENU_LEFT'=> $menuLeft,
    'TITLE_SITE'=> $titleSiteAdmin,
    'LINK_ADMIN'=> $linkAdmin,
    'LINK_SHOP'=> $linkShop,
    'LINK_NO_IMAGE'=> $linkNoImager,
);