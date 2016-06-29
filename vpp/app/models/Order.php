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

    protected $fillable = array('customers_id','customers_name','customers_phone','customers_email','customers_address', 'order_create_time', 'order_status', 'order_price_total', 'order_vat', 'order_price_item', 'customer_note');

    public function orderitem()
    {
        return $this->hasMany('OrderItem', 'order_id');
    }

    public static function add($dataOrder, $dataOrderItems)
    {
        try {

            DB::connection()->getPdo()->beginTransaction();
            $order = new Order();

            if(is_array($dataOrder) && count($dataOrder) > 0) {
                foreach($dataOrder as $k => $v) {
                    $order->$k = $v;
                }
            }
            $order->save();
            $order_id = $order->order_id;
            if(is_array($dataOrderItems) && count($dataOrderItems) > 0){
                foreach($dataOrderItems as $dataOrderItem){
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order_id;
                    foreach($dataOrderItem as $k => $v) {
                        $orderItem->$k = $v;
                    }
                    $orderItem->save();
                }
            }

            DB::connection()->getPdo()->commit();
            return $order_id;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());die;
            DB::connection()->getPdo()->rollBack();
            //throw new PDOException();
            return false;
        }

    }

}