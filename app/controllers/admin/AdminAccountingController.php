<?php
/**
 * Created by PhpStorm.
 * User: TuanNguyenAnh
 * Date: 12/25/2014
 * Time: 9:44 AM
 */

class AdminAccountingController extends AdminController{

    private $aryPayStatus = array(0 => '-- Tất cả --', 1 => ' Chưa thanh toán', 2 => 'Đã thanh toán');
    private $permission_view_warning_accounting = 'view_warning_accounting';
    private $permission_view_manage_accounting = 'view_manage_accounting';
    private $permission_view_full_manage_accounting = 'view_full_manage_accounting';
    private $permission_view_history_accounting = 'view_history_accounting';
    private $permission_view_detail_accounting = 'view_detail_accounting';
    private $permission_pay_accounting = 'pay_accounting';
    private $permission_confirm_pay_accounting = 'confirm_pay_accounting';
    public function __construct() {
        parent::__construct();
        CGlobal::$pageTitle = "Kế toán | Admin Plaza";
        FunctionLib::link_css(array(
            '../admin/lib/datepicker/css/datepicker.css',
        ));
        FunctionLib::link_js(array(
            '../admin/lib/datepicker/js/bootstrap-datepicker.js',
        ));
    }

    public function warningPaySupplier() {

        FunctionLib::link_js('../admin/js/accounting_warning.js');
        if (!$this->is_root && !in_array($this->permission_view_warning_accounting, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $this->layout->content = View::make('admin.Accounting.warning');
        parent::debug();
    }

    public function ajaxWarningPaySupplier() {
//        FunctionLib::link_js('../admin/js/accounting_warning.js');
        if (!$this->is_root && !in_array($this->permission_view_warning_accounting, $this->permission)) {
            return Response::json(array('html' => '','intIsOK' => -1));
        }
        $supplier_name = Request::get('supplier_name','');
        $result = Accounting::warningPaySupplier($supplier_name,$this->key);
        //FunctionLib::debug($result);
        if ($result['code'] == 200 && $result['intIsOK'] == 1) {
            $warning = $result['data'];
            if ($warning) {
                $html = View::make('admin.Accounting.dataWarning')->with('data',$warning)->with('pay_accounting', ($this->is_root || in_array($this->permission_pay_accounting, $this->permission)) ? true : false)->render();
                return Response::json(array('html' => $html,'intIsOK' => 1));
            }
        }
        return Response::json(array('html' => '','intIsOK' => -1));
    }

    public function paySupplier($id){
        FunctionLib::link_js('../admin/js/accounting_pay.js');
        if (!$this->is_root && !in_array($this->permission_pay_accounting, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $result = Accounting::getPaySupplier($id,$this->key);
        //FunctionLib::debug($result);
        if ($result['code'] == 200 && $result['intIsOK'] == 1 && $result['data']) {
            $coupons = $result['data']['coupon'];
            $charge = $result['data']['charge'];
            $supplier = $result['data']['supplier'];
            $this->layout->content = View::make('admin.Accounting.pay')->with('supplier',$supplier)->with('coupons',$coupons)->with('charge',$charge);
        }else{
            $this->layout->content = "Không có coupon nào cần thanh toán cho nhà cung cấp này.";
        }
        parent::debug();
    }

    public function postPaySupplier($id){
        if (!$this->is_root && !in_array($this->permission_pay_accounting, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $ids = Request::get('checkbox_items',array());
        $aryData = array(
            'key' => $this->key,
            'ids' => urlencode(json_encode($ids))
        );
        $re = Accounting::paySupplier($id,$aryData);
        if (isset($re['code']) && $re['code'] == 200) {
            if (isset($re['intIsOK']) && $re['intIsOK'] == 1) {
                $notice = 1;
            }else{
                $notice = 2;
            }
        } else {
            $notice = -1;
        }
        $this->layout->content = View::make('admin.Accounting.complete_pay')->with('notice',$notice)->with('supplier_id',$id);
        parent::debug();
    }

    public function managePaySupplier(){
        if (!$this->is_root && !in_array($this->permission_view_full_manage_accounting, $this->permission) && !in_array($this->permission_view_manage_accounting, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $admin = 1;
        if(!$this->is_root && !in_array($this->permission_view_full_manage_accounting, $this->permission)){
            $admin = 0;
        }
        $page_no = Request::get('page_no',1);
        $param['orders_id'] = trim(Request::get('orders_id',''));
        $param['items_id'] = trim(Request::get('items_id',''));
        $param['coupons'] = trim(Request::get('coupons',''));
        $param['supplier_full_name'] = trim(Request::get('supplier_full_name',''));
        $param['pay_supplier_status'] = (int)Request::get('pay_supplier_status',0);
        $param['pay_time_start'] = trim(Request::get('pay_time_start',''));
        $param['pay_time_end'] = trim(Request::get('pay_time_end',''));
        $param['receive_time_start'] = trim(Request::get('receive_time_start',''));
        $param['receive_time_end'] = trim(Request::get('receive_time_end',''));
        $limit = 30;
        $data = Accounting::managePaySupplier($this->key,$param,$admin,$limit,$page_no);
        $pay = isset($data['data']) ? $data['data'] : array();
        $size = isset($data['size']) ? $data['size'] : 0;
        $paging = isset($size) ? Pagging::getNewPager(3, $page_no, $size, $limit, $param) : '';
        $this->layout->content = View::make('admin.Accounting.manage')->with('pay',$pay)->with('size',$size)->with('param',$param)->with('paging',$paging)->with('aryPayStatus',$this->aryPayStatus)
                                ->with('view_history_accounting', ($this->is_root || in_array($this->permission_view_history_accounting, $this->permission)) ? true : false)
                                ->with('view_detail_accounting', ($this->is_root || in_array($this->permission_view_detail_accounting, $this->permission)) ? true : false);
        parent::debug();
    }

    public function historyPaySupplier($id){
        if (!$this->is_root && !in_array($this->permission_view_history_accounting, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        FunctionLib::link_js('../admin/js/accounting_history.js');
        $supplier = Supplier::getSupplierById($id,$this->key);
        $data = Accounting::historyPaySupplier($id,$this->key);
        $history = isset($data['data']) ? $data['data'] : array();
        $this->layout->content = View::make('admin.Accounting.history')->with('history',$history)->with('supplier',$supplier)
                                ->with('view_detail_accounting', ($this->is_root || in_array($this->permission_view_detail_accounting, $this->permission)) ? true : false)
                                ->with('confirm_pay_accounting', ($this->is_root || in_array($this->permission_confirm_pay_accounting, $this->permission)) ? true : false);
        parent::debug();
    }

    public function confirmPaySupplier(){
        if (!$this->is_root && !in_array($this->permission_confirm_pay_accounting, $this->permission)) {
            return Response::json(array('mess' => 'Bạn không có quyền thực hiện thao tác này.','intIsOK' => -1));
        }
        $pay_id = Request::get('pay_id',0);
        $data['receive_date'] = strtotime(Request::get('receive_date',0));
        $data['bank_fee'] = Request::get('bank_fee',0);
        $data['key'] = $this->key;
        $res = Accounting::confirmPaySupplier($pay_id,$data);
        if(isset($res['code']) && $res['code'] == 200 && $res['intIsOK'] == 1){
            return Response::json(array('mess' => 'Thực hiện xác nhận thành công','intIsOK' => 1));
        }
        return Response::json(array('mess' => 'Thực hiện xác nhận không thành công. Vui lòng thử lại','intIsOK' => -1));
    }

    public function detailPaySupplier($id){
        if (!$this->is_root && !in_array($this->permission_view_detail_accounting, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $export = Request::get('submit',0);
        $data = Accounting::getDetailPaySupplier($id,$this->key);
        //FunctionLib::debug($data);
        $pay = isset($data['data']['pay']) ? $data['data']['pay'] : array();
        $coupons = isset($data['data']['data']) ? $data['data']['data'] : array();
        $charge = isset($data['data']['charge']) ? $data['data']['charge'] : array();
        $supplier = isset($pay['supplier_id']) ? Supplier::getSupplierById($pay['supplier_id'],$this->key) : array();
        if($export == 1){
            $this->exportDetailPaySupplier($supplier,$pay,$coupons,$charge);
        }
        $this->layout->content = View::make('admin.Accounting.detail')->with('supplier',$supplier)->with('pay',$pay)->with('coupons',$coupons)->with('charge',$charge)->with('aryPayStatus',$this->aryPayStatus);
        parent::debug();
    }

    public function exportDetailPaySupplier($supplier, $pay, $coupons, $charge) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Set Orientation, size and scaling
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->setTitle('TT_' . strtolower(FunctionLib::safe_title($supplier['supplier_full_name'])) . '_' . date('d.m', time()));
        // Set font
        $sheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getStyle('B1')->getFont()->setSize(16)->setBold(true)->getColor()->setRGB('000000');
        $sheet->mergeCells('B1:L1');
        $sheet->setCellValue("B1", "Danh sách thanh toán cho " . $supplier['supplier_full_name']);
        $sheet->getRowDimension("1")->setRowHeight(32);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $sheet->getStyle('B1')->getFont()->setSize(14)->setBold(false)->getColor()->setRGB('000000');
        $sheet->mergeCells('B2:L2');
        $sheet->setCellValue("B2", "Ngày " . date('d-m-Y', $pay['pay_supplier_pay_time']));
        $sheet->getRowDimension("2")->setRowHeight(32);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        // setting header
        $position_hearder = 4;
        $sheet->getRowDimension($position_hearder)->setRowHeight(30);
        $ary_cell = array(
            'B' => array('val' => 'STT'),
            'C' => array('val' => 'Ngày KH coupon'),
            'D' => array('val' => 'ID Deal'),
            'E' => array('val' => 'ID đơn hàng'),
            'F' => array('val' => 'Coupon'),
            'G' => array('val' => 'Số tiền'),
            'H' => array('val' => 'Charge trả MC'),
            'I' => array('val' => 'Tiền phải trả'),
            'J' => array('val' => 'Hình thức thanh toán'),
            'K' => array('val' => 'Ngày NCC nhận tiền'),
            'L' => array('val' => 'Trạng thái'),
        );
        foreach ($ary_cell as $col => $attr) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->setCellValue("$col{$position_hearder}", $attr['val']);
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
            $sheet->getStyle($col . $position_hearder)->getFont()->setBold(true);
            $sheet->getStyle($col . $position_hearder)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'eeecff'),
                        'style' => array('font-weight' => 'bold')
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                )
            );
        }

        //hien thị dũ liệu
        $rowCount = $position_hearder + 1; // hang bat dau xuat du lieu
        $i = 1;
        foreach ($coupons as $key => $coupon) {
            foreach ($coupon as $k => $v) {
                $sheet->getRowDimension($rowCount)->setRowHeight(25);//chiều cao của row

                $sheet->getStyle('B' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $sheet->SetCellValue('B' . $rowCount, $i);

                $sheet->getStyle('C' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $sheet->SetCellValue('C' . $rowCount, date('d-m-Y', $v['pay_supplier_coupon_active_time']));

                $sheet->getStyle('D' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $sheet->SetCellValue('D' . $rowCount, $v['pay_supplier_coupon_item_id']);

                $sheet->getStyle('E' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $sheet->SetCellValue('E' . $rowCount, $v['pay_supplier_coupon_order_id']);

                $sheet->getStyle('F' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $sheet->SetCellValue('F' . $rowCount, $v['pay_supplier_coupon_coupon']);

                $sheet->getStyle('G' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
                $sheet->SetCellValue('G' . $rowCount, $v['pay_supplier_coupon_money']);

                if ($k == 0 && isset($charge[$key])) {
                    $fee = $v['pay_supplier_coupon_fee_change'] + $charge[$key];
                    $pa = $v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change'] - $charge[$key];
                } else {
                    $fee = $v['pay_supplier_coupon_fee_change'];
                    $pa = $v['pay_supplier_coupon_money'] - $v['pay_supplier_coupon_fee_change'];
                }
                $sheet->getStyle('H' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
                $sheet->SetCellValue('H' . $rowCount, $fee);

                $sheet->getStyle('I' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
                $sheet->SetCellValue('I' . $rowCount, $pa);

                $sheet->getStyle('J' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                if((int)$v['orders_payment_method'] == 1 && (int)$v['orders_payment_type'] > 0) {
                    $sheet->SetCellValue('J' . $rowCount, CGlobal::$orders_payment_method2[$v['orders_payment_method']] . "(" . CGlobal::$aryPaymentType[(int)$v['orders_payment_type']] . ")");
                } else {
                    $sheet->SetCellValue('J' . $rowCount, CGlobal::$orders_payment_method2[$v['orders_payment_method']]);
                }
                $sheet->getStyle('K' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $sheet->SetCellValue('K' . $rowCount, date('d-m-Y',$pay['pay_supplier_pay_time']));

                $sheet->getStyle('L' . $rowCount)->getAlignment()->applyFromArray(
                    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                $sheet->SetCellValue('L' . $rowCount, $this->aryPayStatus[$pay['pay_supplier_status']]);

                $rowCount++;
                $i++;
            }
        }

        $objPHPExcel->getActiveSheet()
            ->getStyle('B4:L' . ($rowCount))
            ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $sheet->getStyle('G' . $rowCount)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
        $sheet->getStyle('G' . $rowCount)->getFont()->setBold(true);
        $sheet->SetCellValue('G' . $rowCount, '=SUM(G5:G' . ($rowCount - 1) . ')');

        $sheet->getStyle('H' . $rowCount)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
        $sheet->getStyle('H' . $rowCount)->getFont()->setBold(true);
        $sheet->SetCellValue('H' . $rowCount, '=SUM(H5:H' . ($rowCount - 1) . ')');

        $sheet->getStyle('I' . $rowCount)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,));
        $sheet->getStyle('I' . $rowCount)->getFont()->setBold(true);
        $sheet->SetCellValue('I' . $rowCount, '=SUM(I5:I' . ($rowCount - 1) . ')');

        $objPHPExcel->getActiveSheet()
            ->getStyle('G5:I' . $rowCount)
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        // output file
        ob_clean();
        $filename = "PLZ_TT_NCC_" . strtolower(FunctionLib::safe_title($supplier['supplier_full_name'])) . "_" . date("_d/m_") . '.xls';
        @header("Cache-Control: ");
        @header("Pragma: ");
        @header("Content-type: application/octet-stream");
        @header("Content-Disposition: attachment; filename=\"{$filename}\"");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");
        exit();
    }
} 