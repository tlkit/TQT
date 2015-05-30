<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 29/05/2015
 * Time: 6:33 SA
 */

class UserController extends BaseAdminController{

    private $arrStatus = array(0=>'Tất cả', 1=>'Hoạt động',-1 => "Khóa");
    public function __construct()
    {
        parent::__construct();
    }

    public function view(){
        $this->layout->title = "Quản trị tài khoản";
        //check permission

//        if(!$this->is_root){
//            return Redirect::route('admin.dashboard');
//        }
        $page_no = Request::get('page_no',1);
        $dataSearch['user_status'] = Request::get('user_status',0);
        $dataSearch['user_email'] = Request::get('user_email','');
        $dataSearch['user_full_name'] = Request::get('user_full_name','');
        $dataSearch['user_name'] = Request::get('user_name','');
        $dataSearch['user_group'] = Request::get('user_group',0);

        $limit = 30; $paging = '';$size = 0;
        $offset = ($page_no - 1) * $limit;
        $data = User::searchByCondition($dataSearch,$limit,$offset,$size);
        $arrGroupUser = GroupUser::getListGroupUser();

        $this->layout->content = View::make('admin.UserLayouts.view')

            ->with('arrStatus',$this->arrStatus)
            ->with('arrGroupUser', $arrGroupUser)
            ->with('data', $data)
            ->with('dataSearch', $dataSearch)
            ->with('size', $size)
            ->with('paging',$paging);

    }

}