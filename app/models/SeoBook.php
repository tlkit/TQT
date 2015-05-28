<?php

class SeoBook extends \Eloquent {

    /**
     * The database table admin by the model.
     *
     * @var string
     */
    protected $table = 'book';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'book_id';

    public $timestamps = false;

    // define which attributes are mass assignable (for security)
    protected $fillable = array('book_id','book_name', 'book_total_post', 'book_status', 'updated_at', 'created_at', 'book_publisher', 'book_author', 'book_user_id_creater', 'book_user_name_creater', 'book_time_creater', 'book_user_name_modify', 'book_user_id_modify', 'book_time_modify');

    /**
     * @desc: Filter website.
     * @param array $data
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws PDOException
     */
    public static function getByID($id) {
        return SeoBook::where('book_id', $id)->get();
    }

    public static function getBooksAll() {
        $books = SeoBook::where('book_id', '>', 0)->where('book_status', '=', 1)->get();
        $data = array();
        foreach($books as $itm) {
            $data[$itm['book_id']] = $itm['book_name'];
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0){
        try{
            if(!empty($dataSearch)) {
                //FunctionLib::debug($data);
                $query = SeoBook::where('book_id','>',0);
                if (isset($dataSearch['book_name']) && $dataSearch['book_name'] != '') {
                    $query->where('book_name','LIKE', '%' . $dataSearch['book_name'] . '%');
                }
                if (isset($dataSearch['book_status']) && $dataSearch['book_status'] != -1) {
                    $query->where('book_status', $dataSearch['book_status']);
                }
                if (isset($dataSearch['book_user_id_creater']) && $dataSearch['book_user_id_creater'] > 0) {
                    $query->where('book_user_id_creater', $dataSearch['book_user_id_creater']);
                }
                $data = array(
                    'size'=> $query->count(),
                    'data' => $query->orderBy('book_id', 'desc')->take($limit)->skip($offset)->get()
                );

                return $data;
            }else {
                $data=array(
                    'data' =>   DB::table('book')->orderBy('book_id', 'desc')->take($limit)->skip($offset)->get(),
                    'size'=>DB::table('book')->count()
                );
                return $data;
            }
        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    /**
     * @desc: Tao website.
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static function add($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new SeoBook();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->book_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update du lieu
     * @param $id
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static  function updData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = SeoBook::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update trang thai website.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function updStatus($id,$status){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = SeoBook::find($id);
            $dataSave->book_status = $status;
            $dataSave->update();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update trang thai website.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function delData($id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = SeoBook::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }
}
