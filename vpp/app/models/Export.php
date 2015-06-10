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
}