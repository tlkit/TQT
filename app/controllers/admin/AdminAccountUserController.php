<?php
/**
 * QuynhTM
 */

class AdminAccountUserController extends  AdminController {
    private $arrStatus = array(0=>'Tất cả', 1=>'Hoạt động',-1 => "Khóa");
    public function __construct()
    {
        parent::__construct();
//        $this->listGroupUser = $this->getListGroupUser(1);
//        $this->arrGroupUser = $this->buildArrayGroupUser($this->listGroupUser);
        CGlobal::$pageTitle = "QL User | Admin Seo";
    }

    public function index(){
        CGlobal::$pageTitle = "Quản trị user";
        //check permission

        if(!$this->is_root){
            return Redirect::route('admin.dashboard');
        }

        $page_no = Request::get('page_no',1);
        $dataSearch['user_id'] = (int)Request::get('user_id',0);
        $dataSearch['user_status'] = Request::get('user_status',0);
        $dataSearch['user_employee_id'] = (int)Request::get('user_employee_id',0);
        $dataSearch['user_email'] = Request::get('user_email','');
        $dataSearch['user_full_name'] = Request::get('user_full_name','');
        $dataSearch['user_name'] = Request::get('user_name','');
        $dataSearch['user_group'] = Request::get('user_group',0);

        $limit = 30; $paging = '';$size = 0;
        $offset = ($page_no - 1) * $limit;
        $data = User::searchByCondition($dataSearch,$limit,$offset,$size);

        $arrGroupUser = GroupUser::getListGroupUser();


        $this->layout->content = View::make('admin.AdminAccountUser.index')
            ->with('is_root',$this->is_root)
            ->with('arrStatus',$this->arrStatus)
            ->with('arrGroupUser', $arrGroupUser)
            ->with('data', $data)
            ->with('dataSearch', $dataSearch)
            ->with('size', $size)
            ->with('paging',$paging);

        parent::debug();
    }

    public function getCreate(){
        CGlobal::$pageTitle = "Tạo mới User | Admin Seo";
        //check permission
        if(!$this->is_root){
            return Redirect::route('admin.dashboard');
        }
        $arrGroupUser = GroupUser::getListGroupUser();
        $this->layout->content = View::make('admin.AdminAccountUser.AddUser')
               ->with('arrGroupUser',$arrGroupUser);
        parent::debug();
    }

    public function postCreate(){
        //check permission
        if(!$this->is_root){
            return Redirect::route('admin.dashboard');
        }

        $error['mess'] = '';

        $data['user_name'] = Request::get('user_name','');
        $data['user_email'] =  Request::get('user_email','');
        $data['user_employee_id'] =  (int)Request::get('user_employee_id',0);
        $data['user_is_admin'] =  (int)Request::get('user_is_admin',0);
        $data['user_full_name'] =  Request::get('user_full_name','');

        $data =  FunctionLib::encodeParam($data);
        $error['mess'] = $this->validate($data);

        $groupUser = $data['user_group'] =  Request::get('user_group',array());
        if($groupUser){
            $strGroupUser = implode(',',$groupUser);
            $dataInsert['user_group'] = $strGroupUser;
        }
        //$optionStatus = FunctionLib::getOption(array(-1 => ' -- Chọn -- ') + $this->arrStatus, $dataValidate['admin_status']);
        if($error['mess'] != ''){
            $arrGroupUser = GroupUser::getListGroupUser();
            $this->layout->content = View::make('admin.AdminAccountUser.AddUser')
                ->with('error', $error['mess'])
                ->with('data', $data)
                ->with('arrGroupUser',$arrGroupUser);
                //->with('optionStatus',$optionStatus);
        }else{
            //Insert dữ liệu
            $dataInsert['user_name'] = $data['user_name'];
            $dataInsert['user_email'] = $data['user_email'];
            $dataInsert['user_employee_id'] = $data['user_employee_id'];
            $dataInsert['user_is_admin'] = $data['user_is_admin'];
            $dataInsert['user_full_name'] = $data['user_full_name'];
            $dataInsert['user_status'] = 1;
            $dataInsert['user_password'] = 'seo123';
            $dataInsert['user_create_id'] = User::user_id();
            $dataInsert['user_create_name'] = User::user_name();
            $dataInsert['user_created'] = time();


            if(User::createNew($dataInsert)){
                return Redirect::to('admin/adminUser');
            }else{
                $arrGroupUser = GroupUser::getListGroupUser();
                $error['mess'] = 'Lỗi truy xuất dữ liệu';
                $this->layout->content = View::make('admin.AdminAccountUser.AddUser')
                    ->with('error', $error['mess'])
                    ->with('data', $data)
                    ->with('arrGroupUser',$arrGroupUser);
            }
        }
        parent::debug();
    }

    public function getEditPass($ids){
        CGlobal::$pageTitle = "Đổi mật khẩu | Admin Seo";
        $string_id = base64_decode($ids);
        $pos = strrpos($string_id, "_");
        $id = (int)substr($string_id, ($pos + 1), strlen($string_id));
        $user = User::user_login();
        if(!$this->is_root && (int)$id !== (int)$user['user_id']){
                return Redirect::route('admin.dashboard');
        }

        $this->layout->content = View::make('admin.AdminAccountUser.EditPass')->with('id',$id);
        parent::debug();
    }

    public function postEditPass($ids){
        $string_id = base64_decode($ids);
        $pos = strrpos($string_id,"_");
        $id = (int)substr($string_id,($pos+1), strlen($string_id));
        $user = User::user_login();
        //check permission
        if(!$this->is_root && (int)$id !== (int)$user['user_id']){
            return Redirect::route('admin.dashboard');
        }

//        $dataResponse= $data = $dataInsert = $dataValidate = array();

        $error = array();
        $old_password = Request::get('old_password','');
        $new_password = Request::get('new_password','');
        $confirm_new_password = Request::get('confirm_new_password','');
        if(!$this->is_root && $id == $user['user_id']){
            $user_byId = User::getUserById($id);
            if($old_password == ''){
                $error[] = 'Bạn chưa nhập mật khẩu hiện tại';
            }
            if(User::encode_password($old_password) !== $user_byId->user_password ){
                $error[] = 'Mật khẩu hiện tại không chính xác';
            }
        }
        if($new_password == ''){
            $error[] = 'Bạn chưa nhập mật khẩu mới';
        }elseif(strlen($new_password) < 5){
            $error[] = 'Mật khẩu quá ngắn';
        }
        if($confirm_new_password == ''){
            $error[] = 'Bạn chưa xác nhận mật khẩu mới';
        }
        if($new_password != '' && $confirm_new_password != '' && $confirm_new_password != $new_password){
            $error[] = 'Mật khẩu xác nhận không chính xác';
        }
        if(!$this->is_root && (int)$id !== (int)$user['user_id']){
           $error[] = 'Bạn không có quyền thay đổi mất khẩu của User khác';
        }
        if($error != null){
            $this->layout->content = View::make('admin.AdminAccountUser.EditPass')->with('id',$id)
                ->with('error', $error);
        } else {
            //Insert dữ liệu
            if (User::updatePassword($id, $new_password)) {
                return Redirect::to('admin/adminUser');
            } else {
                $error[] = 'Không update được dữ liệu';
                $this->layout->content = View::make('admin.AdminAccountUser.AddUser')->with('id', $id)
                    ->with('error', $error);
            }
        }
        parent::debug();
    }

    public function getEditGroupUser($id){
        CGlobal::$pageTitle = "Sửa nhóm User | Admin Seo";
        //check permission
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }

        $data = User::getUserById($id);
        $data['user_group']=explode(',', $data['user_group']);
        $arrGroupUser = GroupUser::getListGroupUser();
        $this->layout->content = View::make('admin.AdminAccountUser.EditGroupUser')
                                ->with('arrGroupUser',$arrGroupUser)
                                ->with('arrStatus',$this->arrStatus)
                                ->with('data',$data);
        parent::debug();
    }

    public function postEditGroupUser($id){
        //check permission
        if (!$this->is_root) {
            return Redirect::route('admin.dashboard');
        }

        $error['mess'] = '';
        $data['user_id'] =  $id;
        $data['user_email'] =  Request::get('user_email','');
        $data['user_employee_id'] =  (int)Request::get('user_employee_id',0);
        $data['user_is_admin'] =  (int)Request::get('user_is_admin',0);
        $data['user_full_name'] =  Request::get('user_full_name','');
        $data['user_status'] =  Request::get('user_status',-1);

        $data =  FunctionLib::encodeParam($data);
        $error['mess'] = $this->validate($data);
        $data['user_name'] =  Request::get('user_name','');
        $groupUser = $data['user_group'] =  Request::get('user_group',array());
        if($groupUser){
            $strGroupUser = implode(',',$groupUser);
            $dataInsert['user_group'] = $strGroupUser;
        }
        if($error['mess'] != ''){
            $arrGroupUser = GroupUser::getListGroupUser();
            $this->layout->content = View::make('admin.AdminAccountUser.EditGroupUser')
                ->with('error', $error['mess'])
                ->with('data', $data)
                ->with('arrStatus',$this->arrStatus)
                ->with('arrGroupUser',$arrGroupUser);
            //->with('optionStatus',$optionStatus);
        }else{
            //Insert dữ liệu
            $dataInsert['user_email'] = $data['user_email'];
            $dataInsert['user_employee_id'] = $data['user_employee_id'];
            $dataInsert['user_is_admin'] = $data['user_is_admin'];
            $dataInsert['user_full_name'] = $data['user_full_name'];
            $dataInsert['user_status'] = $data['user_status'];
            $dataInsert['user_edit_id'] = User::user_id();
            $dataInsert['user_edit_name'] = User::user_name();
            $dataInsert['user_updated'] = time();

            if(User::updateUser($id,$dataInsert)){
                return Redirect::to('admin/adminUser');
            }else{
                $arrGroupUser = GroupUser::getListGroupUser();
                $error['mess'] = 'Lỗi truy xuất dữ liệu';;
                $this->layout->content = View::make('admin.AdminAccountUser.EditGroupUser')
                    ->with('error', $error['mess'])
                    ->with('data', $data)
                    ->with('arrStatus',$this->arrStatus)
                    ->with('arrGroupUser',$arrGroupUser);
            }
        }

        parent::debug();
    }

    private function validate($data){
        $mess = '';
        $regex = "#^([0-9]+)?$#i";

        if(isset($data['user_name']) && $data['user_name'] == ''){
            $mess ='Tên đăng nhập không được bỏ trống';
        }elseif(isset($data['user_name']) && $data['user_name'] !== ''){
            $dataResponse = User::getUserByName($data['user_name']);
            if($dataResponse){
                $mess ='Tên đăng nhập đã tồn tại!';
            }
        }

        if(isset($data['user_email']) && $data['user_email'] == ''){
            $mess ='Email không được bỏ trống';
        }

        if(isset($data['user_full_name']) && $data['user_full_name'] == ''){
            $mess ='Tên nhân viên không được bỏ trống';
        }

        return $mess;
    }

    public function getAjaxUpdateUserStatus(){
        //check permission
        $permission = 'edit_acount';
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
            $statusUpdate = $status;
            $dataUpdate['admin_status'] = $statusUpdate;
            $dataUpdate['key'] = $this->key;
            $dataResponse = Account::updateStatus($id,$dataUpdate);
            if(!empty($dataResponse) && isset($dataResponse['intIsOK']) && $dataResponse['intIsOK'] == 1){
                $action = 'onclick="updateStatusUser('.$id.','.$statusUpdate.')"';
                $link_a = '<a href="javascript:;"';
                $link_a .= $action;
                $link_a .= ($statusUpdate == 1)? ' class="btn btn-info btn-xs" title="Hiển thị"><i class="fa fa-check"></i></a>': ' class="btn btn-danger btn-xs"title="Ẩn"><i class="fa fa-minus"></i></a>';
                $arrAjax = array('intReturn' => 1, 'info' => $link_a);
            }
        }
        return Response::json($arrAjax);
    }

    private function getListGroupUser($type){
        $dataModel = Permission::getListGroupUser($type,$this->key);
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