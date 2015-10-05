<?php
/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 6/5/2015
 * Time: 5:01 PM
 */

class FunctionLib {

    public  static function numberToWord($s, $lang = 'vi') {
        $ds = 0;
        $so = $hang = array();

        $viN = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $viRow = array("", "nghìn", "triệu", "tỷ");

        $enN = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");
        $enRow = array("", "thousand", "million", "billion");

        if ($lang == 'vi') {
            $so = $viN;
            $hang = $viRow;
        } else {
            $so = $enN;
            $hang = $enRow;
        }

        $s = str_replace(",", "", $s);
        $ds = (int) $s;
        if ($ds == 0) {
            return "không ";
        }

        $i = $j = $donvi = $chuc = $tram = 0;
        $i = strlen($s);

        $Str = "";
        if ($i == 0)
            $Str = "";
        else {
            $j = 0;
            while ($i > 0) {
                $donvi = substr($s, $i - 1, 1);
                $i = $i - 1;
                if ($i > 0) {
                    $chuc = substr($s, $i - 1, 1);
                } else {
                    $chuc = -1;
                }
                $i = $i - 1;
                if ($i > 0) {
                    $tram = substr($s, $i - 1, 1);
                } else {
                    $tram = -1;
                }
                $i = $i - 1;
                if ($donvi > 0 || $chuc > 0 || $tram > 0 || $j == 3)
                    $Str = $hang[$j] . " " . $Str;
                $j = $j + 1;
                if ($j > 3)
                    $j = 1;
                if ($donvi == 1 && $chuc > 1)
                    $Str = "mốt" . " " . $Str;
                else {
                    if ($donvi == 5 && $chuc > 0)
                        $Str = "lăm" . " " . $Str;
                    else if ($donvi > 0)
                        $Str = $so[$donvi] . " " . $Str;
                }
                if ($chuc < 0)
                    break;
                else
                    if ($chuc == 0 && $donvi > 0)
                        $Str = "lẻ" . " " . $Str;
                if ($chuc == 1)
                    $Str = "mười" . " " . $Str;
                if ($chuc > 1)
                    $Str = $so[$chuc] . " " . "mươi" . " " . $Str;
                if ($tram < 0)
                    break;
                else
                    if ($tram > 0 || $chuc > 0 || $donvi > 0)
                        $Str = $so[$tram] . " " . "trăm" . " " . $Str;
            }
        }
        return strtoupper(substr($Str, 0, 1)) . substr($Str, 1, strlen($Str) - 1) . ($lang == 'vi' ? "đồng" : 'vnd');
    }
    static function debug($array) {
        if($_SERVER['HTTP_HOST'] != 'banbuonvpp.vn') {
            echo '<pre>';
            print_r($array);
            die;
        }
    }
}