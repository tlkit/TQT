<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/2/15
 * Time: 2:13 PM
 */

include( __DIR__ . '/../../library/dom/simple_html_dom.php');
class AdminPostsController extends  AdminController{
    private $category = array();
    private $error = array();
    private $permiss_view = 'posts_view';
    private $permiss_view_all = 'posts_view_all';
    private $permiss_update = 'posts_update';
    private $permiss_approve = 'posts_approve';
    private $permiss_delete = 'posts_delete';

    public function __construct() {
        parent::__construct();
        CGlobal::$pageTitle = "Danh sách bài viết hỗ trợ | VCC SEO pro";
        //Include css
        FunctionLib::link_css(array(
            '../admin/lib/datetimepicker_new/datetimepicker.css',
            '../admin/css/cssUpload.css',
            //'../admin/css/admin_style.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            //'common.js',
            //'form_validate.js',
            //'../admin/js/admin_validate_form.js',
            '../admin/lib/datetimepicker_new/jquery.datetimepicker.js',
            //'../admin/js/admin_validate.js'
            '../admin/js/admin_validate.js',
            '../admin/js/ajaxupload.3.5.js',
            '../admin/js/jquery.uploadfile.js',
            '../js/plugins/ckeditor/ckeditor.js',
            '../admin/js/SysProduct.js'
        ));

        $this->categories = SeoCategory::getCategoryAll();
        $this->books = SeoBook::getBooksAll();
        $this->projects = SeoProject::getProjectAll();
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
        $search['posts_title'] = addslashes(Request::get('posts_title',''));
        $search['category_id'] = (int)Request::get('category_id',0);
        $search['books_id'] = (int)Request::get('books_id',0);
        $search['projects_id'] = (int)Request::get('projects_id',0);
        $search['posts_is_run'] = (int)Request::get('posts_is_run',0);
        $search['username'] = Request::get('username','');
        $search['posts_status'] = (int)Request::get('posts_status',-1);
        $search['created_at_start'] = Request::get('created_at_start','');
        $search['created_at_end'] = Request::get('created_at_end','');
        $search['is_admin'] = 0; //($this->is_root || in_array($this->permiss_view_all,$this->permission)) ? 0 : $this->user['user_id'];

        $dataSearch = Posts::searchByCondition($search, CGlobal::PAGIN_LIMIT_DEFAULT, $offset);

        //FunctionLib::debug($dataSearch);
        $optStatus = FunctionLib::getOption(CGlobal::$status, $search['posts_status']);
        $optCategory = FunctionLib::getOption(array(0 => ' [ Tất cả ] ') + $this->categories, $search['category_id']);
        $optBooks = FunctionLib::getOption(array(0 => ' [ Tất cả ] ') + $this->books, $search['books_id']);
        $optProjects = FunctionLib::getOption(array(0 => ' [ Tất cả ] ') + $this->projects, $search['projects_id']);
        $optPostsIsRun = FunctionLib::getOption(array(0 => ' [ Tất cả ] ', 1 => 'Đã chạy', 2 => 'Chưa chạy'), $search['posts_is_run']);

        if(!empty($dataSearch)) {
            $size = isset($dataSearch['size']) ? $dataSearch['size'] : 0;
            $data = isset($dataSearch['data']) ? $dataSearch['data'] : 0;
            $pagging = isset($dataSearch['size']) ? Pagging::getNewPager(3, $pageNo, $size, CGlobal::PAGIN_LIMIT_DEFAULT,$search) : '';
        }

        $this->layout->content = View::make('admin.AdminPosts.index')
                                    ->with('pagging', $pagging)
                                    ->with('size', $size)
                                    ->with('stt', ($pageNo-1)*CGlobal::PAGIN_LIMIT_DEFAULT)
                                    ->with('sizeShow', count($data))
                                    ->with('data', $data)
                                    ->with('books', $this->books)
                                    ->with('categories', $this->categories)
                                    ->with('optCategory', $optCategory)
                                    ->with('optBooks', $optBooks)
                                    ->with('optProjects', $optProjects)
                                    ->with('optPostsIsRun', $optPostsIsRun)
                                    ->with('dataSearch', $search)
                                    ->with('optStatus', $optStatus);
//        parent::debug();
    }

    public function getCreate($posts_id=0) {
        CGlobal::$pageTitle = "Thêm - sửa bài viết hỗ trợ | VCC SEO pro";
        if(!$this->is_root && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $data = array();
        if($posts_id > 0) {
            $data = Posts::find($posts_id);
            $data['img_src'] = Image::buildUrlImage($data['posts_image']);
            $data['website'] = (isset($data['posts_website']) && $data['posts_website'] != '') ? explode(',', $data['posts_website']) : array();
        } else {
            $data['category_id'] = (Session::has('category_id')) ? Session::get('category_id') : '';
            $data['books_id'] = (Session::has('books_id')) ? Session::get('books_id') : '';
        }
        //FunctionLib::debug($data);
        $posts_status = isset($data['posts_status']) ? $data['posts_status'] : -1;
        $category_id = isset($data['category_id']) ? $data['category_id'] : -1;
        $books_id = isset($data['books_id']) ? $data['books_id'] : -1;

        $optCategory = FunctionLib::getOption(array(0 => '[ Chuyên mục ]') + $this->categories, $category_id);
        $optBooks = FunctionLib::getOption(array(0 => '[ Loại sách ]') + $this->books, $books_id);
        $optStatus = FunctionLib::getOption(CGlobal::$status, $posts_status);
        $website = Website::getAll();
        $this->layout->content = View::make('admin.AdminPosts.add')
                                    ->with('posts_id', $posts_id)
                                    ->with('data', $data)
                                    ->with('website', $website)
                                    ->with('optStatus', $optStatus)
                                    ->with('optCategory', $optCategory)
                                    ->with('optBooks', $optBooks);
    }

    public function postCreate($posts_id=0) {
        //Check permission
        if(!$this->is_root && !in_array($this->permiss_update,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $dataSave['posts_title'] = addslashes(Request::get('posts_title'));
        $dataSave['posts_content'] = Request::get('posts_content');
        $dataSave['category_id'] = (int) Request::get('category_id', 0);
        $dataSave['books_id'] = (int)Request::get('books_id', 0);
        $dataSave['posts_tags'] = addslashes(Request::get('posts_tags', 0));
        $dataSave['posts_status'] = (int)Request::get('posts_status', 0);
        $dataSave['posts_slug'] = FunctionLib::safe_title($dataSave['posts_title']);
        $dataSave['posts_desc'] = FunctionLib::cutString(strip_tags($dataSave['posts_content']), 50);
        $dataSave['posts_content'] = $this->replace_img_src($dataSave['posts_content'], $dataSave['posts_title']);
        $posts_website = Request::get('posts_website');
        $dataSave['posts_website'] = (!empty($posts_website)) ? implode(',', $posts_website) : '';

        if($this->valid($dataSave) && empty($this->error)) {
            Session::put('category_id', $dataSave['category_id']);
            Session::put('books_id', $dataSave['books_id']);
            if(isset($_FILES['posts_image']['error']) && $_FILES['posts_image']['error'] == 0) {
                $folderImage = (Config::get('config.DEVMODE')) ? Image::FOLDER_PRODUCT_DEV : Image::FOLDER_PRODUCT_PRODUCT;
                $filename = Image::uploadImg($folderImage,$_FILES['posts_image']);
                $dataSave['posts_image'] = $filename;
            }
            if($posts_id > 0) {
                $dataSave['posts_updated_at'] = time();
                $dataSave['posts_user_updated_at'] = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
                $dataSave['posts_username_updated_at'] = isset($this->user['user_name']) ? $this->user['user_name'] : '';
                if(Posts::updData($posts_id, $dataSave)) {
                    return Redirect::route('posts.index',array('url'=>base64_encode(URL::current())));
                }
            } else {
                $dataSave['posts_created_at'] = time();
                $dataSave['posts_user_created_at'] = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
                $dataSave['posts_username_created_at'] = isset($this->user['user_name']) ? $this->user['user_name'] : '';
                if(Posts::add($dataSave)) {
                    return Redirect::route('posts.index',array('url'=>base64_encode(URL::current())));
                }
            }
        }
        $optCategory = FunctionLib::getOption(array(0 => '[ Chuyên mục ]') + $this->categories, $dataSave['category_id']);
        $optBooks = FunctionLib::getOption(array(0 => '[ Loại sách ]') + $this->books, $dataSave['books_id']);
        $optStatus = FunctionLib::getOption(CGlobal::$status, $dataSave['posts_status']);
        $this->layout->content = View::make('admin.AdminPosts.add')
            ->with('posts_id', $posts_id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('optCategory', $optCategory)
            ->with('optBooks', $optBooks)
            ->with('optStatus', $optStatus);
    }

    public function del() {
        //Check permission
        if(!$this->is_root && !in_array($this->permiss_delete,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $posts_id = (int)Request::get('id', 0);
        $data = array('error' => 1);
        if($posts_id > 0 && Posts::delData($posts_id)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    public function approve($posts_id) {
        //Check permission
        if(!$this->is_root && !in_array($this->permiss_approve,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $data = array('error' => 1);
        if($posts_id > 0 && Posts::approve($posts_id)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    public function uploadMultipleImageOther(){
        $dataImg = $_FILES["multipleFile"];
        $arrAjax = array('intReturn' => 0, 'info' => array(), 'msg'=>'Có lỗi upload ảnh');
        if(!empty($dataImg)){
            $folderImage = (Config::get('config.DEVMODE')) ? Image::FOLDER_PRODUCT_DEV : Image::FOLDER_PRODUCT_PRODUCT;
            $tmpImg = array();
            $images = Image::uploadImg($folderImage,$dataImg);
            $tmpImg['name_img_orther'] = $images;
            $tmpImg['id_key'] = rand(10000, 99999);
            $tmpImg['src'] = Image::buildUrlImage($images);
            return Response::json(array('intReturn' => 1, 'info' => $tmpImg));
        }
        return Response::json($arrAjax);
    }

    public function uploadImageOther(){
        $folderImage = (Config::get('config.DEVMODE')) ? Image::FOLDER_PRODUCT_DEV : Image::FOLDER_PRODUCT_PRODUCT;
        $name_file_upload ='uploadfile';
        $tmpImg = array();
        $images = Image::uploadImg($folderImage,$_FILES[$name_file_upload]);
        $tmpImg['name_img_orther'] = $images;
        $tmpImg['id_key'] = rand(10000, 99999);
        $tmpImg['src'] = Image::buildUrlImage($images);
        return Response::json(array('intReturn' => 1, 'info' => $tmpImg));
    }

    /*
     * up ảnh sản phẩm cho phần nổi bật
     */
    public function uploadImageHotProduct(){
        $folderImage = (Config::get('config.DEVMODE')) ? Image::FOLDER_PRODUCT_DEV : Image::FOLDER_PRODUCT_PRODUCT;
        $name_file_upload ='uploadfile';
        $tmpImg = array();
        $images = Image::uploadImg($folderImage,$_FILES[$name_file_upload]);
        $tmpImg['name_img_orther'] = $images;
        $tmpImg['id_key'] = rand(10000, 99999);
        $tmpImg['src'] = Image::buildUrlImage($images);
        return Response::json(array('intReturn' => 1, 'info' => $tmpImg));
    }

    public function getImagesOther(){
        $arrViewImgOther = array();
        $dataImg = Request::get('dataImg',array());
        $arrAjax = array('intReturn' => 0, 'info' => $arrViewImgOther);
        if(!empty($dataImg)){
            if(!empty($dataImg)){
                foreach($dataImg as $k=>$val){
                    if($val !='')
                        $arrViewImgOther[] = array('img_other'=>$val,'src'=>Image::buildUrlImage($val));
                }
            }

            if(!empty($arrViewImgOther)){
                $arrAjax['info'] = $arrViewImgOther;
                $arrAjax['intReturn'] = 1;
            }
        }
        return Response::json($arrAjax);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(!isset($data['posts_title']) || $data['posts_title'] == '') {
                $this->error[] = 'Tiêu đề không được trống';
            }
            if(!isset($data['category_id']) || $data['category_id'] <= 0) {
                $this->error[] = 'Chuyên mục không được trống';
            }
            if(!isset($data['books_id']) || $data['books_id'] <= 0) {
                $this->error[] = 'Sách không được trống';
            }
            if(!isset($data['posts_content']) || $data['posts_content'] == '') {
                $this->error[] = 'Nội dung không được trống';
            }
            if(!isset($data['posts_status']) || $data['posts_status'] < 0) {
                $this->error[] = 'Trạng thái không được trống';
            }
            return true;
        }
        return false;
    }

    private function replace_img_src($img_tag, $title) {
        $img_tag = mb_convert_encoding($img_tag, 'HTML-ENTITIES', "UTF-8");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadHTML($img_tag);
        $tags = $doc->getElementsByTagName('img');
        $i = 1;
        foreach($tags as $tag){
            $tag->setAttribute('alt', $title . ' ' . $i);
            $i++;
        }
        header("Content-Type: text/html; charset=utf-8");
        return preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $doc->saveHTML());
    }
}
