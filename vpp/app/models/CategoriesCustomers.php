<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class CategoriesCustomers extends Eloquent
{
    protected $table = 'categories_discount_customers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = array('id','category_id', 'category_name', 'category_price_discount', 'customer_id', 'customer_name');

    public static function getCategoriesByCustomersId($customer_id) {
        if($customer_id == 0) return array();
        $categories = CategoriesCustomers::where('customer_id', '=', $customer_id)->get();
        $data = array();
        foreach($categories as $itm) {
            $data[$itm['category_id']] = array('category_price_discount'=>$itm['category_price_discount'],
                'id'=>$itm['id']);
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
            $data = new CategoriesCustomers();
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
            $dataSave = CategoriesCustomers::find($id);
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