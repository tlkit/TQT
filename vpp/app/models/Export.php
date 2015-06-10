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

    protected $fillable = array('export_code','customers_id','export_customers_address','export_customers_name', 'export_customer_phone', 'export_customers_note','export_delivery_time','export_user_store','export_user_cod','export_subtotal','export_total','export_total_pay','export_discount','export_discount_customer','export_vat','export_status','export_note','export_create_id','export_create_time','export_update_id','export_update_time');

    public function exportproduct()
    {
        return $this->hasMany('ExportProduct', 'export_id');
    }
}