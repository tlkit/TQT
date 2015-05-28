<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 6/16/14
 * Time: 5:53 PM
 */

class FunctionLib {
    /**
     * @param $file_name
     */
    static function link_css($file_name, $position = 1) {
        if (is_array($file_name)) {
            foreach ($file_name as $v) {
                self::link_css($v);
            }
            return;
        }
        if (strpos($file_name, 'http://') !== false) {
            $html = '<link rel="stylesheet" href="' . $file_name . ((CGlobal::$css_ver) ? '?ver=' . CGlobal::$css_ver : '') . '" type="text/css">' . "\n";
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderCSS, $html) === false)
                CGlobal::$extraHeaderCSS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterCSS, $html) === false)
                CGlobal::$extraFooterCSS .= $html . "\n";
            return;
        } else {
            $html = '<link type="text/css" rel="stylesheet" href="' . Config::get('config.WEB_ROOT') . 'assets/css/' . $file_name . ((CGlobal::$css_ver) ? '?ver=' . CGlobal::$css_ver : '') . '" />' . "\n";
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderCSS, $html) === false)
                CGlobal::$extraHeaderCSS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterCSS, $html) === false)
                CGlobal::$extraFooterCSS .= $html . "\n";
        }
    }

    /**
     * @param $file_name
     */
    static function link_js($file_name, $position = 1) {
        if (is_array($file_name)) {
            foreach ($file_name as $v) {
                self::link_js($v);
            }
            return;
        }
        if (strpos($file_name, 'http://') !== false) {
            $html = '<script type="text/javascript" src="' . $file_name . ((CGlobal::$js_ver) ? '?ver=' . CGlobal::$js_ver : '') . '"></script>';
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderJS, $html) === false)
                CGlobal::$extraHeaderJS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterJS, $html) === false)
                CGlobal::$extraFooterJS .= $html . "\n";
            return;
        } else {
            $html = '<script type="text/javascript" src="' . Config::get('config.WEB_ROOT') . 'assets/js/' . $file_name . ((CGlobal::$js_ver) ? '?ver=' . CGlobal::$js_ver : '') . '"></script>';
            if ($position == CGlobal::$POS_HEAD && strpos(CGlobal::$extraHeaderJS, $html) === false)
                CGlobal::$extraHeaderJS .= $html . "\n";
            elseif ($position == CGlobal::$POS_END && strpos(CGlobal::$extraFooterJS, $html) === false)
                CGlobal::$extraFooterJS .= $html . "\n";
        }
    }

    /**
     * build param for get method
     *
     * @param string $pices
     * @param array $data
     */
    static function buildParams($pices = '&', $data) {
        $result = "";
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $result .= $k . '=' . urlencode($v) . $pices;
            }
        }
        if ($result != '') {
            $result = substr($result, 0, -1);
        }
        return $result;
    }

    /**
     * encode special chars
     *
     * @param array $data
     */
    static function encodeParam($data) {
        foreach ($data as $k => $item) {
            $data[$k] = nl2br(htmlspecialchars(trim($data[$k])));
        }
        return $data;
    }

    /**
     * urlencode array data
     *
     * @param array $data
     */
    static function urlEncode($data) {
        if (!empty($data)) {
            foreach ($data as $k => $item) {
                $data[$k] = urlencode($data[$k]);
            }
        }
        return $data;
    }

    /**
     * get url root for call api
     *
     */
    static function getUrlApi() {
        $site = '';
        if (Config::get('config.DEVMODE')) {
            $site = Config::get('config.URL_API_LOCAL');
        } else {
            $site = Config::get('config.URL_API_LIVE');
        }
        return $site;
    }

    /**
     * get url root for client
     *
     * @param array $data
     */
    static function getUrlClient() {
        $site = '';
        if (Config::get('config.DEVMODE')) {
            $site = Config::get('config.URL_CLIENT_LOCAL');
        } else {
            $site = Config::get('config.URL_CLIENT_LIVE');
        }
        return $site;
    }

    /**
     * build html select option
     *
     * @param array $options_array
     * @param int $selected
     * @param array $disabled
     */
    static function getOption($options_array, $selected, $disabled = array()) {
        $input = '';
        if ($options_array)
            foreach ($options_array as $key => $text) {
                $input .= '<option value="' . $key . '"';
                if (!in_array($selected, $disabled)) {
                    if ($key === '' && $selected === '') {
                        $input .= ' selected';
                    } else
                        if ($selected !== '' && $key == $selected) {
                            $input .= ' selected';
                        }
                }
                if (!empty($disabled)) {
                    if (in_array($key, $disabled)) {
                        $input .= ' disabled';
                    }
                }
                $input .= '>' . $text . '</option>';
            }
        return $input;
    }

    /**
     * build html select option mutil
     *
     * @param array $options_array
     * @param array $arrSelected
     */
    static function getOptionMultil($options_array, $arrSelected) {
        $input = '';
        if ($options_array)
            foreach ($options_array as $key => $text) {
                $input .= '<option value="' . $key . '"';
                if ($key === '' && empty($arrSelected)) {
                    $input .= ' selected';
                } else
                    if (!empty($arrSelected) && in_array($key, $arrSelected)) {
                        $input .= ' selected';
                    }
                $input .= '>' . $text . '</option>';
            }
        return $input;
    }

    /*
     * QuynhTM
     * Tạo riêng option cho danh mục sản phẩm
     */
    /**
     * build html select option tree category
     *
     * @param array $options_array
     * @param int $selected
     * @param array $disabled
     */
    static function getOptionTreeCategory($options_array, $selected, $disabled = array()) {
        $input = '<option value="0">-- Chọn danh mục  --</option>';
        if ($options_array)
            foreach ($options_array as $k => $val) {
                $key = $val['category_id'];
                $input .= '<option value="' . $key . '"';
                if (!in_array($selected, $disabled)) {
                    if ($key === '' && $selected === '') {
                        $input .= ' selected';
                    } else
                        if ($selected !== '' && $key == $selected) {
                            $input .= ' selected';
                        }
                }
                if (!empty($disabled)) {
                    if (in_array($key, $disabled)) {
                        $input .= ' disabled';
                    }
                }
                $input .= '>' . $val['padding_left'] . $val['category_name'] . '</option>';
            }
        return $input;
    }

    /**
     * format number
     *
     * @param int $number
     */
    static function numberFormat($number = 0) {
        if ($number >= 1000) {
            return number_format($number, 0, ',', '.');
        }
        return $number;
    }

    /**
     * convert time
     *
     * @param string $time_from
     * @param string $time_to
     * @param int $hour_from
     * @param int $minute_from
     * @param int $hour_to
     * @param int $minute_to
     */
    static function timeFromTo($time_from = '', $time_to = '', $hour_from = 0, $minute_from = 0, $hour_to = 23, $minute_to = 59) {
        $condition = array();
        if ($time_from != '') {
            $date_arr = explode('-', $time_from);
            $hour_from = ($hour_from > 24) ? 0 : $hour_from;
            $minute_from = ($minute_from > 60) ? 0 : $minute_from;
            if (isset($date_arr[0]) && isset($date_arr[1]) && isset($date_arr[2])) {
                $created_time_from = mktime($hour_from, $minute_from, 0, (int)$date_arr[1], (int)$date_arr[0], (int)$date_arr[2]);
                $condition['time_start'] = $created_time_from;
            }
        }

        if ($time_to != '') {
            $date_arr = explode('-', $time_to);
            $hour_to = ($hour_to > 24) ? 23 : $hour_to;
            $minute_to = ($minute_to > 60) ? 59 : $minute_to;
            if (isset($date_arr[0]) && isset($date_arr[1]) && isset($date_arr[2])) {
                $created_time_to = mktime($hour_to, $minute_to, 59, (int)$date_arr[1], (int)$date_arr[0], (int)$date_arr[2]);
                $condition['time_end'] = $created_time_to;
            }
        }
        return $condition;
    }

    /**
     * convert time
     *
     * @param array $array
     */
    static function debug($array) {
        if($_SERVER['HTTP_HOST'] != 'plaza.muachung.vn') {
            echo '<pre>';
            print_r($array);
            die;
        }
    }


    static function safe_title($text) {
        $text = FunctionLib::post_db_parse_html($text);
        $text = FunctionLib::stripUnicode($text);
        $text = self::_name_cleaner($text, "-");
        $text = str_replace("----", "-", $text);
        $text = str_replace("---", "-", $text);
        $text = str_replace("--", "-", $text);
        $text = trim($text, '-');

        if ($text) {
            return $text;
        } else {
            return "shop";
        }
    }


    static function post_db_parse_html($t = "") {
        if ($t == "") {
            return $t;
        }

        $t = str_replace("&#39;", "'", $t);
        $t = str_replace("&#33;", "!", $t);
        $t = str_replace("&#036;", "$", $t);
        $t = str_replace("&#124;", "|", $t);
        $t = str_replace("&amp;", "&", $t);
        $t = str_replace("&gt;", ">", $t);
        $t = str_replace("&lt;", "<", $t);
        $t = str_replace("&quot;", '"', $t);

        $t = preg_replace("/javascript/i", "j&#097;v&#097;script", $t);
        $t = preg_replace("/alert/i", "&#097;lert", $t);
        $t = preg_replace("/about:/i", "&#097;bout:", $t);
        $t = preg_replace("/onmouseover/i", "&#111;nmouseover", $t);
        $t = preg_replace("/onmouseout/i", "&#111;nmouseout", $t);
        $t = preg_replace("/onclick/i", "&#111;nclick", $t);
        $t = preg_replace("/onload/i", "&#111;nload", $t);
        $t = preg_replace("/onsubmit/i", "&#111;nsubmit", $t);
        $t = preg_replace("/applet/i", "&#097;pplet", $t);
        $t = preg_replace("/meta/i", "met&#097;", $t);

        return $t;
    }

    static function stripUnicode($str) {
        if (!$str)
            return false;
        $marTViet = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
                    "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
                    , "ế", "ệ", "ể", "ễ",
                    "ì", "í", "ị", "ỉ", "ĩ",
                    "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
                    , "ờ", "ớ", "ợ", "ở", "ỡ",
                    "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
                    "ỳ", "ý", "ỵ", "ỷ", "ỹ",
                    "đ",
                    "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
                    , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
                    "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
                    "Ì", "Í", "Ị", "Ỉ", "Ĩ",
                    "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
                    , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
                    "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
                    "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
                    "Đ");

        $marKoDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
        , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
        , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
        , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
        , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D");

        $str = str_replace($marTViet, $marKoDau, $str);
        return $str;
    }

    static function _name_cleaner($name, $replace_string = "_") {
        return preg_replace("/[^a-zA-Z0-9\-\_]/", $replace_string, $name);
    }

    /**
     * convert from str to array
     *
     * @param string $str_item
     */
    static function standardizeCartStr($str_item) {
        if (empty($str_item))
            return 0;
        $str_item = trim(preg_replace('#([\s]+)|(,+)#', ',', trim($str_item)));
        $data = explode(',', $str_item);
        $arrItem = array();
        foreach ($data as $item) {
            if ($item != '')
                $arrItem[] = $item;
        }
        if (empty($arrItem))
            return 0;
        else
            return $arrItem;
    }

    /**
     * get group user by user
     *
     */
    static function getRoleUser() {
        if (Session::has('user')) {
            $user = Session::get('user');
            $role = ($user['admin_role'] != '') ? $user['admin_role'] : -1;
            return $role;
        } else {
            return false;
        }
    }

    static function getRoleShopUser() {
        if (Session::has('user_supplier')) {
            $user = Session::get('user_supplier');
            $role = (isset($user['group_user_ids']) && $user['group_user_ids'] != '') ? $user['group_user_ids'] : -1;
            return $role;
        } else {
            return false;
        }
    }

    /**
     * strip unicode string
     *
     * @param string $str
     */


    /**
     * get permission by group user
     *
     * @param string $key
     */
    static function buildArrPermission($key) {
        $arrPermission = array();
        $role = FunctionLib::getRoleUser();
        if ($role && $key) {
            $dataModel = GroupUser::getPermissionByGroupUser($role, $key);
            $dataResponse = $dataModel['dataResponse'];
            $dataPermission = $dataModel['data'];
            if (!empty($dataPermission)) {
                foreach ($dataPermission as $item) {
                    $arrPermission[$item['permission_id']] = $item['permission_code'];
                }
            }
        }

        return $arrPermission;
    }


    static function buildArrShopPermission($key) {
        $arrPermission = array();
        $role = FunctionLib::getRoleShopUser();
        if ($role && $key) {
            $dataModel = GroupUser::getPermissionShopByGroupUser($role, $key);
            $dataResponse = $dataModel['dataResponse'];
            $dataPermission = $dataModel['data'];
            if (!empty($dataPermission)) {
                foreach ($dataPermission as $item) {
                    $arrPermission[$item['permission_id']] = $item['permission_code'];
                }
            }
        }

        return $arrPermission;
    }

    /**
     * check permission by user
     *
     * @param string $permission
     * @param string $permission_full
     * @param string $key
     */
    //return 0 thì logout;$permission_full full quyen voi chuc nang
    static function checkPermission($permission, $permission_full, $key) {
        $root = 'root';
        $admin = 'admin';
        $arrPermisson = FunctionLib::buildArrPermission($key);
        if (!$arrPermisson)
            return 0;
        if (!in_array($root, $arrPermisson)) {
            if (!in_array($admin, $arrPermisson)) {
                if (!in_array($permission_full, $arrPermisson)) {
                    if (!in_array($permission, $arrPermisson)) {
                        return 1;
                    }
                } else {
                    return 4; //set full quyen voi chuc nang
                }
            } else {
                if (in_array($permission_full, $arrPermisson)) {
                    return 5; //neu vua co quyen admin vua them full quyen 1 controller
                } else {
                    if (in_array($permission, $arrPermisson)) {
                        return 6; //neu vua co quyen admin vua them quyen 1 action
                    }
                }
                return 3; //full quyen addmin
            }
        }
        return 2; //full quyen root
    }

    static function strip_html_tags($string)
    {
        return preg_replace(array('/\<(script)(.+)>/i', '/\<(.+)(script)>/i', '/\<(style)(.+)>/i', '/\<(.+)(style)>/i'), '', $string);
    }

    static function write_exception_log($message) {
//        $path = __DIR__ . '/../../storage/logs/';
//        $filename = 'exception-' . date('d_m_Y');
//        $logfile = $path . $filename;
        $date = date("d-m-Y H:i:s", time());

        if( ($time = $_SERVER['REQUEST_TIME']) == '') {
            $time = time();
        }
        if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
            $remote_addr = "REMOTE_ADDR_UNKNOWN";
        }
        if( ($request_uri = $_SERVER['REQUEST_URI']) == '') {
            $request_uri = "REQUEST_URI_UNKNOWN";
        }
        RedisPhp::addToListByRPush('log','log_call_api',' Time:['. $date .'] Remote:['.$remote_addr.'] API :['.$request_uri.'] Messes :['.$message);
//        if($fd = @fopen($logfile, "a")) {
//            $result = fputcsv($fd, array($date, $remote_addr, $request_uri, $message));
//            fclose($fd);
//        }
    }

    static function cutString($str, $num) {
        $arr_str = explode(' ', $str);
        $count = count($arr_str);
        $arr_str = array_slice($arr_str, 0, $num);
        $res = implode(' ', $arr_str);
        if ($count > $num) {
            $res .= ' ...';
        }
        return $res;

    }

    static function buildAddress($data = array()) {
        if(empty($data)) {
            return '';
        }
        $arrData = array();
        foreach($data as $itm) {
            if($itm != '') {
                $arrData[] = $itm;
            }
        }
        return implode(', ', $arrData);
    }

    /*
     * QuynhTM
     * build url encode
     */
    static function buildUrlEncode($link = '') {
        return ($link != '')? rtrim(strtr(base64_encode($link), '+/', '-_'), '=') : '';
    }

    static function buildUrlDecode($str_link = '') {
        return ($str_link != '')? base64_decode(str_pad(strtr($str_link, '-_', '+/'), strlen($str_link) % 4, '=', STR_PAD_RIGHT)) : '';
    }

    static function buildRating($selected = 0) {
        $html = '<option value="0" ' . (($selected == 0) ? 'selected' : '') . '> Đánh giá </option>';
        for($i=5.0; $i>3.0; $i-=0.1) {
            $a = $selected * 10;
            $b = $i*10;
            $html .= '<option value="' . $i . '" ' . (((int)$a == (int)$b) ? 'selected' : '') . '>' . $i . ' sao</option>';
        }
        for($j=2.5; $j>=1.0; $j-=0.5) {
            $a = $selected * 10;
            $b = $j*10;
            $html .= '<option value="' . $j . '" ' . (((int)$a == (int)$b) ? 'selected' : '') . '>' . $j . ' sao</option>';
        }
        return $html;
    }

    static function getCurrentLocation(){
        $location_id = isset($_COOKIE['muachung_cityMC']) ? $_COOKIE['muachung_cityMC'] : Area::app_obj_hn;
        if (!in_array($location_id,array_keys(CGlobal::$aryProvince))) {
            $location_id = Area::app_obj_hn;
        }
        return $location_id;
    }

    static function getArrDayInMonth($aryDay){
        $data = array();
        $today = strtotime(date('d-m-Y',time()));
        asort($aryDay);
        foreach($aryDay as $day){
            if($day >= $today){
            $data[strtotime(date('1-m-Y', $day))] = isset($data[strtotime(date('1-m-Y', $day))]) ? $data[strtotime(date('1-m-Y', $day))] . ', ' . date('d', $day) : date('d', $day);
            }
        }
        ksort($data);
        return $data;
    }

    static function round_half_five($number) {
        $expNum = explode('.', $number);
        $decimal = $number - $expNum[0];
        if($decimal == 0)
            return $number;
        if($decimal > 0 && $decimal <= 0.5)
            return $expNum[0] + 0.5;
        else
            return $expNum[0] + 1;
    }

    static function buildNameImg($img, $title)
    {
        $title = strtolower(FunctionLib::safe_title($title));
        $string = array('.jpg', '.png', '.jpeg');
        $replace = array('/' . $title . '.jpg', '/' . $title . '.png', '/' . $title . '.jpeg');
        $img = str_replace($string, $replace, $img);
        return $img;

    }

}