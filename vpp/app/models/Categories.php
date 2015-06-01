<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class Categories extends Eloquent
{
    protected $table = 'categories';
    protected $primaryKey = 'categories_id';
    public $timestamps = false;
    protected $fillable = array('categories_id','categories_GroupID', 'categories_ParentID', 'categories_Name', 'categories_Alias', 'categories_Icon', 'categories_SortIndex', 'categories_Status', 'categories_TotalProduct');

    public static function getByID($id) {
        return Categories::where('categories_id', $id)->get();
    }

    public static function getCategoriessAll() {
        $categories = Categories::where('categories_id', '>', 0)->where('book_status', '=', 1)->get();
        $data = array();
        foreach($categories as $itm) {
            $data[$itm['categories_id']] = $itm['book_name'];
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Categories::where('categories_id','>',0);
            if (isset($dataSearch['categories_Name']) && $dataSearch['categories_Name'] != '') {
                $query->where('categories_Name','LIKE', '%' . $dataSearch['categories_Name'] . '%');
            }
            if (isset($dataSearch['categories_Status']) && $dataSearch['categories_Status'] != -1) {
                $query->where('categories_Status', $dataSearch['categories_Status']);
            }
            $total = $query->count();
            $query->orderBy('categories_id', 'desc');
            return ($offset == 0) ? $query->take($limit)->get() : $query->take($limit)->skip($offset)->get();

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
            $data = new Categories();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->categories_id;
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
            $dataSave = Categories::find($id);
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
            $dataSave = Categories::find($id);
            $dataSave->categories_Status = $status;
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
            $dataSave = Categories::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

}