<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/2/15
 * Time: 2:13 PM
 */

class AdminWebsiteController extends  AdminController{
    private $error = array();
    private $permiss_view = 'website_view';
    private $permiss_update = 'website_update';
    private $permiss_status = 'website_status';
    private $permiss_delete = 'website_delete';

    public function __construct() {
        parent::__construct();
        CGlobal::$pageTitle = "Danh sách website hỗ trợ | VCC SEO pro";
    }

    public function index() {
        //Check permission
        if(!$this->is_root && !in_array($this->permiss_view,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $pageNo = (int) Request::get('page_no',1);
        $offset = ($pageNo -1)*CGlobal::PAGIN_LIMIT_DEFAULT;
        $search = $data = array();
        $pagging = '';
        $size = 0;
        $search['website_name'] = addslashes(Request::get('website_name',''));
        $search['website_domain'] = addslashes(Request::get('website_domain',''));
        $search['website_status'] = (int)Request::get('website_status',-1);

        $dataSearch = Website::searchByCondition($search, CGlobal::PAGIN_LIMIT_DEFAULT, $offset);
        $optStatus = FunctionLib::getOption(CGlobal::$status, $search['website_status']);
        if(!empty($dataSearch)) {
            $size = isset($dataSearch['size']) ? $dataSearch['size'] : 0;
            $data = isset($dataSearch['data']) ? $dataSearch['data'] : 0;
            $pagging = isset($dataResponse['size']) ? Pagging::getNewPager(3, $pageNo, $size, CGlobal::PAGIN_LIMIT_DEFAULT,$search) : '';
        }

        $this->layout->content = View::make('admin.AdminWebsite.index')
                                    ->with('stt', ($pageNo-1)*CGlobal::PAGIN_LIMIT_DEFAULT)
                                    ->with('pagging', $pagging)
                                    ->with('size', $size)
                                    ->with('sizeShow', count($data))
                                    ->with('data', $data)
                                    ->with('optStatus', $optStatus);
//        parent::debug();
    }

    public function getCreate($website_id=0) {
        CGlobal::$pageTitle = "Thêm - sửa website hỗ trợ | VCC SEO pro";
        //Check permission
        if(!$this->is_root && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }

        $data = array();
        if($website_id > 0) {
            $data = Website::find($website_id);
        }
        $website_status = isset($data['website_status']) ? $data['website_status'] : -1;
        $optStatus = FunctionLib::getOption(CGlobal::$status, $website_status);
        $this->layout->content = View::make('admin.AdminWebsite.add')
                                    ->with('website_id', $website_id)
                                    ->with('data', $data)
                                    ->with('optStatus', $optStatus);



    }

    public function postCreate($website_id=0) {
        //Check permission
        if(!$this->is_root && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }

        $dataSave['website_name'] = addslashes(Request::get('website_name'));
        $dataSave['website_desc'] = addslashes(Request::get('website_desc'));
        $dataSave['website_domain'] = addslashes(Request::get('website_domain'));
        $dataSave['website_status'] = (int)Request::get('website_status', -1);

        if($this->valid($dataSave) && empty($this->error)) {
            if($website_id > 0) {
                $dataSave['website_updated_at'] = time();
                $dataSave['website_user_updated'] = isset($this->user['admin_id']) ? $this->user['admin_id'] : 0;
                if(Website::updData($website_id, $dataSave)) {
                    return Redirect::route('website.index',array('url'=>base64_encode(URL::current())));
                }
            } else {
                $dataSave['website_ip'] = '127.0.0.1';
                $dataSave['website_created_at'] = time();
                $dataSave['website_user_created'] = isset($this->user['admin_id']) ? $this->user['admin_id'] : 0;
                if(Website::add($dataSave)) {
                    return Redirect::route('website.index',array('url'=>base64_encode(URL::current())));
                }
            }
        }
        $optStatus = FunctionLib::getOption(CGlobal::$status, $dataSave['website_status']);
        $this->layout->content = View::make('admin.AdminWebsite.add')
            ->with('website_id', $website_id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('optStatus', $optStatus);
    }

    public function del() {
        $data = array('error' => 1);
        //Check permission
        if(!$this->is_root && !in_array($this->permiss_delete,$this->permission)){
            return Response::json($data);
        }
        $website_id = (int)Request::get('id', 0);
        if($website_id > 0 && Website::delData($website_id)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    public function updateStatus() {
        $data = array('error' => 1);
        //Check permission
        if(!$this->is_root && !in_array($this->permiss_status,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        $status = (int)Request::get('status', 1);
        $val_status = ($status == 1)? 0: 1;
        if($id > 0 && Website::updStatus($id,$val_status)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }


    private function valid($data=array()) {
        if(!empty($data)) {
            if(!isset($data['website_name']) || $data['website_name'] == '') {
                $this->error[] = 'Tên website không được trống';
            }
            if(!isset($data['website_desc']) || $data['website_desc'] == '') {
                $this->error[] = 'Mô tả website không được trống';
            }
            if(!isset($data['website_domain']) || $data['website_domain'] == '') {
                $this->error[] = 'Tên miền không được trống';
            }
            if(!isset($data['website_status']) || $data['website_status'] == -1) {
                $this->error[] = 'Trạng thái website không được trống';
            }
            return true;
        }
        return false;
    }
}
