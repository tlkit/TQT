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
}