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

    public function importproduct()
    {
        return $this->hasMany('ImportProduct', 'import_id');
    }

    public static function getCountInDay(){
        $start = strtotime(date('d-m-Y',time()));
        $count = Import::where('import_create_time','>=',$start)->count();
        return $count;
    }

    public static function search($dataSearch = array(), $limit = 50, $offset = 0, &$total)
    {
        try {
            $query = Import::where('import_id', '>', 0);
            if (isset($dataSearch['import_code']) && $dataSearch['import_code'] != '') {
                $query->where('import_code', $dataSearch['import_code']);
            }
            if (isset($dataSearch['import_create_id']) && $dataSearch['import_create_id'] != 0) {
                $query->where('import_create_id', $dataSearch['import_create_id']);
            }
            if (isset($dataSearch['providers_id']) && $dataSearch['providers_id'] != 0) {
                $query->where('providers_id', $dataSearch['providers_id']);
            }
            if (isset($dataSearch['import_status']) && $dataSearch['import_status'] != -1) {
                $query->where('import_status', $dataSearch['import_status']);
            }
            if (isset($dataSearch['import_create_start']) && $dataSearch['import_create_start'] != 0) {
                $query->where('import_create_time','>=', $dataSearch['import_create_start']);
            }
            if (isset($dataSearch['import_create_end']) && $dataSearch['import_create_end'] != 0) {
                $query->where('import_create_time','<=', $dataSearch['import_create_end']);
            }
            $total = $query->count();
            $query->orderBy('import_id', 'desc');
            return ($offset == 0) ? $query->take($limit)->get() : $query->take($limit)->skip($offset)->get();

        } catch (PDOException $e) {
            throw new PDOException();
        }
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

    public static function remove($import){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $import->import_status = 0;
            $import->import_update_id = User::user_id();
            $import->import_update_time = time();
            $import->save();
            $importProduct = $import->importproduct;
            foreach($importProduct as $key => $value){
                if($value['import_product_status'] == 1){
                    $importP = ImportProduct::find($value['import_product_id']);
                    $importP->import_product_status = 0;
                    $importP->import_product_update_id = User::user_id();
                    $importP->import_product_update_time = time();
                    $importP->import_product_status = 0;
                    $importP->save();
                    $product = Product::find($value['product_id']);
                    $product->product_Quantity = $product->product_Quantity - $importP->import_product_num;
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

}