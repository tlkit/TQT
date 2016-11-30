<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class ProductController extends BaseAdminController
{
    private $permission_view = 'product_view';
    private $permission_delete = 'product_delete';
    private $permission_create = 'product_create';
    private $permission_edit = 'product_edit';

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

    public function index()
    {
        //Check phan quyen.
        if(!in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard');
        }
        $pageNo = (int)Request::get('page_no', 1);
        $limit = 30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;
        $search['product_Name'] = Request::get('product_Name', '');
        $search['product_Category'] = Request::get('product_Category', 0);

        $dataSearch = Product::searchByCondition($search, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //echo '<pre>';  print_r($dataSearch); echo '</pre>'; die;
        $this->layout->content = View::make('admin.ProductLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo - 1) * $limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('arrCategory', $this->arrCategory)
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);
    }

    public function getCreate($id = 0)
    {
        if(!in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard');
        }
        $data = array();
        if ($id > 0) {
            $data = Product::find($id);
        }
        //echo '<pre>';  print_r($user); echo '</pre>'; die;
        $this->layout->content = View::make('admin.ProductLayouts.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('arrCategory', $this->arrCategory)
            ->with('arrXuatXu', $this->arrXuatXu)
            ->with('arrDonViTinh', $this->arrDonViTinh);
    }

    public function postCreate($id = 0)
    {
        if(!in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard');
        }
        $dataSave['product_Code'] = Request::get('product_Code');
        $dataSave['product_Name'] = Request::get('product_Name');
        $dataSave['product_Category'] = (int)Request::get('product_Category');
        $dataSave['product_CategoryName'] = isset($this->arrCategory[$dataSave['product_Category']])? $this->arrCategory[$dataSave['product_Category']] : '';
        $product_Price = Request::get('product_Price');
        $dataSave['product_Price'] =  str_replace('.','',$product_Price);
        $product_bulk_price = Request::get('product_bulk_price','');
        $dataSave['product_bulk_price'] = ($product_bulk_price != '') ? str_replace('.', '', $product_bulk_price) : 0;
        $dataSave['product_bulk_quantity'] = (int)Request::get('product_bulk_quantity');
        $dataSave['product_MinimumQuantity'] = Request::get('product_MinimumQuantity');
        $dataSave['product_NameOrigin'] = Request::get('product_NameOrigin');
        $dataSave['product_NameUnit'] = Request::get('product_NameUnit');
        $dataSave['product_NamePackedWay'] = Request::get('product_NamePackedWay');
        $dataSave['product_Description'] = Request::get('product_Description');
        $dataSave['product_show_site'] = (int)Request::get('product_show_site');
        $dataSave['product_highlight'] = (int)Request::get('product_highlight');
        $start = Request::get('product_landing_start','');
        $dataSave['product_landing_start'] = ($start != '') ? strtotime($start) : 0;
        $end = Request::get('product_landing_end','');
        $dataSave['product_landing_end'] = ($end != '') ? strtotime($end) : 0;
        $file = $files = null;
        if ( Input::hasFile('product_avatar')) {
            $file = Input::file('product_avatar');
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            if(!in_array($extension,FunctionLib::$array_allow_image) || $size > FunctionLib::$size_image_max){
                $this->error[] = 'Ảnh đại diện không hợp lệ';
            }
        }
        $error_image = 0;
        if ( Input::hasFile('product_image')) {
            $files = Input::file('product_image');
            foreach($files as $fi){
                $extension = $fi->getClientOriginalExtension();
                $size = $fi->getSize();
                if(!in_array($extension,FunctionLib::$array_allow_image) || $size > FunctionLib::$size_image_max){
                    $error_image = 1;
                }
            }
        }
        if($error_image == 1){
            $this->error[] = 'Ảnh sản phẩm không hợp lệ';
        }
        if ($this->valid($dataSave, $id) && empty($this->error)) {
            if ($file) {
                $name = time() . '-av-' . $file->getClientOriginalName();
                $file->move(Constant::dir_product, $name);
                chmod (Constant::dir_product.$name, 777);
                $dataSave['product_Avatar'] = $name;
            }
            if ($files) {
                $image = array();
                foreach ($files as $fi) {
                    $name = time() . '-img-' . $fi->getClientOriginalName();
                    $fi->move(Constant::dir_product, $name);
                    $image[] = $name;
                }
                if ($image) {
                    $dataSave['product_Image'] = json_encode($image);
                }
            }
            if ($id > 0) {
                if (Product::updData($id, $dataSave)) {
                    $dataSave['product_CreatedTime'] = time();

                    return Redirect::route('admin.product_list');
                }
            } else {
                if (Product::add($dataSave)) {
                    $dataSave['product_ModifiedTime'] = time();
                    return Redirect::route('admin.product_list');
                }
            }
        }
        if ($id > 0) {
            $pro = Product::find($id);
            $dataSave['product_Image'] = $pro['product_Image'];
            $dataSave['product_Avatar'] = $pro['product_Avatar'];
        }
        $this->layout->content = View::make('admin.ProductLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('arrCategory', $this->arrCategory)
            ->with('arrXuatXu', $this->arrXuatXu)
            ->with('arrDonViTinh', $this->arrDonViTinh);
    }

    public function deleteItem()
    {
        $data = array('isIntOk' => 0);
        if(!in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && Product::delData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    public function getCategoryProduct()
    {
        return Categories::getCategoriessAll();
    }

    private function valid($data = array(), $id = 0)
    {
        if (!empty($data)) {
            if (isset($data['product_Name']) && $data['product_Name'] == '') {
                $this->error[] = 'Tên sản phẩm không được trống';
            }

            if (isset($data['product_Code']) && $data['product_Code'] == '') {
                $this->error[] = 'Mã sản phẩm không được trống';
            } elseif (isset($data['product_Code']) && $data['product_Code'] != '') {
                $product_Code = Product::getProductsByProductCode($data['product_Code']);
                if (!empty($product_Code) && !isset($product_Code[$id])) {
                    $this->error[] = 'Mã sản phẩm này đã tồn tại, hãy nhập mã khác';
                }
            }
            return true;
        }
        return false;
    }

    function updatecConvernt(){
        die;
        $product = DB::table('product')->get();;
        foreach ($product as $k => $va) {
            DB::table('product')
                ->where('product_id', $va->product_id)
                ->update(['product_NameOrigin' => isset($this->arrXuatXu[$va->product_OriginID]) ? $this->arrXuatXu[$va->product_OriginID] : '',
                    'product_NameUnit' => isset($this->arrDonViTinh[$va->product_UnitID]) ? $this->arrDonViTinh[$va->product_UnitID] : '']);
        }
        die('xong');

        /*echo '<pre>';
        print_r($product_categories);
        echo '</pre>';
        die;*/
    }

    public function getProductByName(){
        $name = Request::get('product_name', '');
        $product = Product::getListByName($name);
        $data['success'] = 1;
        $data['product'] = $product;
        return Response::json($data);
    }

}