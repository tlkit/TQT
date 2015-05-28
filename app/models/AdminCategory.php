<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 6/24/14
 * Time: 9:39 AM
 */

class AdminCategory {

    public static function getSearchCategory($paramSearch = array(),$start = 0, $limit = 30){
        $category = self::callSearchApiCategory($paramSearch,$start,$limit);
        return $category;
    }

    public static function callSearchApiCategory( $dataSearch = array(),$start = 0,$limit = 30){
        if(empty($dataSearch))
            return array();
        $key = Session::get('key');
        $paramSearch =  FunctionLib::buildParams("&", $dataSearch);
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/catalog/search";
        $site .="?start={$start}&limit={$limit}&{$paramSearch}&key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        return $dataResponse = json_decode($response,1);
    }

    public static function getCategoryById($id) {
        $data = array();
        if($id > 0){
            $key = Session::get('key');
            $site = FunctionLib::getUrlApi();
            $site .= "api/admin/catalog/show/".$id;
            $curl = PlazaCurl::getInstance();
            $response = $curl->get($site."?key={$key}");
            $dataResponse = json_decode($response,1);

            if(!Authenticate::checkLogin($dataResponse)){
                return Redirect::route('admin.login');
            }

            if(isset($dataResponse['data']) && !empty($dataResponse['data'])){
                $data = $dataResponse['data'];
            }
         }
        return $data;
    }

    public static function updateCategory($id,$data){
        if(empty($data))
            return array();
        if($id > 0){
            $site = FunctionLib::getUrlApi();
            $site .="api/admin/catalog/update/{$id}";
            $curl = PlazaCurl::getInstance();
            $request = $curl->post($site, $data);
            $dataResponse = json_decode($request,1);

            if(!Authenticate::checkLogin($dataResponse)){
                return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
            }
            return $dataResponse;
        }
        return array();
    }

    public static function insertCategory($data){
        if(empty($data))
            return array();
        $site = FunctionLib::getUrlApi();
        $site .="api/admin/catalog/create";
        $curl = PlazaCurl::getInstance();
        $request = $curl->post($site, $data);
        $dataResponse = json_decode($request,1);

        if(!Authenticate::checkLogin($dataResponse)){
            return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
        }
        return $dataResponse;
    }

    public static function getArrayCategory($is_show = true){
        $arrCategory = array();
        $key = Session::get('key');
        $site = FunctionLib::getUrlApi();
        $site .= "api/site/catalog/search";

        $dataSearch = array();
        if($is_show){
            $dataSearch['category_status'] = 1;
        }

        $paramSearch =  FunctionLib::buildParams("&", $dataSearch);
        $site .="?start=0&limit=10000&{$paramSearch}&key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response,1);

        if(!empty($dataResponse)){
            if(isset($dataResponse['data']) && !empty($dataResponse['data'])){
                foreach ($dataResponse['data'] as $k=>$value){
                    $arrCategory[$value['category_id']] = $value['category_name'];
                }
            }
        }
        return $arrCategory;
    }

    /*
     * Build cây danh mục sản phẩm
     */
    public static function getAllTreeCategory($parent = false){
        $arrCategory = $aryCategoryProduct = array();
        $key = Session::get('key');
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/catalog/search";

        $dataSearch['category_status'] = 1;
        $paramSearch =  FunctionLib::buildParams("&", $dataSearch);
        $site .="?start=0&limit=10000&{$paramSearch}&key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response,1);

        //xử lý build cây danh mục
        $max = 0;
        if(!empty($dataResponse)){
            if(isset($dataResponse['data']) && !empty($dataResponse['data'])){
                foreach ($dataResponse['data'] as $k=>$value){
                    if($parent){
                        if($value['category_parent_id']==0) {
                            $max = 1;
                            $arrCategory[$value['category_id']] = array('category_id' => $value['category_id'],
                                                                'category_parent_id' => $value['category_parent_id'],
                                                                'category_status' => $value['category_status'],
                                                                'level' => ($value['category_parent_id'] == 0) ? 1 : 2,
                                                                'category_name' => $value['category_name']);
                        }
                    }else{
                        $max = ($max < $value['category_parent_id'])? $value['category_parent_id'] : $max;
                        $arrCategory[$value['category_id']] = array('category_id'=>$value['category_id'],
                                                                'category_parent_id'=>$value['category_parent_id'],
                                                                'category_status'=>$value['category_status'],
                                                                'level'=>($value['category_parent_id']==0)? 1: 2,
                                                                'category_name'=>$value['category_name']);
                    }
                }
            }
        }

        if($max > 0){
            $aryCategoryProduct = self::showCategory($max, $arrCategory);
        }
        return $aryCategoryProduct;
    }

    public static function  showCategory($max, $aryDataInput) {
        $aryData = array();
        if(is_array($aryDataInput) && count($aryDataInput) > 0) {
            foreach ($aryDataInput as $k => $val) {
                if((int)$val['category_parent_id'] == 0) {
                    $val['padding_left'] = '';
                    $aryData[] = $val;
                    self::showSubCategory($val['category_id'], $max, $aryDataInput, $aryData);
                }
            }
        }
        return $aryData;
    }

    public static function showSubCategory($cat_id, $max, $aryDataInput, &$aryData) {
        if($cat_id <= $max) {
            foreach ($aryDataInput as $chk => $chval) {
                if($chval['category_parent_id'] == $cat_id) {
                    $chval['padding_left'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $aryData[] = $chval;
                    self::showSubCategory($chval['category_id'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }

    /*
     * Insert và cập nhật tiêu chí đánh giá cho danhmuc sản phẩm
     */
    public static function categoryRatting($category_id,$data){
        if(empty($data))
            return array();
        if($category_id > 0){
            $key = Session::get('key');
            $site = FunctionLib::getUrlApi();
            $site .="api/admin/rating/updateCategoryRating/{$category_id}";
            $curl = PlazaCurl::getInstance();
            $request = $curl->post($site,array('data'=>json_encode($data),'key'=>$key));
            $dataResponse = json_decode($request,1);
            return $dataResponse;
        }
        return array();
    }
    public static function getInforCategoryRatting($category_id){
        if($category_id > 0){
            $key = Session::get('key');
            $site = FunctionLib::getUrlApi();
            $site .="api/admin/rating/getCategoryRating/{$category_id}?key={$key}";
            $curl = PlazaCurl::getInstance();
            $response = $curl->get($site);
            $dataResponse = json_decode($response,1);
            return $dataResponse;
        }
        return array();
    }
}