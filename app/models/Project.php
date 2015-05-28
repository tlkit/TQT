<?php

class SeoProject extends \Eloquent {

    /**
     * The database table admin by the model.
     *
     * @var string
     */
    protected $table = 'seo_project';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'seo_project_id';

    public $timestamps = false;

    // define which attributes are mass assignable (for security)
    protected $fillable = array('seo_project_id','seo_project_name','seo_project_status','seo_project_position','seo_project_user_id_creater','seo_project_user_name_creater','seo_project_time_creater','seo_project_user_id_modify','seo_project_user_name_modify','seo_project_time_modify');

    /**
     * @desc: Filter website.
     * @param array $data
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws PDOException
     */
    public static function getByID($id) {
        return SeoProject::where('seo_project_id', $id)->get();
    }

    public static function getProjectAll() {
        $project = SeoProject::where('seo_project_id', '>', 0)->where('seo_project_status', '=', 1)->get();
        $data = array();
        foreach($project as $itm) {
            $data[$itm['seo_project_id']] = $itm['seo_project_name'];
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0){
        try{
            if(!empty($dataSearch)) {
                $query = SeoProject::where('seo_project_id','>',0);
                if (isset($dataSearch['seo_project_name']) && $dataSearch['seo_project_name'] != '') {
                    $query->where('seo_project_name','LIKE', '%' . $dataSearch['seo_project_name'] . '%');
                }
                if (isset($dataSearch['seo_project_status']) && $dataSearch['seo_project_status'] != -1) {
                    $query->where('seo_project_status', $dataSearch['seo_project_status']);
                }
                $data = array(
                    'size'=> $query->count(),
                    'data' => $query->orderBy('seo_project_position', 'asc')->take($limit)->skip($offset)->get()
                );

                return $data;
            }else {
                $data=array(
                    'data' => DB::table('seo_project')->orderBy('seo_project_position', 'asc')->take($limit)->skip($offset)->get(),
                    'size'=>DB::table('seo_project')->count()
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
            $data = new SeoProject();
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
            $dataSave = SeoProject::find($id);
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
            $dataSave = SeoProject::find($id);
            $dataSave->seo_project_status = $status;
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
            $dataSave = SeoProject::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }
}
