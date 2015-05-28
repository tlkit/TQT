<?php

class Website extends \Eloquent {

    /**
     * The database table admin by the model.
     *
     * @var string
     */
    protected $table = 'website';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'website_id';

    public $timestamps = false;

    // define which attributes are mass assignable (for security)
    protected $fillable = array('website_id','website_name', 'website_desc', 'website_domain', 'website_ip', 'website_status', 'website_position', 'website_created_at','website_updated_at','website_user_created','website_user_updated','website_is_run');

    /**
     * @desc: Filter website.
     * @param array $data
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws PDOException
     */
    public static function getByID($website_id) {
        return Website::where('website_id', $website_id)->get();
    }

    public static function getDomainByID($website_id) {
        return Website::select('website_domain')->where('website_id', $website_id)->first();
    }

    public static function getByArrayID($arrID) {
        return Website::where('website_id', 'IN', '(2, 4)')->get();
    }

    public static function getAll() {
        $query = DB::table('website');
        $query->select('website_id', 'website_domain');
        return $query->where('website_id', '>', 0)->where('website_status', '=', 1)->where('website_is_run', '=', 0)->get();
    }

    public static function setValueIsRun() {
        return Website::where('website_id', '>', 0)->update(array('website_is_run' => 0));
    }

    public static function searchByCondition($data = array(), $limit =0, $offset=0){
        try{
            if(!empty($data)) {
                //FunctionLib::debug($data);
                $query = Website::where('website_id','>',0);
                if (isset($data['website_name']) && $data['website_name'] != '') {
                    $query->where('website_name','LIKE', '%' . $data['website_name'] . '%');
                }
                if (isset($data['website_domain']) && $data['website_domain'] != '') {
                    $query->where('website_domain','LIKE', '%' . $data['website_domain'] . '%');
                }
                if (isset($data['website_status']) && $data['website_status'] > 0) {
                    $query->where('website_status', $data['website_status']);
                }
                $website = array(
                    'size'=> $query->count(),
                    'data' => $query->orderBy('website_id', 'desc')->take($limit)->skip($offset)->get()
                );

                return $website;
            }else {
                $website=array(
                    'data' =>   DB::table('website')->orderBy('website_id', 'desc')->take($limit)->skip($offset)->get(),
                    'size'=>DB::table('website')->count()
                );
                return $website;
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
    public static function add($data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $website = new Website();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $website->$k = $v;
                }
            }
            if ($website->save()) {
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
    public static  function updData($id, $data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $website = Website::find($id);
            foreach($data as $k=>$val) {
                $website->$k = $val;
            }
            if($website->update()) {
                DB::connection()->getPdo()->commit();
                return true;
            }
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
            $website = Website::find($id);
            $website->website_status = $status;
            $website->update();
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
            $website = Website::find($id);
            $website->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }
}
