<?php
/**
 * QuynhTM
 */


class AdminUploadController extends  AdminController{
    private $error = array();
    private $permiss_create = 'book_upload';
    private $dir = '';
    private $books = array();

    public function __construct() {
        parent::__construct();
        CGlobal::$pageTitle = "Quản lý upload | VCC SEO pro";
        $this->dir = public_path() . DIRECTORY_SEPARATOR . 'upload_file/';
        $this->books = SeoBook::getBooksAll();
    }

    public function uploadFileOk() {
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $dataMsg = array();
        $msg_suss ='';
        if(Session::has('dataUploadFileSuss')){
            $dataMsg = Session::get('dataUploadFileSuss');
            if(!empty($dataMsg)){
                $msg_suss = 'Bạn đã Inport file thành công';
            }
            Session::forget('dataUploadFileSuss');
        }else{
            return Redirect::route('upload.getCreate');
        }
        //FunctionLib::debug($dataMsg);
        $this->layout->content = View::make('admin.AdminUpload.index')->with('msg_suss', $msg_suss)->with('data', $dataMsg);
    }

    public function getCreate($id=0) {
        CGlobal::$pageTitle = "Thêm - sửa sách | VCC SEO pro";
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $data = array();
        if($id > 0) {
            $data = SeoBook::find($id);
        }
        $aryCategory = SeoCategory::getCategoryAll();
        $optCategoryUpload = FunctionLib::getOption(array(0 => ' [ Chọn chuyên mục ] ') + $aryCategory, 0);

        $optBooks = FunctionLib::getOption(array(0 => '[ Chọn loại sách ]') + $this->books, 0);
        $optTypeload = FunctionLib::getOption(array(0 => ' [ Chọn kiểu inport ] ',1=>'Upload file',2=>'Inport file từ thư mục'), 1);
        $optTypeBook = FunctionLib::getOption(array(0 => ' [ Chọn nhập tên sách ] ',1=>'Nhập tên sách mới',2=>'Chọn danh mục sách đã có'), 1);
        $this->layout->content = View::make('admin.AdminUpload.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('msg_suss', '')
            ->with('optTypeload', $optTypeload)
            ->with('optTypeBook', $optTypeBook)
            ->with('optBooks', $optBooks)
            ->with('optCategoryUpload', $optCategoryUpload);
    }

    public function postCreate($id=0) {
        if(!$this->is_root && !in_array($this->permiss_create,$this->permission)){
            return Redirect::route('admin.page_error');
        }
        $dataSave['upload_category'] = addslashes(Request::get('upload_category'));

        $type_book = (int)Request::get('type_book',1);
        if($type_book == 1){
            $dataSave['book_name'] = addslashes(Request::get('book_name'));
        }elseif($type_book == 2){
            $dataSave['book_id'] = (int)Request::get('book_id',0);
        }else{
            $this->error[] = 'Bạn chưa chọn kiểu nhập tên Sách';
        }

        $dataSave['upload_type'] = (int)Request::get('upload_type',1);
        if($dataSave['upload_type'] == 2){
            $dataSave['folder_upload'] = addslashes(Request::get('folder_upload'));
        }

        if($dataSave['upload_type'] == 1){
            //upload file
            $infoUpload = array();
            if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
                $infoUpload = $this->upload_file_seo($_FILES["files"]);
            }
            if(isset($infoUpload['error'])){
                foreach ($infoUpload['error'] as $k =>$error) {
                    $this->error[] = $error;
                }
            }
        }

        //FunctionLib::debug($infoUpload);
        $insert = false;
        $book_id = 0;$book_name = '';
        $dataMsg = array();

        if($this->valid($dataSave)){
            if(empty($this->error) && $dataSave['upload_type'] == 1) {
                if(isset($infoUpload['Ok']) && !empty($infoUpload['Ok'])){
                    if($type_book == 1){
                        $book_id = $this->addBookNew($dataSave['book_name']);
                        $book_name = $dataSave['book_name'];
                    }elseif($type_book == 2){
                        $book_id = $dataSave['book_id'];
                        $book_name =isset($this->books[$book_id]) ? $this->books[$book_id]:'';
                    }

                    foreach($infoUpload['Ok'] as $k=> $file_upload){
                        $dataFileInput = $this->processContentFileHtml($file_upload['link_file']);
                        $total_post = 0;
                        if(is_array($dataFileInput) && !empty($dataFileInput)){
                            foreach($dataFileInput as $k =>$content){
                                $dataDB['posts_status'] = 0;
                                $dataDB['posts_approve'] = 1;
                                $dataDB['posts_created_at'] = time();
                                $dataDB['posts_user_created_at'] = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
                                $dataDB['posts_username_created_at'] = isset($this->user['user_name']) ? $this->user['user_name'] : '';
                                $name_fix = ($k < 9)? '-0'.($k+1) : '-'.($k+1);
                                $dataDB['posts_title'] = $book_name.$name_fix;
                                $dataDB['posts_slug'] = FunctionLib::safe_title($dataDB['posts_title']);
                                $dataDB['posts_content'] = $content;
                                $dataDB['posts_desc'] = FunctionLib::cutString(strip_tags($content), 50);
                                $dataDB['category_id'] = $dataSave['upload_category'];
                                $dataDB['books_id'] = $book_id;
                                if(Posts::add($dataDB)) {
                                    $insert = true;
                                    $total_post++;
                                }
                            }
                        }
                        //xóa file vừa lấy dữ liệu
                        $file_remove = $this->dir . $file_upload['name_file'];
                        if (file_exists($file_remove)) {
                            @unlink($file_remove);
                        }
                        $dataMsg[]= array('link_file'=>$file_upload['link_file'],'total_post'=>$total_post);
                    }
                }
            }

            //input du lieu tu thu muc tren server
            if(empty($this->error) && $dataSave['upload_type'] == 2){
                $listFile = glob('../public/upload_file/'.$dataSave['folder_upload'].'/*.html');
                if(is_array($listFile) && !empty($listFile)){
                    if($type_book == 1){
                        $book_id = $this->addBookNew($dataSave['book_name']);
                        $book_name = $dataSave['book_name'];
                    }elseif($type_book == 2){
                        $book_id = $dataSave['book_id'];
                        $book_name =isset($this->books[$book_id]) ? $this->books[$book_id]:'';
                    }
                    foreach($listFile as $file){
                        $dataFileInput = $this->processContentFileHtml($file);

                        $total_post = 0;
                        if(is_array($dataFileInput) && !empty($dataFileInput)){
                            foreach($dataFileInput as $k =>$content){
                                $dataDB['posts_status'] = 0;
                                $dataDB['posts_approve'] = 1;
                                $dataDB['posts_created_at'] = time();
                                $dataDB['posts_user_created_at'] = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
                                $dataDB['posts_username_created_at'] = isset($this->user['user_name']) ? $this->user['user_name'] : '';
                                $name_fix = ($k < 9)? '-0'.($k+1) : '-'.($k+1);
                                $dataDB['posts_title'] = $book_name.$name_fix;
                                $dataDB['posts_slug'] = FunctionLib::safe_title($dataDB['posts_title']);
                                $dataDB['posts_content'] = $content;
                                $dataDB['posts_desc'] = FunctionLib::cutString(strip_tags($content), 50);
                                $dataDB['category_id'] = $dataSave['upload_category'];
                                $dataDB['books_id'] = $book_id;
                                if(Posts::add($dataDB)) {
                                    $insert = true;
                                    $total_post++;
                                }
                            }

                            //xóa file vừa inport xong
                            if (file_exists($file)) {
                                @unlink($file);
                            }
                        }
                        $dataMsg[]= array('link_file'=>$file,'total_post'=>$total_post);
                    }
                }else{
                    $this->error[] = 'Thư mục file_input không tồn tại hoặc bị trống, nên không up inport dữ liệu được';
                }

                //xóa thu mục khi đã upload xong
                $folder_upload = $this->dir.$dataSave['folder_upload'];
                $listFile = glob('../public/upload_file/'.$dataSave['folder_upload'].'/*.html');
                if (is_dir($folder_upload) && count($listFile) == 0){
                    @rmdir($folder_upload);
                }
            }
        }

        if($insert == true) {
            Session::put('dataUploadFileSuss', $dataMsg,10000);
            if(!empty($dataMsg)){
                $myFile = $this->dir."log_upload_file.txt";
                $stringData = "\n";
                foreach($dataMsg as $k => $val){
                    $stringData .= ' Ngày '.date('d-m-Y',time()).': Upload file '.$val['link_file'].' --- Inport duoc '.$val['total_post'].' so bai viet'."\n";
                }
                if(is_file($myFile)){
                    $current = file_get_contents($myFile);
                    $current .= $stringData;
                    file_put_contents($myFile, $current);
                }
            }
            return Redirect::route('upload.uploadFileOk',array('url'=>base64_encode(URL::current())));
        }else{
            $this->error[] = 'Có lỗi khi nhập dữ liệu qua file, yêu cầu nhập lại';
        }

        $aryCategory = SeoCategory::getCategoryAll();
        $optCategoryUpload = FunctionLib::getOption(array(0 => ' [ Chọn chuyên mục ] ') + $aryCategory, $dataSave['upload_category']);
        $optBooks = FunctionLib::getOption(array(0 => '[ Chọn loại sách ]') + $this->books, isset($dataSave['book_id'])?$dataSave['book_id']:0);
        $optTypeload = FunctionLib::getOption(array(0 => ' [ Chọn kiểu inport ] ',1=>'Upload file',2=>'Inport file từ thư mục'), $dataSave['upload_type']);
        $optTypeBook = FunctionLib::getOption(array(0 => ' [ Chọn nhập tên sách ] ',1=>'Nhập tên sách mới',2=>'Chọn danh mục sách đã có'), $type_book);
        $this->layout->content = View::make('admin.AdminUpload.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('msg_suss', '')
            ->with('error', $this->error)
            ->with('optBooks', $optBooks)
            ->with('optTypeBook', $optTypeBook)
            ->with('optTypeload', $optTypeload)
            ->with('optCategoryUpload', $optCategoryUpload);
    }

    public function addBookNew($book_name){
        $book_id = 0;
        if($book_name != ''){
            $dataSave['book_user_id_creater'] = User::user_id();
            $dataSave['book_user_name_creater'] = User::user_name();
            $dataSave['book_time_creater'] = time();
            $dataSave['book_name'] = $book_name;
            $dataSave['book_status'] = 1;
            $book_id = SeoBook::add($dataSave);
        }
        return $book_id;
    }
    public function upload_file_seo($file_upload){
        $valid_formats = array("html");
        $link_url = Config::get('config.WEB_ROOT'). DIRECTORY_SEPARATOR . 'upload_file/';
        if (!is_dir($this->dir))
        {
            mkdir($this->dir, true);
        }
        $arrUrlFile = array();
        if(isset($file_upload)){
            foreach ($file_upload['name'] as $f => $name) {
                //build name va type file
                $type_file = self::getTypeFile($name);
                $nameImg = explode('.',$name);
                $name_file = 'file_seo';
                if(isset($nameImg[0])){
                    $name_file = $nameImg[0];
                }
                $uni = rand(10000, 99999);
                $name_file = $name_file.'_'.$uni;
                if ($file_upload['error'][$f] == 4) {
                    $arrUrlFile['error'][] = 'Bạn chưa chọn file upload';
                    continue;
                }
                if ($file_upload['error'][$f] == 0) {
                        if( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                        $arrUrlFile['error'][] = "$name is not a valid format";
                        continue;
                    }
                    else{
                        if(move_uploaded_file($file_upload["tmp_name"][$f], $this->dir.$name_file.$type_file)) {
                            $arrUrlFile['Ok'][] = array('link_file'=>$link_url.$name_file.$type_file,'name_file'=>$name_file.$type_file);
                        }
                    }
                }
            }
        }
        //FunctionLib::debug($arrUrlFile);
        return $arrUrlFile;
    }
    // lấy type file
    public function getTypeFile($img_src) {
        $img_type = strtolower(strrchr($img_src, '.'));
        $arrExts = array('.html');
        if (!in_array($img_type, $arrExts)) {
            $img_type = '.html';
        }
        return ($img_type != '') ? $img_type : false;
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['book_name']) && $data['book_name'] == '') {
                $this->error[] = 'Bạn chưa chọn tên sách';
            }
            if(isset($data['book_id']) && $data['book_id'] == 0) {
                $this->error[] = 'Bạn chưa chọn Danh mục sách có sẵn';
            }

            if(isset($data['upload_category']) && $data['upload_category'] == 0) {
                $this->error[] = 'Bạn chưa chọn chuyên mục upload';
            }

            if(isset($data['upload_type']) && $data['upload_type'] == 0) {
                $this->error[] = 'Bạn chưa chọn kiểu inport dữ liệu';
            }

            if(isset($data['folder_upload']) && $data['folder_upload'] == '') {
                $this->error[] = 'Bạn chưa điền tên folder chưa file inport';
            }
            return true;
        }
        return false;
    }
    /** xu ly noi dung tu file html, cat file html ra thanh cac doan nho khac nhau, moi doan toi thieu 5 the p
     * @param string $url
     * @return array|bool
     */

    public function processContentFileHtml($url= ''){
        if($url !== ''){
            $html =  DomHtml::file_get_html($url);
            $xxx=$html->find('p');
            $content = array();
            if(sizeof($xxx) >= 10){// neu so dong lon hon 10 thi chia ra
                $count = floor(sizeof($xxx)/5);
                for($i=0;$i<=$count;$i++){
                    $y = $i*5;
                    $z=$y+5;
                    if(($y+4) > (sizeof($xxx) -5)){ // neu doan van tiep theo it hon 5 thi khong cat
                        $z = sizeof($xxx);
                    }
                    $textContent ='';
                    for($k=$y;$k < $z & $k <sizeof($xxx);$k++){
                        $textContent .= $xxx[$k]->outertext() ;
                    }
                    $content[] = $textContent;
                    if( $z == sizeof($xxx)){
                        break;
                    }
                }
            }else{
                $textContent = '';
                foreach($xxx as $element){
                    $textContent .=$element->outertext();
                }
                $content[] = $textContent;
            }
            return $content;
        }
        return false;
    }
}
