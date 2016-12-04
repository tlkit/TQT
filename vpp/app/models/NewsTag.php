<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 12/4/2016
 * Time: 10:25 AM
 */
class NewsTag extends Eloquent
{
    protected $table = 'news_tag';
    protected $primaryKey = 'news_tag_id';
    public $timestamps = false;
    protected $fillable = array(
        'news_tag_name',
        'news_tag_status',
        'news_tag_create_id'
    );

    public static function add($id,$dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            if($id > 0){
                $data = NewsTag::find($id);
            }else{
                $data = new NewsTag();
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

    public static function getAllListTag(){
        $tag = NewsTag::where('news_tag_status', '>', 0)->lists('news_tag_name','news_tag_id');
        return $tag ? $tag : array();
    }

}