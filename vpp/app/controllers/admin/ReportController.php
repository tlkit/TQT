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
        $submit = (int)Request::get('submit',1);
        $input = $param;
        $input['import_product_create_start'] = ($input['import_product_create_start'] != '') ? strtotime($input['import_product_create_start']) : 0;
        $input['import_product_create_end'] = ($input['import_product_create_end'] != '') ? strtotime($input['import_product_create_end'])+86400 : 0;

        $data = ImportProduct::reportImport($input);
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
    /*
     * Xuất excel cho thông kê nhập hàng
     */
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