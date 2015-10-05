<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class TicketController extends BaseAdminController
{
    private $permission_view = 'ticket_view';
    private $permission_create = 'ticket_create';
    private $permission_edit = 'ticket_edit';
    private $arrType = array(-1 => '--Chọn kiểu khách hàng--', 1 => 'Mua buôn', 2 => 'Mua lẻ', 3 => 'Yêu cầu báo giá');
    private $arrTypeTicket = array(1 => 'Phiếu thu', 2 => 'Phiếu chi');

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        //Check phan quyen.
        if(!in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard');
        }
        $pageNo = (int) Request::get('page_no',1);
        $limit = 30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['ticket_person_money'] = addslashes(Request::get('ticket_person_money',''));
        $search['ticket_type'] = (int)Request::get('ticket_type',0);
        $search['ticket_time_created_start'] = Request::get('ticket_time_created_start','');
        $search['ticket_time_created_end'] = Request::get('ticket_time_created_end','');

        $search['ticket_time_approve_start'] = Request::get('ticket_time_approve_start','');
        $search['ticket_time_approve_end'] = Request::get('ticket_time_approve_end','');


        $dataSearch = Ticket::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //echo '<pre>';  print_r($dataSearch); echo '</pre>'; die;
        $this->layout->content = View::make('admin.TicketLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            //->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 1)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 1)
            ->with('arrTypeTicket', $this->arrTypeTicket);
    }

    public function getCreate($ids = 0, $ticket_type = 1) {
        if(!in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard');
        }
        $data = array();
        $id = base64_decode($ids);
        if($id > 0) {
            $data = Ticket::find($id);
        }
        $this->layout->content = View::make('admin.TicketLayouts.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('ticket_type', $ticket_type)
            ->with('arrTypeTicket', $this->arrTypeTicket);
    }

    public function postCreate($ids = 0, $ticket_type = 1) {
        if(!in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard');
        }
        $id = base64_decode($ids);
        $submit = (int)Request::get('submit',1);
        $dataSave['ticket_type'] = (int)Request::get('ticket_type',1);

        $dataSave['ticket_company'] = Request::get('ticket_company','');
        $dataSave['ticket_company_address'] = Request::get('ticket_company_address','');
        $dataSave['ticket_company_mst'] = Request::get('ticket_company_mst','');

        $ticket_time_created = Request::get('ticket_time_created','');
        if($ticket_time_created != ''){
            $dataSave['ticket_time_created'] = strtotime($ticket_time_created);
        }

        $dataSave['ticket_book_number'] = Request::get('ticket_book_number','');
        $dataSave['ticket_number'] = Request::get('ticket_number','');
        $dataSave['ticket_miss'] = Request::get('ticket_miss','');
        $dataSave['ticket_acttack'] = Request::get('ticket_acttack','');

        $dataSave['ticket_person_money'] = Request::get('ticket_person_money','');
        $dataSave['ticket_person_address'] = Request::get('ticket_person_address','');
        $dataSave['ticket_reason'] = Request::get('ticket_reason','');

        //$dataSave['ticket_money'] = Request::get('ticket_money','');
        $ticket_money = Request::get('ticket_money');
        $dataSave['ticket_money'] =  str_replace('.','',$ticket_money);

        $dataSave['ticket_file_acttack'] = Request::get('ticket_file_acttack','');
        $dataSave['ticket_file_root'] = Request::get('ticket_file_root','');

        $ticket_time_approve = Request::get('ticket_time_approve','');
        if($ticket_time_approve != ''){
            $dataSave['ticket_time_approve'] = strtotime($ticket_time_approve);
        }

        //$dataSave['ticket_money_pay'] = Request::get('ticket_money_pay','');
        $ticket_money_pay = Request::get('ticket_money_pay');
        $dataSave['ticket_money_pay'] =  str_replace('.','',$ticket_money_pay);

        $dataSave['ticket_rate'] = Request::get('ticket_rate','');
        $ticket_rate_money = Request::get('ticket_rate_money');
        $dataSave['ticket_rate_money'] =  (int)str_replace('.','',$ticket_rate_money);

        $dataSave['ticket_money_miss'] =  abs((int)$dataSave['ticket_money']-(int)$dataSave['ticket_money_pay']);

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                $dataSave['ticket_date_update'] = time();
                $dataSave['ticket_user_id_update'] = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
                $dataSave['ticket_user_update'] = isset($this->user['user_full_name']) ? $this->user['user_full_name']: '---';
                if(Ticket::updateTicket($id, $dataSave)) {
                    if($submit == 1 ){
                        return Redirect::route('admin.ticket_list',array('ticket_type'=>$dataSave['ticket_type']));
                    }else{
                        $this->exporTicket($id);
                    }

                }
            } else {
                $dataSave['ticket_date_created'] = time();
                $dataSave['ticket_user_id_created'] = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
                $dataSave['ticket_user_created'] = isset($this->user['user_full_name']) ? $this->user['user_full_name']: '---';
                //FunctionLib::debug($dataSave);
                $ticket_id = Ticket::createNew($dataSave);

                if($ticket_id > 0) {
                    if($submit == 1 ){
                        return Redirect::route('admin.ticket_list',array('ticket_type'=>$dataSave['ticket_type']));
                    }else{
                        $this->exporTicket($ticket_id);
                    }
                }
            }
        }
        $this->layout->content =  View::make('admin.TicketLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('ticket_type', $ticket_type)
            ->with('error', $this->error)
            ->with('arrTypeTicket', $this->arrTypeTicket);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['ticket_person_money']) && $data['ticket_person_money'] == '') {
                $this->error[] = 'Họ tên người nhận - nộp tiền không được bỏ trống';
            }
            if(isset($data['ticket_money']) && $data['ticket_money'] == '') {
                $this->error[] = 'Tiền ước tính thu-chi không được bỏ trống';
            }
            if(isset($data['ticket_money_pay']) && $data['ticket_money_pay'] == '') {
                $this->error[] = 'Tiền đã nhận thu-chi không được bỏ trống';
            }

            return true;
        }
        return false;
    }

        function ticket_export($ids){
        $ticket_id = base64_decode($ids);
        $this->exporTicket($ticket_id);
    }
    function exporTicket($ticket_id){
        $infor_ticket = array();
        if($ticket_id > 0){
            $infor_ticket = Ticket::find($ticket_id);
        }
        if(empty($infor_ticket))
            die('Không có thông tin phiếu thu này');

        $type = 1;
        //xuất phiếu thu
        $template = 'admin.TicketLayouts.ticket';
        $filename = ($infor_ticket['ticket_type'] == 1)?"Phiếu_thu" : "Phiếu_chi";
        if($type == 1){
            $output = View::make($template)->with('data',$infor_ticket);
            $filepath = $filename.'_'.date('d-m-Y h:i',time()).".doc";
            @header("Cache-Control: ");// leave blank to avoid IE errors
            @header("Pragma: ");// leave blank to avoid IE errors
            @header("Content-type: application/octet-stream");
            @header("Content-Disposition: attachment; filename=\"{$filepath}\"");
            echo $output;die;
        }elseif($type == 2){
            $html = View::make($template)->with('data',$infor_ticket)->render();
            $signature = false;
            $filepath = $filename.".pdf";
            $this->pdfOutput($html, $filepath, 'I', $signature);
        }
    }

    function pdfOutput($html, $filename, $outputType = 'I', $signature = false){
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'px', PDF_PAGE_FORMAT, true, 'UTF-8', false, false, $signature);

        // set document information
        $pdf->SetCreator('VCCorp System');
        $pdf->SetAuthor('VCCorp');
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('VCCorp, contract');
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->setFontSubsetting(false);

        //set margins
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        $pdf->Output($filename, $outputType);
    }
}