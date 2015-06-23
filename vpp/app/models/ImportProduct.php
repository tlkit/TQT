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

        $tbl_product = with(new Product())->getTable();
        $tbl_import_product = with(new ImportProduct())->getTable();
        $query = ImportProduct::where('import_product_id','>',0);
        $query->join($tbl_product,$tbl_import_product.'.product_id', '=', $tbl_product . '.product_id');
        if ($param['providers_id'] > 0) {
            $query->where($tbl_import_product . '.providers_id', $param['providers_id']);
        }
        if ($param['product_id'] > 0) {
            $query->where($tbl_import_product . '.product_id', $param['product_id']);
        }
        if ($param['import_product_create_start'] > 0) {
            $query->where($tbl_import_product . '.import_product_create_time', '>=', $param['import_product_create_start']);
        }
        if ($param['import_product_create_end'] > 0) {
            $query->where($tbl_import_product . '.import_product_create_time', '<', $param['import_product_create_end']);
        }
        $query->orderBy($tbl_import_product . '.import_product_id', 'DESC');
        $field_table = array(
          $tbl_import_product.'.import_product_create_time',
          $tbl_import_product.'.import_product_num',
          $tbl_import_product.'.import_product_price',
          $tbl_import_product.'.providers_id',
          $tbl_product.'.product_Code',
          $tbl_product.'.product_Name',
        );
        $data = $query->get($field_table);
        return $data;
    }


}