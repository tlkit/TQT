<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 03/06/2015
 * Time: 8:14 CH
 */

class ImportFakeController extends BaseAdminController{

    private $filename = '';
    private $aryStatus = array(-1 => 'Chọn trạng thái', 0 => 'Hóa đơn hủy', 1 => 'Hóa đơn bình thường');
    private $aryPayType = array(-1 => 'Chọn trạng thái', 0 => 'Đã thanh toán', 1 => 'Thanh toán công nợ');
    private $permission_view = 'import_view';
    private $permission_create = 'import_create';
    private $permission_edit = 'import_edit';
    private $permission_update_payment = 'import_update_payment';

    public function __construct(){
        parent::__construct();

    }


    public function view(){

        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $dataSearch['import_create_id'] = Request::get('import_create_id', 0);
        $dataSearch['import_code'] = Request::get('import_code', '');
        $dataSearch['import_status'] = Request::get('import_status', -1);
        $dataSearch['import_pay_type'] = Request::get('import_pay_type', -1);
        $dataSearch['providers_id'] = Request::get('providers_id', 0);
        $dataSearch['import_create_start'] = Request::get('import_create_start', '');
        $dataSearch['import_create_end'] = Request::get('import_create_end', '');
        $page_no = Request::get('page_no', 1);
        $limit = 30;
        $total = 0;
        $offset = ($page_no - 1) * $limit;
        $param = $dataSearch;
        $admin = User::getListAllUser();
        $providers = Providers::getListAll();
        $param['import_create_start'] = ($param['import_create_start'] != '') ? strtotime($param['import_create_start']) : 0;
        $param['import_create_end'] = ($param['import_create_end'] != '') ? strtotime($param['import_create_end'])+86400 : 0;
        $data = ImportFake::search($param, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';
        $this->layout->content = View::make('admin.ImportFakeLayouts.view')
            ->with('param',$dataSearch)
            ->with('data',$data)
            ->with('total', $total)
            ->with('aryStatus', $this->aryStatus)
            ->with('aryPayType', $this->aryPayType)
            ->with('admin', $admin)
            ->with('providers', $providers)
            ->with('start', ($page_no - 1) * $limit)
            ->with('paging',$paging)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
            ->with('permission_update_payment', in_array($this->permission_update_payment, $this->permission) ? 1 : 1);
    }

    public function importInfo(){

        if (!in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        Session::forget('import_fake');
        $providers = Providers::getListAll();
        $this->layout->content = View::make('admin.ImportFakeLayouts.import')
            ->with('providers',$providers)->with('providers_id',0);
    }

    public function import(){
        if (!in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $providers_id = Request::get('providers_id',0);
        $import_pay_type = Request::get('import_pay_type',0);
        $import_pay_discount_type = (int)Request::get('import_pay_discount_type',0);
        $discount_vnd = (int)Request::get('import_pay_discount_vnd',0);
        $discount_percent = Request::get('import_pay_discount_percent',0);
        $import = Session::has('import_fake') ? Session::get('import_fake') : array();
        $error = '';
        if(!$import){
            $error = 'Chưa chọn sản phẩm cần nhập';
        }
        if($providers_id == 0){
            $error = 'Chưa chọn nhà cung cấp nhập hàng';
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
                $aryImportProduct[$k]['import_product_type'] = $import_pay_type;
                $aryImportProduct[$k]['import_product_create_id'] = User::user_id();
                $aryImportProduct[$k]['import_product_create_time'] = time();
                $total += $aryImportProduct[$k]['import_product_total'];
            }
            $import_pay_discount = 0;
            if ($import_pay_discount_type == 1) {
                $import_pay_discount = (int)($total * ($discount_percent/100));
            }elseif($import_pay_discount_type == 2){
                $import_pay_discount = (int)$discount_vnd;
            }
            $count = ImportFake::getCountInDay();
            $count = $count +1;
            $num_length = strlen((string)$count);
            if ($num_length == 1) {
                $code = 'NA0' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            } else {
                $code = 'NA' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            }
            $aryImport['import_code'] = $code;
            $aryImport['providers_id'] = $providers_id;
            $aryImport['import_price'] = $total;
            $aryImport['import_status'] = 1;
            $aryImport['import_note'] = '';
            $aryImport['import_pay_discount'] = $import_pay_discount;
            $aryImport['import_pay_total'] = $total - $import_pay_discount;
            $aryImport['import_pay_type'] = $import_pay_type;
            $aryImport['import_create_id'] = User::user_id();
            $aryImport['import_create_time'] = time();
            if($import_pay_type == 0){
                $aryImport['import_pay_id'] = User::user_id();
                $aryImport['import_pay_time'] = time();
            }
            $import_id = ImportFake::add($aryImport,$aryImportProduct);
            if ($import_id) {
                Session::forget('import_fake');
                return Redirect::route("admin.import_fake_detail", array('id' => base64_encode($import_id)));
            } else {
                $error = 'Cập nhật dữ liệu không thành công ';
            }
        }

        if($error != ''){
            $providers = Providers::getListAll();
            $this->layout->content = View::make('admin.ImportFakeLayouts.import')
                ->with('providers',$providers)->with('providers_id',$providers_id)->with('error',$error);
            $provider = Providers::find($providers_id);
            $this->layout->content->provider_info = View::make('admin.ImportFakeLayouts.provider_info')->with('provider',$provider);
            $this->layout->content->product_info = View::make('admin.ImportFakeLayouts.product_info')->with('import',$import)->with('import_pay_type',$import_pay_type)->with('import_pay_discount_type',$import_pay_discount_type)->with('discount_vnd',$discount_vnd)->with('discount_percent',$discount_percent);
        }
    }

    public function addProduct(){

        $name = Request::get('name','');
        $price = Request::get('price',0);
        $num = Request::get('num',0);
        $type = (int)Request::get('type',0);
        $import_pay_discount_type = (int)Request::get('discount_type',0);
        $discount_vnd = (int)Request::get('discount_vnd',0);
        $discount_percent = Request::get('discount_percent',0);
        $product = Product::getByName($name);
        $import = Session::has('import_fake') ? Session::get('import_fake') : array();
        $error = '';
        if($num == 0){
            $error = 'Chưa chọn số lượng nhập hàng';
        }
        if($price == 0){
            $error = 'Chưa chọn giá nhập hàng';
        }
        if($name == ''){
            $error = 'Chưa chọn sản phẩm nhập kho';
        }
        if ($error == '') {
            if ($product) {
                $import[$product->product_id] = array(
                    'product_id' => $product->product_id,
                    'product_Code' => $product->product_Code,
                    'product_Name' => $product->product_Name,
                    'product_NameOrigin' => $product->product_NameOrigin,
                    'product_NameUnit' => $product->product_NameUnit,
                    'import_product_price' => $price,
                    'import_product_num' => $num,
                );
                Session::put('import_fake', $import);
            } else {
                $error = 'Sản phẩm bạn nhập không có trong hệ thống';
            }
        }
        $data['success'] = ($error == '') ? 1 : 0;
        $data['html'] = View::make('admin.ImportFakeLayouts.product_info')->with('import',$import)->with('import_pay_type',$type)->with('import_pay_discount_type',$import_pay_discount_type)->with('discount_vnd',$discount_vnd)->with('discount_percent',$discount_percent)->with('error',$error)->render();

        return Response::json($data);

    }

    public function removeProduct(){
        $product_id = Request::get('product_id',0);
        $type = (int)Request::get('type',0);
        $import_pay_discount_type = (int)Request::get('discount_type',0);
        $discount_vnd = (int)Request::get('discount_vnd',0);
        $discount_percent = Request::get('discount_percent',0);
        $import = Session::has('import_fake') ? Session::get('import_fake') : array();
        if(isset($import[$product_id])){
            unset($import[$product_id]);
        }
        Session::put('import_fake', $import);
        $data['success'] = 1;
        $data['html'] = View::make('admin.ImportFakeLayouts.product_info')->with('import',$import)->with('import_pay_type',$type)->with('import_pay_discount_type',$import_pay_discount_type)->with('discount_vnd',$discount_vnd)->with('discount_percent',$discount_percent)->render();
        return Response::json($data);
    }

    public function detail($ids){
        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = base64_decode($ids);
        $import = ImportFake::find($id);
        $providers = Providers::find($import->providers_id);
        $importProduct = $import->importproductfake;
        foreach($importProduct as $product){
            $product->product;
        }
        $this->layout->content = View::make('admin.ImportFakeLayouts.detail')->with('import',$import)->with('importProduct',$importProduct)->with('providers',$providers);
    }

    public function exportPdf($ids)
    {
        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = base64_decode($ids);
        $import = ImportFake::find($id);
        $providers = Providers::find($import->providers_id);
        $importProduct = $import->importproductfake;
        foreach($importProduct as $product){
            $product->product;
        }
        $html = View::make('admin.ImportFakeLayouts.export')->with('import',$import)->with('importProduct',$importProduct)->with('providers',$providers)->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->stream("import_f_" . $import->import_code . ".pdf");
    }

    public function remove(){
        if (!in_array($this->permission_edit, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $import_id = Request::get('import_id',0);
        $import_note = Request::get('import_note','');
        $restore = Request::get('restore',0);
        if($import_id == 0){
            $data['success'] = 0;
            $data['html'] = 'Không tìm thấy hóa đơn cần hủy';
            return Response::json($data);
        }
        $import = ImportFake::find($import_id);
        $import->import_note = $import_note;
        if($import->import_status != 1){
            $data['success'] = 0;
            $data['html'] = 'Hóa đơn này đã bị hủy trước đó';
            return Response::json($data);
        }
        $product_ids = ImportProductFake::getProductByImportId($import_id);
        $count_export = ExportProductFake::getCountExPort($product_ids,$import->import_create_time);
        if($count_export > 0){
            $data['success'] = 0;
            $data['html'] = 'Hóa đơn này không hủy được vì hàng đã xuất kho';
            return Response::json($data);
        }
        if(ImportFake::remove($import)){
            if($restore == 1){
                $data['link'] = URL::route('admin.import_fake_restore',array('id' => base64_encode($import_id)));
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
        if (!in_array($this->permission_edit, $this->permission) && !in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = base64_decode($ids);
        $import = ImportFake::find($id);
        $provider = Providers::find($import->providers_id);
        $importProduct = $import->importproductfake;
        $aryImport = array();
        foreach($importProduct as $product){
            $p = $product->product;
            $aryImport[$product->product_id] = array(
                'product_id' => $p->product_id,
                'product_Code' => $p->product_Code,
                'product_Name' => $p->product_Name,
                'product_OriginID' => $p->product_OriginID,
                'product_NameOrigin' => $p->product_NameOrigin,
                'product_UnitID' => $p->product_UnitID,
                'product_NameUnit' => $p->product_NameUnit,
                'import_product_price' => $product->import_product_price,
                'import_product_num' => $product->import_product_num,
            );
        }
        Session::put('import_fake', $aryImport);
        $providers = Providers::getListAll();
        $this->layout->content = View::make('admin.ImportFakeLayouts.import')
            ->with('providers',$providers)->with('providers_id',$import->providers_id);
        $this->layout->content->provider_info = View::make('admin.ImportFakeLayouts.provider_info')->with('provider',$provider);
        $this->layout->content->product_info = View::make('admin.ImportFakeLayouts.product_info')->with('import',$aryImport);
    }

    public function updatePayment()
    {
        $data['success'] = 0;
        $import_id = (int)Request::get('import_id', 0);
        $import = ImportFake::find($import_id);
        if (!$import) {
            $data['html'] = 'Không tìm thấy phiếu nhập cần thanh toán';
            return Response::json($data);
        }
        if ($import->import_pay_type == 0) {
            $data['html'] = 'Phiếu nhập đã được thanh toán trước đó';
            return Response::json($data);
        }
        if (ImportFake::updatePayment($import)) {
            $data['success'] = 1;
            $data['html'] = 'Cập nhật thành công';
            return Response::json($data);
        } else {
            $data['html'] = 'Cập nhật không thành công';
            return Response::json($data);
        }
    }

}