<?php

/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 4/10/2015
 * Time: 4:08 PM
 */
class AdminSeoCampaignController extends AdminController {

    private $permission_view = 'seo_campaign_view';
    private $permission_add = 'seo_campaign_add';
    private $permission_edit = 'seo_campaign_edit';

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageTitle = "QL Campaign | Admin Seo";
    }

    public function view() {
        CGlobal::$pageTitle = "Xem danh sách Campaign | Admin Seo";
        if(!$this->is_root && !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.page_error');
        }

        $aryProject = SeoProject::getProjectAll();
        $page_no = Request::get('page_no', 1);
        $param['seo_keyword_key'] = Request::get('seo_keyword_key', '');
        $param['seo_campaign_name'] = Request::get('seo_campaign_name', '');
        $param['seo_campaign_project_id'] = (int)Request::get('seo_campaign_project_id', 0);
        $param['seo_campaign_start_from'] = Request::get('seo_campaign_start_from', '');
        $param['seo_campaign_start_to'] = Request::get('seo_campaign_start_to', '');
        $dataSearch = $param;
        $dataSearch['seo_campaign_start_from'] = $dataSearch['seo_campaign_start_from'] != '' ? strtotime($dataSearch['seo_campaign_start_from']) : 0;
        $dataSearch['seo_campaign_start_to'] = $dataSearch['seo_campaign_start_to'] != '' ? strtotime($dataSearch['seo_campaign_start_to']) + 86399 : 0;
        $limit = 30;
        $size = 0;
        $offset = ($page_no - 1) * $limit;
        if($param['seo_keyword_key'] != ''){
            $keyword = SeoKeyWord::getCampaignByKeyName($param['seo_keyword_key']);
            $dataSearch['ary_seo_campaign_id'] = $keyword;
        }
        $data = SeoCampaign::search($dataSearch, $limit, $offset, $size);
        foreach ($data as $k => $v) {
            $aryKey = array();
            foreach($v->keyword as $key){
                $aryKey[] = $key['seo_keyword_key'];
            }
            $v['key'] = implode(',',$aryKey);
            $data[$k] = $v;
        }
        $paging = $size > 0 ? Pagging::getNewPager(3, $page_no, $size, $limit, $param) : '';
        $this->layout->content = View::make('admin.AdminCampaign.view')
            ->with('aryProject', $aryProject)
            ->with('permission_add', $this->is_root || in_array($this->permission_add,$this->permission))
            ->with('permission_edit', $this->is_root || in_array($this->permission_add,$this->permission))
            ->with('param', $param)
            ->with('data', $data)
            ->with('size', $size)
            ->with('offset', $offset)
            ->with('paging', $paging);
    }

    public function createCampaign($id = 0){

        CGlobal::$pageTitle = "Tạo/Sửa Campaign | Admin Seo";
        //check permission
        if($id  == 0){
            if(!$this->is_root && !in_array($this->permission_add,$this->permission)){
                return Redirect::route('admin.page_error');
            }
        }else{
            if(!$this->is_root && !in_array($this->permission_edit,$this->permission)){
                return Redirect::route('admin.page_error');
            }
        }

        $aryProject = SeoProject::getProjectAll();
        $data = array();
        if($id > 0){
            $data = SeoCampaign::find($id);
            if(!$data){
                return Redirect::route('admin.page_error');
            }
        }
        $this->layout->content = View::make('admin.AdminCampaign.create')
            ->with('campaign_id', $id)
            ->with('data', $data)
            ->with('aryProject', $aryProject);
        parent::debug();
    }

    public function postCreateCampaign($id=0) {
        //Check permission
        if($id  == 0){
            if(!$this->is_root && !in_array($this->permission_add,$this->permission)){
                return Redirect::route('admin.page_error');
            }
        }else{
            if(!$this->is_root && !in_array($this->permission_edit,$this->permission)){
                return Redirect::route('admin.page_error');
            }
        }
        $data['seo_campaign_name'] = addslashes(Request::get('seo_campaign_name',''));
        $data['seo_campaign_project_id'] = (int) Request::get('seo_campaign_project_id', 0);
        $data['seo_campaign_start_time'] = Request::get('seo_campaign_start_time', '') != '' ? strtotime(Request::get('seo_campaign_start_time')) : 0;
        $error = array();
        if ($data['seo_campaign_name'] == '') {
            $error[] = 'Chưa nhập tên chiến dịch';
        }
        if ($data['seo_campaign_project_id'] == 0) {
            $error[] = 'Chưa chọn dự án';
        }
        if($id == 0){
            if ($data['seo_campaign_start_time'] == 0) {
                $error[] = 'Chưa chọn thời gian bắt đầu';
            }
            if ($data['seo_campaign_start_time'] < time()) {
                $error[] = 'Ngày bắt đầu chạy phải lớn hơn thời gian hiện tại';
            }
        }else{
            $dataEdit = SeoCampaign::find($id);
            if($dataEdit && $dataEdit->seo_campaign_start_time > time()){
                if ($data['seo_campaign_start_time'] == 0) {
                    $error[] = 'Chưa chọn thời gian bắt đầu';
                    $data['seo_campaign_start_time'] = $dataEdit->seo_campaign_start_time;
                }
                if ($data['seo_campaign_start_time'] < time()) {
                    $error[] = 'Ngày bắt đầu chạy phải lớn hơn thời gian hiện tại';
                    $data['seo_campaign_start_time'] = $dataEdit->seo_campaign_start_time;
                }
            }elseif($dataEdit){
                $data['seo_campaign_start_time'] = $dataEdit->seo_campaign_start_time;
            }else{
                $error[] = 'Không tìm thấy chiến dịch';
            }
        }

        $rows = array();
        if(Input::hasFile('seo_key_file')){
            $file = Input::file('seo_key_file');
            $ext = $file->getClientOriginalExtension();
            switch ($ext) {
                case 'xls':
                case 'xlsx':
                    $objPHPExcel = PHPExcel_IOFactory::load($file);
                    //$objPHPExcel->setActiveSheetIndex(2);
                    //$sheetCount = $objPHPExcel->getSheetCount();
                    $rows = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    unset($rows[1]);
                    break;
                default:
                    $error[] = "Invalid file type";
            }

        }else{
            if($id == 0){
                $error[] = "Not found file input";
            }
        }
        if(sizeof($error) == 0){
            if($id > 0){
                $data['seo_campaign_update_time'] = time();
                $data['seo_campaign_update_id'] = User::user_id();
                if(SeoCampaign::updateCampaign($id,$data, $rows)) {
                    return Redirect::route('campaign.view');
                }else{
                    $error[] = 'Không thể cập nhật dữ liệu';
                }
            }else{
                $data['seo_campaign_status'] = 1;
                $data['seo_campaign_create_time'] = time();
                $data['seo_campaign_create_id'] = User::user_id();
                if(SeoCampaign::createCampaign($data, $rows)) {
                    return Redirect::route('campaign.view');
                }else{
                    $error[] = 'Không thể cập nhật dữ liệu';
                }
            }
        }
        $aryProject = SeoProject::getProjectAll();
        $this->layout->content = View::make('admin.AdminCampaign.create')
            ->with('campaign_id', $id)
            ->with('data', $data)
            ->with('error', $error)
            ->with('aryProject', $aryProject);
    }

    public function delCampaign(){
        $id = (int)Request::get('id',0);
        $data['error'] = 0;
        $campaign  = SeoCampaign::find($id);
        if($campaign){
            $campaign->seo_campaign_status = -1;
            $campaign->save();
            $data['error'] = 1;
        }
        return Response::json($data);
    }

    public function detailCampaign($id)
    {
        $campaign = SeoCampaign::find($id);
        $campaign->keyword;
        $aryProject = SeoProject::getProjectAll();
        $aryCategory = SeoCategory::getCategoryAll();
        $this->layout->content = View::make('admin.AdminCampaign.detail')->with('aryProject', $aryProject)->with('aryCategory', $aryCategory)->with('campaign', $campaign);
    }

}