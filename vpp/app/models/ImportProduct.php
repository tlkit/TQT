<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 04/06/2015
 * Time: 9:21 CH
 */

class ImportProduct extends Eloquent{

    protected $table = 'import_product';

    public $timestamps = false;

    protected $primaryKey = 'import_product_id';

    protected $fillable = array('import_id','product_id','providers_id','import_product_price','import_product_num','import_product_total','import_product_create_id','import_product_create_time','import_product_update_id','import_product_update_time','import_product_status');

    public function product()
    {
        return $this->belongsTo('Product', 'product_id');
    }

    public static function reportImport($param){

        $query = ImportProduct::where('import_product_id','>',0);
        if($param['providers_id'] > 0){
            $query->where('providers_id',$param['providers_id']);
        }
        if($param['product_id'] > 0){
            $query->where('product_id',$param['product_id']);
        }
        if($param['import_product_create_start'] > 0){
            $query->where('import_product_create_time','>=',$param['import_product_create_start']);
        }
        if($param['import_product_create_end'] > 0){
            $query->where('import_product_create_time','<',$param['import_product_create_end']);
        }
        $query->orderBy('import_product_id','DESC');
        $data = $query->get();
        return $data;
    }


}