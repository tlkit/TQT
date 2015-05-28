<?php

/**
 * Created by PhpStorm.
 * User: TuanNguyenAnh
 * Date: 1/5/2015
 * Time: 9:14 AM
 */
class Accounting {

    public static function warningPaySupplier($supplier_name, $key) {
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/accounting/warningPaySupplier?supplier_name={$supplier_name}&key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response, 1);
        return $dataResponse;
    }

    public static function getPaySupplier($id, $key) {
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/accounting/pay/{$id}?key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response, 1);
        return $dataResponse;
    }

    public static function paySupplier($id, $aryData) {
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/accounting/pay/{$id}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->post($site, $aryData);
        $dataResponse = json_decode($response, 1);
        return $dataResponse;
    }

    public static function managePaySupplier($key, $data = array(), $admin = 0, $limit, $page_no) {
        $site = FunctionLib::getUrlApi();
        $paramSearch = FunctionLib::buildParams("&", $data);
        $site .= "api/admin/accounting/manage_pay_supplier?limit={$limit}&page_no={$page_no}&key={$key}&{$paramSearch}&admin={$admin}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response, 1);
        return $dataResponse;
    }

    public static function  historyPaySupplier($id, $key) {

        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/accounting/history_pay/$id?key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response, 1);
        return $dataResponse;
    }

    public static function confirmPaySupplier($id, $aryData) {
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/accounting/confirm_pay/{$id}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->post($site, $aryData);
        $dataResponse = json_decode($response, 1);
        return $dataResponse;
    }

    public static function getDetailPaySupplier($id, $key) {
        $site = FunctionLib::getUrlApi();
        $site .= "api/admin/accounting/detail_pay/{$id}?key={$key}";
        $curl = PlazaCurl::getInstance();
        $response = $curl->get($site);
        $dataResponse = json_decode($response, 1);
        return $dataResponse;
    }

} 