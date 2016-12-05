<?php

/**
 * Created by PhpStorm.
 * User: tuanna
 * Date: 01/07/2016
 * Time: 12:04 SA
 */
class Page extends Eloquent
{
    protected $table = 'page';

    public $timestamps = false;

    protected $primaryKey = 'page_id';

    protected $fillable = array('page_name', 'page_content', 'page_status', 'page_type', 'page_is_head');

    public static function add($id,$dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            if($id > 0){
                $data = Page::find($id);
            }else{
                $data = new Page();
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
}