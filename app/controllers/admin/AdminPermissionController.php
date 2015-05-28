<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 7/11/14
 * Time: 9:40 AM
 */

class AdminPermissionController extends  AdminController{
    private $arrStatus = array(-1 =>'Xóa',0 => 'Tất cả',1=>'Hoạt động');
//    private $listGroupUser = array();
//    private $arrGroupUser = array();
//    private $permission_view = 'view_permission';
//    private $permission_create = 'create_permission';
//    private $permission_edit = 'edit_permission';
    public function __construct()
    {
        parent::__construct();
//        $this->listGroupUser = $this->getListGroupUser();
//        $this->arrGroupUser = $this->buildArrayGroupUser($this->listGroupUser);
        CGlobal::$pageTitle = "Quản trị quyền | Admin Seo";
    }

    public function index(){
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }

        $dataSearch = $dataResponse = $data = array();
        $page_no = Request::get('page_no',1);//phan trang

        $dataSearch['permission_code'] = Request::get('permission_code','');
        $dataSearch['permission_status'] = Request::get('permission_status',0);

        $limit = 30;
        $offset = ($page_no - 1) * $limit;
        $total = 0;
        //call api
        $aryPermission = Permission::searchPermission($dataSearch,$limit,$offset,$total);
        if(!empty($aryPermission)) {
            $aryPermissionId = array();
            foreach($aryPermission as $val) {
                $aryPermissionId[] = $val->permission_id;
            }
            if(!empty($aryPermissionId)) {
                $groupPermission = new GroupUserPermission();
                $aryGroupUser = $groupPermission->getListGroupByPermissionId($aryPermissionId);
                if(!empty($aryGroupUser)) {
                    foreach($aryPermission as $k => $v) {
                        $items = $v;
                        foreach($aryGroupUser as $val) {
                            if($v->permission_id == $val->permission_id) {
                                $item = isset($v->groups) ? $v->groups : array();
                                $count = isset($v->countGroup) ? $v->countGroup : 0;
                                $item[] = $val;
                                $count++;
                                $items->groups = $item;
                                $items->countGroup = $count;
                            }
                        }
                        $aryPermission[$k] = $items;
                    }
                }
            }
        }

        $paging = $total > 0 ? Pagging::getNewPager(3,$page_no,$total,$limit,$dataSearch) : '';
        $this->layout->content = View::make('admin.AdminPermission.index')

            ->with('data', $aryPermission)
            ->with('dataSearch', $dataSearch)
            ->with('total', $total)
            ->with('paging',$paging)
            ->with('arrStatus',$this->arrStatus);

        parent::debug();
    }

    public function getCreatePermission(){
        CGlobal::$pageTitle = "Tạo mới quyền | Admin Seo";
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }
        //$optionStatus = FunctionLib::getOption($this->arrStatus, 1);
        // Show the page
        $arrGroupUser = GroupUser::getListGroupUser();
        $this->layout->content = View::make('admin.AdminPermission.create_permission')
            //->with('optionStatus',$optionStatus)
            ->with('arrGroupUser',$arrGroupUser);
        parent::debug();
    }

    public function postCreatePermission() {
//        //check permission
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }
        $dataResponse = $data = array();
        $error = array();
        $dataEncode['permission_code'] = Request::get('permission_code', '');
        $dataEncode['permission_name'] = Request::get('permission_name', '');
        $dataEncode['permission_group_name'] = Request::get('permission_group_name', '');
        //encode các ký tự html
        $dataResult = FunctionLib::encodeParam($dataEncode);
        $dataSave['permission_code'] = (!FunctionLib::stripUnicode($dataResult['permission_code'])) ? $dataResult['permission_code'] : FunctionLib::stripUnicode($dataResult['permission_code']);
        $dataSave['permission_name'] = $dataResult['permission_name'];
        $dataSave['permission_status'] = 1;
        $dataSave['permission_group_name'] = (!FunctionLib::stripUnicode($dataResult['permission_group_name'])) ? $dataResult['permission_group_name'] : FunctionLib::stripUnicode($dataResult['permission_group_name']);
        $data = $dataSave;

        $arrGroupUser = $data['user_group'] = Request::get('user_group',array());

        if ($dataResult['permission_code'] == '') {
            $error[] = 'Mã quyền không được để trống ';
        }
        if ($dataResult['permission_group_name'] == '') {
            $error[] = 'Nhóm quyền không được để trống ';
        }
        if(Permission::checkExitsPermissionCode($dataSave['permission_code'])){
            $error[] = 'Mã quyền đã tồn tại ';
        }

        if ($error != null) {
            $this->layout->content = View::make('admin.AdminPermission.create_permission')
                ->with('error', $error)
                ->with('data', $data)
                ->with('arrGroupUser', GroupUser::getListGroupUser());
        } else {

            //insert dl
            if(Permission::createPermission($dataSave, $arrGroupUser)){
                return Redirect::to("admin/permission");
            }else{
                $error[] = 'Lỗi truy xuất dữ liệu';
                $this->layout->content = View::make('admin.AdminPermission.create_permission')
                    ->with('error', $error)
                    ->with('data', $data)
                    ->with('arrGroupUser', GroupUser::getListGroupUser());
            }
        }

        parent::debug();
    }

    public function getEditPermission($id){
        CGlobal::$pageTitle = "Sửa quyền | Admin Seo";
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }
        $data = Permission::find($id);//lay dl permission theo id
        $groupPermission = new GroupUserPermission();
        $dataGroups = $groupPermission->getListGroupByPermissionId(array($id));

        $aryGroup = array();
        if($dataGroups){
            foreach($dataGroups as $group){
                $aryGroup[] = $group->group_user_id;
            }
        }
        $data->user_group = $aryGroup;

        $this->layout->content = View::make('admin.AdminPermission.edit_permission')
            ->with('data',$data)
            ->with('arrStatus',$this->arrStatus)
            ->with('arrGroupUser',GroupUser::getListGroupUser());
        parent::debug();
    }

    public function postEditPermission($id) {
        //check permission
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }

        $error = array();
        $dataEncode['permission_code'] = Request::get('permission_code', '');
        $dataEncode['permission_name'] = Request::get('permission_name', '');
        $dataEncode['permission_group_name'] = Request::get('permission_group_name', '');
        //encode các ký tự html
        $dataResult = FunctionLib::encodeParam($dataEncode);
        if ($dataResult['permission_code'] == '') {
            $error['mess'] = 'Mã quyền không được để trống ';
        }
        if ($dataResult['permission_group_name'] == '') {
            $error['mess'] = 'Nhóm quyền không được để trống ';
        }
        $dataSave['permission_code'] = (!FunctionLib::stripUnicode($dataResult['permission_code'])) ? $dataResult['permission_code'] : FunctionLib::stripUnicode($dataResult['permission_code']);
        $dataSave['permission_name'] = $dataResult['permission_name'];
        $dataSave['permission_status'] = Request::get('permission_status', 1);
        $dataSave['permission_group_name'] = (!FunctionLib::stripUnicode($dataResult['permission_group_name'])) ? $dataResult['permission_group_name'] : FunctionLib::stripUnicode($dataResult['permission_group_name']);

        $data = $dataSave;

        if(Permission::checkExitsPermissionCode($dataSave['permission_code'],$id)){
            $error[] = 'Mã quyền đã tồn tại ';
        }
        $arrGroupUserUpdate = $data['user_group'] = Request::get('user_group',array());

        if ($error != null) {
            $this->layout->content = View::make('admin.AdminPermission.create_permission')
                ->with('error', $error['mess'])
                ->with('data', $data)
                ->with('arrStatus', $this->arrStatus)
                ->with('arrGroupUser', GroupUser::getListGroupUser());
        } else {

            if(Permission::updatePermission($id,$dataSave, $arrGroupUserUpdate)){
                return Redirect::to("admin/permission");
            }else{
                $error[] = 'Lỗi truy xuất dữ liệu';
                $this->layout->content = View::make('admin.AdminPermission.edit_permission')
                    ->with('error', $error)
                    ->with('data', $data)
                    ->with('arrStatus', $this->arrStatus)
                    ->with('arrGroupUser', GroupUser::getListGroupUser());
            }
        }

        parent::debug();
    }

    public function updatePermissionStatus(){
        //check permission
        $permission = 'edit_permission';
        $checkPermission = FunctionLib::checkPermission($permission,$this->permission_full,$this->key);
        if($checkPermission == 0){
            $arrAjax = array('intReturn' => 3);
            return Response::json($arrAjax);
        }
        elseif($checkPermission == 1 || $checkPermission == 3){
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
            $dataUpdate['permission_status'] = $statusUpdate;
            $dataResponse = Permission::updatePermission($id,$dataUpdate,$this->key);//update dl
            if(!Authenticate::checkLogin($dataResponse)){
                return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
            }

            if(!empty($dataResponse) && $dataResponse['code'] == 200 && $dataResponse['intIsOK'] == 1){
                $action = 'onclick="permission.updateStatusPermission('.$id.','.$statusUpdate.')"';
                $link_a = '<a id="sys_status_'.$id.'" href="javascript:;"';
                $link_a .= $action;
                $link_a .= ($statusUpdate == 1)? ' class="btn btn-info btn-xs" title="Hiện"><i class="fa fa-check"></i></a>': ' class="btn btn-danger btn-xs"title="Ẩn"><i class="fa fa-minus"></i></a>';
                $arrAjax = array('intReturn' => 1, 'info' => $link_a);
            }
        }
        return Response::json($arrAjax);
    }

    public function stripUnicode(){
        $arrAjax = array('intReturn' => 0);
        $strCode = Request::get('code','');
        if($strCode != ''){
            $strCode = (!FunctionLib::stripUnicode($strCode))?$strCode:FunctionLib::stripUnicode($strCode);
            $arrAjax = array('intReturn' => 1);
        }
        return Response::json($arrAjax);
    }

    private function getListGroupUser(){
        $dataModel = Permission::getListGroupUser(1,$this->key);
        $listPermission = $dataModel['data'];//lay ds ncc
        $dataResponse = $dataModel['dataResponse'];
        //kiêm tra login
        if(!Authenticate::checkLogin($dataResponse)){
            return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
        }
        return $listPermission;
    }

    private function buildArrayGroupUser($listGroupUser){
        if(!Authenticate::checkAuthenticateNoParam()){
            return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
        }
        $arrGroupUser = array();
        if(!empty($listGroupUser)){
            foreach($listGroupUser as $group){
                $arrGroupUser[$group['group_user_id']] = $group['group_user_name'];
            }
        }
        return $arrGroupUser;
    }
}