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

    /*****************************************************************************************
     * Thống kê khách hàng
     * ******************************************************************************************/
    public function reportCustomer(){
        $param['customers_id'] = Request::get('customers_id',0);
        $param['export_create_start'] = Request::get('export_create_start','');
        $param['export_create_end'] = Request::get('export_create_start','');
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['export_create_start'] = ($input['export_create_start'] != '') ? strtotime($input['export_create_start']) : 0;
        $input['export_create_end'] = ($input['export_create_end'] != '') ? strtotime($input['export_create_end'])+86400 : 0;
        $data = Customers::reportCustomer($input);
        $customers = Customers::getListAll();

        //xuất excel
        if($submit == 2){
            $this->exportExcelReportCustomer($data);
        }
        $this->layout->content = View::make('admin.ReportLayouts.customer')->with('param',$param)->with('data',$data)->with('customers',$customers);
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
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue("A1", "Thống kê khách hàng");
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
            'B'=>array('w'=>$val50,'val'=>'Khách hàng','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
            'C'=>array('w'=>$val18,'val'=>'Tổng số hóa đơn','align'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
            'D'=>array('w'=>$val18,'val'=>'Tổng tiền','align'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
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
            $sheet->SetCellValue('B'.$rowCount, $data['customers_FirstName']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['count_export']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('D'.$rowCount, number_format($data['sum_export'],0,',',',').' đ');

            $rowCount++;
        }
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
            $sheet->SetCellValue('B'.$rowCount, $data['product_Code']);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,));
            $sheet->SetCellValue('C'.$rowCount, $data['product_Name']);

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('D'.$rowCount, number_format($data['sum_product'],0,',',',').' đ');

            $rowCount++;
        }
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
        $param['import_product_create_start'] = Request::get('import_product_create_start','');
        $param['import_product_create_end'] = Request::get('import_product_create_end','');
        $param['product_id'] = (int)Request::get('product_id',0);
        $param['providers_id'] = (int)Request::get('providers_id',0);
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['import_product_create_start'] = ($input['import_product_create_start'] != '') ? strtotime($input['import_product_create_start']) : 0;
        $input['import_product_create_end'] = ($input['import_product_create_end'] != '') ? strtotime($input['import_product_create_end'])+86400 : 0;

        $data = ImportProduct::reportImport($input);
        $d = Product::getProductStore();
        echo '<pre>';print_r($d);echo '</pre>';die;
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
            $sheet->SetCellValue('F'.$rowCount, number_format($data['import_product_price'],0,',',',').' đ');

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $provider[$data['providers_id']]);

            $rowCount++;
        }
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
     * thông kê Xuất hàng
     * ******************************************************************************************/
    public function reportExport(){
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
            $sheet->SetCellValue('F'.$rowCount, number_format($data['export_product_price'],0,',',',').' đ');

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $customer[$data['customers_id']]);

            $rowCount++;
        }
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
     * thông kê Chiết khấu
     * ******************************************************************************************/
    public function reportDiscount(){
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
            $sheet->SetCellValue('C'.$rowCount, number_format($data['ckcn'],0,',',',').' đ');

            $sheet->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('D'.$rowCount, number_format($data['ckdn'],0,',',',').' đ');

            $sheet->getStyle('E'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('E'.$rowCount, number_format(($data['ckcn']+$data['ckdn']),0,',',',').' đ');

            $rowCount++;
        }
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
        $param['export_product_create_start'] = Request::get('export_product_create_start','');
        $param['export_product_create_end'] = Request::get('export_product_create_end','');
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
            'D'=>array('w'=>$val18,'val'=>'Xuất sứ','align'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
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
            $sheet->SetCellValue('F'.$rowCount, number_format($data['export_product_price'],0,',',',').' đ');

            $sheet->getStyle('G'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $sheet->SetCellValue('G'.$rowCount, $data['export_product_num']);

            $sheet->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
            $sheet->SetCellValue('H'.$rowCount, number_format($data['export_product_total'],0,',',',').' đ');

            $rowCount++;
        }
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
}