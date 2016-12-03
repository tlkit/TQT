<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class ProductSort extends Eloquent
{
    protected $table = 'product_sort';

    protected $primaryKey = 'product_sort_id';

    public $timestamps = false;

    protected $fillable = array('product_sort_object_id', 'product_sort_label', 'product_sort_status', 'product_sort_banner', 'product_sort_product_ids', 'product_sort_type', 'product_sort_create_id', 'product_sort_create_time', 'product_sort_update_id', 'product_sort_update_time');

    public static function getProductShortByTypeAndObject($type,$object){
        return ProductSort::where('product_sort_status',1)->where('product_sort_type',$type)->where('product_sort_object_id',$object)->first();
    }

    public static function getListProductShortByTypeAndObject($type,$object){
        return ProductSort::where('product_sort_status',1)->where('product_sort_type',$type)->where('product_sort_object_id',$object)->get();
    }

    public static function updData($id, $dataInput)
    {
        try {
            if ($id == 0) {
                $dataSave = new ProductSort();
            } else {
                $dataSave = ProductSort::find($id);
            }
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $dataSave->$k = $v;
                }
            }
            $dataSave->save();
            return $dataSave->product_sort_id;
        } catch (PDOException $e) {
            var_dump($e);die;
            throw new PDOException();
        }
    }

    public static function search($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Product::where('product_id', '>', 0);
            if (isset($dataSearch['product_sort_label']) && $dataSearch['product_sort_label'] != '') {
                $query->where('product_sort_label', 'LIKE', '%' . $dataSearch['product_sort_label'] . '%');
            }
            if (isset($dataSearch['product_sort_status']) && $dataSearch['product_sort_status'] >= 0) {
                $query->where('product_sort_status', '=', $dataSearch['product_sort_status']);
            }
            $query->where('product_sort_type', '=', 3);
            $total = $query->count();
            $query->orderBy('product_id', 'desc');
            return $query->take($limit)->skip($offset)->get();

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }
}