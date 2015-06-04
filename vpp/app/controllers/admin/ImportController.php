<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 03/06/2015
 * Time: 8:14 CH
 */

class ImportController extends BaseAdminController{

    public function __construct(){
        parent::__construct();
    }

    public function import(){

        $providers = Providers::getListAll();
        $this->layout->content = View::make('admin.ImportLayouts.import')
            ->with('providers',$providers);
    }

}