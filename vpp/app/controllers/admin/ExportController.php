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
            $vat = $customers->customers_IsNeededVAT ? 10 : 0;
            $export[$product->product_id] = array(
                'product_id' => $product->product_id,
                'export_product_price' => $product->product_Price,
                'export_product_num' => $num,
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

}