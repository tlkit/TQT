<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 14/06/2015
 * Time: 6:28 CH
 */

class ReportController extends BaseAdminController{

    private $filename = '';
    private $permission_report_customer = 'report_customer';
    private $permission_report_product_hot = 'report_product_hot';
    private $permission_report_import = 'report_import';
    private $permission_report_export = 'report_export';
    private $permission_report_discount = 'report_discount';
    private $permission_report_sale_list = 'report_sale_list';
    private $permission_report_store = 'report_store';
    public function __construct(){
        parent::__construct();

    }

    /*****************************************************************************************
     * Thống kê khách hàng
     * ******************************************************************************************/
    public function reportCustomer(){
        if (!in_array($this->permission_report_customer, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['customers_id'] = Request::get('customers_id',0);
        $param['customers_ManagedBy'] = Request::get('customers_ManagedBy',0);
        $param['export_create_start'] = Request::get('export_create_start','');
        $param['export_create_end'] = Request::get('export_create_end','');
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['export_create_start'] = ($input['export_create_start'] != '') ? strtotime($input['export_create_start']) : 0;
        $input['export_create_end'] = ($input['export_create_end'] != '') ? strtotime($input['export_create_end'])+86400 : 0;
        $data = Customers::reportCustomer($input);
        $customers = Customers::getListAll();
        $admin = User::getListAllUser();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportCustomer($data);
        }
        $this->layout->content = View::make('admin.ReportLayouts.customer')->with('param',$param)->with('data',$data)->with('customers',$customers)->with('admin',$admin);
    }
    public function exportExcelReportCustomer($arrData = array()){
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue("A1", "Thống kê khách hàng");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val50,'val'=>'Khách hàng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val18,'val'=>'Tổng số hóa đơn','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'D'=>array('w'=>$val18,'val'=>'Tổng nhập','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
            'E'=>array('w'=>$val18,'val'=>'Tổng tiền','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data->customers_FirstName);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data->count_export);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('D'.$rowCount, $data->sum_origin);

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('E'.$rowCount, $data->sum_export);

            $rowCount++;
        }
        $sheet->getStyle('D4:E' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Thong_ke_ban_hàng" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
    * Sản phẩm bán chạy
    * ******************************************************************************************/
    public function reportProductHot(){
        if (!in_array($this->permission_report_product_hot, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
//        $param['customers_id'] = Request::get('customers_id',0);
        $param['export_product_create_start'] = Request::get('export_product_create_start','');
        $param['export_product_create_end'] = Request::get('export_product_create_end','');
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['export_product_create_start'] = ($input['export_product_create_start'] != '') ? strtotime($input['export_product_create_start']) : 0;
        $input['export_product_create_end'] = ($input['export_product_create_end'] != '') ? strtotime($input['export_product_create_end'])+86400 : 0;
        $data = Product::reportProductHot($input);

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportProductHot($data);
        }
        $this->layout->content = View::make('admin.ReportLayouts.product')->with('param',$param)->with('data',$data);
    }
    public function exportExcelReportProductHot($arrData = array()){
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue("A1", "Sản phẩm bán chạy");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val18,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val50,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Tổng tiền đã bán','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data->product_Code);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data->product_Name);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('D'.$rowCount, $data->sum_product);

            $rowCount++;
        }
        $sheet->getStyle('D4:D' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "San_pham_ban_chay" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
     * thông kê nhập hàng
     * ******************************************************************************************/
    public function reportImport(){
        if (!in_array($this->permission_report_import, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['import_product_create_start'] = Request::get('import_product_create_start','');
        $param['import_product_create_end'] = Request::get('import_product_create_end','');
        $param['product_id'] = (int)Request::get('product_id',0);
        $param['providers_id'] = (int)Request::get('providers_id',0);
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['import_product_create_start'] = ($input['import_product_create_start'] != '') ? strtotime($input['import_product_create_start']) : 0;
        $input['import_product_create_end'] = ($input['import_product_create_end'] != '') ? strtotime($input['import_product_create_end'])+86400 : 0;

        $data = ImportProduct::reportImport($input);
        //$d = Product::getProductStore();
        //echo '<pre>';print_r($d);echo '</pre>';die;
        $provider = Providers::getListAll();
        $product = Product::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportImport($data,$provider);
        }

        $this->layout->content = View::make('admin.ReportLayouts.import')
            ->with('provider',$provider)
            ->with('product',$product)
            ->with('param',$param)
            ->with('data',$data);
    }
    public function exportExcelReportImport($arrData = array(),$provider = array()){
        //echo '<pre>'; print_r($arrData); echo '</pre>'; die();
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue("A1", "Thống kê nhập hàng");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val18,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val50,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Thời gian','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'E'=>array('w'=>$val18,'val'=>'Số lượng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'F'=>array('w'=>$val18,'val'=>'Giá nhập','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
            'G'=>array('w'=>$val25,'val'=>'Nhà cung cấp','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data['product_Code']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['product_Name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, date('d-m-Y',$data['import_product_create_time']));

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, $data['import_product_num']);

            $sheet->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('F'.$rowCount, $data['import_product_price']);

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $provider[$data['providers_id']]);

            $rowCount++;
        }
        $sheet->getStyle('F4:F' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Thong_ke_nhap_hàng" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
     * thông kê nhập hàng ảo
     * ******************************************************************************************/
    public function reportImportFake(){
        if (!in_array($this->permission_report_import, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['import_product_create_start'] = Request::get('import_product_create_start','');
        $param['import_product_create_end'] = Request::get('import_product_create_end','');
        $param['product_id'] = (int)Request::get('product_id',0);
        $param['providers_id'] = (int)Request::get('providers_id',0);
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['import_product_create_start'] = ($input['import_product_create_start'] != '') ? strtotime($input['import_product_create_start']) : 0;
        $input['import_product_create_end'] = ($input['import_product_create_end'] != '') ? strtotime($input['import_product_create_end'])+86400 : 0;

        $data = ImportProductFake::reportImport($input);
        //$d = Product::getProductStore();
        //echo '<pre>';print_r($d);echo '</pre>';die;
        $provider = Providers::getListAll();
        $product = Product::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportImportFake($data,$provider);
        }

        $this->layout->content = View::make('admin.ReportLayouts.import_fake')
            ->with('provider',$provider)
            ->with('product',$product)
            ->with('param',$param)
            ->with('data',$data);
    }
    public function exportExcelReportImportFake($arrData = array(),$provider = array()){

        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue("A1", "Thống kê nhập hàng");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val18,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val50,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Thời gian','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'E'=>array('w'=>$val18,'val'=>'Số lượng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'F'=>array('w'=>$val18,'val'=>'Giá nhập','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
            'G'=>array('w'=>$val25,'val'=>'Nhà cung cấp','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data['product_Code']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['product_Name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, date('d-m-Y',$data['import_product_create_time']));

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, $data['import_product_num']);

            $sheet->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('F'.$rowCount, $data['import_product_price']);

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $provider[$data['providers_id']]);

            $rowCount++;
        }
        $sheet->getStyle('F4:F' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Thong_ke_nhap_hàng_ảo_" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
     * thông kê Xuất hàng
     * ******************************************************************************************/
    public function reportExport(){
        if (!in_array($this->permission_report_export, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['export_product_create_start'] = Request::get('export_product_create_start','');
        $param['export_product_create_end'] = Request::get('export_product_create_end','');
        $param['product_id'] = (int)Request::get('product_id',0);
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['export_product_create_start'] = ($input['export_product_create_start'] != '') ? strtotime($input['export_product_create_start']) : 0;
        $input['export_product_create_end'] = ($input['export_product_create_end'] != '') ? strtotime($input['export_product_create_end'])+86400 : 0;

        $data = ExportProduct::reportExport($input);
        $customer = Customers::getListAll();
        $product = Product::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportExport($data,$customer);
        }

        $this->layout->content = View::make('admin.ReportLayouts.export')
            ->with('customer',$customer)
            ->with('product',$product)
            ->with('param',$param)
            ->with('data',$data);

    }
    public function exportExcelReportExport($arrData = array(),$customer = array()){
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue("A1", "Thống kê Xuất hàng");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val18,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val50,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Thời gian','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'E'=>array('w'=>$val18,'val'=>'Số lượng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'F'=>array('w'=>$val18,'val'=>'Giá xuất','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
            'G'=>array('w'=>$val25,'val'=>'Khách hàng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data['product_Code']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['product_Name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, date('d-m-Y',$data['export_product_create_time']));

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, $data['export_product_num']);

            $sheet->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('F'.$rowCount, $data['export_product_price']);

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $customer[$data['customers_id']]);

            $rowCount++;
        }
        $sheet->getStyle('F4:F' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Thong_ke_xuat_hang" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
     * thông kê Xuất hàng ảo
     * ******************************************************************************************/
    public function reportExportFake(){
        if (!in_array($this->permission_report_export, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['export_product_create_start'] = Request::get('export_product_create_start','');
        $param['export_product_create_end'] = Request::get('export_product_create_end','');
        $param['product_id'] = (int)Request::get('product_id',0);
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['export_product_create_start'] = ($input['export_product_create_start'] != '') ? strtotime($input['export_product_create_start']) : 0;
        $input['export_product_create_end'] = ($input['export_product_create_end'] != '') ? strtotime($input['export_product_create_end'])+86400 : 0;

        $data = ExportProductFake::reportExport($input);
        $customer = Customers::getListAll();
        $product = Product::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportExportFake($data,$customer);
        }

        $this->layout->content = View::make('admin.ReportLayouts.export_fake')
            ->with('customer',$customer)
            ->with('product',$product)
            ->with('param',$param)
            ->with('data',$data);

    }
    public function exportExcelReportExportFake($arrData = array(),$customer = array()){
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue("A1", "Thống kê Xuất hàng");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val18,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val50,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Thời gian','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'E'=>array('w'=>$val18,'val'=>'Số lượng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'F'=>array('w'=>$val18,'val'=>'Giá xuất','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
            'G'=>array('w'=>$val25,'val'=>'Khách hàng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data['product_Code']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['product_Name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, date('d-m-Y',$data['export_product_create_time']));

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, $data['export_product_num']);

            $sheet->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('F'.$rowCount, $data['export_product_price']);

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $customer[$data['customers_id']]);

            $rowCount++;
        }
        $sheet->getStyle('F4:F' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Thong_ke_xuat_hang_ao_" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
     * thông kê Chiết khấu
     * ******************************************************************************************/
    public function reportDiscount(){
        if (!in_array($this->permission_report_discount, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['export_create_start'] = Request::get('export_create_start','');
        $param['export_create_end'] = Request::get('export_create_end','');
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['export_create_start'] = ($input['export_create_start'] != '') ? strtotime($input['export_create_start']) : 0;
        $input['export_create_end'] = ($input['export_create_end'] != '') ? strtotime($input['export_create_end'])+86400 : 0;
        $data = Export::reportDiscount($input);
        $customer = Customers::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportDiscount($data,$customer);
        }
        $this->layout->content = View::make('admin.ReportLayouts.discount')
            ->with('customer',$customer)
            ->with('param',$param)
            ->with('data',$data);

    }
    public function exportExcelReportDiscount($arrData = array(),$customer = array()){
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue("A1", "Thống kê Chiết khấu");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val50,'val'=>'Khách hàng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'C'=>array('w'=>$val18,'val'=>'CK cá nhân','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'D'=>array('w'=>$val18,'val'=>'Ck công ty','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'E'=>array('w'=>$val18,'val'=>'Tổng tiền','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('B'.$rowCount, $customer[$data['customers_id']]);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('C'.$rowCount, $data['ckcn']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, $data['ckdn']);

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, ($data['ckcn']+$data['ckdn']));

            $rowCount++;
        }
        $sheet->getStyle('C4:E' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Thong_ke_chiet_khau" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
     * bảng kê bán hàng
     * ******************************************************************************************/
    public function reportSaleList(){
        if (!in_array($this->permission_report_sale_list, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['export_product_create_start'] = Request::get('export_product_create_start','');
        $param['export_product_create_end'] = Request::get('export_product_create_end','');
        $param['export_time'] = Request::get('export_time',date('d-m-Y',time()));
        $param['bill_code'] = Request::get('bill_code','');
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['export_product_create_start'] = ($input['export_product_create_start'] != '') ? strtotime($input['export_product_create_start']) : 0;
        $input['export_product_create_end'] = ($input['export_product_create_end'] != '') ? strtotime($input['export_product_create_end'])+86400 : 0;
        $data = ExportProduct::reportSaleList($input);
        $customer = Customers::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportSaleList($data,$customer);
        }
        $this->layout->content = View::make('admin.ReportLayouts.sale_list')
            ->with('customer',$customer)
            ->with('param',$param)
            ->with('data',$data);

    }

    public function exportPdf()
    {
//        if (!in_array($this->permission_view, $this->permission)) {
//            return Redirect::route('admin.dashboard');
//        }

//        $providers = Providers::find($import->providers_id);

        $param['export_product_create_start'] = Request::get('export_start','');
        $param['export_product_create_end'] = Request::get('export_end','');
        $param['export_time'] = Request::get('export_time',date('d-m-Y',time()));
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $param['bill_code'] = Request::get('bill_code','');
        //$submit = (int)Request::get('submit',1);
        $input = $param;
        $input['export_product_create_start'] = ($input['export_product_create_start'] != '') ? strtotime($input['export_product_create_start']) : 0;
        $input['export_product_create_end'] = ($input['export_product_create_end'] != '') ? strtotime($input['export_product_create_end'])+86400 : 0;
        $input['export_time'] = ($input['export_time'] != '') ? strtotime($input['export_time']) : 0;
        $data = ExportProduct::reportSaleList($input);
        $customer = Customers::find($param['customers_id']);
        if ($customer) {
            $html = View::make('admin.ReportLayouts.exportpdf')->with('data', $data)->with('input', $input)->with('customer', $customer)->render();
        }else{
            $html = 'Không có thông tin khách hàng';
        }
        $signature = false;
        $this->filename = "Bang-ke-KH-" . $param['customers_id'] . ".pdf";
        $this->pdfOutput($html, $this->filename, 'I', $signature);
    }

    function pdfOutput($html, $filename, $outputType = 'I', $signature = false){
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'px', PDF_PAGE_FORMAT, true, 'UTF-8', false, false, $signature);
        // set document information
        $pdf->SetCreator('System');
        $pdf->SetAuthor('TQT');
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('TQT, export');
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

    public function exportExcelReportSaleList($arrData = array()){
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue("A1", "Bảng kê bán hàng");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val18,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val50,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Xuất xứ','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'E'=>array('w'=>$val18,'val'=>'Đơn vị tính','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'F'=>array('w'=>$val18,'val'=>'Giá','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
            'G'=>array('w'=>$val25,'val'=>'Số lượng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'H'=>array('w'=>$val25,'val'=>'Tổng tiền','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data['product_Code']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['product_Name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, $data['product_NameOrigin']);

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, $data['product_NameUnit']);

            $sheet->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('F'.$rowCount, $data['export_product_price']);

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $data['export_product_num']);

            $sheet->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('H'.$rowCount, $data['export_product_total']);

            $rowCount++;
        }
        $sheet->getStyle('F4:F' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        $sheet->getStyle('H4:H' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Bang_ke_ban_hàng" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
     * Thống kê tồn kho
     * ******************************************************************************************/
    public function reportStore(){
        if (!in_array($this->permission_report_store, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['product_id'] = (int)Request::get('product_id',0);
        $submit = (int)Request::get('submit',1);
        $data = Product::getProductStore($param);
        $product = Product::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportStore($data);
        }

        $this->layout->content = View::make('admin.ReportLayouts.store')
            ->with('param',$param)
            ->with('data',$data)
            ->with('product',$product);

    }
    public function exportExcelReportStore($arrData = array()){
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue("A1", "Thống kê tồn kho");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val18,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val50,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Xuất xứ','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'E'=>array('w'=>$val18,'val'=>'Đơn vị tính','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'F'=>array('w'=>$val18,'val'=>'Số lượng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'G'=>array('w'=>$val25,'val'=>'Giá nhập','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'H'=>array('w'=>$val25,'val'=>'Tiền tồn','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data['product_Code']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['product_Name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, $data['product_NameOrigin']);

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, $data['product_NameUnit']);

            $sheet->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('F'.$rowCount, $data['product_Quantity']);

            $sub_total = 0;$show_price = '';
            $quantity = $data['product_Quantity'];
            if($data['store']){
                foreach($data['store'] as $store){
                    if($quantity > 0){
                        if($quantity >= $store['import_product_num']){
                            $show_price = number_format($store['import_product_price'],0,'.','.').'đ'.' ('.$store['import_product_num'].')';
                            $quantity = $quantity-$store['import_product_num'];
                            $sub_total += ($store['import_product_num'] * $store['import_product_price']);
                        }
                        else{
                            $show_price = number_format($store['import_product_price'],0,'.','.').'đ'.' ('.$quantity.')';
                            $sub_total += ($quantity * $store['import_product_price']);
                            $quantity = 0;
                        }
                    }
                }
            }

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $show_price);

            $sheet->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('H'.$rowCount, $sub_total);

            $rowCount++;
        }
        $sheet->getStyle('H4:H' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Thong_ke_ton_kho" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /*****************************************************************************************
     * Thống kê tồn kho ảo
     * ******************************************************************************************/
    public function reportStoreFake(){
        if (!in_array($this->permission_report_store, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['product_id'] = (int)Request::get('product_id',0);
        $submit = (int)Request::get('submit',1);
        $data = Product::getProductStoreFake($param);
        $product = Product::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportStoreFake($data);
        }

        $this->layout->content = View::make('admin.ReportLayouts.store_fake')
            ->with('param',$param)
            ->with('data',$data)
            ->with('product',$product);

    }
    public function exportExcelReportStoreFake($arrData = array()){
        if(empty($arrData))
            return;
        // xu ly export
        ini_set('max_execution_time', 3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('A1')->getFont()->setSize(16)->getColor()->setRGB('000000');
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue("A1", "Thống kê tồn kho");
        $sheet->getRowDimension("1")->setRowHeight(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //ngày thống kê
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('000000');
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue("A2", "Ngày thống kê: ".date('d-m-Y H:i:s',time()));
        $sheet->getRowDimension("2")->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // setting header
        $position_hearder = 3;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $val10 = 10; $val18 = 18; $val35 = 35;$val50 = 50; $val25 = 25;
        $ary_cell = array(
            'A'=>array('w'=>$val10,'val'=>'STT','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'B'=>array('w'=>$val18,'val'=>'Mã SP','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val50,'val'=>'Tên sản phẩm','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Xuất xứ','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'E'=>array('w'=>$val18,'val'=>'Đơn vị tính','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'F'=>array('w'=>$val18,'val'=>'Số lượng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'G'=>array('w'=>$val25,'val'=>'Giá nhập','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'H'=>array('w'=>$val25,'val'=>'Tiền tồn','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        );

        //build header title
        foreach($ary_cell as $col => $attr){
            $sheet->getColumnDimension($col)->setWidth($attr['w']);
            $sheet->setCellValue("$col{$position_hearder}",$attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '05729C'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '333333')
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => $attr['align'],
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder+1; // hang bat dau xuat du lieu
        foreach($arrData as $ky=>$data){
            $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('A'.$rowCount, $ky+1);

            $sheet->getStyle('B'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('B'.$rowCount, $data['product_Code']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['product_Name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, $data['product_NameOrigin']);

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, $data['product_NameUnit']);

            $sheet->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('F'.$rowCount, $data['product_Quantity_Fake']);

            $sub_total = 0;$show_price = '';
            $quantity = $data['product_Quantity_Fake'];
            if($data['store']){
                foreach($data['store'] as $store){
                    if($quantity > 0){
                        if($quantity >= $store['import_product_num']){
                            $show_price = number_format($store['import_product_price'],0,'.','.').'đ'.' ('.$store['import_product_num'].')';
                            $quantity = $quantity-$store['import_product_num'];
                            $sub_total += ($store['import_product_num'] * $store['import_product_price']);
                        }
                        else{
                            $show_price = number_format($store['import_product_price'],0,'.','.').'đ'.' ('.$quantity.')';
                            $sub_total += ($quantity * $store['import_product_price']);
                            $quantity = 0;
                        }
                    }
                }
            }

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $show_price);

            $sheet->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('H'.$rowCount, $sub_total);

            $rowCount++;
        }
        $sheet->getStyle('H4:H' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
        // output file
        ob_clean();
        $filename = "Thong_ke_ton_kho_ao" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    /**************************************
     * Lập báo giá khách hàng
     **************************************/
    public function priceListInfo(){
//        if (!in_array($this->permission_create, $this->permission)) {
//            return Redirect::route('admin.dashboard');
//        }
        Session::forget('price_list');
        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.ReportLayouts.price_list')
            ->with('customers',$customers)->with('customers_id',0);
    }

    public function priceList()
    {
        $data['success'] = 0;
        $customers_id = (int)Request::get('customers_id', 0);
        $customers = Customers::find($customers_id);
        $price_list = Session::has('price_list') ? Session::get('price_list') : array();
        if (!$customers) {
            $data['mess'] = 'Không tìm thấy thông tin khách hàng';
            return Response::json($data);
        }
        if (!$price_list) {
            $data['mess'] = 'Không tìm thấy thông tin sản phẩm cần báo giá';
            return Response::json($data);
        }
        $data['success'] = 1;
        $data['link'] = URL::route('admin.price_list_pdf', array('id' => $customers_id));
        return Response::json($data);
    }

    public function priceListPdf($id){
        $customers = Customers::find($id);
        $price_list = Session::has('price_list') ? Session::get('price_list') : array();
        $html = View::make('admin.ReportLayouts.price_list_pdf')->with('customer',$customers)->with('list',$price_list)->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->stream('my.pdf');
    }

    public function addProduct(){
        $customers_id = (int)Request::get('customers_id',0);
        $name = Request::get('name','');
        $num = (int)Request::get('num',0);
        $vat = 0;
        $product = Product::getByName($name);
        $customers = Customers::find($customers_id);
        $price_list = Session::has('price_list') ? Session::get('price_list') : array();
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
        if ($error == '') {
            $vat = $customers->customers_IsNeededVAT ? 10 : 0;
            $price_list[$product->product_id] = array(
                'product_id' => $product->product_id,
                'product_price' => $product->product_Price,
                'product_num' => $num,
                'product_Name' => $product->product_Name,
                'product_Code' => $product->product_Code,
                'product_NameOrigin' => $product->product_NameOrigin,
                'product_NameUnit' => $product->product_NameUnit,
            );
            Session::put('price_list', $price_list);
        }
        $data['success'] = ($error == '') ? 1 : 0;
        $data['html'] = View::make('admin.ReportLayouts.product_info')->with('price_list',$price_list)->with('vat',$vat)->with('error',$error)->render();
        return Response::json($data);

    }

    public function removeSessionPriceList()
    {
        Session::forget('price_list');
        $data['success'] = 1;
        return Response::json($data);
    }

    public function removeProduct()
    {
        $product_id = Request::get('product_id', 0);
        $customers_id = (int)Request::get('customers_id', 0);
        $customers = Customers::find($customers_id);
        $vat = $customers->customers_IsNeededVAT ? 10 : 0;
        $price_list = Session::has('price_list') ? Session::get('price_list') : array();
        if (isset($price_list[$product_id])) {
            unset($price_list[$product_id]);
        }
        Session::put('price_list', $price_list);
        $data['success'] = 1;
        $data['html'] = View::make('admin.ReportLayouts.product_info')->with('price_list', $price_list)->with('vat', $vat)->render();
        return Response::json($data);
    }
}