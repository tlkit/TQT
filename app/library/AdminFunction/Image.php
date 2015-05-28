<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 6/19/14
 * Time: 11:15 AM
 * To change this template use File | Settings | File Templates.
 */
class Image{
    const FOLDER_DEFAULT_DEV = 'dev/default/';
    const FOLDER_SUPLIER_DEV = 'dev/supplier/';
    const FOLDER_PRODUCT_DEV = 'dev/product/';
    const FOLDER_ADVER_BANNER_DEV = 'dev/banner/';
    const FOLDER_CATEGORY_DEV = 'dev/category/';
    const FOLDER_PAGE_HOME_DEV = 'dev/pageHome/';
    const FOLDER_CAMPAIGN_BANNER_DEV = 'dev/campaign/banner/';
    const FOLDER_CAMPAIGN_PREVIEW_DEV = 'dev/campaign/preview/';

    const FOLDER_DEFAULT_PRODUCT = 'product/default/';
    const FOLDER_SUPLIER_PRODUCT = 'product/supplier/';
    const FOLDER_PRODUCT_PRODUCT = 'product/product/';
    const FOLDER_ADVER_BANNER = 'banner/banner/';
    const FOLDER_CATEGORY_CATEGORY = 'category/category/';

    const FOLDER_PAGE_HOME_BANNER = 'dev/pageHome/';
    const FOLDER_CAMPAIGN_BANNER = 'campaign/banner/';
    const FOLDER_CAMPAIGN_PREVIEW = 'campaign/preview/';
    // ham upload anh
    public static  function uploadImg($folder = Image::FOLDER_DEFAULT_DEV,$images,$id = 0){
        $result = 'no image';
        if($images){
            $client = StorageClient::getInstance();
            $folder = str_replace('img/', '', $folder);

            if (is_array($images)) {
                $fileName = $images['name'];
                $source = $images['tmp_name'];
                $ext = self::getImageType($fileName);
                $name = explode('.',$fileName);
                $nameImg = 'mc_plaza';
                if(isset($name[0])){
                    $nameImg = $name[0];
                }
                $dest = self::getFileName($id, $folder, $ext,$nameImg);
                while ($client->isExists($dest)) {
                    $dest = self::getFileName($id, $folder, $ext,$nameImg);
                }
                if ($client->upload($dest, $source, true)) {
                    //$result = 'http://solo10.vcmedia.vn/'.$dest;
                    $result = $dest;
                }
            }
        }
        return $result;
    }

    public static  function uploadImgByUrl($folder = Image::FOLDER_DEFAULT_DEV,$images,$id = 0){
        $result = 'no image';
        if($images){
            $client = StorageClient::getInstance();
            $folder = str_replace('img/', '', $folder);

            if (is_array($images)) {
                $fileName = $images['name'];
                $source = $images['url'];
                $ext = self::getImageType($fileName);
                $name = explode('.',$fileName);
                $nameImg = 'mc_plaza';
                if(isset($name[0])){
                    $nameImg = $name[0];
                }
                $dest = self::getFileName($id, $folder, $ext,$nameImg);

                while ($client->isExists($dest)) {
                    $dest = self::getFileName($id, $folder, $ext,$nameImg);
                }
                if ($client->upload($dest, $source, true)) {
                    //$result = 'http://solo10.vcmedia.vn/'.$dest;
                    $result = $dest;
                }
            }
        }
        return $result;
    }

    public static  function multiUploadImg($folder = Image::FOLDER_DEFAULT_DEV,$images,$id = 0){
        //$folder = Config::get('config.DEVMODE') ? str_replace('dev/', '', $folder) : str_replace('product/', '', $folder);
        $result = array();
        if (is_array($images)) {
            $client = StorageClient::getInstance();
            foreach ($images as $key => $file) {
                // Neu nguon anh la 1 URL
                if (is_string($file) && preg_match('#http:\/\/.*$#', $file)) {
                    $fileName = $file;
                    $source = $file;
                    $ext = self::getImageType($fileName);
                    $name = explode('.',$fileName);
                    $nameImg = 'mc_plaza';
                    if(isset($name[0])){
                        $nameImg = $name[0];
                    }
                    $dest = self::getFileName($id, $folder, $ext,$nameImg);
                    while ($client->isExists($dest)) {
                        $dest = self::getFileName($id, $folder, $ext,$nameImg);
                    }
                    if ($client->upload($dest, $source, true)) {
                        $result[$key] = $dest;
                    }
                } else {
                    // Neu upload nhieu file cung luc
                    if (is_array($file['name']) && count($file['name']) > 0) {
                        foreach ($file['name'] as $key_file => $f_name) {
                            $fileName = $f_name;
                            $source = $file['tmp_name'][$key_file];
                            $ext = self::getImageType($fileName);
                            $name = explode('.',$fileName);
                            $nameImg = 'mc_plaza';
                            if(isset($name[0])){
                                $nameImg = $name[0];
                            }
                            $dest = self::getFileName($id, $folder, $ext,$nameImg);
                            while ($client->isExists($dest)) {
                                $dest = self::getFileName($id, $folder, $ext,$nameImg);
                            }
                            if ($client->upload($dest, $source, true)) {
                                $result[$key][$key_file] = $dest;
                            }
                        }
                    } else {
                        $fileName = $file['name'];
                        $source = $file['tmp_name'];
                        $ext = self::getImageType($fileName);
                        $name = explode('.',$fileName);
                        $nameImg = 'mc_plaza';
                        if(isset($name[0])){
                            $nameImg = $name[0];
                        }
                        $dest = self::getFileName($id, $folder, $ext,$nameImg);
                        while ($client->isExists($dest)) {
                            $dest = self::getFileName($id, $folder, $ext,$nameImg);
                        }
                        if ($client->upload($dest, $source, true)) {
                            $result[$key] = $dest;
                        }
                    }
                }
            }
            if (is_array($result) && !empty($result)) {
                if (count($result) == 1 && isset($result[0])) {
                    return $result[0];
                } else {
                    return $result;
                }
            } else {
                return false;
            }
        }

        return false;
    }
    // lấy type ảnh
    static function getImageType($img_src, $mine_type = '') {
        $img_type = strtolower(strrchr($img_src, '.'));

        if ($img_type != '.jpg' && $img_type != '.png' && $mine_type != '') {
            switch ($mine_type) {
                case 'image/jpg':
                case 'image/jpeg': $img_type = '.jpg';
                    break;
                case 'image/png': $img_type = '.png';
                    break;
                default: $img_type = '.jpg';
            }
        } else {
            $arrExts = array('.jpg', '.jpeg', '.png');
            if (!in_array($img_type, $arrExts)) {
                $img_type = '.png';
            }
        }
        return ($img_type != '') ? $img_type : false;
    }

    // build file nam ảnh
    static function getFileName($id='mc_plaza', $prefix, $type = '.jpg',$name='mc_plaza') {
        $uni = rand(10000, 99999);
        return $prefix . '-' . $id. '-'.$name.'-' . $uni . $type;
    }

    //build link ảnh
    static function buildUrlImage($name_image = '',$thumb_w = 0,$seo = false){
        if($seo){
            $name_space = Config::get('servicesimage.NAME_SPACE_SEO');
        }else{
            $name_space = Config::get('servicesimage.NAME_SPACE');
        }
        $url = '';
       if($name_image !=''){
           $url= Config::get('servicesimage.SERVER_IMAGE');
           if ($thumb_w) {
               $url .= 'thumb_wl/' . $thumb_w . '/' . $name_space . '/';
           } else {
               $url .= 'thumb_max/' . $name_space . '/';
           }
           $url .= $name_image;
       }
       return $url;
    }

    static function buildUrlImageZoom($name_image = '',$size = '50_50',$seo = false){
        if($seo){
            $name_space = Config::get('servicesimage.NAME_SPACE_SEO');
        }else{
            $name_space = Config::get('servicesimage.NAME_SPACE');
        }
        $url = '';
        if($name_image !=''){
            $url= Config::get('servicesimage.SERVER_IMAGE');
            $url .= 'zoom/' . $size . '/' . $name_space . '/' . $name_image;
        }
        return $url;
    }
    static function buildUrlImageThumb($name_image = '',$size = '50_50',$seo = false){
        if($seo){
            $name_space = Config::get('servicesimage.NAME_SPACE_SEO');
        }else{
            $name_space = Config::get('servicesimage.NAME_SPACE');
        }
        $url = '';
        if($name_image !=''){
            $url= Config::get('servicesimage.SERVER_IMAGE');
            $url .= 'thumb/' . $size . '/' . $name_space . '/' . $name_image;
        }
        return $url;
    }
    /**
     * Get campaign images folder
     *
     * @return string
     */
    static function  getCampaignImagesFolder() {
        return (Config::get('config.DEVMODE')) ? Image::FOLDER_CAMPAIGN_BANNER_DEV : Image::FOLDER_CAMPAIGN_BANNER;
    }
}