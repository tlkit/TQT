<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 07/06/2015
 * Time: 7:46 CH
 */

class Export extends Eloquent{

    protected $table = 'export';

    public $timestamps = false;

    protected $primaryKey = 'export_id';

    protected $fillable = array('export_code','customers_id','export_customers_address','export_customers_name', 'export_customer_phone', 'export_customers_note','export_delivery_time','export_user_store','export_user_cod', 'export_user_customer','export_subtotal','export_total','export_total_pay','export_discount','export_discount_customer','export_vat','export_status','export_note','export_create_id','export_create_time','export_update_id','export_update_time');

    public function exportproduct()
    {
        return $this->hasMany('ExportProduct', 'export_id');
    }

    public static function getCountInDay(){
        $start = strtotime(date('d-m-Y',time()));
        $count = Export::where('export_create_time','>=',$start)->count();
        return $count;
    }

    public static function search($dataSearch = array(), $limit = 50, $offset = 0, &$total)
    {
        try {
            $query = Export::where('export_id', '>', 0);
            if (isset($dataSearch['export_code']) && $dataSearch['export_code'] != '') {
                $query->where('export_code', $dataSearch['export_code']);
            }
            if (isset($dataSearch['export_create_id']) && $dataSearch['export_create_id'] != 0) {
                $query->where('export_create_id', $dataSearch['export_create_id']);
            }
            if (isset($dataSearch['customers_id']) && $dataSearch['customers_id'] != 0) {
                $query->where('customers_id', $dataSearch['customers_id']);
            }
            if (isset($dataSearch['export_user_store']) && $dataSearch['export_user_store'] != 0) {
                $query->where('export_user_store', $dataSearch['export_user_store']);
            }
            if (isset($dataSearch['export_user_cod']) && $dataSearch['export_user_cod'] != 0) {
                $query->where('export_user_cod', $dataSearch['export_user_cod']);
            }
            if (isset($dataSearch['export_status']) && $dataSearch['export_status'] != -1) {
                $query->where('export_status', $dataSearch['export_status']);
            }
            if (isset($dataSearch['export_create_start']) && $dataSearch['export_create_start'] != 0) {
                $query->where('export_create_time','>=', $dataSearch['export_create_start']);
            }
            if (isset($dataSearch['export_create_end']) && $dataSearch['export_create_end'] != 0) {
                $query->where('export_create_time','<=', $dataSearch['export_create_end']);
            }
            $total = $query->count();
            $query->orderBy('export_id', 'desc');
            return ($offset == 0) ? $query->take($limit)->get() : $query->take($limit)->skip($offset)->get();

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function add($aryExport, $aryExportProduct)
    {
        try {

            DB::connection()->getPdo()->beginTransaction();
            $export = new Export();

            if(is_array($aryExport) && count($aryExport) > 0) {
                foreach($aryExport as $k => $v) {
                    $export->$k = $v;
                }
            }
            $export->save();
            $export_id = $export->export_id;

            if(is_array($aryExportProduct) && count($aryExportProduct) > 0){
                foreach($aryExportProduct as $exProduct){
                    $exportProduct = new ExportProduct();
                    $exportProduct->export_id = $export_id;
                    foreach($exProduct as $k => $v) {
                        $exportProduct->$k = $v;
                    }
                    $exportProduct->save();
                    $product = Product::find($exportProduct->product_id);
                    $product->product_Quantity = $product->product_Quantity - $exportProduct->export_product_num;
                    $product->save();
                }
            }

            DB::connection()->getPdo()->commit();
            return $export_id;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());die;
            DB::connection()->getPdo()->rollBack();
            //throw new PDOException();
            return false;
        }

    }

    public static function remove($export){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $export->export_status = 0;
            $export->export_update_id = User::user_id();
            $export->export_update_time = time();
            $export->save();
            $exportProduct = $export->exportproduct;
            foreach($exportProduct as $key => $value){
                if($value['export_product_status'] == 1){
                    $exportP = ExportProduct::find($value['export_product_id']);
                    $exportP->export_product_status = 0;
                    $exportP->export_product_update_id = User::user_id();
                    $exportP->export_product_update_time = time();
                    $exportP->export_product_status = 0;
                    $exportP->save();
                    $product = Product::find($value['product_id']);
                    $product->product_Quantity = $product->product_Quantity + $exportP->export_product_num;
                    $product->save();
                }
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());die;
            DB::connection()->getPdo()->rollBack();
            //throw new PDOException();
            return false;
        }
    }

    public static function reportDiscount($param){
        $query = Export::where('export_status',1);
        if(isset($param['customers_id']) && $param['customers_id'] > 0){
            $query->where('customers_id',$param['customers_id']);
        }
        if(isset($param['export_create_start']) && $param['export_create_start'] > 0){
            $query->where('export_create_time','>=',$param['export_create_start']);
        }
        if(isset($param['export_create_end']) && $param['export_create_end'] > 0){
            $query->where('export_create_time','<',$param['export_create_end']);
        }
        $query->select(DB::raw('customers_id,SUM(export_discount) as ckdn,SUM(export_discount_customer) as ckcn'));
        $query->orderBy('export_id','DESC');
        $query->groupBy('customers_id');
        $data = $query->get();
        return $data;
    }
}