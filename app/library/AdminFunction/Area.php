<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/18/14
 * Time: 2:11 PM
 */
class Area {
    const banner_big_home = 1; // Banner lớn trang Home
    const banner_min_home = 2; //Banner nhỏ trang home
    const banner_promotion_home = 3; //Banner promotion home
    const product_hot_home = 4; // san pham hot home
    const product_top_home = 5; // san pham trong trang home
    const promotion_avatar = 6; // anh dai dien promotion
    const campaign_image = 7; // anh dai dien promotion

    const app_obj_all = 1;
    const app_obj_hn = 22;
    const app_obj_hcm = 29;
    const app_obj_dn = 15;

    static function getAllArea() {
        $dataBanner = Area::buildDataBanner();
        $areaList = array();
        foreach ($dataBanner as $key => $banner){
            $item = array(
                'area_id' =>$key,
                'area_name' => $banner
            );
            $areaList [] = $item;
        }
        return $areaList;
    }

    static function buildDataBanner(){
        $dataBanner = array(
            Area::banner_big_home => 'Banner lớn trang Home',
            Area::banner_min_home => 'Banner nhỏ trang Home',
            Area::banner_promotion_home => 'Banner promotion Home',
            Area::product_hot_home => 'Sản phẩm hot Home',
            Area::product_top_home => 'Sản phẩm top Home',
            Area::campaign_image => 'Ảnh đại diện campaign'
        );
        return $dataBanner;
    }

//    static $aryAppObj = array(
//        Area::app_obj_hn => 'Hà Nội',
//        Area::app_obj_hcm => 'Hồ Chí Minh',
//        Area::app_obj_dn => 'Đà Nẵng'
//    );

}