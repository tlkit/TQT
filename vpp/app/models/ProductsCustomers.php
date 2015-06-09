<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class ProductsCustomers extends Eloquent
{
    protected $table = 'product_discount_customers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = array('id','category_id', 'category_name', 'customer_id', 'customer_name', 'product_id', 'product_name', 'product_price', 'product_price_discount');

    public static function getProductByCustomersId($customer_id) {
        if($customer_id == 0) return array();
        $categories = ProductsCustomers::where('customer_id', '=', $customer_id)->get();
        $data = array();
        foreach($categories as $itm) {
            $data[$itm['product_id']] = array('product_price_discount'=>$itm['product_price_discount'], 'id'=>$itm['id']);
        }
        return $data;
    }

    /**
     * @desc: Tao website.
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static function add($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new ProductsCustomers();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }



    /**
     * @desc: Update du lieu
     * @param $id
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static  function updData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = ProductsCustomers::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

}