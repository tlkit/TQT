<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 07/06/2015
 * Time: 7:46 CH
 */

class ExportProduct extends Eloquent{

    protected $table = 'export_product';

    public $timestamps = false;

    protected $primaryKey = 'export_product_id';

    protected $fillable = array('export_id','product_id','customers_id','export_product_price','export_product_num','export_product_discount','export_product_discount_customer','export_product_total','export_product_price_origin','export_product_status','export_product_type','export_product_create_id','export_product_create_time','export_product_update_id','export_product_update_time');

    public function product()
    {
        return $this->belongsTo('Product', 'product_id');
    }

    public static function reportExport($param){

        $tbl_product = with(new Product())->getTable();
        $tbl_export_product = with(new ExportProduct())->getTable();
        $query = ExportProduct::where('export_product_status',1);
        $query->join($tbl_product,$tbl_export_product.'.product_id', '=', $tbl_product . '.product_id');
        if ($param['customers_id'] > 0) {
            $query->where($tbl_export_product . '.customers_id', $param['customers_id']);
        }
        if ($param['product_id'] > 0) {
            $query->where($tbl_export_product . '.product_id', $param['product_id']);
        }
        if ($param['export_product_create_start'] > 0) {
            $query->where($tbl_export_product . '.export_product_create_time', '>=', $param['export_product_create_start']);
        }
        if ($param['export_product_create_end'] > 0) {
            $query->where($tbl_export_product . '.export_product_create_time', '<', $param['export_product_create_end']);
        }
        $query->orderBy($tbl_export_product . '.export_product_id', 'DESC');
        $field_table = array(
            $tbl_export_product.'.export_product_create_time',
            $tbl_export_product.'.export_product_num',
            $tbl_export_product.'.export_product_price',
            $tbl_export_product.'.customers_id',
            $tbl_product.'.product_Code',
            $tbl_product.'.product_Name',
        );
        $data = $query->get($field_table);
        return $data;
    }
    public static function reportSaleList($export_ids){
        $tbl_product = with(new Product())->getTable();
        $tbl_export_product = with(new ExportProduct())->getTable();
        $query = ExportProduct::where('export_product_status',1);
        $query->join($tbl_product,$tbl_export_product.'.product_id', '=', $tbl_product . '.product_id');
        $query->whereIn($tbl_export_product.'.export_id',$export_ids);
        $query->orderBy($tbl_export_product . '.export_product_id', 'DESC');
        $query->groupBy($tbl_export_product . '.product_id');
        $query->groupBy($tbl_export_product . '.export_product_price');
        $field_table = array(
            $tbl_export_product.'.export_product_create_time',
            DB::raw('SUM('.$tbl_export_product.'.export_product_num) as export_product_num'),
            $tbl_export_product.'.export_product_price',
            DB::raw('SUM('.$tbl_export_product.'.export_product_discount) as export_product_discount'),
            DB::raw('SUM('.$tbl_export_product.'.export_product_total) as export_product_total'),
            $tbl_export_product.'.customers_id',
            $tbl_product.'.product_id',
            $tbl_product.'.product_Code',
            $tbl_product.'.product_Name',
            $tbl_product.'.product_NameUnit',
            $tbl_product.'.product_NameOrigin',
        );
        $data = $query->get($field_table);
        return $data;
    }
    
    public static function reportSaleListNotVat($param)
    {
        $tbl_product = with(new Product())->getTable();
        $tbl_export_product = with(new ExportProduct())->getTable();
        $tbl_export = with(new Export())->getTable();
        $query = ExportProduct::where('export_product_status', 1);
        $query->join($tbl_product, $tbl_export_product . '.product_id', '=', $tbl_product . '.product_id');
        $query->join($tbl_export, $tbl_export . '.export_id', '=', $tbl_export_product . '.export_id');

        $query->where($tbl_export . '.export_vat', '=', 0);
        if ($param['customers_id'] > 0) {
            $query->where($tbl_export_product . '.customers_id', $param['customers_id']);
        }
        if ($param['export_product_create_start'] > 0) {
            $query->where($tbl_export_product . '.export_product_create_time', '>=', $param['export_product_create_start']);
        }
        if ($param['export_product_create_end'] > 0) {
            $query->where($tbl_export_product . '.export_product_create_time', '<', $param['export_product_create_end']);
        }
        $query->orderBy($tbl_export_product . '.export_product_id', 'DESC');
        $query->groupBy($tbl_export_product . '.product_id');
        $query->groupBy($tbl_export_product . '.export_product_price');
        $field_table = array(
            $tbl_export_product . '.export_product_create_time',
            DB::raw('SUM(' . $tbl_export_product . '.export_product_num) as export_product_num'),
            $tbl_export_product . '.export_product_price',
            DB::raw('SUM(' . $tbl_export_product . '.export_product_discount) as export_product_discount'),
            DB::raw('SUM(' . $tbl_export_product . '.export_product_total) as export_product_total'),
            $tbl_export_product . '.customers_id',
            $tbl_product . '.product_id',
            $tbl_product . '.product_Code',
            $tbl_product . '.product_Name',
            $tbl_product . '.product_NameUnit',
            $tbl_product . '.product_NameOrigin',
            $tbl_export . '.export_customers_name',
        );
        $data = $query->get($field_table);
        return $data;
    }

}