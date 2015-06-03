<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class ProductController extends BaseAdminController
{

    private $permission_view = 'providers_view';
    private $permiss_delete = 'providers_view';
    private $permission_create = 'providers_create';
    private $permission_edit = 'providers_edit';
    private $arrXuatXu = array(14 => 'Việt Nam',
                                15 => 'Thái Lan',
                                16 => 'Trung Quốc',
                                17 => 'Indonesia',
                                18 => 'Nhật Bản',
                                19 => 'Singapore',
                                20 => 'Đức',
                                21 => 'Pháp',
                                22 => 'Hàn Quốc',
                                23 => 'Đài Loan');
    private $arrDonViTinh = array(25 => 'Ram',
                                26 => 'Cuộn',
                                27 => 'Chiếc',
                                28 => 'Hộp',
                                29 => 'Quyển',
                                30 => 'Tập',
                                33 => 'Lọ',
                                34 => 'Vỉ',
                                35 => 'Chai',
                                );
    private $arrCategory = array();

    public function __construct()
    {
        parent::__construct();
        $this->arrCategory = $this->getCategoryProduct();
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
        $search['product_Name'] = Request::get('product_Name','');
        $search['product_Category'] = Request::get('product_Category',0);

        $dataSearch = Product::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //echo '<pre>';  print_r($dataSearch); echo '</pre>'; die;

        $this->layout->content = View::make('admin.ProductLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('arrCategory', $this->arrCategory)
            //->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 1);
    }

    public function getCreate($id=0) {
        /*if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $data = array();
        if($id > 0) {
            $data = Product::find($id);
        }
        //echo '<pre>';  print_r($user); echo '</pre>'; die;
        $this->layout->content = View::make('admin.ProductLayouts.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('arrXuatXu', $this->arrXuatXu)
            ->with('arrDonViTinh', $this->arrDonViTinh);
    }

    public function postCreate($id=0) {
        /*if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/

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
                if(Product::updData($id, $dataSave)) {
                    return Redirect::route('admin.product_list');
                }
            } else {
                if(Product::add($dataSave)) {
                    return Redirect::route('admin.product_list');
                }
            }
        }
        $user = User::getListAllUser();
        $this->layout->content =  View::make('admin.ProductLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('user', $user);
    }

    public function deleteItem() {
        $data = array('isIntOk' => 0);
        /*if(!$this->is_root && !in_array($this->permiss_delete,$this->permission)){
            return Response::json($data);
        }*/
        $id = (int)Request::get('id', 0);
        if($id > 0 && Product::delData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    public function getCategoryProduct(){
        return Categories::getCategoriessAll();
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

    function updatecConvernt(){
        die;
        $product_categories = DB::table('product_categories')->get();;
        foreach($product_categories as $k=>$va){
            DB::table('product')
                ->where('product_id', $va->product_id)
                ->update(['product_Category' => $va->category_id]);
        }

        echo '<pre>';  print_r($product_categories); echo '</pre>'; die;
    }

}