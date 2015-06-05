<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class PersonnelController extends BaseAdminController
{

    private $permission_view = 'personnel_view';
    private $permiss_delete = 'personnel_view';
    private $permission_create = 'personnel_create';
    private $permission_edit = 'personnel_edit';
    private $arrStatus = array(1=>'Đang làm việc', 2=>'Đang thử việc',3=>'Đã nghỉ việc');
    private $arrCheckCreater = array(0=>'Không tạo', 1=>'Có tạo');

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        //Check phan quyen.
        /*if(!in_array($this->permiss_view,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $pageNo = (int) Request::get('page_no',1);
        $limit = 30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;
        $search['personnel_name'] = addslashes(Request::get('personnel_name',''));
        $search['personnel_phone'] = addslashes(Request::get('personnel_phone',''));

        $dataSearch = Personnel::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //echo '<pre>';  print_r($dataSearch); echo '</pre>'; die;
        $this->layout->content = View::make('admin.PersonnelLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('arrStatus', $this->arrStatus)
            //->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 1);
    }

    public function getCreate($id=0) {
        /*if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $data = array();
        $personnel_user_id = 0;
        if($id > 0) {
            $data = Personnel::find($id);
            if($data){
                $personnel_user_id = $data['personnel_user_id'];
            }
        }

        //người tạo
        ///echo '<pre>';  print_r($data); echo '</pre>'; die;
        $this->layout->content = View::make('admin.PersonnelLayouts.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('personnel_user_id', $personnel_user_id)
            ->with('arrCheckCreater', $this->arrCheckCreater)
            ->with('arrStatus', $this->arrStatus);
    }

    public function postCreate($id=0) {
        /*if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $dataSave['personnel_name'] = Request::get('personnel_name');
        $dataSave['personnel_village'] = Request::get('personnel_village');
        $dataSave['personnel_adress_1'] = Request::get('personnel_adress_1');
        $dataSave['personnel_adress_2'] = Request::get('personnel_adress_2');
        $personnel_brithday = Request::get('personnel_brithday');
        $dataSave['personnel_email'] = Request::get('personnel_email');
        $dataSave['personnel_phone'] = Request::get('personnel_phone');
        $personnel_time_star_work = Request::get('personnel_time_star_work');
        $dataSave['personnel_time_out_work'] = Request::get('personnel_time_out_work');
        $dataSave['personnel_status'] = Request::get('personnel_status');
        $dataSave['personnel_time_out_work'] = ($dataSave['personnel_status'] == 3)? time(): 0;

        $dataSave['personnel_check_creater'] = Request::get('personnel_check_creater',0);
        $dataSave['personnel_user_id'] = Request::get('personnel_user_id');
        if($dataSave['personnel_check_creater'] ==1){
            $dataSave['personnel_user_name'] = Request::get('personnel_user_name');
        }

        if($personnel_brithday != ''){
            $dataSave['personnel_brithday'] = strtotime($personnel_brithday);
        }
        if($personnel_time_star_work != ''){
            $dataSave['personnel_time_star_work'] = strtotime($personnel_time_star_work);
        }

        //echo '<pre>';  print_r($dataSave); echo '</pre>'; die;
        if($this->valid($dataSave) && empty($this->error)) {
            unset($dataSave['personnel_check_creater']);
            //nếu tạo user/pass đăng nhập luôn
            if(isset($dataSave['personnel_user_id']) && $dataSave['personnel_user_id'] == 0 && isset($dataSave['personnel_user_name']) && $dataSave['personnel_user_name'] != ''){
                $user['user_name'] = $dataSave['personnel_user_name'];
                $user['user_email'] = $dataSave['personnel_email'];
                $user['user_phone'] = $dataSave['personnel_phone'];
                $user['user_full_name'] = $dataSave['personnel_name'];
                $user['user_status'] = 1;
                $user['user_password'] = 'vpp@123';
                $user['user_create_id'] = User::user_id();
                $user['user_create_name'] = User::user_name();
                $user['user_created'] = time();
                $dataSave['personnel_user_id'] = User::createNew($user);
            }

            //echo '<pre>';  print_r($dataSave); echo '</pre>'; die;
            if($id > 0) {
                if(Personnel::updData($id, $dataSave)) {
                    return Redirect::route('admin.personnel_list');
                }
            } else {
                //echo '<pre>';  print_r($dataSave); echo '</pre>'; die;
                if(Personnel::add($dataSave)) {
                    return Redirect::route('admin.personnel_list');
                }
            }
        }
        $this->layout->content =  View::make('admin.PersonnelLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('arrCheckCreater', $this->arrCheckCreater)
            ->with('arrStatus', $this->arrStatus);
    }

    public function deleteItem() {
        $data = array('isIntOk' => 0);
        /*if(!$this->is_root && !in_array($this->permiss_delete,$this->permission)){
            return Response::json($data);
        }*/
        $id = (int)Request::get('id', 0);
        if($id > 0 && Personnel::delData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['personnel_name']) && $data['personnel_name'] == '') {
                $this->error[] = 'Tên nhân viên không được trống';
            }
            if(isset($data['personnel_user_name']) && $data['personnel_user_name'] == '' && isset($data['personnel_check_creater']) && $data['personnel_check_creater'] == 1) {
                $this->error[] = 'User name đăng nhập không được trống';
            }elseif(isset($data['personnel_user_name']) && $data['personnel_user_name'] != '' && isset($data['personnel_check_creater']) && $data['personnel_check_creater'] == 1){
                $dataResponse = User::getUserByName($data['personnel_user_name']);
                if ($dataResponse) {
                    $this->error[] = 'User name đăng nhập đã tồn tại!';
                }
            }
            return true;
        }
        return false;
    }


}