<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 21/10/2015
 * Time: 11:03 CH
 */

class LiabilitiesController extends BaseAdminController{


    private $permission_view_liaCustomer = 'liaCustomer_view';
    private $permission_view_liaProvider = 'liaProvider_view';

    public function __construct()
    {
        parent::__construct();

    }

    public function liaCustomer(){

        if (!in_array($this->permission_view_liaCustomer, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['customers_id'] = Request::get('customers_id',0);
        $param['customers_ManagedBy'] = Request::get('customers_ManagedBy',0);
        $param['sale_list_create_start'] = Request::get('sale_list_create_start','');
        $param['sale_list_create_end'] = Request::get('sale_list_create_end','');
        $input = $param;
        $input['sale_list_create_start'] = ($input['sale_list_create_start'] != '') ? strtotime($input['sale_list_create_start']) : 0;
        $input['sale_list_create_end'] = ($input['sale_list_create_end'] != '') ? strtotime($input['sale_list_create_end'])+86400 : 0;
        $data = Customers::liaCustomer($input);
        $customers = Customers::getListAll();
        $admin = User::getListAllUser();
        $this->layout->content = View::make('admin.LiabilitiesLayouts.customer')->with('param',$param)->with('data',$data)->with('customers',$customers)->with('admin',$admin);
    }

    public function liaProvider(){

        if (!in_array($this->permission_view_liaProvider, $this->permission)) {
            return Redirect::route('admin.dashboard');
        }
        $param['providers_id'] = Request::get('providers_id',0);
        $param['import_create_start'] = Request::get('import_create_start','');
        $param['import_create_end'] = Request::get('import_create_end','');
        $input = $param;
        $input['import_create_start'] = ($input['import_create_start'] != '') ? strtotime($input['import_create_start']) : 0;
        $input['import_create_end'] = ($input['import_create_end'] != '') ? strtotime($input['import_create_end'])+86400 : 0;
        $data = Providers::liaProvider($input);
        $providers = Providers::getListAll();
        $this->layout->content = View::make('admin.LiabilitiesLayouts.provider')
            ->with('param',$param)
            ->with('data',$data)
            ->with('providers',$providers);
    }

}