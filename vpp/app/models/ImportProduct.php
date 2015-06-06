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


}