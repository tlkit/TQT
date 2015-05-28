<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 7/7/14
 * Time: 9:56 AM
 */

class AdminRegisterController extends AdminController {
    private $arrStatus = array(0=>'Ẩn',1=>'Hiện');
    private $arrStatusProcess = array(0=>'Đang xử lý',1=>'Đã xem',2=>'Đã trả lời');
    private $permission_view = 'view_register_shop';
    private $permission_edit = 'edit_register_shop';
    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageTitle = "QL đăng ký Shop | Admin Plaza";
    }

    public function index(){
        //check permission
        if (!$this->is_root && !in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
        }

        $dataSearch = $dataResponse = $data = array();
        $error['mess'] = '';
        $dataSearch['page_no'] = $page_no = Request::get('page_no',1);//phan trang
        $dataSearch['supplier_temp_name'] = Request::get('supplier_temp_name','');
        $dataSearch['supplier_temp_email'] = Request::get('supplier_temp_email','');
        $dataSearch['supplier_temp_phone'] = Request::get('supplier_temp_phone','');
        $dataSearch['supplier_temp_status'] = Request::get('supplier_temp_status',-1);
        $dataSearch['supplier_temp_status_process'] = Request::get('supplier_temp_status_process',-1);
//        /FunctionLib::debug($dataSearch);
        $limit = 30;
        //call api
        $dataResponse = SupplierTemp::search($limit,$dataSearch,$this->key);
        //kiêm tra login
        if(!Authenticate::checkLogin($dataResponse)){
            return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
        }
        $optionStatus = FunctionLib::getOption(array(-1 => '--- Chưa chọn ---')+$this->arrStatus,$dataSearch['supplier_temp_status']);
        $optionStatusProcess = FunctionLib::getOption(array(-1 => '--- Chưa chọn ---')+$this->arrStatusProcess,$dataSearch['supplier_temp_status_process']);
        $optionStatusProcessRow = FunctionLib::getOption($this->arrStatusProcess,0);
        //FunctionLib::debug($dataSearch);
        if(!empty($dataResponse)){
            if($dataResponse['code'] == 200 && $dataResponse['intIsOK'] == 1){
                $pagging = isset($dataResponse['size']) ? Pagging::getNewPager(3,$page_no,$dataResponse['size'],$limit,$dataSearch) : '';
                $totalItem = isset($dataResponse['size']) ? $dataResponse['size'] : 0;
                $data = $dataResponse['data'];
                $this->layout->content = View::make('admin.AdminRegister.index')
                    ->with('edit_register_shop',in_array($this->permission_edit,$this->permission) ? 1 : 0)
                    ->with('is_root',$this->is_root)
                    ->with('error', $error['mess'])
                    ->with('data', $data)
                    ->with('dataSearch', $dataSearch)
                    ->with('totalItem', $totalItem)
                    ->with('pagging',$pagging)
                    ->with('optionStatus',$optionStatus)
                    ->with('optionStatusProcess',$optionStatusProcess)
                    ->with('optionStatusProcessRow',$optionStatusProcessRow);
            }else{
                $this->layout->content = View::make('admin.AdminRegister.index')
                    ->with('edit_register_shop',in_array($this->permission_edit,$this->permission) ? 1 : 0)
                    ->with('is_root',$this->is_root)
                    ->with('error', $dataResponse['message'])
                    ->with('data', $data)
                    ->with('dataSearch', $dataSearch)
                    ->with('optionStatus',$optionStatus)
                    ->with('optionStatusProcess',$optionStatusProcess)
                    ->with('optionStatusProcessRow',$optionStatusProcessRow);
            }
        }else{
            $error['mess'] = 'Không truy xuất được dữ liệu';
            $this->layout->content = View::make('admin.AdminRegister.index')
                ->with('edit_register_shop',in_array($this->permission_edit,$this->permission) ? 1 : 0)
                ->with('is_root',$this->is_root)
                ->with('error', $error['mess'])
                ->with('data', $data)
                ->with('dataSearch', $dataSearch)
                ->with('optionStatus',$optionStatus)
                ->with('optionStatusProcess',$optionStatusProcess)
                ->with('optionStatusProcessRow',$optionStatusProcessRow);
        }
        parent::debug();
    }


    public function updateRegisterStatus(){
        //check permission
//        $permission = 'edit_register';
//        $checkPermission = FunctionLib::checkPermission($permission,$this->permission_full,$this->key);
//        if($checkPermission == 0){
//            $arrAjax = array('intReturn' => 3);
//            return Response::json($arrAjax);
//        }
//        elseif($checkPermission == 1){
//            $arrAjax = array('intReturn' => 2);
//            return Response::json($arrAjax);
//        }

        if (!$this->is_root && !in_array($this->permission_edit, $this->permission)) {
            $arrAjax = array('intReturn' => 2);
            return Response::json($arrAjax);
        }
        $id = Request::get('id',0);
        $status = Request::get('status',0);
        $arrData = array();
        $arrAjax = array('intReturn' => 0, 'info' => $arrData);
        if($id > 0){
            $statusUpdate = ($status == 0)? 1: 0;
            $dataUpdate['key'] = $this->key;
            $dataUpdate['supplier_temp_status'] = $statusUpdate;
            $dataResponse = SupplierTemp::updateRegister($id,$dataUpdate,$this->key);//update dl
            if(!Authenticate::checkLogin($dataResponse)){
                return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
            }

            if(!empty($dataResponse) && $dataResponse['code'] == 200 && $dataResponse['intIsOK'] == 1){
                $action = 'onclick="shopRegister.updateStatusRegister('.$id.','.$statusUpdate.')"';
                $link_a = '<a id="sys_status_'.$id.'" href="javascript:;"';
                $link_a .= $action;
                $link_a .= ($statusUpdate == 1)? ' class="btn btn-info btn-xs" title="Hiện"><i class="fa fa-check"></i></a>': ' class="btn btn-danger btn-xs"title="Ẩn"><i class="fa fa-minus"></i></a>';
                $arrAjax = array('intReturn' => 1, 'info' => $link_a);
            }
        }
        return Response::json($arrAjax);
    }

    public function deleteRegister(){
        //check permission
        if (!$this->is_root && !in_array($this->permission_edit, $this->permission)) {
            $arrAjax = array('intReturn' => 2);
            return Response::json($arrAjax);
        }

        $id = Request::get('id',0);
        $flag = Request::get('flag',0);
        $arrAjax = array('intReturn' => 0);
        if($id > 0){
            $flagUpdate = ($flag == 0)? 1: 0;
            $dataUpdate['key'] = $this->key;
            $dataUpdate['supplier_temp_del_flg'] = $flagUpdate;
            $dataResponse = SupplierTemp::updateRegister($id,$dataUpdate,$this->key);//update dl
            if(!Authenticate::checkLogin($dataResponse)){
                return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
            }
            if(!empty($dataResponse)){
                if($dataResponse['code'] == 200 && $dataResponse['intIsOK'] == 1){
                    $arrAjax = array('intReturn' => 1);
                }
            }
        }
        return Response::json($arrAjax);
    }

    public function updateStatusProcess(){
        //check permission
        if (!$this->is_root && !in_array($this->permission_edit, $this->permission)) {
            $arrAjax = array('intReturn' => 2);
            return Response::json($arrAjax);
        }

        $id = Request::get('id',0);
        $arrData = array();
        $arrAjax = array('intReturn' => 0, 'info' => $arrData);
        if($id > 0){
            $statusUpdate = Request::get('status',0);
            $dataUpdate['key'] = $this->key;
            $dataUpdate['supplier_temp_status_process'] = $statusUpdate;
            $dataResponse = SupplierTemp::updateRegister($id,$dataUpdate,$this->key);//update dl
            if(!Authenticate::checkLogin($dataResponse)){
                return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
            }

            if(!empty($dataResponse) && $dataResponse['code'] == 200 && $dataResponse['intIsOK'] == 1){
                $action = 'onclick="shopRegister.openUpdateStatusProcess('.$id.')"';
                if($statusUpdate == 0)
                    $statusName = 'Đang xử lý';
                elseif($statusUpdate == 1)
                    $statusName = 'Đã xem';
                else
                    $statusName = 'Đã trả lời';
                $link_a = '<a href="javascript:;"';
                $link_a .= $action;
                $link_a .=' class="btn btn-info btn-xs" title="Sửa trạng thái xử lý">'.$statusName.'</a>';
                $arrAjax = array('intReturn' => 1, 'info' => $link_a);
            }
        }
        return Response::json($arrAjax);
    }
}