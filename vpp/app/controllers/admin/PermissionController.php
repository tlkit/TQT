<?php
/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 5/30/2015
 * Time: 4:22 PM
 */

class PermissionController extends BaseAdminController{

    private $arrStatus = array(-1 =>'Xóa',0 => 'Tất cả',1=>'Hoạt động');
    public function __construct(){
        parent::__construct();
    }

    public function view(){
//        if (!$this->is_root) {
//            return Redirect::route('admin.dashboard');
//        }

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
                $aryGroupUser = GroupUserPermission::getListGroupByPermissionId($aryPermissionId);
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

//        $paging = $total > 0 ? Pagging::getNewPager(3,$page_no,$total,$limit,$dataSearch) : '';
        $this->layout->content = View::make('admin.PermissionLayouts.view')

            ->with('data', $aryPermission)
            ->with('dataSearch', $dataSearch)
            ->with('total', $total)
            ->with('paging',0)
            ->with('arrStatus',$this->arrStatus);
    }


}