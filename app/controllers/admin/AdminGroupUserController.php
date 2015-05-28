<?php
/**
 * Created by PhpStorm.
 * User: Vietlh
 * Date: 7/11/14
 * Time: 3:14 PM
 */

class AdminGroupUserController extends  AdminController{
    private $arrStatus = array(-1=>'Ẩn',0 => 'Tất cả',1=>'Hiện');
//    private $arrType = array(1=>'Admin',2=>'Shop');
//    private $listPermission = array();
//    private $arrPermission = array();
//    private $arrPermissionByController = array();
//    private $permission_view = 'view_group_user';
//    private $permission_create = 'create_group_user';
//    private $permission_edit = 'edit_group_user';

    public function __construct()
    {
        parent::__construct();
//        $this->listPermission = $this->getListPermission();
//        $this->arrPermission = $this->buildArrayPermission($this->listPermission);
//        $this->arrPermissionByController = $this->buildArrayPermissionByController($this->listPermission);
        CGlobal::$pageTitle = "QL nhóm User | Admin Seo";
    }

    public function index(){
        //check permission
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }

        $page_no = Request::get('page_no',1);//phan trang
        $dataSearch['group_user_name'] = Request::get('group_user_name','');
        $dataSearch['group_user_status'] = Request::get('group_user_status',0);


        $limit = 30;
        $offset = ($page_no - 1) * $limit;
        $total = 0;
        //call api
        $aryGroupUser = GroupUser::searchGroupUser($dataSearch, $limit, $offset, $total);
        if(!empty($aryGroupUser)) {
            $aryGroupId = array();
            foreach($aryGroupUser as $val) {
                $aryGroupId[] = $val->group_user_id;
            }
            if(!empty($aryGroupId)) {
                $groupPermission = new GroupUserPermission();
                $aryPermission = $groupPermission->getListPermissionByGroupId($aryGroupId);
                if(!empty($aryPermission)) {
                    foreach($aryGroupUser as $k => $v) {
                        $items = $v;
                        foreach($aryPermission as $val) {
                            if($v->group_user_id == $val->group_user_id) {
                                $item = isset($v->permissions) ? $v->permissions : array();
                                $count = isset($v->countPermission) ? $v->countPermission : 0;
                                $item[] = $val;
                                $count++;
                                $items->permissions = $item;
                                $items->countPermission = $count;
                            }
                        }
                        $aryGroupUser[$k] = $items;
                    }
                }
            }
        }


        $paging = $total > 0 ? Pagging::getNewPager(3,$page_no,$total,$limit,$dataSearch) : '';

        $this->layout->content = View::make('admin.AdminGroupUser.index')
            ->with('data', $aryGroupUser)
            ->with('dataSearch', $dataSearch)
            ->with('total', $total)
            ->with('paging',$paging)
            ->with('arrStatus',$this->arrStatus);


        parent::debug();
    }

    public function getCreateGroupUser(){
        CGlobal::$pageTitle = "Tạo nhóm User | Admin Seo";
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }
        // Show the page
        $listPermission = Permission::getListPermission();
        $arrPermissionByController = $this->buildArrayPermissionByController($listPermission);
        $this->layout->content = View::make('admin.AdminGroupUser.create_group')
//            ->with('optionStatus',$optionStatus)
            ->with('arrPermissionByController',$arrPermissionByController);
        parent::debug();
    }

    public function postCreateGroupUser(){
        //check permission

        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }

        $error = array();
        $dataEncode['group_user_name'] = Request::get('group_user_name','');

        //encode các ký tự html
        $dataResult =  FunctionLib::encodeParam($dataEncode);

        $dataSave['group_user_name'] = $dataResult['group_user_name'];
        $dataSave['group_user_status'] =  1;
        $data = $dataSave;

        $arrPermission = $data['strPermission'] =  Request::get('permission_id',array());
//        if(!empty($arrPermission)){
//            $strPermission = implode(',',$arrPermission);
//            $dataSave['strPermission'] = $strPermission;
//        }

        if ($dataResult['group_user_name'] == '') {
            $error[] = 'Tên nhóm người dùng không được để trống ';
        }
        if(GroupUser::checkExitsGroupName($dataResult['group_user_name'])){
            $error[] = 'Tên nhóm người dùng đã được sử dụng ';
        }
        if ($error != null) {
            $listPermission = Permission::getListPermission();
            $arrPermissionByController = $this->buildArrayPermissionByController($listPermission);
            $this->layout->content = View::make('admin.AdminGroupUser.create_group')
                ->with('error', $error)
                ->with('data', $data)
                ->with('arrPermissionByController', $arrPermissionByController);
        } else {
            //urlencode dữ liệu
//            $dataSave = FunctionLib::urlEncode($dataSave);
            //insert dl
            if(GroupUser::createGroup($dataSave,$arrPermission)){
                return Redirect::to("admin/groupUser");
            }else{
                $listPermission = Permission::getListPermission();
                $arrPermissionByController = $this->buildArrayPermissionByController($listPermission);
                $error[] = 'Lỗi truy xuất dữ liệu';
                $this->layout->content = View::make('admin.AdminGroupUser.create_group')
                    ->with('error', $error)
                    ->with('data', $data)
                    ->with('arrPermissionByController', $arrPermissionByController);
            }
        }
        parent::debug();
    }

    public function getEditGroupUser($id){
        CGlobal::$pageTitle = "Sửa nhóm User | Admin Seo";
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }

        $data = GroupUser::find($id);//lay dl permission theo id
        $groupPermission = new GroupUserPermission();
        $dataPermission = $groupPermission->getListPermissionByGroupId(array($id));

        $aryPermission = array();
        if($dataPermission){
            foreach($dataPermission as $per){
                $aryPermission[] = $per->permission_id;
            }
        }
        $data->strPermission = $aryPermission;

        // Show the page
        $listPermission = Permission::getListPermission();
        $arrPermissionByController = $this->buildArrayPermissionByController($listPermission);
        $this->layout->content = View::make('admin.AdminGroupUser.edit_group')
            ->with('data',$data)
            ->with('arrStatus',$this->arrStatus)
//            ->with('arrType',$this->arrType)
            ->with('arrPermissionByController',$arrPermissionByController);
        parent::debug();
    }

    public function postEditGroupUser($id){
        //check permission
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }
        $error = array();
        $dataEncode['group_user_name'] = Request::get('group_user_name','');
        //encode các ký tự html
        $dataResult =  FunctionLib::encodeParam($dataEncode);

        $dataSave['group_user_name'] = $dataResult['group_user_name'];
        $dataSave['group_user_status'] =  Request::get('group_user_status',1);
        $data = $dataSave;

        $arrPermission = $data['strPermission'] =  Request::get('permission_id');

        if ($dataResult['group_user_name'] == '') {
            $error[] = 'Tên nhóm người dùng không được để trống ';
        }
        if(GroupUser::checkExitsGroupName($dataResult['group_user_name'],$id)){
            $error[] = 'Tên nhóm người dùng đã được sử dụng ';
        }
        if ($error != null) {
            $listPermission = Permission::getListPermission();
            $arrPermissionByController = $this->buildArrayPermissionByController($listPermission);
            $this->layout->content = View::make('admin.AdminGroupUser.edit_group')
                ->with('error', $error)
                ->with('data', $data)
                ->with('arrStatus', $this->arrStatus)
                ->with('arrPermissionByController', $arrPermissionByController);
        } else {

            if(GroupUser::updateGroup($id,$dataSave,$arrPermission)){
                return Redirect::to("admin/groupUser");
            }else{
                $listPermission = Permission::getListPermission();
                $arrPermissionByController = $this->buildArrayPermissionByController($listPermission);
                $error['mess'] = 'Lỗi truy xuất dữ liệu';
                $this->layout->content = View::make('admin.AdminGroupUser.edit_group')
                    ->with('error', $error)
                    ->with('data', $data)
                    ->with('arrStatus', $this->arrStatus)
                    ->with('arrPermissionByController', $arrPermissionByController);
            }

            //urlencode dữ liệu
            $dataSave = FunctionLib::urlEncode($dataSave);
            //FunctionLib::debug($dataSave);
            //insert dl
            $dataResponse = GroupUser::updateGroupUser($id, $dataSave);
            //kiêm tra login
            if (!Authenticate::checkLogin($dataResponse)) {
                return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
            }
            //$optionStatus = FunctionLib::getOption($this->arrStatus, $data['group_user_status']);
            if (!empty($dataResponse)) {
                if ($dataResponse['code'] == 200 && $dataResponse['intIsOK'] == 1) {
                    return Redirect::to("admin/groupUser");
                } else {
                    $this->layout->content = View::make('admin.AdminGroupUser.edit_group')
                        ->with('error', $dataResponse['message'])
                        ->with('data', $data)
                        ->with('arrStatus', $this->arrStatus)
                        ->with('arrType',$this->arrType)
                        ->with('arrPermissionByController', $this->arrPermissionByController);
                }
            } else {
                $error['mess'] = 'Lỗi truy xuất dữ liệu';
                $this->layout->content = View::make('admin.AdminGroupUser.edit_group')
                    ->with('error', $error['mess'])
                    ->with('data', $data)
                    ->with('arrStatus', $this->arrStatus)
                    ->with('arrType',$this->arrType)
                    ->with('arrPermissionByController', $this->arrPermissionByController);
            }
        }

        parent::debug();
    }

    public function updateGroupUserStatus(){
        //check permission
        $permission = 'edit_group_user';
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
            $dataUpdate['group_user_status'] = $statusUpdate;
            $dataResponse = GroupUser::updateGroupUser($id,$dataUpdate,$this->key);//update dl
            if(!Authenticate::checkLogin($dataResponse)){
                return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
            }

            if(!empty($dataResponse) && $dataResponse['code'] == 200 && $dataResponse['intIsOK'] == 1){
                $action = 'onclick="groupUser.updateStatusGroupUser('.$id.','.$statusUpdate.')"';
                $link_a = '<a id="sys_del_'.$id.'" href="javascript:;"';
                $link_a .= $action;
                $link_a .= ($statusUpdate == 1)? ' class="btn btn-info btn-xs" title="Hiện"><i class="fa fa-check"></i></a>': ' class="btn btn-danger btn-xs"title="Ẩn"><i class="fa fa-minus"></i></a>';
                $arrAjax = array('intReturn' => 1, 'info' => $link_a);
            }
        }
        return Response::json($arrAjax);
    }

    private function getListPermission(){
        $dataModel = GroupUser::getListPermission($this->key);
        $listPermission = $dataModel['data'];//lay ds ncc
        $dataResponse = $dataModel['dataResponse'];
        //kiêm tra login
        if(!Authenticate::checkLogin($dataResponse)){
            return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
        }
        return $listPermission;
    }

    private function buildArrayPermission($listPermission){
        if(!Authenticate::checkAuthenticateNoParam()){
            return Redirect::route('admin.login',array('url'=>base64_encode(URL::current())));
        }
        $arrPermission = array();
        if(!empty($listPermission)){
            foreach($listPermission as $permission){
                $arrPermission[$permission['permission_id']] = $permission['permission_name'];
            }
        }
        return $arrPermission;
    }

    private function buildArrayPermissionByController($listPermission){

        $arrPermissionByController = array();
        if(!empty($listPermission)){
            foreach($listPermission as $permission){
                  $arrPermissionByController[$permission['permission_group_name']][] = $permission;
            }
        }
        return $arrPermissionByController;
    }
}