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

    protected $fillable = array('customers_id','sale_list_type','sale_list_status','sale_list_code','sale_list_bill','sale_list_time','sale_list_total_pay','sale_list_create_id', 'sale_list_create_time','sale_list_pay_id','sale_list_pay_time');

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
            $total = 0;
            if(is_array($export_ids) && count($export_ids) > 0){
                foreach($export_ids as $export_id){
                    $export = Export::find($export_id);
                    if($export->sale_list_id == 0){
                        $export->sale_list_id = $sale_list_id;
                        $total += $export->export_total_pay;
                        $export->save();
                    }else{
                        return false;
                    }
                }
            }
            $sale_list->sale_list_total_pay = $total;
            if($sale_list->sale_list_type == 0){
                $sale_list->sale_list_pay_id = User::user_id();
                $sale_list->sale_list_pay_time = time();
            }
            $sale_list->save();

            DB::connection()->getPdo()->commit();
            return $sale_list_id;
        } catch (\PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            //throw new PDOException();
            return false;
        }

    }

    public static function search($dataSearch = array(), $limit = 50, $offset = 0, &$total)
    {
        try {
            $query = SaleList::where('sale_list_id', '>', 0);

            if (isset($dataSearch['customers_id']) && $dataSearch['customers_id'] != 0) {
                $query->where('customers_id', $dataSearch['customers_id']);
            }
            if (isset($dataSearch['sale_list_status']) && $dataSearch['sale_list_status'] != -1) {
                $query->where('sale_list_status', $dataSearch['sale_list_status']);
            }
            if (isset($dataSearch['sale_list_type']) && $dataSearch['sale_list_type'] != -1) {
                $query->where('sale_list_type', $dataSearch['sale_list_type']);
            }
            if (isset($dataSearch['sale_list_code']) && $dataSearch['sale_list_code'] != '') {
                $query->where('sale_list_code', $dataSearch['sale_list_code']);
            }
            if (isset($dataSearch['sale_list_bill']) && $dataSearch['sale_list_bill'] != '') {
                $query->where('sale_list_bill', $dataSearch['sale_list_bill']);
            }
            if (isset($dataSearch['sale_list_create_id']) && $dataSearch['sale_list_create_id'] != 0) {
                $query->where('sale_list_create_id', $dataSearch['sale_list_create_id']);
            }
            if (isset($dataSearch['sale_list_start']) && $dataSearch['sale_list_start'] != 0) {
                $query->where('sale_list_time','>=', $dataSearch['sale_list_start']);
            }
            if (isset($dataSearch['sale_list_end']) && $dataSearch['sale_list_end'] != 0) {
                $query->where('sale_list_time','<=', $dataSearch['sale_list_end']);
            }
            $total = $query->count();
            $query->orderBy('sale_list_id', 'desc');
            return $query->take($limit)->skip($offset)->get();

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function updatePayment($sale){
        try {
            DB::connection()->getPdo()->beginTransaction();
            if($sale->sale_list_type == 1){
                $sale->sale_list_type = 0;
                $sale->sale_list_pay_id = User::user_id();
                $sale->sale_list_pay_time = time();
                $sale->save();
            }else{
                return false;
            }
            DB::connection()->getPdo()->commit();
            return $sale->sale_list_id;
        } catch (\PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            //throw new PDOException();
            return false;
        }
    }

}