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
        $this->layout->content = View::make('admin.ExportLayouts.export');
    }

}