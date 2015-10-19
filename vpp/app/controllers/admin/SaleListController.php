<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 18/10/2015
 * Time: 11:15 CH
 */
class SaleListController extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function createInfo(){

        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.ExportLayouts.sale_list')
            ->with('customers',$customers)
            ->with('customers_id',0);
    }
}