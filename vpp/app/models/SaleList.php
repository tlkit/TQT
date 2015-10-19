<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 18/10/2015
 * Time: 10:11 CH
 */

class SaleList extends Eloquent{

    protected $table = 'sale_list';

    public $timestamps = false;

    protected $primaryKey = 'sale_list_id';

    protected $fillable = array('customers_id','sale_list_type','sale_list_status','sale_list_code','sale_list_create_id', 'sale_list_create_time');

    public function export()
    {
        return $this->hasMany('Export', 'sale_list_id');
    }

}