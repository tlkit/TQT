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

    protected $fillable = array('customers_id','sale_list_type','sale_list_status','sale_list_code','sale_list_bill','sale_list_create_id', 'sale_list_create_time');

    public function export()
    {
        return $this->hasMany('Export', 'sale_list_id');
    }

    public static function getCountInDay(){
        $start = strtotime(date('d-m-Y',time()));
        $count = SaleList::where('sale_list_create_time','>=',$start)->count();
        return $count;
    }

    public static function add($data, $export_ids)
    {
        try {

            DB::connection()->getPdo()->beginTransaction();
            $sale_list = new SaleList();
            if(is_array($data) && count($data) > 0) {
                foreach($data as $k => $v) {
                    $sale_list->$k = $v;
                }
            }
            $sale_list->save();
            $sale_list_id = $sale_list->sale_list_id;
            if(is_array($export_ids) && count($export_ids) > 0){
                foreach($export_ids as $export_id){
                    $export = Export::find($export_id);
                    if($export->sale_list_id == 0){
                        $export->sale_list_id = $sale_list_id;
                        $export->save();
                    }else{
                        return false;
                    }
                }
            }

            DB::connection()->getPdo()->commit();
            return $sale_list_id;
        } catch (\PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            //throw new PDOException();
            return false;
        }

    }

}