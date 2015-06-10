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
        $customers_id = (int)Request::get('customers_id');
        $param['export_customers_name'] = Request::get('export_customers_name','');
        $param['export_customers_code'] = Request::get('export_customers_code','');
        $param['export_customers_address'] = Request::get('export_customers_address','');
        $param['export_user_store'] = (int)Request::get('export_user_store',0);
        $param['export_user_cod'] = (int)Request::get('export_user_cod',0);
        $param['export_delivery_time'] = Request::get('export_delivery_time','');
        $param['export_user_customer'] = Request::get('export_user_customer','');
        $param['export_customer_phone'] = Request::get('export_customer_phone','');
        $param['export_customers_note'] = Request::get('export_customers_note','');
        $export = Session::has('export') ? Session::get('export') : array();
        $error = '';
        if(!$export){
            $error = 'Chưa chọn sản phẩm cần xuất';
        }
        if($customers_id == 0){
            $error = 'Chưa chọn khách hàng';
        }
        if($customers_id > 0){
            $customer = Customers::find($customers_id);
            $vat = $customer->customers_IsNeededVAT ? 10 : 0;
        }
        if($error == ''){

            $aryExport = $aryExportProduct = array();
            $total = $total_discount = $total_discount_customer = 0;
            foreach ($export as $k => $v) {
                $aryExportProduct[$k]['product_id'] = $v['product_id'];
                $aryExportProduct[$k]['customers_id'] = $customers_id;
                $aryExportProduct[$k]['export_product_price'] = $v['export_product_price'];
                $aryExportProduct[$k]['export_product_num'] = $v['export_product_num'];
//                $aryExportProduct[$k]['export_product_subtotal'] = $v['export_product_num']* $v['export_product_price'];
                $aryExportProduct[$k]['export_product_discount'] = $v['export_product_discount'];
                $aryExportProduct[$k]['export_product_discount_customer'] = $v['export_product_discount_customer'];
                $aryExportProduct[$k]['export_product_total'] = $v['export_product_num']* $v['export_product_price'];
                $aryExportProduct[$k]['export_product_status'] = 1;
                $aryExportProduct[$k]['export_product_create_id'] = User::user_id();
                $aryExportProduct[$k]['export_product_create_time'] = time();
                $total += $aryExportProduct[$k]['export_product_total'];
                $total_discount += $aryExportProduct[$k]['export_product_discount'];
                $total_discount_customer += $aryExportProduct[$k]['export_product_discount_customer'];
            }


            $count = Export::getCountInDay();
            $count = $count +1;
            $num_length = strlen((string)$count);
            if ($num_length == 1) {
                $code = 'X0' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            } else {
                $code = 'X' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            }
            $aryExport['export_code'] = $code;
            $aryExport['customers_id'] = $customers_id;
            $aryExport['export_customers_address'] = $param['export_customers_address'];
            $aryExport['export_customers_name'] = $param['export_customers_name'];
            $aryExport['export_customer_phone'] = $param['export_customer_phone'];
            $aryExport['export_customers_note'] = $param['export_customers_note'];
            $aryExport['export_delivery_time'] = strtotime($param['export_delivery_time']);
            $aryExport['export_user_store'] = $param['export_user_store'];
            $aryExport['export_user_cod'] = $param['export_user_cod'];
            $aryExport['export_user_customer'] = $param['export_user_customer'];
            $aryExport['export_subtotal'] = $total;
            $aryExport['export_total'] = $total - $total_discount;
            $aryExport['export_total_pay'] = $aryExport['export_total'] + $aryExport['export_total']*$vat/100;
            $aryExport['export_discount'] = $total_discount;
            $aryExport['export_discount_customer'] = $total_discount_customer;
            $aryExport['export_vat'] = $aryExport['export_total']*$vat/100;
            $aryExport['export_status'] = 1;
            $aryExport['export_create_id'] = User::user_id();
            $aryExport['export_create_time'] = time();
            $export_id = Export::add($aryExport,$aryExportProduct);
            if ($export_id) {
                Session::forget('export');
                return Redirect::route("admin.export_detail", array('id' => base64_encode($export_id)));
            } else {
                $error = 'Cập nhật dữ liệu không thành công ';
            }
        }

        if($error != ''){
            $customers = Customers::getListAll();
            $this->layout->content = View::make('admin.ExportLayouts.export')
                ->with('customers',$customers)->with('customers_id',$customers_id);
            $admin = User::getListAllUser();
//            if($customers_id > 0){
//                $this->layout->content->customer_info = View::make('admin.ExportLayouts.customer_info')->with('customers',$param)->with('admin',$admin);
//                $this->layout->content->product_info = View::make('admin.ExportLayouts.product_info')->with('export',$export)->with('vat',$vat);
//            }
        }
    }

    public function addProduct(){
        $customers_id = (int)Request::get('customers_id',0);
        $name = Request::get('name','');
        $num = (int)Request::get('num',0);
        $vat = 0;
        $product = Product::getByName($name);
        $customers = Customers::find($customers_id);
        $export = Session::has('export') ? Session::get('export') : array();
        $error = '';
        if(!$customers){
            $error = 'Không tìm thấy thông tin khách hàng';
        }
        if($num == 0){
            $error = 'Chưa chọn số lượng xuất kho';
        }
        if($name == ''){
            $error = 'Chưa chọn sản phẩm xuất kho';
        }
        if(!$product){
            $error = 'Không tìm thấy sản phẩm cần xuất kho';
        }
        if($num > $product->product_Quantity){
            $error = 'Số lượng hàng trong kho không đủ';
        }
        if ($error == '') {
            $category_price_hide_discount = $category_price_discount = 0;
            $product_customer = ProductsCustomers::getByProductAndCustomerId($product->product_id,$customers_id);
            if(isset($product_customer->product_price_discount) && $product_customer->product_price_discount > 0){
                $product->product_Price = $product_customer->product_price_discount;
            }
            $category_customer = CategoriesCustomers::getByCategoryAndCustomerId($product->product_Category,$customers_id);
            if(isset($category_customer->category_price_hide_discount) && $category_customer->category_price_hide_discount > 0){
                $category_price_hide_discount = $product_customer->category_price_hide_discount;
            }
            if(isset($category_customer->category_price_discount) && $category_customer->category_price_discount > 0){
                $category_price_discount = $product_customer->category_price_discount;
            }
            $vat = $customers->customers_IsNeededVAT ? 10 : 0;
            $export[$product->product_id] = array(
                'product_id' => $product->product_id,
                'export_product_price' => $product->product_Price,
                'export_product_num' => $num,
                'export_product_discount' => (int)($product->product_Price * $num * $category_price_discount),
                'export_product_discount_customer' => (int)($product->product_Price * $num * $category_price_hide_discount),
                'product_Name' => $product->product_Name,
                'product_Code' => $product->product_Code,
                'product_NameOrigin' => $product->product_NameOrigin,
                'product_NameUnit' => $product->product_NameUnit,
            );
            Session::put('export', $export);
        }
        $data['success'] = ($error == '') ? 1 : 0;
        $data['html'] = View::make('admin.ExportLayouts.product_info')->with('export',$export)->with('vat',$vat)->with('error',$error)->render();

        return Response::json($data);

    }

    public function removeProduct(){
        $product_id = Request::get('product_id',0);
        $customers_id = (int)Request::get('customers_id',0);
        $customers = Customers::find($customers_id);
        $vat = $customers->customers_IsNeededVAT ? 10 : 0;
        $export = Session::has('export') ? Session::get('export') : array();
        if(isset($export[$product_id])){
            unset($export[$product_id]);
        }
        Session::put('export', $export);
        $data['success'] = 1;
        $data['html'] = View::make('admin.ExportLayouts.product_info')->with('export',$export)->with('vat',$vat)->render();
        return Response::json($data);
    }

    public function detail($ids){
        $id = base64_decode($ids);
        echo $id;die;
//        $import = Import::find($id);
//        $providers = Providers::find($import->providers_id);
//        $importProduct = $import->importproduct;
//        foreach($importProduct as $product){
//            $product->product;
//        }
//        $this->layout->content = View::make('admin.ImportLayouts.detail')->with('import',$import)->with('importProduct',$importProduct)->with('providers',$providers);
    }

}