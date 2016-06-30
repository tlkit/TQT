<?php

/**
 * Created by PhpStorm.
 * User: Vicky
 * Date: 6/27/2016
 * Time: 12:16 AM
 */
class OrderItem extends Eloquent
{
    protected $table = 'order_item';

    public $timestamps = false;

    protected $primaryKey = 'order_item_id';

    protected $fillable = array('order_id','product_id','product_name','product_price','product_num', 'order_item_price', 'order_item_create');

    public function order()
    {
        return $this->belongsTo('Order', 'order_id');
    }
    public function product()
    {
        return $this->belongsTo('Product');
    }
}