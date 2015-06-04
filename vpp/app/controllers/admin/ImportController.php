<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 03/06/2015
 * Time: 8:14 CH
 */

class ImportController extends BaseAdminController{

    public function __construct(){
        parent::__construct();
    }

    public function import(){

        $providers = Providers::getListAll();
        $this->layout->content = View::make('admin.ImportLayouts.import')
            ->with('providers',$providers);
    }

    public function addProduct(){

        $name = Request::get('name','');
        $price = Request::get('price',0);
        $num = Request::get('num',0);
        $product = Product::getByName($name);
        $import = Session::has('import') ? Session::get('import') : array();
        $error = '';
        if($num == 0){
            $error = 'Chưa chọn số lượng nhập hàng';
        }
        if($price == 0){
            $error = 'Chưa chọn giá nhập hàng';
        }
        if($name == ''){
            $error = 'Chưa chọn sản phẩm nhập kho';
        }
        if ($error == '') {
            if ($product) {
                $import[$product->product_id] = array(
                    'product_id' => $product->product_id,
                    'product_Code' => $product->product_Code,
                    'product_Name' => $product->product_Name,
                    'product_OriginID' => $product->product_OriginID,
                    'product_UnitID' => $product->product_UnitID,
                    'import_product_price' => $price,
                    'import_product_num' => $num,
                );
                Session::put('import', $import);
            } else {
                $error = 'Sản phẩm bạn nhập không có trong hệ thống';
            }
        }
        $data['success'] = 1;
        $data['html'] = View::make('admin.ImportLayouts.product_info')->with('import',$import)->with('error',$error)->render();

        return Response::json($data);

    }

}