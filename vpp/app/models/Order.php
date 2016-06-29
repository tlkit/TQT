<?php

/**
 * Created by PhpStorm.
 * User: Vicky
 * Date: 6/26/2016
 * Time: 11:13 PM
 */
class Order extends Eloquent
{
    protected $table = 'order';

    public $timestamps = false;

    protected $primaryKey = 'order_id';

    protected $fillable = array('customers_id','customers_name','customer_phone','customer_email','customers_address', 'order_create_time', 'order_status', 'order_price_total', 'order_vat', 'order_price_item', 'customer_note');

    public function orderitem()
    {
        return $this->hasMany('OrderItem', 'order_id');
    }

}