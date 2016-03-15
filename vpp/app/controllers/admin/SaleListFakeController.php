<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 18/10/2015
 * Time: 11:15 CH
 */
class SaleListFakeController extends BaseAdminController
{
    private $aryStatus = array(-1 => 'Chọn trạng thái', 0 => 'Bảng kê hủy', 1 => 'Bảng kê bình thường');
    private $aryType = array(-1 => 'Chọn trạng thái', 0 => 'Đã thanh toán', 1 => 'Công nợ');

    private $permission_view = 'sale_list_view';
    private $permission_create = 'sale_list_create';
    private $permission_update_payment = 'sale_list_update_payment';

    public function __construct()
    {
        parent::__construct();

    }

    public function view(){

        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $dataSearch['customers_id'] = Request::get('customers_id', 0);
        $dataSearch['sale_list_type'] = Request::get('sale_list_type', -1);
        $dataSearch['sale_list_status'] = Request::get('sale_list_status', -1);
        $dataSearch['sale_list_code'] = Request::get('sale_list_code', '');
        $dataSearch['sale_list_bill'] = Request::get('sale_list_bill', '');
        $dataSearch['sale_list_create_id'] = Request::get('export_create_id', 0);
        $dataSearch['sale_list_start'] = Request::get('sale_list_start', '');
        $dataSearch['sale_list_end'] = Request::get('sale_list_end', '');
        $page_no = Request::get('page_no', 1);
        $limit = 30;
        $total = 0;
        $offset = ($page_no - 1) * $limit;
        $param = $dataSearch;
        $admin = User::getListAllUser();
        $customers = Customers::getListAll();
        $param['sale_list_start'] = ($param['sale_list_start'] != '') ? strtotime($param['sale_list_start']) : 0;
        $param['sale_list_end'] = ($param['sale_list_end'] != '') ? strtotime($param['sale_list_end'])+86400 : 0;
        $data = SaleListFake::search($param, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';
        $this->layout->content = View::make('admin.SaleListFakeLayouts.view')
            ->with('param',$dataSearch)
            ->with('data',$data)
            ->with('total', $total)
            ->with('aryStatus', $this->aryStatus)
            ->with('aryType', $this->aryType)
            ->with('admin', $admin)
            ->with('customers', $customers)
            ->with('start', ($page_no - 1) * $limit)
            ->with('paging',$paging)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
            ->with('permission_update_payment', in_array($this->permission_update_payment, $this->permission) ? 1 : 0);
    }

    public function createInfo(){

        if (!in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.SaleListFakeLayouts.sale_list')
            ->with('customers',$customers)
            ->with('customers_id',0);
    }

    public function create(){

        if (!in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['customers_id'] = (int)Request::get('customers_id',0);
        $param['sale_list_type'] = (int)Request::get('sale_list_type',-1);
        $param['sale_list_bill'] = Request::get('sale_list_bill','');
        $param['sale_list_time'] = Request::get('sale_list_time','');
        $param['export_create_start'] = Request::get('export_create_start','');
        $param['export_create_end'] = Request::get('export_create_end','');
        $param['export_id'] = Request::get('export_id',array());
        $error = array();
        if($param['customers_id'] <= 0){
            $error[] = 'Chưa chọn khách hàng';
        }
        if($param['sale_list_type'] != 0 && $param['sale_list_type'] != 1){
            $error[] = 'Chưa chọn kiểu thanh toán';
        }
        if($param['sale_list_time'] == ''){
            $error[] = 'Chưa chọn ngày tạo bảng kê';
        }
        if(sizeof($param['export_id']) == 0){
            $error[] = 'Chưa chọn xuất kho';
        }else{
            if(!ExportFake::checkForSale($param,sizeof($param['export_id']))){
                $error[] = 'Xuất kho không phù hợp';
            }
        }
        if(!$error){
            $count = SaleListFake::getCountInDay();
            $count = $count +1;
            $num_length = strlen((string)$count);
            if ($num_length == 1) {
                $code = 'BKA0' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            } else {
                $code = 'BKA' . (string)$count . date('d', time()) . date('m', time()) . date('y', time());
            }
            $data['customers_id'] = $param['customers_id'];
            $data['sale_list_type'] = $param['sale_list_type'];
            $data['sale_list_status'] = 1;
            $data['sale_list_bill'] = $param['sale_list_bill'];
            $data['sale_list_time'] = strtotime($param['sale_list_time']);
            $data['sale_list_code'] = $code;
            $data['sale_list_create_id'] = User::user_id();;
            $data['sale_list_create_time'] = time();
            $ex_ids =  $param['export_id'];
            $id = SaleListFake::add($data,$ex_ids);
            if(!$id){
                $error[] = 'Lỗi cập nhật dữ liệu';
            }else{
                return Redirect::route('admin.sale_list_fake_detail',array('id'=>base64_encode($id)));
            }
        }

        if($error){
            $customers = Customers::getListAll();
            $this->layout->content = View::make('admin.SaleListFakeLayouts.sale_list')
                ->with('customers',$customers)
                ->with('param',$param)
                ->with('error',$error)
                ->with('customers_id',$param['customers_id']);
        }
    }

    public function detail($id){
        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = (int) base64_decode($id);
        $sale_list = SaleListFake::find($id);
        $export_ids = ExportFake::getListIdBySaleList($id);
        $customer = Customers::find($sale_list->customers_id);
        $product = ExportProductFake::reportSaleList($export_ids);
        $this->layout->content = View::make('admin.SaleListFakeLayouts.sale_list_detail')
            ->with('sale_list',$sale_list)
            ->with('customer',$customer)
            ->with('product',$product);
    }

    public function exportPdf($id)
    {
        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = (int) base64_decode($id);
        $sale_list = SaleListFake::find($id);
        $export_ids = ExportFake::getListIdBySaleList($id);
        $customer = Customers::find($sale_list->customers_id);
        $product = ExportProductFake::reportSaleList($export_ids);
        $html = View::make('admin.SaleListFakeLayouts.sale_list_pdf')
            ->with('sale_list',$sale_list)
            ->with('customer',$customer)
            ->with('product',$product)->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->stream("Bang-ke-KH-" . $customer['customers_id'] . ".pdf");
    }

    public function exportExcelReportSaleList($id){
        if (!in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $id = (int) base64_decode($id);
        $export_ids = ExportFake::getListIdBySaleList($id);
        $arrData = ExportProductFake::reportSaleList($export_ids);
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
        $filename = "Bang_ke_ao" . date("_d/m/Y_H_i").'.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
        parent::debug();
    }

    public function updatePayment()
    {
        if (!in_array($this->permission_update_payment, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $data['success'] = 0;
        $sale_list_id = (int)Request::get('sale_list_id', 0);
        $sale_list = SaleListFake::find($sale_list_id);
        if (!$sale_list) {
            $data['html'] = 'Không tìm thấy bảng kê cần thanh toán';
            return Response::json($data);
        }
        if ($sale_list->sale_list_type == 0) {
            $data['html'] = 'Bảng kê đã được thanh toán trước đó';
            return Response::json($data);
        }
        if (SaleListFake::updatePayment($sale_list)) {
            $data['success'] = 1;
            $data['html'] = 'Cập nhật thành công';
            return Response::json($data);
        } else {
            $data['html'] = 'Cập nhật không thành công';
            return Response::json($data);
        }
    }
}