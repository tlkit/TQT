<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 04/06/2015
 * Time: 9:19 CH
 */

class Import extends Eloquent{

    protected $table = 'import';

    public $timestamps = false;

    protected $primaryKey = 'import_id';

    protected $fillable = array('import_code','providers_id','import_price','import_status','import_note','import_create_id','import_create_time','import_update_id','import_update_time');

    public static function getCountInDay(){
        $start = strtotime(date('d-m-Y',time()));
        $count = Import::where('import_create_time','>=',$start)->count();
        return $count;
    }

    public static function add($aryImport, $aryImportProduct)
    {
        try {

            DB::connection()->getPdo()->beginTransaction();
            $import = new Import();

            if(is_array($aryImport) && count($aryImport) > 0) {
                foreach($aryImport as $k => $v) {
                    $import->$k = $v;
                }
            }
            $import->save();
            $import_id = $import->import_id;

            if(is_array($aryImportProduct) && count($aryImportProduct) > 0){
                foreach($aryImportProduct as $imProduct){
                    $importProduct = new ImportProduct();
                    $importProduct->import_id = $import_id;
                    foreach($imProduct as $k => $v) {
                        $importProduct->$k = $v;
                    }
                    $importProduct->save();
                    $product = Product::find($importProduct->product_id);
                    $product->product_Quantity = $product->product_Quantity + $importProduct->import_product_num;
                    $product->save();
                }
            }

            DB::connection()->getPdo()->commit();
            return $import_id;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());die;
            DB::connection()->getPdo()->rollBack();
            //throw new PDOException();
            return false;
        }

    }

}