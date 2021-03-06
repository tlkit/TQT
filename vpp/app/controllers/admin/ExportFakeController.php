<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 07/06/2015
 * Time: 9:41 CH
 */

class ExportFakeController extends BaseAdminController{

    private $aryStatus = array(-1 => 'Chọn trạng thái', 0 => 'Hóa đơn hủy', 1 => 'Hóa đơn bình thường');
    private $permission_view = 'export_view';
    private $permission_create = 'export_create';
    private $permission_edit = 'export_edit';

    public function __construct(){
        parent::__construct();

    }

    public function view(){

        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $dataSearch['export_create_id'] = Request::get('export_create_id', 0);
        $dataSearch['export_code'] = Request::get('export_code', '');
        $dataSearch['export_status'] = Request::get('export_status', -1);
        $dataSearch['customers_id'] = Request::get('customers_id', 0);
        $dataSearch['export_user_store'] = Request::get('export_user_store', 0);
        $dataSearch['export_user_cod'] = Request::get('export_user_cod', 0);
        $dataSearch['export_create_start'] = Request::get('export_create_start', '');
        $dataSearch['export_create_end'] = Request::get('export_create_end', '');
        $page_no = Request::get('page_no', 1);
        $limit = 30;
        $total = 0;
        $offset = ($page_no - 1) * $limit;
        $param = $dataSearch;
        $admin = User::getListAllUser();
        $customers = Customers::getListAll();
        $param['export_create_start'] = ($param['export_create_start'] != '') ? strtotime($param['export_create_start']) : 0;
        $param['export_create_end'] = ($param['export_create_end'] != '') ? strtotime($param['export_create_end'])+86400 : 0;
//        echo '<pre>';
//        print_r($param);die;
        $data = ExportFake::search($param, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';
        $this->layout->content = View::make('admin.ExportFakeLayouts.view')
            ->with('param',$dataSearch)
            ->with('data',$data)
            ->with('total', $total)
            ->with('aryStatus', $this->aryStatus)
            ->with('admin', $admin)
            ->with('customers', $customers)
            ->with('start', ($page_no - 1) * $limit)
            ->with('paging',$paging)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0);
    }

    public function exportInfo(){
        if (!in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        Session::forget('export_fake');
        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.ExportFakeLayouts.export')
            ->with('customers',$customers)->with('customers_id',0);
    }

    public function export(){
        if (!in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
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
        $param['export_pay_type'] = (int)Request::get('export_pay_type',0);
        $export = Session::has('export_fake') ? Session::get('export_fake') : array();
        $error = '';
        if(!$export){
            $error = 'Chưa chọn sản phẩm cần xuất';
        }
        if($customers_id == 0){
            $error = 'Chưa chọn khách hàng';
        }
        $vat = 0;
        if($customers_id > 0){
            $customer = Customers::find($customers_id);
            $vat = $customer->customers_IsNeededVAT ? 10 : 0;
        }
        if($error == ''){
            $aryExport = $aryExportProduct = array();
            $total = $total_discount = $total_discount_customer = $price_origin = 0;
            foreach ($export as $k => $v) {
                $aryExportProduct[$k]['product_id'] = $v['product_id'];
                $aryExportProduct[$k]['customers_id'] = $customers_id;
                $aryExportProduct[$k]['export_product_price'] = $v['export_product_price'];
                $aryExportProduct[$k]['export_product_num'] = $v['export_product_num'];
                $aryExportProduct[$k]['export_product_price_origin'] = $v['export_product_price_origin'];
//                $aryExportProduct[$k]['export_product_subtotal'] = $v['export_product_num']* $v['export_product_price'];
                $aryExportProduct[$k]['export_product_discount'] = $v['export_product_discount'];
                $aryExportProduct[$k]['export_product_discount_customer'] = $v['export_product_discount_customer'];
                $aryExportProduct[$k]['export_product_total'] = $v['export_product_num']* $v['export_product_price'];
                $aryExportProduct[$k]['export_product_status'] = 1;
                $aryExportProduct[$k]['export_product_type'] = $param['export_pay_type'];
                $aryExportProduct[$k]['export_product_create_id'] = User::user_id();
                $aryExportProduct[$k]['export_product_create_time'] = time();
                $total += $aryExportProduct[$k]['export_product_total'];
                $total_discount += $aryExportProduct[$k]['export_product_discount'];
                $total_discount_customer += $aryExportProduct[$k]['export_product_discount_customer'];
                $price_origin += $aryExportProduct[$k]['export_product_price_origin'];
            }


            $count = ExportFake::getCountInDay();
            $count = $count +1;
            $num_length = strlen((string)$count);
            if ($num_length == 1) {
                $code = 'XA0' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            } else {
                $code = 'XA' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            }
            $aryExport['export_code'] = $code;
            $aryExport['customers_id'] = $customers_id;
            $aryExport['export_customers_address'] = $param['export_customers_address'];
            $aryExport['export_customers_name'] = $param['export_customers_name'];
            $aryExport['export_customer_phone'] = $param['export_customer_phone'];
            $aryExport['export_customers_note'] = $param['export_customers_note'];
            $aryExport['export_pay_type'] = $param['export_pay_type'];
            $aryExport['export_delivery_time'] = strtotime($param['export_delivery_time']);
            $aryExport['export_user_store'] = $param['export_user_store'];
            $aryExport['export_user_cod'] = $param['export_user_cod'];
            $aryExport['export_user_customer'] = $param['export_user_customer'];
            $aryExport['export_subtotal'] = $total;
            $aryExport['export_total'] = $total - $total_discount;
            $aryExport['export_total_pay'] = $aryExport['export_total'] + (int)($aryExport['export_total']*($vat/100));
            $aryExport['export_discount'] = $total_discount;
            $aryExport['export_discount_customer'] = $total_discount_customer;
            $aryExport['export_vat'] = (int)($aryExport['export_total']*($vat/100));
            $aryExport['export_price_origin'] = $price_origin;
            $aryExport['export_status'] = 1;
            $aryExport['export_create_id'] = User::user_id();
            $aryExport['export_create_time'] = time();
            $export_id = ExportFake::add($aryExport,$aryExportProduct);
            if ($export_id) {
                Session::forget('export_fake');
                return Redirect::route("admin.export_fake_detail", array('id' => base64_encode($export_id)));
            } else {
                $error = 'Cập nhật dữ liệu không thành công ';
            }
        }

        if($error != ''){
            $customers = Customers::getListAll();
            $this->layout->content = View::make('admin.ExportFakeLayouts.export')
                ->with('customers',$customers)->with('customers_id',$customers_id);
            $admin = User::getListAllUser();
            if($customers_id > 0){
                $this->layout->content->customer_info = View::make('admin.ExportFakeLayouts.customer_info')->with('customers',$param)->with('admin',$admin);
                $this->layout->content->product_info = View::make('admin.ExportFakeLayouts.product_info')->with('export',$export)->with('vat',$vat);
            }
        }
    }

    public function addProduct(){
        $customers_id = (int)Request::get('customers_id',0);
        $name = Request::get('name','');
        $num = (int)Request::get('num',0);
        $vat = 0;
        $product = Product::getByName($name);
        $customers = Customers::find($customers_id);
        $export = Session::has('export_fake') ? Session::get('export_fake') : array();
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
        }else{
            if($num > $product->product_Quantity_Fake){
                $error = 'Số lượng hàng trong kho không đủ';
            }
        }
        if ($error == '') {
            $category_price_hide_discount = $category_price_discount = 0;
            $product_customer = ProductsCustomers::getByProductAndCustomerId($product->product_id,$customers_id);
            if(isset($product_customer->product_price_discount) && $product_customer->product_price_discount > 0){
                $product->product_Price = $product_customer->product_price_discount;
            }
            $category_customer = CategoriesCustomers::getByCategoryAndCustomerId($product->product_Category,$customers_id);
            if(isset($category_customer->category_price_hide_discount) && $category_customer->category_price_hide_discount > 0){
                $category_price_hide_discount = $category_customer->category_price_hide_discount;
            }
            if(isset($category_customer->category_price_discount) && $category_customer->category_price_discount > 0){
                $category_price_discount = $category_customer->category_price_discount;
            }
            $vat = $customers->customers_IsNeededVAT ? 10 : 0;
            $import = ImportProductFake::getByProductId($product->product_id);
            $aryStore = array();
            $price_input = 0;
            if($import){
                $x = $y = $i =0;
                foreach($import as $k => $v){
                    if($x < $product->product_Quantity_Fake){
                        $y = $x;
                        $x += $v['import_product_num'];
                        $aryStore[$i]['num'] = ($x <= $product->product_Quantity_Fake) ? $v['import_product_num'] : ($product->product_Quantity_Fake - $y);
                        $aryStore[$i]['price'] = $v['import_product_price'];
                        $i++;
                    }
                }
                krsort($aryStore);
                $aryStore = array_values($aryStore);
                $temp = $num;
                foreach($aryStore as $k => $v){
                    if($temp > 0){
                        $price_input += ($temp <= $v['num']) ? ($temp*$v['price']) : ($v['num']*$v['price']);
                        $temp = $temp - $v['num'];
                    }
                }
            }
            $export[$product->product_id] = array(
                'product_id' => $product->product_id,
                'export_product_price' => $product->product_Price,
                'export_product_num' => $num,
                'export_product_price_origin' => $price_input,
                'export_product_discount' => (int)($product->product_Price * $num * ($category_price_discount/100)),
                'export_product_discount_customer' => (int)($product->product_Price * $num * ($category_price_hide_discount/100)),
                'product_Name' => $product->product_Name,
                'product_Code' => $product->product_Code,
                'product_NameOrigin' => $product->product_NameOrigin,
                'product_NameUnit' => $product->product_NameUnit,
            );
//            echo '<pre>';
//            print_r($export);
//            echo '<pre>';die;
            Session::put('export_fake', $export);
        }
        $data['success'] = ($error == '') ? 1 : 0;
        $data['html'] = View::make('admin.ExportFakeLayouts.product_info')->with('export',$export)->with('vat',$vat)->with('error',$error)->render();

        return Response::json($data);

    }

    public function removeProduct(){
        $product_id = Request::get('product_id',0);
        $customers_id = (int)Request::get('customers_id',0);
        $customers = Customers::find($customers_id);
        $vat = $customers->customers_IsNeededVAT ? 10 : 0;
        $export = Session::has('export_fake') ? Session::get('export_fake') : array();
        if(isset($export[$product_id])){
            unset($export[$product_id]);
        }
        Session::put('export_fake', $export);
        $data['success'] = 1;
        $data['html'] = View::make('admin.ExportFakeLayouts.product_info')->with('export',$export)->with('vat',$vat)->render();
        return Response::json($data);
    }

    public function detail($ids){
        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = base64_decode($ids);
        $export = ExportFake::find($id);
//        $providers = Providers::find($import->providers_id);
        $exportProduct = $export->exportproductfake;
        foreach($exportProduct as $product){
            $product->product;
        }
        $this->layout->content = View::make('admin.ExportFakeLayouts.detail')->with('export',$export)->with('exportProduct',$exportProduct);
    }

    public function exportPdf($ids)
    {
        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = base64_decode($ids);
        $export = ExportFake::find($id);
//        $providers = Providers::find($import->providers_id);
        $exportProduct = $export->exportproductfake;
        foreach($exportProduct as $product){
            $product->product;
        }
        $html = View::make('admin.ExportFakeLayouts.exportpdf')->with('export',$export)->with('exportProduct',$exportProduct)->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->stream("export_f_" . $export->export_code . ".pdf");
    }

    public function remove(){
        if (!in_array($this->permission_edit, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $export_id = Request::get('export_id',0);
        $export_note = Request::get('export_note','');
        $restore = Request::get('restore',0);
        if($export_id == 0){
            $data['success'] = 0;
            $data['html'] = 'Không tìm thấy hóa đơn cần hủy';
            return Response::json($data);
        }
        $export = ExportFake::find($export_id);
        $export->export_note = $export_note;
        if($export->export_status != 1){
            $data['success'] = 0;
            $data['html'] = 'Hóa đơn này đã bị hủy trước đó';
            return Response::json($data);
        }
        if($export->sale_list_id > 0){
            $data['success'] = 0;
            $data['html'] = 'Hóa đơn này đã tạo bảng kê không thể hủy';
            return Response::json($data);
        }
        if(ExportFake::remove($export)){
            if($restore == 1){
                $data['link'] = URL::route('admin.export_fake_restore',array('id' => base64_encode($export_id)));
            }
            $data['success'] = 1;
            $data['html'] = 'Hủy hóa đơn thành công';
            return Response::json($data);
        }else{
            $data['success'] = 0;
            $data['html'] = 'Lỗi cập nhật hệ thống. Vui lòng thử lại';
            return Response::json($data);
        }

    }

    public function restore($ids){
        if (!in_array($this->permission_create, $this->permission) && !in_array($this->permission_edit, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = base64_decode($ids);
        $export = ExportFake::find($id);
        $customer = Customers::find($export->customers_id);
        $exportProduct = $export->exportproductfake;
        $aryExport = array();
        $vat = 0;
        foreach($exportProduct as $product){
            $p = $product->product;
            $category_price_hide_discount = $category_price_discount = 0;
            $product_customer = ProductsCustomers::getByProductAndCustomerId($product->product_id,$export->customers_id);
            if(isset($product_customer->product_price_discount) && $product_customer->product_price_discount > 0){
                $p->product_Price = $product_customer->product_price_discount;
            }
            $category_customer = CategoriesCustomers::getByCategoryAndCustomerId($product->product_Category,$export->customers_id);
            if(isset($category_customer->category_price_hide_discount) && $category_customer->category_price_hide_discount > 0){
                $category_price_hide_discount = $category_customer->category_price_hide_discount;
            }
            if(isset($category_customer->category_price_discount) && $category_customer->category_price_discount > 0){
                $category_price_discount = $category_customer->category_price_discount;
            }
            $vat = $customer->customers_IsNeededVAT ? 10 : 0;
            $aryExport[$product->product_id] = array(
                'product_id' => $p->product_id,
                'export_product_price' => $p->product_Price,
                'export_product_num' => $product->export_product_num,
                'export_product_price_origin' => $product->export_product_price_origin,
                'export_product_discount' => (int)($p->product_Price * $product->export_product_num * $category_price_discount),
                'export_product_discount_customer' => (int)($p->product_Price * $product->export_product_num * $category_price_hide_discount),
                'product_Name' => $p->product_Name,
                'product_Code' => $p->product_Code,
                'product_NameOrigin' => $p->product_NameOrigin,
                'product_NameUnit' => $p->product_NameUnit,
            );
        }
        Session::put('export_fake', $aryExport);
        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.ExportFakeLayouts.export')
            ->with('customers',$customers)->with('customers_id',$export->customers_id);
        $admin = User::getListAllUser();
        $export['export_delivery_time'] = ($export['export_delivery_time'] > 0 ) ? date('d-m-Y',$export['export_delivery_time']) : '';
        $this->layout->content->customer_info = View::make('admin.ExportFakeLayouts.customer_info')->with('customers',$export)->with('admin',$admin);
        $this->layout->content->product_info = View::make('admin.ExportFakeLayouts.product_info')->with('export',$aryExport)->with('vat',$vat);
//        $this->layout->content = View::make('admin.ImportLayouts.import')
//            ->with('providers',$providers)->with('providers_id',$import->providers_id);
//        $this->layout->content->provider_info = View::make('admin.ImportLayouts.provider_info')->with('provider',$provider);
//        $this->layout->content->product_info = View::make('admin.ImportLayouts.product_info')->with('import',$aryImport);
    }

    public function getExportForSale(){
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $param['export_pay_type'] = (int)Request::get('export_pay_type',0);
        $param['export_create_start'] = Request::get('export_create_start','');
        $param['export_create_end'] = Request::get('export_create_end','');
        $param['export_create_start'] = ($param['export_create_start'] != '') ? strtotime($param['export_create_start']) : 0;
        $param['export_create_end'] = ($param['export_create_end'] != '') ? strtotime($param['export_create_end'])+86400 : 0;
        $data['success'] = 0;
        if($param['customers_id'] == 0){
            $data['html'] = '<div class="alert alert-danger">Chưa chọn khách hàng</div>';
            return Response::json($data);
        }
        $export = ExportFake::getExportForSale($param);
        $admin = User::getListAllUser();
        $html = View::make('admin.SaleListLayouts.export_sale')->with('export',$export)->with('admin',$admin)->render();
        $data['html'] = $html;
        return Response::json($data);
    }

}