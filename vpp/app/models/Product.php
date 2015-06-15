<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class Product extends Eloquent
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    public $timestamps = false;

    protected $fillable = array('product_id', 'product_Code', 'product_Name', 'product_Category', 'product_CategoryName', 'product_Alias', 'product_OriginID', 'product_NameOrigin', 'product_UnitID', 'product_NameUnit', 'product_PackedWayID', 'product_NamePackedWay', 'product_Price', 'product_Description', 'product_Image', 'product_Thumbnail', 'product_Quantity', 'product_MinimumQuantity', 'product_IsAvailable', 'product_CreatorID', 'product_CreatedTime', 'product_ModifiedTime', 'product_Status');

    public static function getByID($id)
    {
        $product = Product::where('product_id', $id)->first();
        return $product;
    }

    public static function getProductsAll()
    {
        $categories = Product::where('product_id', '>', 0)->get();
        $data = array();
        foreach ($categories as $itm) {
            $data[$itm['product_id']] = array('product_Name'=>$itm['product_Name'],'product_Price'=>$itm['product_Price']);
        }
        return $data;
    }


    public static function getProductsByProductCode($product_Code) {
        $product_Code = Product::where('product_Code','=', $product_Code)->get();
        $data = array();
        foreach($product_Code as $itm) {
            if(isset($itm['product_id'])){
                $data[$itm['product_id']] = $itm['product_Code'];
            }
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Product::where('product_id','>',0);
            if (isset($dataSearch['product_Name']) && $dataSearch['product_Name'] != '') {
                $query->where('product_Name', 'LIKE', '%' . $dataSearch['product_Name'] . '%');
            }
            if (isset($dataSearch['product_Category']) && $dataSearch['product_Category'] != 0) {
                $query->where('product_Category', '=', $dataSearch['product_Category']);
            }
            $total = $query->count();
            $query->orderBy('product_id', 'desc');
            return ($offset == 0) ? $query->take($limit)->get() : $query->take($limit)->skip($offset)->get();

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }


    public static function add($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Product();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->product_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }


    public static function updData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Product::find($id);
            if (!empty($dataInput)) {
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }


    public static function delData($id)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Product::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function getListByName($name)
    {

        $data = Product::where('product_Name', 'LIKE', '%' . $name . '%')->take(30)->get(array('product_id','product_Name','product_Quantity'));
        return $data ? $data : array();
    }

    public static function getByName($name)
    {
        $data = Product::where('product_Name',$name)->first();
        return $data;
    }

    public static function reportProductHot($param){
        $tbl_product = with(new Product())->getTable();
        $tbl_export_product = with(new ExportProduct())->getTable();
        $query = DB::table($tbl_product);
        $query->join($tbl_export_product, $tbl_product . '.product_id', '=', $tbl_export_product . '.customers_id');
        $query->where($tbl_export_product . '.export_product_status', 1);
//        if ($param['customers_id'] > 0) {
//            $query->where($tbl_customers . '.customers_id', $param['customers_id']);
//        }
        if ($param['export_product_create_start'] > 0) {
            $query->where($tbl_export_product . '.export_product_create_time', '>=', $param['export_product_create_start']);
        }
        if ($param['export_product_create_end'] > 0) {
            $query->where($tbl_export_product . '.export_product_create_time', '<=', $param['export_product_create_end']);
        }
        $query->select(DB::raw($tbl_product.'.*,SUM('.$tbl_export_product.'.export_product_num) as sum_product'));
        $query->orderBy(DB::raw('SUM('.$tbl_export_product.'.export_product_num)'),'desc');
        $query->groupBy($tbl_export_product.'.product_id');
        $data = $query->get();
        return $data;
    }


}