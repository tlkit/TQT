<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 07/06/2015
 * Time: 9:41 CH
 */

class ExportController extends BaseAdminController{

    public function __construct(){
        parent::__construct();

    }

    public function exportInfo(){
        Session::forget('export');
        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.ExportLayouts.export')
            ->with('customers',$customers)->with('customers_id',0);
    }

    public function export(){
        $customers_id = Request::get('customers_id');
        echo $customers_id;die;
    }

}