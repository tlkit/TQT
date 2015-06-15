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
    protected $fillable = array('customers_Type', 'customers_FirstName', 'customers_LastName', 'customers_Code', 'customers_ContractNo', 'customers_BizRegistrationNo', 'customers_IsNeededVAT', 'customers_TaxCode','customers_Phone', 'customers_Fax', 'customers_Email', 'customers_Website', 'customers_BizAddress', 'customers_ContactAddress', 'customers_Description', 'customers_ContactPhone','customers_ContactEmail', 'customers_ContactName', 'customers_TotalInvoice', 'customers_AmountOfCapital', 'customers_AmountOfRevenue', 'customers_NetProfit', 'customers_ManagedBy', 'customers_CreatedTime');

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
            if (isset($dataSearch['customers_Type']) && $dataSearch['customers_Type'] != -1) {
                $query->where('customers_Type', $dataSearch['customers_Type']);
            }
            $total = $query->count();
            $query->orderBy('customers_id', 'desc');
            return ($offset == 0) ? $query->take($limit)->get() : $query->take($limit)->skip($offset)->get();

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
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->customers_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
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
        $categories = Customers::where('customers_id', '>', 0)->orderBy('customers_FirstName')->lists('customers_FirstName','customers_id');
        return $categories ? $categories : array();
    }

    public static function reportCustomer($param){
        $tbl_customers = with(new Customers())->getTable();
        $tbl_export = with(new Export())->getTable();
        $query = DB::table($tbl_customers);
        $query->join($tbl_export, $tbl_customers . '.customers_id', '=', $tbl_export . '.customers_id');
        $query->where($tbl_export . '.export_status', 1);
        if ($param['customers_id'] > 0) {
            $query->where($tbl_customers . '.customers_id', $param['customers_id']);
        }
        if ($param['export_create_start'] > 0) {
            $query->where($tbl_export . '.export_create_time', '>=', $param['export_create_start']);
        }
        if ($param['export_create_end'] > 0) {
            $query->where($tbl_export . '.export_create_time', '<=', $param['export_create_end']);
        }
        $query->select(DB::raw($tbl_customers.'.*,COUNT('.$tbl_export.'.export_id) as count_export, SUM('.$tbl_export.'.export_total_pay) as sum_export'));
        $query->orderBy(DB::raw('SUM('.$tbl_export.'.export_total_pay)'),'desc');
        $query->groupBy($tbl_export.'.customers_id');
        $data = $query->get();
        return $data;
    }

}