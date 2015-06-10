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
        $export = Session::has('export') ? Session::get('export') : array();
        $error = array();
        if(!$export){
            $error[] = 'Chưa chọn sản phẩm cần xuất';
        }
        if($customers_id == 0){
            $error = 'Chưa chọn khách hàng';
        }
        if($error == ''){
            $aryImport = $aryImportProduct = array();
            $total = 0;
            foreach ($import as $k => $v) {
                $aryImportProduct[$k]['product_id'] = $v['product_id'];
                $aryImportProduct[$k]['providers_id'] = $providers_id;
                $aryImportProduct[$k]['import_product_price'] = $v['import_product_price'];
                $aryImportProduct[$k]['import_product_num'] = $v['import_product_num'];
                $aryImportProduct[$k]['import_product_total'] = $v['import_product_num'] * $v['import_product_price'];
                $aryImportProduct[$k]['import_product_status'] = 1;
                $aryImportProduct[$k]['import_product_create_id'] = User::user_id();
                $aryImportProduct[$k]['import_product_create_time'] = time();
                $total += $aryImportProduct[$k]['import_product_total'];
            }


            $count = Import::getCountInDay();
            $count = $count +1;
            $num_length = strlen((string)$count);
            if ($num_length == 1) {
                $code = 'N0' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            } else {
                $code = 'N' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            }
            $aryImport['import_code'] = $code;
            $aryImport['providers_id'] = $providers_id;
            $aryImport['import_price'] = $total;
            $aryImport['import_status'] = 1;
            $aryImport['import_note'] = '';
            $aryImport['import_create_id'] = User::user_id();
            $aryImport['import_create_time'] = time();
            $import_id = Import::add($aryImport,$aryImportProduct);
            if ($import_id) {
                Session::forget('import');
                return Redirect::route("admin.import_detail", array('id' => base64_encode($import_id)));
            } else {
                $error = 'Cập nhật dữ liệu không thành công ';
            }
        }

        if($error != ''){
            $providers = Providers::getListAll();
            $this->layout->content = View::make('admin.ImportLayouts.import')
                ->with('providers',$providers)->with('providers_id',$providers_id)->with('error',$error);
            $provider = Providers::find($providers_id);
            $this->layout->content->provider_info = View::make('admin.ImportLayouts.provider_info')->with('provider',$provider);
            $this->layout->content->product_info = View::make('admin.ImportLayouts.product_info')->with('import',$import);
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

}