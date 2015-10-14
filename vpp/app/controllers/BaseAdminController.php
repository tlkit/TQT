<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 29/05/2015
 * Time: 8:27 CH
 */
class BaseAdminController extends BaseController
{

    protected $layout = 'admin.AdminLayouts.index';
    protected $permission = array();
    protected $user = array();

    public function __construct()
    {
        if (!User::isLogin()) {

            Redirect::route('admin.login',array('url'=>self::buildUrlEncode(URL::current())))->send();
        }

        $this->user = User::user_login();
        if($this->user && sizeof($this->user['user_permission']) > 0){
            $this->permission = $this->user['user_permission'];
        }

        View::share('aryPermission',$this->permission);
        View::share('user',$this->user);

    }

    public function convert(){
        $ex = ExportProduct::where('export_product_status',1)->where('export_product_price_origin',0)->orderBy('export_product_id','ASC')->take(200)->get();
        foreach($ex as $key => $value){
            $countN = ImportProduct::where('product_id',$value['product_id'])->where('import_product_status',1)->sum('import_product_num');;
            $countX = ExportProduct::where('product_id',$value['product_id'])->where('export_product_status',1)->where('export_product_create_time','<',$value['export_product_create_time'])->sum('export_product_num');;
            $count = $countN - $countX;
            $import = ImportProduct::where('product_id',$value['product_id'])->where('import_product_status',1)->orderBy('import_product_create_time', 'DESC')->get();
            $aryStore = array();
            $price_input = 0;
            if($import){
                $x = $y = $i =0;
                foreach($import as $k => $v){
                    if($x < $count){
                        $y = $x;
                        $x += $v['import_product_num'];
                        $aryStore[$i]['num'] = ($x <= $count) ? $v['import_product_num'] : ($count - $y);
                        $aryStore[$i]['price'] = $v['import_product_price'];
                        $i++;
                    }
                }
                krsort($aryStore);
                $aryStore = array_values($aryStore);
                $temp = $value['export_product_num'];
                foreach($aryStore as $k => $v){
                    if($temp > 0){
                        $price_input += ($temp <= $v['num']) ? ($temp*$v['price']) : ($v['num']*$v['price']);
                        $temp = $temp - $v['num'];
                    }
                }
            }
            $export = ExportProduct::find($value['export_product_id']);
            $export->export_product_price_origin = $price_input;
            $export->save();
            echo $value['export_product_id'].'_'.$price_input;
            echo '<br>';
        }
        echo 'done';die;
    }

    public function update(){
        /*
         *
         * UPDATE export AS e,
 (
	SELECT
		export_id,
		sum(
			export_product_price_origin
		) AS mysum
	FROM
		export_product
	GROUP BY
		export_id
) AS p
SET e.export_price_origin = p.mysum
WHERE
	e.export_id = p.export_id
         * */
    }

}