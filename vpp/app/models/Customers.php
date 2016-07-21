<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class Customers extends Eloquent
{
    protected $table = 'customers';
    protected $primaryKey = 'customers_id';
    public $timestamps = false;
    protected $fillable = array('customers_Type', 'customers_FirstName', 'customers_LastName', 'customers_Code', 'customers_ContractNo', 'customers_BizRegistrationNo', 'customers_IsNeededVAT', 'customers_TaxCode','customers_Phone', 'customers_Fax', 'customers_Email', 'customers_Website', 'customers_BizAddress', 'customers_ContactAddress', 'customers_Description', 'customers_ContactPhone','customers_ContactEmail', 'customers_ContactName', 'customers_TotalInvoice', 'customers_AmountOfCapital', 'customers_AmountOfRevenue', 'customers_NetProfit', 'customers_ManagedBy', 'customers_CreatedTime', 'customers_Type_Pay', 'customers_site', 'customers_username', 'customers_password');

    public static function getByID($id) {
        $customers = Customers::where('customers_id', $id)->first();
        return $customers;
    }

    public static function getCustomerssAll() {
        $categories = Customers::where('customers_id', '>', 0)->get();
        $data = array();
        foreach($categories as $itm) {
            $data[$itm['customers_id']] = $itm['customers_FirstName'];
        }
        return $data;
    }

    public static function getCustomersByCustomersCode($customers_Code) {
        $customers_Code = Customers::where('customers_Code','=', $customers_Code)->get();
        $data = array();
        foreach($customers_Code as $itm) {
            if(isset($itm['customers_id'])){
                $data[$itm['customers_id']] = $itm['customers_Code'];
            }
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Customers::where('customers_id','>',0);
            if (isset($dataSearch['customers_FirstName']) && $dataSearch['customers_FirstName'] != '') {
                $query->where('customers_FirstName','LIKE', '%' . $dataSearch['customers_FirstName'] . '%');
            }
            if (isset($dataSearch['customers_Phone']) && $dataSearch['customers_Phone'] != '') {
                $query->where('customers_Phone','LIKE', '%' . $dataSearch['customers_Phone'] . '%');
            }
            if (isset($dataSearch['customers_Type']) && $dataSearch['customers_Type'] != -1) {
                $query->where('customers_Type', $dataSearch['customers_Type']);
            }
            $total = $query->count();
            $query->orderBy('customers_id', 'desc');
            return $query->take($limit)->skip($offset)->get();

        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    /**
     * @desc: Tao website.
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static function add($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Customers();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            $data->save();
            DB::connection()->getPdo()->commit();
            return $data->customers_id;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update du lieu
     * @param $id
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static  function updData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Customers::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update trang thai website.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function updStatus($id,$status){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Customers::find($id);
            $dataSave->categories_Status = $status;
            $dataSave->update();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update trang thai website.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function delData($id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Customers::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function getListAll() {
        $customer = Customers::where('customers_id', '>', 0)->orderBy('customers_FirstName')->lists('customers_FirstName','customers_id');
        return $customer ? $customer : array();
    }

    public static function reportCustomer($param)
    {
        $tbl_customers = with(new Customers())->getTable();
        $tbl_export = with(new Export())->getTable();
        $query = DB::table($tbl_customers);
        //$query->leftJoin($tbl_export, $tbl_customers . '.customers_id', '=', $tbl_export . '.customers_id');
        $query->leftjoin($tbl_export, function ($join) use ($tbl_customers, $tbl_export, $param) {
            $join->on($tbl_customers . '.customers_id', '=', $tbl_export . '.customers_id');
            $join->where($tbl_export . '.export_status', '=', 1);
            if ($param['export_is_vat'] > 0) {
                $join->where($tbl_export . '.export_vat', '>', 0);
            } elseif ($param['export_is_vat'] == 0) {
                $join->where($tbl_export . '.export_vat', '=', 0);
            }
            if ($param['export_create_start'] > 0) {
                $join->where($tbl_export . '.export_create_time', '>=', $param['export_create_start']);
            }
            if ($param['export_create_end'] > 0) {
                $join->where($tbl_export . '.export_create_time', '<=', $param['export_create_end']);
            }
        });
        if ($param['customers_id'] > 0) {
            $query->where($tbl_customers . '.customers_id', $param['customers_id']);
        }
        if ($param['customers_ManagedBy'] > 0) {
            $query->where($tbl_customers . '.customers_ManagedBy', $param['customers_ManagedBy']);
        }
        $query->select(DB::raw($tbl_customers . '.*,COUNT(' . $tbl_export . '.export_id) as count_export, SUM(' . $tbl_export . '.export_total_pay) as sum_export,SUM(' . $tbl_export . '.export_price_origin) as sum_origin'));
        $query->orderBy(DB::raw('SUM(' . $tbl_export . '.export_total_pay)'), 'desc');
        $query->groupBy($tbl_customers . '.customers_id');
        if (isset($param['customers_is_buy']) && $param['customers_is_buy'] == 0) {
            $query->havingRaw('count_export = 0');
        } elseif (isset($param['customers_is_buy']) && $param['customers_is_buy'] == 1) {
            $query->havingRaw('count_export > 0');
        }
        $data = $query->get();
        return $data;
    }

    public static function liaCustomer($param){
        $tbl_customers = with(new Customers())->getTable();
        $tbl_sale_list = with(new SaleList())->getTable();
        $query = DB::table($tbl_customers);
        $query->join($tbl_sale_list, $tbl_customers . '.customers_id', '=', $tbl_sale_list . '.customers_id');
        $query->where($tbl_sale_list . '.sale_list_status', 1);
        $query->where($tbl_sale_list . '.sale_list_type', 1);
        if ($param['customers_id'] > 0) {
            $query->where($tbl_customers . '.customers_id', $param['customers_id']);
        }
        if ($param['customers_ManagedBy'] > 0) {
            $query->where($tbl_customers . '.customers_ManagedBy', $param['customers_ManagedBy']);
        }
        if ($param['sale_list_create_start'] > 0) {
            $query->where($tbl_sale_list . '.sale_list_create_time', '>=', $param['sale_list_create_start']);
        }
        if ($param['sale_list_create_end'] > 0) {
            $query->where($tbl_sale_list . '.sale_list_create_time', '<=', $param['sale_list_create_end']);
        }
        $query->select(DB::raw($tbl_customers.'.*,COUNT('.$tbl_sale_list.'.sale_list_id) as count_sale_list, SUM('.$tbl_sale_list.'.sale_list_total_pay) as sum_sale_list'));
        $query->orderBy(DB::raw('SUM('.$tbl_sale_list.'.sale_list_total_pay)'),'desc');
        $query->groupBy($tbl_sale_list.'.customers_id');
        $data = $query->get();
        return $data;
    }

    public static function customer_login(){
        $user = array();
        if(Session::has('customer')){
            $user = Session::get('customer');
        }
        return $user;
    }

}