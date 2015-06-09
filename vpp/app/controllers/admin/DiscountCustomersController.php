<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class DiscountCustomersController extends BaseAdminController
{
    private $permission_edit = 'discountCustomer_edit';
    private $permiss_view = 'discountCustomer_view';

    public function __construct()
    {
        parent::__construct();
    }

    public function discountCategory($customer_id) {
        //Check phan quyen.
        /*if(!in_array($this->permiss_view,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/

        $data = array();
        $inforCust = Customers::getByID($customer_id);

        //danh sách danh mục gốc
        $dataCategory = Categories::getCategoriessAll();

        //danh sách danh mục đã có giá triết khấu
        $dataCategoryCustomer = CategoriesCustomers::getCategoriesByCustomersId($customer_id);

        if(!empty($dataCategory)){
            foreach($dataCategory as $categories_id=> $val){
                $data[] = array('category_id'=>$categories_id,
                    'category_name'=>$val,
                    'customer_id'=>$customer_id,
                    'category_price_discount'=>isset($dataCategoryCustomer[$categories_id])? $dataCategoryCustomer[$categories_id]['category_price_discount']:0,
                );
            }
        }

        //echo '<pre>';  print_r($data); echo '</pre>'; die;
        $this->layout->content = View::make('admin.DiscountCustomersLayouts.discountCategory')
            ->with('data', $data)
            ->with('inforCust', $inforCust)
            //->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 1);
    }

    public function updateCategory()
    {
        $data = array('isIntOk' => 0);
        /*if(!$this->is_root && !in_array($this->permission_edit,$this->permission)){
            return Response::json($data);
        }*/

        $customer_id = (int)Request::get('customer_id', 0);
        $category_id = (int)Request::get('category_id', 0);
        $price_discount = Request::get('category_price_discount', 0);
        $category_price_discount =  str_replace('.','',$price_discount);

        //danh sách danh mục đã có giá triết khấu
        $dataCategoryCustomer = CategoriesCustomers::getCategoriesByCustomersId($customer_id);

        //update
        if(isset($dataCategoryCustomer[$category_id])){
            $id = $dataCategoryCustomer[$category_id]['id'];
            $dataSave['category_price_discount'] = $category_price_discount;
            if(CategoriesCustomers::updData($id, $dataSave)) {
                $data['isIntOk'] = 1;
            }
        }
        //insert mới
        else{
            $inforCate = Categories::getByID($category_id);
            //echo '<pre>';  print_r($inforCate); echo '</pre>'; die;
            $inforCust = Customers::getByID($customer_id);

            $dataSave['category_id'] = $category_id;
            $dataSave['category_name'] = $inforCate['categories_Name'];
            $dataSave['category_price_discount'] = $category_price_discount;
            $dataSave['customer_id'] = $customer_id;
            $dataSave['customer_name'] = $inforCust['customers_FirstName'];
            //echo '<pre>';  print_r($dataSave); echo '</pre>'; die;

            if(CategoriesCustomers::add($dataSave)) {
                $data['isIntOk'] = 1;
            }
        }
        return Response::json($data);
    }

    public function discountProduct($customer_id) {
        //Check phan quyen.
        /*if(!in_array($this->permiss_view,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/

        $data = array();
        $inforCust = Customers::getByID($customer_id);

        //danh sách sản phẩm gốc
        $dataProdcuct = Product::getProductsAll();

        //danh sách danh mục đã có giá triết khấu
        $dataProductCustomer = ProductsCustomers::getProductByCustomersId($customer_id);
        //echo '<pre>';  print_r($dataProductCustomer); echo '</pre>'; die;

        if(!empty($dataProdcuct)){
            foreach($dataProdcuct as $product_id=> $val){
                $data[] = array('product_id'=>$product_id,
                    'product_Name'=>$val['product_Name'],
                    'product_Price'=>$val['product_Price'],
                    'customer_id'=>$customer_id,
                    'product_price_discount'=>isset($dataProductCustomer[$product_id])? $dataProductCustomer[$product_id]['product_price_discount']:0,
                );
            }
        }

        //echo '<pre>';  print_r($data); echo '</pre>'; die;
        $this->layout->content = View::make('admin.DiscountCustomersLayouts.discountProduct')
            ->with('data', $data)
            ->with('inforCust', $inforCust)
            //->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 1);
    }

    public function updateProduct()
    {
        $data = array('isIntOk' => 0);
        /*if(!$this->is_root && !in_array($this->permission_edit,$this->permission)){
            return Response::json($data);
        }*/

        $customer_id = (int)Request::get('customer_id', 0);
        $product_id = (int)Request::get('product_id', 0);
        $price_discount = Request::get('product_price_discount', 0);
        $product_price_discount =  str_replace('.','',$price_discount);

        //danh sách sản phẩm đã có giá triết khấu
        $dataProductCustomer = ProductsCustomers::getProductByCustomersId($customer_id);

        //update
        if(isset($dataProductCustomer[$product_id])){
            $id = $dataProductCustomer[$product_id]['id'];
            $dataSave['product_price_discount'] = $product_price_discount;
            if(ProductsCustomers::updData($id, $dataSave)) {
                $data['isIntOk'] = 1;
            }
        }
        //insert mới
        else{

            $inforProduct = Product::getByID($product_id);
            $inforCate = Categories::getByID((int)$inforProduct['product_Category']);
            $inforCust = Customers::getByID($customer_id);

            $dataSave['product_id'] = $product_id;
            $dataSave['category_id'] = $inforCate['categories_id'];
            $dataSave['category_name'] = $inforCate['categories_Name'];
            $dataSave['product_name'] = $inforProduct['product_Name'];
            $dataSave['product_price'] = $inforProduct['product_Price'];
            $dataSave['product_price_discount'] = (int)$product_price_discount;
            $dataSave['customer_id'] = $customer_id;
            $dataSave['customer_name'] = $inforCust['customers_FirstName'];
            //echo '<pre>';  print_r($dataSave); echo '</pre>'; die;

            if(ProductsCustomers::add($dataSave)) {
                $data['isIntOk'] = 1;
            }
        }
        return Response::json($data);
    }



}