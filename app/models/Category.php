<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 6/24/14
 * Time: 9:39 AM
 */

class Category
{


    public  $location_id = 0;

    public function __construct() {
        $this->location_id = FunctionLib::getCurrentLocation();
    }

    private static $client_id = '5e6e415783b7860e1d4b9ff908763686';
    public static function getSearchCategory($paramSearch = array(), $start = 0, $limit = 30)
    {
        $category = self::callSearchApiCategory($paramSearch, $start, $limit);
        return $category;
    }

    public static function callSearchApiCategory($dataSearch = array(), $start = 0, $limit = 30)
    {
        if (empty($dataSearch))
            return array();
        $key = Session::get('key_shop');
        $paramSearch = FunctionLib::buildParams("&", $dataSearch);
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/catalog/search";
        $site .= "?start={$start}&limit={$limit}&{$paramSearch}&key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        return $dataResponse = json_decode($response, 1);
    }

    public static function getCategoryById($id)
    {
        $data = array();
        if ($id > 0) {
            $key = Session::get('key_shop');
            $site = FunctionLib::getUrlApi();
            $site .= "api/admin/catalog/show/" . $id;
            $curl = PlazaCurl::getInstance();
            $response = $curl->get($site . "?key={$key}");
            $dataResponse = json_decode($response, 1);

            if (!Authenticate::checkShopLogin($dataResponse)) {
                return Redirect::route('shop.login');
            }

            if (isset($dataResponse['data']) && !empty($dataResponse['data'])) {
                $data = $dataResponse['data'];
            }
        }
        return $data;
    }

    public static function updateCategory($id, $data)
    {
        if (empty($data))
            return array();
        if ($id > 0) {
            $site = FunctionLib::getUrlApi();
            $site .= "api/admin/catalog/update/{$id}";
            $curl = PlazaCurl::getInstance();
            $request = $curl->post($site, $data);
            $dataResponse = json_decode($request, 1);

            if (!Authenticate::checkShopLogin($dataResponse)) {
                return Redirect::route('shop.login');
            }
            return $dataResponse;
        }
        return array();
    }

    public static function insertCategory($data)
    {
        if (empty($data))
            return array();
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/catalog/create";
        $curl = PlazaCurl::getInstance();
        $request = $curl->post($site, $data);
        $dataResponse = json_decode($request, 1);

        if (!Authenticate::checkShopLogin($dataResponse)) {
            return Redirect::route('shop.login');
        }
        return $dataResponse;
    }

    public static function getArrayCategory($status = false)
    {
        $arrCategory = array();
        $key = Session::get('key_shop');
        $site = FunctionLib::getUrlApi();
        $site .= "api/site/catalog/search";
        //lấy all
        if($status){
            $dataSearch['category_status'] = 1;
            $paramSearch = FunctionLib::buildParams("&", $dataSearch);
            $site .= "?start=0&limit=10000&{$paramSearch}&key={$key}";
        }else{
            $site .= "?start=0&limit=10000&key={$key}";
        }

        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response, 1);

        /*if (!Authenticate::checkShopLogin($dataResponse)) {
            return Redirect::route('shop.login');
        }*/
        //var_dump($dataResponse); die;
        if (!empty($dataResponse)) {
            if (isset($dataResponse['data']) && !empty($dataResponse['data'])) {
                foreach ($dataResponse['data'] as $k => $value) {
                    $arrCategory[$value['category_id']] = $value['category_name'];
                }
            }
        }
        //var_dump($arrCategory); die;
        return $arrCategory;
    }

    /*
     * Build cây danh mục sản phẩm
     */
    public static function getAllTreeCategory()
    {
        $arrCategory = $aryCategoryProduct = array();
        $key = Session::get('key_shop');
        $site = FunctionLib::getUrlApi();
        $site .= "api/site/catalog/search";
        $dataSearch['category_status'] = 1;
        $paramSearch = FunctionLib::buildParams("&", $dataSearch);
        $site .= "?start=0&limit=10000&{$paramSearch}&key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response, 1);

        //xử lý build cây danh mục
        $max = 0;

        if (!empty($dataResponse)) {
            if (isset($dataResponse['data']) && !empty($dataResponse['data'])) {
                foreach ($dataResponse['data'] as $k => $value) {
                    $max = ($max < $value['category_parent_id']) ? $value['category_parent_id'] : $max;
                    $arrCategory[$value['category_id']] = array('category_id' => $value['category_id'],
                        'category_parent_id' => $value['category_parent_id'],
                        'category_name' => $value['category_name']);
                }
            }
        }

        if ($max > 0) {
            $aryCategoryProduct = self::showCategory($max, $arrCategory);
        }
        return $aryCategoryProduct;
    }

    public static function  showCategory($max, $aryDataInput)
    {
        $aryData = array();
        if (is_array($aryDataInput) && count($aryDataInput) > 0) {
            foreach ($aryDataInput as $k => $val) {
                if ((int)$val['category_parent_id'] == 0) {
                    $val['padding_left'] = '';
                    $aryData[] = $val;
                    self::showSubCategory($val['category_id'], $max, $aryDataInput, $aryData);
                }
            }
        }
        return $aryData;
    }

    public static function showSubCategory($cat_id, $max, $aryDataInput, &$aryData)
    {
        if ($cat_id <= $max) {
            foreach ($aryDataInput as $chk => $chval) {
                if ($chval['category_parent_id'] == $cat_id) {
                    $chval['padding_left'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $aryData[] = $chval;
                    self::showSubCategory($chval['category_id'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }

    public static function getListCategory($id, $cache = false)
    {
        $location = (Session::has('sess_location')) ? Session::get('sess_location') : Area::app_obj_hn;
        $is_demo = (int)Config::get('compile.demo');
        $dataResponse = array();
        if ($id > 0) {
            if ($cache) {
                $dataResponse = Cache::get('category_' . $id. '_'. $is_demo);
            }
            if (!$dataResponse) {
                $site = FunctionLib::getUrlApi();
                $site .= "api/site/category/" . $id . "/$is_demo?location=$location";
                $curl = PlazaCurl::getInstance();
                $response = $curl->get($site);
                $dataResponse = json_decode($response, true);
                Cache::forever('category_' . $id . '_'. $is_demo, $dataResponse, 100);
            }
        }
        return $dataResponse;
    }

    public static function getCategory($cache = true)
    {
        $category = new Category();
        $location_id = $category->location_id;
        $data = array();
        if ($cache) {
            $data = Cache::get('category_all');
        }

        if (!$data) {
            $site = FunctionLib::getUrlApi();
            $site .= "api/site/category/all/{$location_id}";
            $curl = PlazaCurl::getInstance();
            $response = $curl->get($site);

            $dataResponse = json_decode($response, true);
            if ($dataResponse['code'] == 200 && $dataResponse['data']) {
                $data = $dataResponse['data'];
                Cache::forever('category_all', $data);
            }

        }
        return $data;
    }

    public static function getParentCategoryById($id)
    {

        $data = array();
        $site = FunctionLib::getUrlApi();
        $site .= "api/site/category/parent/{$id}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response, true);
        if ($dataResponse['code'] == 200 && $dataResponse['data']) {
            $data = $dataResponse['data'];
            //Cache::forever('category_parent', $data);
        }
        return $data;
    }

    public static function categoryMC($province_id) {
        $link_api = "http://api.muachung.vn/3.0/get-cate.json?client_id=" . self::$client_id . "&province={$province_id}&plaza=1";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($link_api);
        $category = json_decode($response,true);
        return $category;
    }

    public static function getCategoryRatting($category_id){
        $data = array();
        if($category_id > 0){
            $site = FunctionLib::getUrlApi();
            $site .="api/site/getCategoryRating/{$category_id}";
            $curl = PlazaCurl::getInstance();
            $response = $curl->get($site);
            $dataResponse = json_decode($response,1);
            if(isset($dataResponse['code']) && $dataResponse['code'] == 200) {
                $data = $dataResponse['data'];
            }
        }
        return $data;
    }

}