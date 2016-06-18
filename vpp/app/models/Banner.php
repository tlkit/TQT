<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/15/2016
 * Time: 9:59 AM
 */
class Banner extends Eloquent
{
    protected $table = 'banner';

    public $timestamps = false;

    protected $primaryKey = 'banner_id';

    protected $fillable = array('banner_name','banner_image','banner_url','banner_start_time','banner_end_time');

    public static function add($id,$dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            if($id > 0){
                $data = Banner::find($id);
            }else{
                $data = new Banner();
            }
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            $data->save();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
            return false;
        }
    }

    public static function getBannerRun(){
        try{
            $query = Banner::where('banner_id','>',0)->where('banner_start_time','<=',time())->where('banner_end_time','>=',time());
            $query->orderBy('banner_id', 'desc');
            return $query->get();
        }catch (PDOException $e){
            throw new PDOException();
        }
    }
}