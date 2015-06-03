<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class CustomersController extends BaseAdminController
{

    private $permission_view = 'customers_view';
    private $permiss_delete = 'customers_view';
    private $permission_create = 'customers_create';
    private $permission_edit = 'customers_edit';
    private $arrType = array(-1 => 'Kiểu khách hàng', 1 => 'Mua buôn', 2 => 'Mua lẻ');
    private $arrTypeVat = array(1 => 'Có VAT', 0 => 'Không có VAT');

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
        $search['customers_FirstName'] = addslashes(Request::get('customers_FirstName',''));
        $search['customers_Type'] = (int)Request::get('customers_Type',-1);

        $dataSearch = Customers::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        if(!empty($dataSearch)){
            foreach($dataSearch as $k=> $val){
                $data[] = array('customers_id'=>$val->customers_id,
                    'customers_FirstName'=>$val->customers_FirstName,
                    'customers_Phone'=>$val->customers_Phone,
                    'customers_ContactEmail'=>$val->customers_ContactEmail,
                    'customers_ContactAddress'=>$val->customers_ContactAddress,
                    'customers_Type'=>isset($this->arrType[$val->customers_Type])? $this->arrType[$val->customers_Type] :'---',
                );
            }
        }

        //echo '<pre>';  print_r($dataSearch); echo '</pre>'; die;
        $this->layout->content = View::make('admin.CustomersLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $data)
            ->with('search', $search)
            //->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 1)
            ->with('arrType', $this->arrType);
    }

    public function getCreate($id=0) {
        /*if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $data = array();
        if($id > 0) {
            $data = Customers::find($id);
        }

        //người tạo
        $user = User::getListAllUser();
        //echo '<pre>';  print_r($user); echo '</pre>'; die;
        $this->layout->content = View::make('admin.CustomersLayouts.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('arrTypeVat', $this->arrTypeVat)
            ->with('user', $user)
            ->with('arrType', $this->arrType);
    }

    public function postCreate($id=0) {
        /*if(!in_array($this->permission_edit,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $dataSave['customers_FirstName'] = Request::get('customers_FirstName');
        $dataSave['customers_Code'] = Request::get('customers_Code');
        $dataSave['customers_ContractNo'] = Request::get('customers_ContractNo');
        $dataSave['customers_BizRegistrationNo'] = Request::get('customers_BizRegistrationNo');
        $dataSave['customers_IsNeededVAT'] = Request::get('customers_IsNeededVAT');
        $dataSave['customers_TaxCode'] = Request::get('customers_TaxCode');
        $dataSave['customers_Fax'] = Request::get('customers_Fax');
        $dataSave['customers_Phone'] = Request::get('customers_Phone');

        $dataSave['customers_Email'] = Request::get('customers_Email');
        $dataSave['customers_Website'] = Request::get('customers_Website');
        $dataSave['customers_BizAddress'] = Request::get('customers_BizAddress');
        $dataSave['customers_ContactAddress'] = Request::get('customers_ContactAddress');
        $dataSave['customers_Description'] = Request::get('customers_Description');
        $dataSave['customers_ContactPhone'] = Request::get('customers_ContactPhone');
        $dataSave['customers_ContactEmail'] = Request::get('customers_ContactEmail');

        $dataSave['customers_ContactEmail'] = Request::get('customers_ContactEmail');
        $dataSave['customers_ContactName'] = Request::get('customers_ContactName');
        $dataSave['customers_TotalInvoice'] = Request::get('customers_TotalInvoice');
        $dataSave['customers_AmountOfCapital'] = Request::get('customers_AmountOfCapital');
        $dataSave['customers_AmountOfRevenue'] = Request::get('customers_AmountOfRevenue');
        $dataSave['customers_NetProfit'] = Request::get('customers_NetProfit');
        $dataSave['customers_ManagedBy'] = Request::get('customers_ManagedBy');

        $dataSave['customers_Type'] = (int)Request::get('customers_Type', 0);

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                if(Customers::updData($id, $dataSave)) {
                    return Redirect::route('admin.customers_list');
                }
            } else {
                $dataSave['customers_CreatedTime'] = time();
                if(Customers::add($dataSave)) {
                    return Redirect::route('admin.customers_list');
                }
            }
        }
        $user = User::getListAllUser();
        $this->layout->content =  View::make('admin.CustomersLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('arrTypeVat', $this->arrTypeVat)
            ->with('user', $user)
            ->with('arrType', $this->arrType);
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