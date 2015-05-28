<?php
/**
 * QuynhTM
 */


class AdminProjectController extends  AdminController{
    private $error = array();
    private $permiss_view = 'project_view';
    private $permiss_create = 'project_create';
    private $permiss_update = 'project_update';
    private $permiss_delete = 'project_delete';

    public function __construct() {
        parent::__construct();
        CGlobal::$pageTitle = "Quản lý Project | VCC SEO pro";
    }

    public function index() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permiss_view,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $pageNo = (int) Request::get('page_no',0);

        $search = $data = array();
        $pagging = '';
        $size = 0;
        $search['seo_project_id'] = addslashes(Request::get('seo_project_id',''));
        $search['seo_project_name'] = addslashes(Request::get('seo_project_name',''));
        $search['seo_project_status'] = (int)Request::get('seo_project_status',-1);
        if(!$this->is_root){
            $search['seo_project_user_id_creater'] = User::user_id();
        }

        $dataSearch = SeoProject::searchByCondition($search, CGlobal::PAGIN_LIMIT_DEFAULT, $pageNo);
        $optStatus = FunctionLib::getOption(CGlobal::$status, $search['seo_project_status']);
        if(!empty($dataSearch)) {
            $size = isset($dataSearch['size']) ? $dataSearch['size'] : 0;
            $data = isset($dataSearch['data']) ? $dataSearch['data'] : 0;
            $pagging = isset($dataResponse['size']) ? Pagging::getNewPager(3, $pageNo, $size, CGlobal::PAGIN_LIMIT_DEFAULT,$data) : '';
        }

        $this->layout->content = View::make('admin.AdminProject.index')
            ->with('pagging', $pagging)
            ->with('stt', ($pageNo)*CGlobal::PAGIN_LIMIT_DEFAULT)
            ->with('size', $size)
            ->with('sizeShow', count($data))
            ->with('data', $data)
            ->with('search', $search)
            ->with('is_root', $this->is_root)
            ->with('permission_delete', in_array($this->permiss_delete, $this->permission) ? 1 : 0)
            ->with('permission_item', in_array($this->permiss_view, $this->permission) ? 1 : 0)
            ->with('optStatus', $optStatus);
//        parent::debug();
    }

    public function getCreate($id=0) {
        CGlobal::$pageTitle = "Thêm - sửa project | VCC SEO pro";
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission) && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $data = array();
        if($id > 0) {
            $data = SeoProject::find($id);
        }
        $seo_project_status = isset($data['seo_project_status']) ? $data['seo_project_status'] : -1;
        $optStatus = FunctionLib::getOption(CGlobal::$status, $seo_project_status);
        $this->layout->content = View::make('admin.AdminProject.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optStatus', $optStatus);
    }

    public function postCreate($id=0) {
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission) && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $dataSave['seo_project_name'] = addslashes(Request::get('seo_project_name'));
        $dataSave['seo_project_status'] = (int)Request::get('seo_project_status', -1);
        $dataSave['seo_project_position'] = (int)Request::get('seo_project_position', 0);

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                $dataSave['seo_project_user_id_modify'] = User::user_id();
                $dataSave['seo_project_user_name_modify'] = User::user_name();
                $dataSave['seo_project_time_modify'] = time();
                if(SeoProject::updData($id, $dataSave)) {
                    return Redirect::route('project.index',array('url'=>base64_encode(URL::current())));
                }
            } else {
                $dataSave['seo_project_user_id_creater'] = User::user_id();
                $dataSave['seo_project_user_name_creater'] = User::user_name();
                $dataSave['seo_project_time_creater'] = time();
                if(SeoProject::add($dataSave)) {
                    return Redirect::route('project.index',array('url'=>base64_encode(URL::current())));
                }
            }
        }
        $optStatus = FunctionLib::getOption(CGlobal::$status, $dataSave['seo_project_status']);

        $this->layout->content = View::make('admin.AdminProject.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('optStatus', $optStatus);
    }

    public function deleteItem() {
        $data = array('error' => 1);
        if(!$this->is_root && !in_array($this->permiss_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if($id > 0 && SeoProject::delData($id)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    public function updateStatus() {
        $data = array('error' => 1);
        if(!$this->is_root && !in_array($this->permiss_update,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        $status = (int)Request::get('status', 1);
        $val_status = ($status == 1)? 0: 1;
        if($id > 0 && SeoProject::updStatus($id,$val_status)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(!isset($data['seo_project_name']) || $data['seo_project_name'] == '') {
                $this->error[] = 'Tên project không được trống';
            }
            if(!isset($data['seo_project_status']) || $data['seo_project_status'] == -1) {
                $this->error[] = 'Bạn chưa chọn trạng thái cho project';
            }
            return true;
        }
        return false;
    }
}
