<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 14/06/2015
 * Time: 6:28 CH
 */

class ReportController extends BaseAdminController{

    public function __construct(){
        parent::__construct();

    }

    public function reportCustomer(){
        $param['customers_id'] = Request::get('customers_id',0);
        $param['export_create_start'] = Request::get('export_create_start','');
        $param['export_create_end'] = Request::get('export_create_start','');

        $input = $param;
        $input['export_create_start'] = ($input['export_create_start'] != '') ? strtotime($input['export_create_start']) : 0;
        $input['export_create_end'] = ($input['export_create_end'] != '') ? strtotime($input['export_create_end'])+86400 : 0;
        $data = Customers::reportCustomer($input);
        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.ReportLayouts.customer')->with('param',$param)->with('data',$data)->with('customers',$customers);
    }

    public function reportProductHot(){
//        $param['customers_id'] = Request::get('customers_id',0);
        $param['export_product_create_start'] = Request::get('export_product_create_start','');
        $param['export_product_create_end'] = Request::get('export_product_create_end','');

        $input = $param;
        $input['export_product_create_start'] = ($input['export_product_create_start'] != '') ? strtotime($input['export_product_create_start']) : 0;
        $input['export_product_create_end'] = ($input['export_product_create_end'] != '') ? strtotime($input['export_product_create_end'])+86400 : 0;
        $data = Product::reportProductHot($input);
        $this->layout->content = View::make('admin.ReportLayouts.product')->with('param',$param)->with('data',$data);
    }

    public function reportImport(){
        $param['import_product_create_start'] = Request::get('import_product_create_start','');
        $param['import_product_create_end'] = Request::get('import_product_create_end','');
        $param['product_id'] = (int)Request::get('product_id',0);
        $param['providers_id'] = (int)Request::get('providers_id',0);
        $input = $param;
        $input['import_product_create_start'] = ($input['import_product_create_start'] != '') ? strtotime($input['import_product_create_start']) : 0;
        $input['import_product_create_end'] = ($input['import_product_create_end'] != '') ? strtotime($input['import_product_create_end'])+86400 : 0;
        $data = ImportProduct::reportImport($input);
        $provider = Providers::getListAll();
        $product = Product::getListAll();
        $this->layout->content = View::make('admin.ReportLayouts.import')
            ->with('provider',$provider)
            ->with('product',$product)
            ->with('param',$param)
            ->with('data',$data);

    }

    public function reportExport(){
        $param['export_product_create_start'] = Request::get('export_product_create_start','');
        $param['export_product_create_end'] = Request::get('export_product_create_end','');
        $param['product_id'] = (int)Request::get('product_id',0);
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $input = $param;
        $input['export_product_create_start'] = ($input['export_product_create_start'] != '') ? strtotime($input['export_product_create_start']) : 0;
        $input['export_product_create_end'] = ($input['export_product_create_end'] != '') ? strtotime($input['export_product_create_end'])+86400 : 0;
        $data = ExportProduct::reportExport($input);
        $customer = Customers::getListAll();
        $product = Product::getListAll();
        $this->layout->content = View::make('admin.ReportLayouts.export')
            ->with('customer',$customer)
            ->with('product',$product)
            ->with('param',$param)
            ->with('data',$data);

    }

    public function reportDiscount(){
        $param['export_create_start'] = Request::get('export_create_start','');
        $param['export_create_end'] = Request::get('export_create_end','');
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $input = $param;
        $input['export_create_start'] = ($input['export_create_start'] != '') ? strtotime($input['export_create_start']) : 0;
        $input['export_create_end'] = ($input['export_create_end'] != '') ? strtotime($input['export_create_end'])+86400 : 0;
        $data = Export::reportDiscount($input);
        $customer = Customers::getListAll();
        $this->layout->content = View::make('admin.ReportLayouts.discount')
            ->with('customer',$customer)
            ->with('param',$param)
            ->with('data',$data);

    }

    public function reportSaleList(){
        $param['export_product_create_start'] = Request::get('export_product_create_start','');
        $param['export_product_create_end'] = Request::get('export_product_create_end','');
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $input = $param;
        $input['export_product_create_start'] = ($input['export_product_create_start'] != '') ? strtotime($input['export_product_create_start']) : 0;
        $input['export_product_create_end'] = ($input['export_product_create_end'] != '') ? strtotime($input['export_product_create_end'])+86400 : 0;
        $data = ExportProduct::reportSaleList($input);
        $customer = Customers::getListAll();
        $this->layout->content = View::make('admin.ReportLayouts.sale_list')
            ->with('customer',$customer)
            ->with('param',$param)
            ->with('data',$data);

    }
}