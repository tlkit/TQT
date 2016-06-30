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

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Order::where('order_id','>',0);
            if (isset($dataSearch['customers_name']) && $dataSearch['customers_name'] != '') {
                $query->where('customers_name','LIKE', '%' . $dataSearch['customers_name'] . '%');
            }
            if (isset($dataSearch['order_status']) && $dataSearch['order_status'] != -1) {
                $query->where('order_status', $dataSearch['order_status']);
            }
            if (isset($dataSearch['customers_phone']) && $dataSearch['customers_phone'] != '') {
                $query->where('customers_phone', $dataSearch['customers_phone']);
            }
            if (isset($dataSearch['customers_email']) && $dataSearch['customers_email'] != '') {
                $query->where('customers_email', $dataSearch['customers_email']);
            }
            $total = $query->count();
            $query->orderBy('order_id', 'desc');
            return $query->take($limit)->skip($offset)->get();

        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    public static function getOrderById($id){
        try {
            $orders = Order::find($id);
            if ($orders) {
                foreach ($orders->orderitem as $item) {
                    $item->product;
                }
                return $orders;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new PDOException();
            return false;
        }
    }

    public static function upDateStatusById($id,$status){
        try {
            $orders = Order::find($id);
            if ($orders) {
                $orders->order_status= $status;
                $orders->save();
                return $orders;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new PDOException();
            return false;
        }
    }

}