<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class Personnel extends Eloquent
{
    protected $table = 'personnel';
    protected $primaryKey = 'personnel_id';
    public $timestamps = false;
    protected $fillable = array('personnel_id','personnel_name', 'personnel_brithday', 'personnel_village', 'personnel_adress_1', 'personnel_adress_2', 'personnel_email', 'personnel_phone', 'personnel_time_star_work','personnel_time_out_work', 'personnel_status','personnel_user_id','personnel_user_name');

    public static function getByID($id) {
        return Personnel::where('personnel_id', $id)->get();
    }

    public static function getListAll() {
        $categories = Personnel::where('personnel_id', '>', 0)->lists('personnel_name','personnel_id');
        return $categories ? $categories : array();
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Personnel::where('personnel_id','>',0);
            if (isset($dataSearch['personnel_name']) && $dataSearch['personnel_name'] != '') {
                $query->where('personnel_name','LIKE', '%' . $dataSearch['personnel_name'] . '%');
            }
            if (isset($dataSearch['personnel_phone']) && $dataSearch['personnel_phone'] != '') {
                $query->where('personnel_phone','LIKE', '%' . $dataSearch['personnel_phone'] . '%');
            }
            $total = $query->count();
            $query->orderBy('personnel_id', 'desc');
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
            $data = new Personnel();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->personnel_id;
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
            $dataSave = Personnel::find($id);
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
    public static function delData($id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Personnel::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

}