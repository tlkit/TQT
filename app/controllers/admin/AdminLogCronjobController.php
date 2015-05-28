<?php
/**
 * QuynhTM
 */


class AdminLogCronjobController extends  AdminController{
    private $permiss_view = 'log_cronjob_view';

    public function __construct() {
        parent::__construct();
        CGlobal::$pageTitle = "Quản lý sách | VCC SEO pro";
        //Include css
        FunctionLib::link_css(array(
            '../admin/lib/datetimepicker_new/datetimepicker.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            '../admin/lib/datetimepicker_new/jquery.datetimepicker.js',
        ));
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
        $search['log_created_at_from'] = addslashes(Request::get('log_created_at_from',''));
        $search['log_created_at_to'] = addslashes(Request::get('log_created_at_to',''));

        $dataSearch = LogAPI::searchByCondition($search, CGlobal::PAGIN_LIMIT_DEFAULT, $offset);
        //FunctionLib::debug($dataSearch);
        if(!empty($dataSearch)) {
            $size = isset($dataSearch['size']) ? $dataSearch['size'] : 0;
            $data = isset($dataSearch['data']) ? $dataSearch['data'] : 0;
            $pagging = isset($dataSearch['size']) ? Pagging::getNewPager(3, $pageNo, $size, CGlobal::PAGIN_LIMIT_DEFAULT,$search) : '';
        }

        $this->layout->content = View::make('admin.AdminLogCronjob.index')
            ->with('pagging', $pagging)
            ->with('stt', ($pageNo-1)*CGlobal::PAGIN_LIMIT_DEFAULT)
            ->with('size', $size)
            ->with('sizeShow', count($data))
            ->with('data', $data)
            ->with('search', $search)
            ->with('is_root', $this->is_root)
            ->with('permission_item', in_array($this->permiss_view, $this->permission) ? 1 : 0);
//        parent::debug();
    }

    public function ajaxViewLog(){
        $idLog = (int)Request::get('id',0);
        $arrData = array();
        $arrAjax = array('intReturn' => 0, 'info' => $arrData, 'msg' => 'Không tìm thấy log này');
        if($idLog > 0){
            $data = LogAPI::find($idLog);
            if(isset($data->log_content)){
                $content = json_decode($data->log_content);
                $html = View::make('admin.AdminLogCronjob.view_log')->with('content', $content)->render();
               // $html = $this->layout->content = View::make('admin.AdminLogCronjob.view_log')->with('content', $content);
                $arrAjax = array('intReturn' => 1, 'info' => $html);
            }else{
                $arrAjax = array('intReturn' => -1, 'msg' => 'Không có log này');
            }
        }
        return Response::json($arrAjax);
    }


}
