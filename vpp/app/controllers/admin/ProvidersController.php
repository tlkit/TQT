<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class ProvidersController extends BaseAdminController
{
    private $permission_view = 'providers_view';
    private $permission_delete = 'providers_delete';
    private $permission_edit = 'providers_edit';

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        //Check phan quyen.
        if(!in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard');
        }
        $pageNo = (int) Request::get('page_no',1);
        $limit = 30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;
        $search['providers_Name'] = addslashes(Request::get('providers_Name',''));
        $search['providers_Phone'] = addslashes(Request::get('providers_Phone',''));

        $dataSearch = Providers::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //echo '<pre>';  print_r($dataSearch); echo '</pre>'; die;
        $this->layout->content = View::make('admin.ProvidersLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);
    }

    public function getCreate($id=0) {
        if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }
        $data = array();
        if($id > 0) {
            $data = Providers::find($id);
        }
        $user = User::getListAllUser();
        //echo '<pre>';  print_r($user); echo '</pre>'; die;
        $this->layout->content = View::make('admin.ProvidersLayouts.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('user', $user);
    }

    public function postCreate($id=0) {
        if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }

        $dataSave['providers_Code'] = Request::get('providers_Code');
        $dataSave['providers_Name'] = Request::get('providers_Name');
        $dataSave['providers_Address'] = Request::get('providers_Address');
        $dataSave['providers_StoreAddress'] = Request::get('providers_StoreAddress');
        $dataSave['providers_Phone'] = Request::get('providers_Phone');
        $dataSave['providers_Website'] = Request::get('providers_Website');
        $dataSave['providers_Description'] = Request::get('providers_Description');
        $dataSave['providers_TotalImport'] = Request::get('providers_TotalImport');
        $dataSave['providers_TotalExport'] = Request::get('providers_TotalExport');

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                if(Providers::updData($id, $dataSave)) {
                    return Redirect::route('admin.providers_list');
                }
            } else {
                if(Providers::add($dataSave)) {
                    return Redirect::route('admin.providers_list');
                }
            }
        }
        $user = User::getListAllUser();
        $this->layout->content =  View::make('admin.ProvidersLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('user', $user);
    }

    public function deleteItem() {
        $data = array('isIntOk' => 0);
        if(!in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if($id > 0 && Providers::delData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    public function getProviderInfo(){
        $providers_id = Request::get('providers_id',0);
        $data['success'] = 0;
        $data['html'] = '';
        if($providers_id > 0){
            $provider = Providers::find($providers_id);
            if($provider){
                $data['success'] = 1;
                $data['html'] = View::make('admin.ImportLayouts.provider_info')->with('provider',$provider)->render();
            }
        }
        return Response::json($data);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['customers_FirstName']) && $data['customers_FirstName'] == '') {
                $this->error[] = 'Tên khách hàng không được trống';
            }
            return true;
        }
        return false;
    }


}