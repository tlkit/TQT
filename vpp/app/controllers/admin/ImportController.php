<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 03/06/2015
 * Time: 8:14 CH
 */

class ImportController extends BaseAdminController{

    private $filename = '';
    private $aryStatus = array(-1 => 'Chọn trạng thái', 0 => 'Hóa đơn hủy', 1 => 'Hóa đơn bình thường');
    private $permission_view = 'import_view';
    private $permission_create = 'import_create';
    private $permission_edit = 'import_edit';

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
        $param['import_create_end'] = ($param['import_create_end'] != '') ? strtotime($param['import_create_end']) : 0;
        $data = Import::search($param, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';
        $this->layout->content = View::make('admin.ImportLayouts.view')
            ->with('param',$dataSearch)
            ->with('data',$data)
            ->with('total', $total)
            ->with('aryStatus', $this->aryStatus)
            ->with('admin', $admin)
            ->with('providers', $providers)
            ->with('start', ($page_no - 1) * $limit)
            ->with('paging',$paging)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 1)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 1);
    }

    public function importInfo(){

        Session::forget('import');
        $providers = Providers::getListAll();
        $this->layout->content = View::make('admin.ImportLayouts.import')
            ->with('providers',$providers)->with('providers_id',0);
    }

    public function import(){
        $providers_id = Request::get('providers_id',0);
        $import = Session::has('import') ? Session::get('import') : array();
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

        $name = Request::get('name','');
        $price = Request::get('price',0);
        $num = Request::get('num',0);
        $product = Product::getByName($name);
        $import = Session::has('import') ? Session::get('import') : array();
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
                Session::put('import', $import);
            } else {
                $error = 'Sản phẩm bạn nhập không có trong hệ thống';
            }
        }
        $data['success'] = ($error == '') ? 1 : 0;
        $data['html'] = View::make('admin.ImportLayouts.product_info')->with('import',$import)->with('error',$error)->render();

        return Response::json($data);

    }

    public function removeProduct(){
        $product_id = Request::get('product_id',0);
        $import = Session::has('import') ? Session::get('import') : array();
        if(isset($import[$product_id])){
            unset($import[$product_id]);
        }
        Session::put('import', $import);
        $data['success'] = 1;
        $data['html'] = View::make('admin.ImportLayouts.product_info')->with('import',$import)->render();
        return Response::json($data);
    }

    public function detail($ids){
        $id = base64_decode($ids);
        $import = Import::find($id);
        $providers = Providers::find($import->providers_id);
        $importProduct = $import->importproduct;
        foreach($importProduct as $product){
            $product->product;
        }
        $this->layout->content = View::make('admin.ImportLayouts.detail')->with('import',$import)->with('importProduct',$importProduct)->with('providers',$providers);
    }

    public function exportPdf($ids)
    {
        $id = base64_decode($ids);
        $import = Import::find($id);
        $providers = Providers::find($import->providers_id);
        $importProduct = $import->importproduct;
        foreach($importProduct as $product){
            $product->product;
        }
        $html = View::make('admin.ImportLayouts.export')->with('import',$import)->with('importProduct',$importProduct)->with('providers',$providers)->render();
        $signature = false;
        $this->filename = "import_" . $import->import_code . ".pdf";
        $this->pdfOutput($html, $this->filename, 'I', $signature);
    }

    function pdfOutput($html, $filename, $outputType = 'I', $signature = false){
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'px', PDF_PAGE_FORMAT, true, 'UTF-8', false, false, $signature);
        // set document information
        $pdf->SetCreator('System');
        $pdf->SetAuthor('TQT');
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('TQT, import');
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->setFontSubsetting(false);
        $pdf->SetMargins(30, 15, 30);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        $pdf->SetCellPaddings(0);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setFormDefaultProp(array('lineWidth'=>0, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 255), 'strokeColor'=>array(255, 255, 255)));
        // set font
        $pdf->SetFont('freeserif', '', 10);
        // add a page
        $pdf->AddPage();
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        // reset pointer to the last page
        $pdf->lastPage();
        //Close and output PDF document
        $pdf->Output($filename, $outputType);
    }

    public function remove(){
        $import_id = Request::get('import_id',0);
        $import_note = Request::get('import_note','');
        $restore = Request::get('restore',0);
        if($import_id == 0){
            $data['success'] = 0;
            $data['html'] = 'Không tìm thấy hóa đơn cần hủy';
            return Response::json($data);
        }
        $import = Import::find($import_id);
        $import->import_note = $import_note;
        if($import->import_status != 1){
            $data['success'] = 0;
            $data['html'] = 'Hóa đơn này đã bị hủy trước đó';
            return Response::json($data);
        }
        if(Import::remove($import)){
            if($restore == 1){
                $data['link'] = URL::route('admin.import_restore',array('id' => base64_encode($import_id)));
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
        $id = base64_decode($ids);
        $import = Import::find($id);
        $provider = Providers::find($import->providers_id);
        $importProduct = $import->importproduct;
        $aryImport = array();
        foreach($importProduct as $product){
            $p = $product->product;
            $aryImport[$product->product_id] = array(
                'product_id' => $p->product_id,
                'product_Code' => $p->product_Code,
                'product_Name' => $p->product_Name,
                'product_OriginID' => $p->product_OriginID,
                'product_UnitID' => $p->product_UnitID,
                'import_product_price' => $product->import_product_price,
                'import_product_num' => $product->import_product_num,
            );
        }
        Session::put('import', $aryImport);
        $providers = Providers::getListAll();
        $this->layout->content = View::make('admin.ImportLayouts.import')
            ->with('providers',$providers)->with('providers_id',$import->providers_id);
        $this->layout->content->provider_info = View::make('admin.ImportLayouts.provider_info')->with('provider',$provider);
        $this->layout->content->product_info = View::make('admin.ImportLayouts.product_info')->with('import',$aryImport);
    }

}