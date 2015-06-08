<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 07/06/2015
 * Time: 7:46 CH
 */

class ExportProduct extends Eloquent{

    protected $table = 'export_product';

    public $timestamps = false;

    protected $primaryKey = 'export_product_id';

    protected $fillable = array('export_id','product_id','customers_id','export_product_price','export_product_num','export_product_subtotal','export_product_discount','export_product_discount_customer','export_product_total','export_report_status','export_product_create_id','export_product_create_time','export_product_update_id','export_product_update_time');

    public function product()
    {
        return $this->belongsTo('Product', 'product_id');
    }

}