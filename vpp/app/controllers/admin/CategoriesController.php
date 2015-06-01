<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class CategoriesController extends BaseAdminController
{

    private $permission_view = 'categories_view';
    private $permiss_delete = 'categories_view';
    private $permission_create = 'categories_create';
    private $permission_edit = 'categories_edit';
    private $arrStatus = array(-1 => 'Chọn trạng thái', 0 => 'Ẩn', 1 => 'Hiện');

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
        $search['categories_id'] = addslashes(Request::get('categories_id',''));
        $search['categories_Name'] = addslashes(Request::get('categories_Name',''));
        $search['categories_Status'] = (int)Request::get('categories_Status',-1);

        $dataSearch = Categories::searchByCondition($search, $limit, $offset,$total);
        $pagging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        if(!empty($dataSearch)){
            foreach($dataSearch as $k=> $val){
                $data[] = array('categories_id'=>$val->categories_id,
                    'categories_Name'=>$val->categories_Name,
                    'categories_Status'=>$val->categories_Status,
                );
            }
        }

        /*echo '<pre>';  print_r($data); echo '</pre>'; die;*/

        $this->layout->content = View::make('admin.CategoriesLayouts.view')
            ->with('pagging', $pagging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $data)
            ->with('search', $search)
            //->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 1)
            ->with('arrStatus', $this->arrStatus);
    }

    public function getCreate($id=0) {
        /*if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $data = array();
        if($id > 0) {
            $data = Categories::find($id);
        }
        $this->layout->content = View::make('admin.CategoriesLayouts.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('arrStatus', $this->arrStatus);
    }

    public function postCreate($id=0) {
        /*if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/

        $dataSave['categories_Name'] = addslashes(Request::get('categories_Name'));
        $dataSave['categories_Status'] = (int)Request::get('categories_Status', 0);
        $dataSave['categories_GroupID'] = 1;
        $dataSave['categories_SortIndex'] = 1;
        $dataSave['categories_ParentID'] = 0;
        $dataSave['categories_TotalProduct'] = 0;

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                if(Categories::updData($id, $dataSave)) {
                    return Redirect::route('admin.categories_list',array('url'=>base64_encode(URL::current())));
                }
            } else {
                if(Categories::add($dataSave)) {
                    return Redirect::route('admin.categories_list',array('url'=>base64_encode(URL::current())));
                }
            }
        }
        $this->layout->content =  View::make('admin.CategoriesLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('arrStatus', $this->arrStatus);
    }

    public function deleteItem() {
        $data = array('error' => 1);
        if(!$this->is_root && !in_array($this->permiss_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if($id > 0 && SeoBook::delData($id)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    public function updateStatus() {
        $data = array('error' => 1);
        if(!$this->is_root && !in_array($this->permiss_update,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        $status = (int)Request::get('status', 1);
        $val_status = ($status == 1)? 0: 1;
        if($id > 0 && SeoBook::updStatus($id,$val_status)) {
            $data['error'] = 0;
        }
        return Response::json($data);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['categories_Name']) && $data['categories_Name'] == '') {
                $this->error[] = 'Tên danh mục không được trống';
            }
            if(isset($data['categories_Status']) && $data['categories_Status'] == -1) {
                $this->error[] = 'Bạn chưa chọn trạng thái cho danh mục';
            }
            return true;
        }
        return false;
    }


}