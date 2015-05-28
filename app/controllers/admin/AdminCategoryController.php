<?php
/**
 * QuynhTM
 */


class AdminCategoryController extends  AdminController{
    private $error = array();
    private $permiss_view = 'category_view';
    private $permiss_create = 'category_create';
    private $permiss_update = 'category_update';
    private $permiss_status = 'category_status';
    private $permiss_delete = 'category_delete';

    public function __construct() {
        parent::__construct();
        CGlobal::$pageTitle = "Danh mục Seo | VCC SEO pro";
    }

    public function index() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permiss_view,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $pageNo = (int) Request::get('page_no',1);
        $offset = ($pageNo -1)*CGlobal::PAGIN_LIMIT_DEFAULT;

        $search = $data = array();
        $pagging = '';
        $size = 0;
        $search['category_id'] = addslashes(Request::get('category_id',''));
        $search['category_name'] = addslashes(Request::get('category_name',''));
        $search['category_status'] = (int)Request::get('category_status',-1);
        if(!$this->is_root){
            $search['category_user_id_creater'] = User::user_id();
        }

        $dataSearch = SeoCategory::searchByCondition($search, CGlobal::PAGIN_LIMIT_DEFAULT, $offset);
        $optStatus = FunctionLib::getOption(CGlobal::$status, $search['category_status']);
        if(!empty($dataSearch)) {
            $size = isset($dataSearch['size']) ? $dataSearch['size'] : 0;
            $data = isset($dataSearch['data']) ? $dataSearch['data'] : 0;
            $pagging = isset($dataSearch['size']) ? Pagging::getNewPager(3, $pageNo, $size, CGlobal::PAGIN_LIMIT_DEFAULT,$search) : '';
        }

        $this->layout->content = View::make('admin.AdminCategory.index')
            ->with('pagging', $pagging)
            ->with('stt', ($pageNo-1)*CGlobal::PAGIN_LIMIT_DEFAULT)
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
        CGlobal::$pageTitle = "Thêm - sửa danh mục | VCC SEO pro";
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission) && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $data = array();
        if($id > 0) {
            $data = SeoCategory::find($id);
        }
        $category_status = isset($data['category_status']) ? $data['category_status'] : -1;
        $optStatus = FunctionLib::getOption(CGlobal::$status, $category_status);
        $this->layout->content = View::make('admin.AdminCategory.AddCategory')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optStatus', $optStatus);
    }

    public function postCreate($id=0) {
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission) && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $dataSave['category_name'] = addslashes(Request::get('category_name'));
        $dataSave['category_status'] = (int)Request::get('category_status', -1);

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                $dataSave['category_user_id_modify'] = User::user_id();
                $dataSave['category_user_name_modify'] = User::user_name();
                if(SeoCategory::updData($id, $dataSave)) {
                    return Redirect::route('category.index',array('url'=>base64_encode(URL::current())));
                }
            } else {
                $dataSave['category_user_id_creater'] = User::user_id();
                $dataSave['category_user_name_creater'] = User::user_name();
                if(SeoCategory::add($dataSave)) {
                    return Redirect::route('category.index',array('url'=>base64_encode(URL::current())));
                }
            }
        }
        $optStatus = FunctionLib::getOption(CGlobal::$status, $dataSave['category_status']);
        $this->layout->content = View::make('admin.AdminCategory.AddCategory')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('optStatus', $optStatus);
    }

    public function del() {
        $data = array('error' => 1);
        if(!$this->is_root && !in_array($this->permiss_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if($id > 0 && SeoCategory::delData($id)) {
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
        if($id > 0 && SeoCategory::updStatus($id,$val_status)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(!isset($data['category_name']) || $data['category_name'] == '') {
                $this->error[] = 'Tên danh mục không được trống';
            }
            if(!isset($data['category_status']) || $data['category_status'] == -1) {
                $this->error[] = 'Bạn chưa chọn trạng thái danh mục';
            }
            return true;
        }
        return false;
    }
}
