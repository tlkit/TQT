<?php

class LogAPI extends \Eloquent {

    /**
     * The database table admin by the model.
     *
     * @var string
     */
    protected $table = 'log';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'log_id';

    public $timestamps = false;

    // define which attributes are mass assignable (for security)
    protected $fillable = array('log_id','log_content', 'log_type', 'log_run_time', 'log_created_at');

    /**
     * @desc: Filter website.
     * @param array $data
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws PDOException
     */
    public static function getByID($log_id) {
        return LogAPI::where('log_id', '=', $log_id)->get();
    }

    public static function searchByCondition($data = array(), $limit =0, $offset=0){
        try{
            if(!empty($data)) {
                //FunctionLib::debug($data);
                $query = LogAPI::where('log_id','>',0);

                $arrTime = FunctionLib::timeFromTo($data['log_created_at_from'],'');
                $created_at_start = isset($arrTime['time_start']) ? $arrTime['time_start'] : 0;
                if (isset($data['log_created_at_from']) && $created_at_start > 0) {
                    $query->where('log_created_at', '>=', $created_at_start);
                }

                $arrTimeEnd = FunctionLib::timeFromTo('',$data['log_created_at_to'],'');
                $created_at_end = isset($arrTimeEnd['time_end']) ? $arrTimeEnd['time_end'] : 0;
                if (isset($data['log_created_at_to']) && $created_at_end > 0) {
                    $query->where('log_created_at', '<=', $created_at_end);
                }

                $website = array(
                    'size'=> $query->count(),
                    'data' => $query->orderBy('log_id', 'desc')->take($limit)->skip($offset)->get()
                );
                return $website;
            }else {
                $website=array(
                    'data' =>DB::table('log')->orderBy('log_id', 'desc')->take($limit)->skip($offset)->get(),
                    'size'=>DB::table('log')->count()
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
    public static function addData($data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $logAPI = new LogAPI();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $logAPI->$k = $v;
                }
            }
           $logAPI->save();
           DB::connection()->getPdo()->commit();
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            //echo var_dump($e->getMessage()); die;
            throw new PDOException();
        }
    }
}
