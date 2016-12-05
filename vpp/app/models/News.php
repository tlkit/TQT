<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 12/4/2016
 * Time: 10:25 AM
 */
class News extends Eloquent
{
    protected $table = 'news';
    protected $primaryKey = 'news_id';
    public $timestamps = false;
    protected $fillable = array(
        'news_title',
        'news_image',
        'news_short_content',
        'news_content',
        'news_created_id',
        'news_created_name',
        'news_created_time',
        'news_update_id',
        'news_update_name',
        'news_update_time',
        'news_tag_ids',
        'news_start_time',
        'news_end_time'
    );

    public static function search($dataSearch = array(), $limit = 50, $offset = 0, &$total)
    {
        try {
            $query = News::where('news_id', '>', 0);
            if (isset($dataSearch['news_title']) && $dataSearch['news_title'] != '') {
                $query->where('news_title', $dataSearch['news_title']);
            }
            if (isset($dataSearch['news_created_id']) && $dataSearch['news_created_id'] != 0) {
                $query->where('news_created_id', $dataSearch['news_created_id']);
            }
            if (isset($dataSearch['news_start_time']) && $dataSearch['news_start_time'] != 0) {
                $query->where('news_start_time','>=', $dataSearch['news_start_time']);
            }
            if (isset($dataSearch['news_end_time']) && $dataSearch['news_end_time'] != 0) {
                $query->where('news_end_time','<=', $dataSearch['news_end_time']);
            }
            $total = $query->count();
            $query->orderBy('news_id', 'desc');
            return $query->take($limit)->skip($offset)->get();

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function add($id,$dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            if($id > 0){
                $data = News::find($id);
            }else{
                $data = new News();
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
            FunctionLib::debug($e->getMessage());
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
            return false;
        }
    }

    public static function getNewForHome(){
        try {
            $query = News::where('news_id', '>', 0);
            $query->where('news_start_time','<=', time());
            $query->where('news_end_time','>=', time());
            $query->orderBy('news_start_time', 'desc');
            return $query->take(2)->skip(0)->get();
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function getNewReCom($id,$ids){
        try {
            $query = News::where('news_id', '!=', $id);
            $query->where(function ($qu) use ($ids) {
                foreach ($ids as $k => $i) {
                    if ($k == 0) {
                        $qu->whereRaw('FIND_IN_SET(' . $i . ',news_tag_ids)');
                    } else {
                        $qu->orWhereRaw('FIND_IN_SET(' . $i . ',news_tag_ids)');
                    }
                }
            });
            $query->where('news_start_time', '<=', time());
            $query->where('news_end_time', '>=', time());
            $query->orderBy('news_start_time', 'desc');
            return $query->take(4)->skip(0)->get();
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

}