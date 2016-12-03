<?php

/**
 * Created by PhpStorm.
 * User: tuanna
 * Date: 20/06/2016
 * Time: 8:30 CH
 */
class GroupCategory extends Eloquent
{
    protected $table = 'group_category';

    public $timestamps = false;

    protected $primaryKey = 'group_category_id';

    protected $fillable = array('group_category_name','group_category_icon','group_category_icon_hover','group_category_image','category_list_id','group_category_status','category_status');

    public static function add($id,$dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            if($id > 0){
                $data = GroupCategory::find($id);
            }else{
                $data = new GroupCategory();
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

    public static function getGroupForSite(){
        try {
            $data = GroupCategory::where('group_category_status', 1)->where('category_status', 1)->get();
            return $data;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function getGroupByCatId($id){
        try {
            return GroupCategory::whereRaw('FIND_IN_SET('.$id.',category_list_id)')->first();
        } catch (PDOException $e) {
            return $e->getMessage();
            var_dump($e->getMessage());die;
            throw new PDOException();
        }
    }
}