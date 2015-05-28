<?php

class SeoCategory extends \Eloquent {

    /**
     * The database table admin by the model.
     *
     * @var string
     */
    protected $table = 'category';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'category_id';

    public $timestamps = false;

    // define which attributes are mass assignable (for security)
    protected $fillable = array('category_id','category_name', 'category_total_post', 'category_status', 'updated_at', 'created_at', 'category_user_id_creater', 'category_user_name_creater', 'category_user_id_modify', 'category_user_name_modify');

    /**
     * @desc: Filter website.
     * @param array $data
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws PDOException
     */
    public static function getByID($id) {
        return SeoCategory::where('category_id', $id)->get();
    }

    public static function getCategoryAll() {
        $categories = SeoCategory::where('category_id', '>', 0)->where('category_status', '=', 1)->get();
        $data = array();
        foreach($categories as $itm) {
            $data[$itm['category_id']] = $itm['category_name'];
        }
        return $data;
    }

    public static function aryCategorySafe() {
        $categories = SeoCategory::where('category_id', '>', 0)->where('category_status', '=', 1)->get();
        $data = array();
        foreach($categories as $itm) {
            $data[strtolower(FunctionLib::safe_title($itm['category_name']))] = $itm['category_id'];
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0){
        try{
            if(!empty($dataSearch)) {
                //FunctionLib::debug($data);
                $query = SeoCategory::where('category_id','>',0);
                if (isset($dataSearch['category_name']) && $dataSearch['category_name'] != '') {
                    $query->where('category_name','LIKE', '%' . $dataSearch['category_name'] . '%');
                }
                if (isset($dataSearch['category_status']) && $dataSearch['category_status'] != -1) {
                    $query->where('category_status', $dataSearch['category_status']);
                }
                if (isset($dataSearch['category_user_id_creater']) && $dataSearch['category_user_id_creater'] > 0) {
                    $query->where('category_user_id_creater', $dataSearch['category_user_id_creater']);
                }
                $data = array(
                    'size'=> $query->count(),
                    'data' => $query->orderBy('category_id', 'desc')->take($limit)->skip($offset)->get()
                );

                return $data;
            }else {
                $data=array(
                    'data' =>   DB::table('category')->orderBy('category_id', 'desc')->take($limit)->skip($offset)->get(),
                    'size'=>DB::table('category')->count()
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
            $data = new SeoCategory();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return true;
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
            $dataSave = SeoCategory::find($id);
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
            $dataSave = SeoCategory::find($id);
            $dataSave->category_status = $status;
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
            $dataSave = SeoCategory::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }
}
