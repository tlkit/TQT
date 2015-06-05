<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 03/06/2015
 * Time: 8:14 CH
 */

class ImportController extends BaseAdminController{

    private $filename = '';

    public function __construct(){
        parent::__construct();
    }


    public function view(){
        
    }

    public function importInfo(){

        Session::forget('import');
        $providers = Providers::getListAll();
        $this->layout->content = View::make('admin.ImportLayouts.import')
            ->with('providers',$providers);
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
                ->with('providers',$providers)->with('error',$error);
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
                    'product_OriginID' => $product->product_OriginID,
                    'product_UnitID' => $product->product_UnitID,
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

}