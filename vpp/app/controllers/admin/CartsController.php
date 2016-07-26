<?php
/**
 * Created by PhpStorm.
 * User: mac-109
 * Date: 6/29/16
 * Time: 10:52 PM
 */

class CartsController extends BaseAdminController{
    private $permission_view = 'cart_view';
    private $permission_delete = 'cart_delete';
    private $permission_create = 'cart_create';
    private $permission_edit = 'cart_edit';
    private $arrStatus = array(-1 => 'Chọn trạng thái', 0 => 'Xóa', 1 => 'Mới',2=>'Xác nhận',3=>'Tạo Bản Kê');

    public function __construct()
    {
        parent::__construct();
    }

    public function view() {
        //Check phan quyen.
       /* if(!in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $pageNo = (int) Request::get('page_no',1);
        $limit = 30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;
        $search['order_id']         = (int)Request::get('order_id',-1);
        $search['customers_name']   = addslashes(Request::get('customers_name',''));
        $search['customers_phone']  = addslashes(Request::get('customers_phone',''));
        $search['customers_email']  = addslashes(Request::get('customers_email',''));
        $search['order_status']     = (int)Request::get('order_status',-1);

        $dataSearch = Order::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        if(!empty($dataSearch)){
            foreach($dataSearch as $k=> $val){
                $data[] = array('order_id'=>$val->order_id,
                    'customers_name'=>$val->customers_name,
                    'order_status'=>$val->order_status,
                    'customers_phone'=>$val->customers_phone,
                    'customers_email'=>$val->customers_email,
                    'customers_address'=>$val->customers_address,
                    'order_create_time'=>$val->order_create_time,
                    'order_price_total'=>$val->order_price_total,
                    'order_vat'=>$val->order_vat,
                    'customer_note'=>$val->customer_note,
                );
            }
        }

        /*echo '<pre>';  print_r($data); echo '</pre>'; die;*/

        $this->layout->content = View::make('admin.CartsLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $data)
            ->with('search', $search)
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('arrStatus', $this->arrStatus);
    }

    public function detail($id) {
        //Check phan quyen.
        /* if(!in_array($this->permission_view,$this->permission)){
             return Redirect::route('admin.dashboard');
         }*/
        $data =null;
        if($id >0){
            $data =Order::getOrderById($id);
          //  echo '<pre>';  print_r($dataSearch->orderitem); echo '</pre>'; die;

        }

        /*echo '<pre>';  print_r($data); echo '</pre>'; die;*/

        $this->layout->content = View::make('admin.CartsLayouts.detail')
            ->with('data', $data)
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('arrStatus', $this->arrStatus);
    }

    public function mapDirection(){
        $dataSearch['order_status'] = 2;$total =0;
        $data = Order::searchByCondition($dataSearch,30,0,$total);
        $addRess = array();
        $Orders = array();
        if(!empty($data)){
            foreach($data as $k=> $val){
                $Orders[] = array('order_id'=>$val->order_id,
                    'customers_name'=>$val->customers_name,
                    'order_status'=>$val->order_status,
                    'customers_phone'=>$val->customers_phone,
                    'customers_email'=>$val->customers_email,
                    'customers_address'=>$val->customers_address,
                    'order_create_time'=>$val->order_create_time,
                    'order_price_total'=>$val->order_price_total,
                    'order_vat'=>$val->order_vat,
                    'customer_note'=>$val->customer_note,
                );
                $addRess[]=$val->customers_address;
            }
        }
        $this->layout->content = View::make('admin.CartsLayouts.map')
            ->with('total', $total)
            ->with('address', ($addRess))
            ->with('start', 'Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội')
            ->with('end', 'Số 64, Phố Yên Bái II, Phường Phố Huế, Quận Hai Bà Trưng, TP Hà Nội')
            ->with('data', $Orders);
    }

    public function confirm() {
        //Check phan quyen.
        $id = (int)Request::get('id',-1);
        if($id >0){
            $status = Order::upDateStatusById($id,2);
            if($status !== false){
                $data['success'] = 1;
                $data['mess'] = 'Xác nhận đơn hàng thành công';
                return Response::json($data);
            }
            $data['success'] = 2;
            $data['mess'] = 'Có lỗi xảy ra khi thao tác';
            return Response::json($data);

        }
        return json_encode(array('isIntOk'=>1));

    }

    public function deleteItem(){
        $id = (int)Request::get('id',-1);
        if($id >0){
            $status = Order::upDateStatusById($id,0);
            if($status !== false){
                $data['success'] = 1;
                $data['mess'] = 'Hủy đơn hàng thành công';
                return Response::json($data);
            }
            $data['success'] = 2;
            $data['mess'] = 'Có lỗi xảy ra khi thao tác';
            return Response::json($data);
        }
        $data['success'] = -1;
        $data['mess'] = 'Không tìm thấy đơn hàng';
        return Response::json($data);
    }

    public function ajaxExport(){
        $data['success'] = 1;
        $ids = htmlspecialchars(trim(Request::get('ids','')));
        $order_id = (int)Request::get('order_id',0);
        $data['link'] = URL::route('admin.mngSite_carts_export',array('ids' => $ids,'order_id' => $order_id));
        return Response::json($data);
    }

    public function export(){

        $ids = htmlspecialchars(trim(Request::get('ids','')));
        $order_id = (int)Request::get('order_id',0);
        $ids = ($ids !='') ? explode(',',$ids) : array();

        $orders = Order::find($order_id);
        $item = OrderItem::getByIdsAndOrderId($ids,$order_id);
        //$export = Export::find($id);
        //$customer = Customers::find($export->customers_id);
        //$exportProduct = $export->exportproduct;
        $aryExport = array();
        $vat = $orders->order_vat > 0 ? 10 : 0;
        foreach($item as $product){
            $p = $product->product;
            $category_price_hide_discount = $category_price_discount = 0;
            $product_customer = ProductsCustomers::getByProductAndCustomerId($product->product_id,$orders->customers_id);
            if(isset($product_customer->product_price_discount) && $product_customer->product_price_discount > 0){
                $p->product_Price = $product_customer->product_price_discount;
            }
            $category_customer = CategoriesCustomers::getByCategoryAndCustomerId($product->product_Category,$orders->customers_id);
            if(isset($category_customer->category_price_hide_discount) && $category_customer->category_price_hide_discount > 0){
                $category_price_hide_discount = $category_customer->category_price_hide_discount;
            }
            if(isset($category_customer->category_price_discount) && $category_customer->category_price_discount > 0){
                $category_price_discount = $category_customer->category_price_discount;
            }
            //$vat = $customer->customers_IsNeededVAT ? 10 : 0;
            $import = ImportProduct::getByProductId($product->product_id);
            $aryStore = array();
            $price_input = 0;
            if($import){
                $x = $y = $i =0;
                foreach($import as $k => $v){
                    if($x < $product->product_Quantity){
                        $y = $x;
                        $x += $v['import_product_num'];
                        $aryStore[$i]['num'] = ($x <= $product->product_Quantity) ? $v['import_product_num'] : ($product->product_Quantity - $y);
                        $aryStore[$i]['price'] = $v['import_product_price'];
                        $i++;
                    }
                }
                krsort($aryStore);
                $aryStore = array_values($aryStore);
                $temp = $product->product_num;
                foreach($aryStore as $k => $v){
                    if($temp > 0){
                        $price_input += ($temp <= $v['num']) ? ($temp*$v['price']) : ($v['num']*$v['price']);
                        $temp = $temp - $v['num'];
                    }
                }
            }
            $aryExport[$product->product_id] = array(
                'product_id' => $p->product_id,
                'export_product_price' => $p->product_Price,
                'export_product_num' => $product->product_num,
                'export_product_price_origin' => $price_input,
                'export_product_discount' => (int)($p->product_Price * $product->product_num * $category_price_discount),
                'export_product_discount_customer' => (int)($p->product_Price * $product->export_product_num * $category_price_hide_discount),
                'product_Name' => $p->product_Name,
                'product_Code' => $p->product_Code,
                'product_NameOrigin' => $p->product_NameOrigin,
                'product_NameUnit' => $p->product_NameUnit,
            );
        }
        Session::put('export', $aryExport);
        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.ExportLayouts.export')
            ->with('customers',$customers)->with('customers_id',$orders->customers_id);
        $admin = User::getListAllUser();

        $cus = Customers::find($orders->customers_id);
        $param['export_customers_name'] = $orders->customers_name;
        $param['export_customers_code'] = $cus['customers_TaxCode'];
        $param['export_customers_address'] = $orders->customers_address;
        $param['export_user_store'] = User::user_id();
        $param['export_user_cod'] = User::user_id();
        $param['export_delivery_time'] = date('d-m-Y',time());
        $param['export_user_customer'] = $cus->customers_ContactName;
        $param['export_customer_phone'] = $orders->customers_phone;
        $param['export_customers_note'] = '';
        $param['export_pay_type'] = ($cus['customers_Type_Pay'] == 1) ? 1 : 0;

        $this->layout->content->customer_info = View::make('admin.ExportLayouts.customer_info')->with('customers',$param)->with('admin',$admin);
        $this->layout->content->product_info = View::make('admin.ExportLayouts.product_info')->with('export',$aryExport)->with('vat',$vat);
    }
}