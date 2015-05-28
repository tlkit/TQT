<?php
/**
 * QuynhTM
 */


class AdminBookController extends  AdminController{
    private $error = array();
    private $permiss_view = 'book_view';
    private $permiss_create = 'book_create';
    private $permiss_update = 'book_update';
    private $permiss_status = 'book_status';
    private $permiss_delete = 'book_delete';

    public function __construct() {
        parent::__construct();
        CGlobal::$pageTitle = "Quản lý sách | VCC SEO pro";
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
        $search['book_id'] = addslashes(Request::get('book_id',''));
        $search['book_name'] = addslashes(Request::get('book_name',''));
        $search['book_status'] = (int)Request::get('book_status',-1);
        if(!$this->is_root){
            $search['book_user_id_creater'] = User::user_id();
        }

        $dataSearch = SeoBook::searchByCondition($search, CGlobal::PAGIN_LIMIT_DEFAULT, $offset);
        $optStatus = FunctionLib::getOption(CGlobal::$status, $search['book_status']);
        if(!empty($dataSearch)) {
            $size = isset($dataSearch['size']) ? $dataSearch['size'] : 0;
            $data = isset($dataSearch['data']) ? $dataSearch['data'] : 0;
            $pagging = isset($dataSearch['size']) ? Pagging::getNewPager(3, $pageNo, $size, CGlobal::PAGIN_LIMIT_DEFAULT,$search) : '';
        }

        $this->layout->content = View::make('admin.AdminBook.index')
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
        CGlobal::$pageTitle = "Thêm - sửa sách | VCC SEO pro";
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission) && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $data = array();
        if($id > 0) {
            $data = SeoBook::find($id);
        }
        $book_status = isset($data['book_status']) ? $data['book_status'] : -1;
        $optStatus = FunctionLib::getOption(CGlobal::$status, $book_status);
        $this->layout->content = View::make('admin.AdminBook.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optStatus', $optStatus);
    }

    public function postCreate($id=0) {
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission) && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $dataSave['book_name'] = addslashes(Request::get('book_name'));
        $dataSave['book_status'] = (int)Request::get('book_status', -1);

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                $dataSave['book_user_id_modify'] = User::user_id();
                $dataSave['book_user_name_modify'] = User::user_name();
                $dataSave['book_time_modify'] = time();
                if(SeoBook::updData($id, $dataSave)) {
                    return Redirect::route('book.index',array('url'=>base64_encode(URL::current())));
                }
            } else {
                $dataSave['book_user_id_creater'] = User::user_id();
                $dataSave['book_user_name_creater'] = User::user_name();
                $dataSave['book_time_creater'] = time();
                if(SeoBook::add($dataSave)) {
                    return Redirect::route('book.index',array('url'=>base64_encode(URL::current())));
                }
            }
        }
        $optStatus = FunctionLib::getOption(CGlobal::$status, $dataSave['book_status']);
        $this->layout->content = View::make('admin.AdminBook.add')
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
        if($id > 0 && SeoBook::delData($id)) {
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
        if($id > 0 && SeoBook::updStatus($id,$val_status)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(!isset($data['book_name']) || $data['book_name'] == '') {
                $this->error[] = 'Tên sách không được trống';
            }
            if(!isset($data['book_status']) || $data['book_status'] == -1) {
                $this->error[] = 'Bạn chưa chọn trạng thái cho sách';
            }
            return true;
        }
        return false;
    }
}
