<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 18/10/2015
 * Time: 11:15 CH
 */
class SaleListController extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function createInfo(){

        $customers = Customers::getListAll();
        $this->layout->content = View::make('admin.ExportLayouts.sale_list')
            ->with('customers',$customers)
            ->with('customers_id',0);
    }

    public function create(){

        $param['customers_id'] = (int)Request::get('customers_id',0);
        $param['sale_list_type'] = (int)Request::get('sale_list_type',-1);
        $param['sale_list_code'] = Request::get('sale_list_code','');
        $param['export_create_start'] = Request::get('export_create_start','');
        $param['export_create_end'] = Request::get('export_create_end','');
        $param['export_id'] = Request::get('export_id',array());
        $error = array();
        if($param['customers_id'] <= 0){
            $error[] = 'Chưa chọn khách hàng';
        }
        if($param['sale_list_type'] != 0 && $param['sale_list_type'] != 1){
            $error[] = 'Chưa chọn kiểu thanh toán';
        }
        if(sizeof($param['export_id']) == 0){
            $error[] = 'Chưa chọn xuất kho';
        }else{
            if(!Export::checkForSale($param,sizeof($param['export_id']))){
                $error[] = 'Xuất kho không phù hợp';
            }
        }
        if(!$error){
            $data['customers_id'] = $param['customers_id'];
            $data['sale_list_type'] = $param['sale_list_type'];
            $data['sale_list_status'] = 1;
            $data['sale_list_code'] = $param['sale_list_code'];
            $data['sale_list_create_id'] = User::user_id();;
            $data['sale_list_create_time'] = time();
            $ex_ids =  $param['export_id'];
            if(!SaleList::add($data,$ex_ids)){
                $error[] = 'Lỗi cập nhật dữ liệu';
            }else{
                echo 'fuck';die;
            }
        }

        if($error){
            $customers = Customers::getListAll();
            $this->layout->content = View::make('admin.ExportLayouts.sale_list')
                ->with('customers',$customers)
                ->with('param',$param)
                ->with('error',$error)
                ->with('customers_id',$param['customers_id']);
        }
    }

    public function detail($id){
        $id = (int) base64_decode($id);
        
    }
}