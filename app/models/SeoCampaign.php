<?php
/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 4/10/2015
 * Time: 2:39 PM
 */

class SeoCampaign extends Eloquent{

    protected $table = 'seo_campaign';

    public $timestamps = false;

    protected $primaryKey = 'seo_campaign_id';

    protected $fillable = array('seo_campaign_name', 'seo_campaign_category_id','seo_campaign_start_time','seo_campaign_project_id','seo_campaign_status','seo_campaign_create_id','seo_campaign_create_time','seo_campaign_update_id','seo_campaign_update_time');

    public function keyword()
    {
        return $this->belongsToMany('SeoKeyWord', 'seo_campaign_keyword', 'seo_campaign_id', 'seo_keyword_id');
    }
	
	public function seoCampaignKey()
    {
        return $this->hasMany('SeoCampaignKeyWord', 'seo_campaign_id');
    }

    public function getSeoCampaignById($project_id, $limit=0) {
        $query = DB::table($this->table);
        $seoCampaignKeyWord = new SeoCampaignKeyWord();
        $tblSeoCampaignKeyWord = $seoCampaignKeyWord->getTable();

        $seoKeyWord = new SeoKeyWord();
        $tblSeoKeyWord = $seoKeyWord->getTable();

        $query->join($tblSeoCampaignKeyWord, function($join)
        {
            $join->on($this->table.'.seo_campaign_id', '=', 'seo_campaign_keyword.seo_campaign_id');
        });
        $query->join($tblSeoKeyWord, function($join)
        {
            $join->on('seo_campaign_keyword.seo_keyword_id', '=', 'seo_keyword.seo_keyword_id');
        });
        $query->where($this->table.'.seo_campaign_start_time', '<=', time());
        $query->where('seo_keyword.seo_keyword_run_last_time', '<=', time()-86400);
        $query->where($this->table.'.seo_campaign_status', '=', 1);
        $query->where($this->table.'.seo_campaign_project_id', '=', $project_id);

        return $query->take($limit)->get();
    }
	
    public static function createCampaign($data = array(),$row = array()){

        try {
            // tạo campaign
            $campaign = new SeoCampaign();
            DB::connection()->getPdo()->beginTransaction();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $campaign->$k = $v;
                }
            }
            $campaign->save();
            // tạo môi quan hê + key word
            if (is_array($row) && count($row) > 0) {

                $aryCategory = SeoCategory::aryCategorySafe();
                foreach($row as $val){
                    if(isset($val['C']) && $val['C'] != '' ){
                        $key = SeoKeyWord::where('seo_keyword_encode',base64_encode($val['C']))->where('seo_keyword_project',$data['seo_campaign_project_id'])->first();
                        if($key){
                            $key->seo_keyword_description_before = isset($val['B']) ? $val['B'] : '';
                            $key->seo_keyword_description_after = isset($val['D']) ? $val['D'] : '';
                            $key->seo_keyword_rank = isset($val['E']) ? $val['E'] : '';
                            $key->seo_keyword_landing_url = isset($val['F']) ? $val['F'] : '';
                            $key->seo_keyword_category = isset($aryCategory[strtolower(FunctionLib::safe_title($val['G']))]) ? $aryCategory[strtolower(FunctionLib::safe_title($val['G']))] : 0;
                            $key->seo_keyword_group = isset($val['H']) ? $val['H'] : '';
                            $key->seo_keyword_number_search = isset($val['I']) ? (int)$val['I'] : '';
                            $key->seo_keyword_max_link_vt = isset($val['J']) ? (int)$val['J'] : '';
                            $key->seo_keyword_daily_link_vt = isset($val['K']) ? (int)$val['K'] : '';
                            $key->seo_keyword_update_time = time();
                            $key->seo_keyword_update_id = User::user_id();
                            $key->save();
                            $id_key = $key->seo_keyword_id;
                        }else{
                            $key = new SeoKeyWord();
                            $key->seo_keyword_description_before = isset($val['B']) ? $val['B'] : '';
                            $key->seo_keyword_key = $val['C'];
                            $key->seo_keyword_encode = base64_encode($val['C']);
                            $key->seo_keyword_description_after = isset($val['D']) ? $val['D'] : '';
                            $key->seo_keyword_rank = isset($val['E']) ? $val['E'] : '';
                            $key->seo_keyword_landing_url = isset($val['F']) ? $val['F'] : '';
                            $key->seo_keyword_category = isset($aryCategory[strtolower(FunctionLib::safe_title($val['G']))]) ? $aryCategory[strtolower(FunctionLib::safe_title($val['G']))] : 0;
                            $key->seo_keyword_group = isset($val['H']) ? $val['H'] : '';
                            $key->seo_keyword_number_search = isset($val['I']) ? (int)$val['I'] : '';
                            $key->seo_keyword_max_link_vt = isset($val['J']) ? (int)$val['J'] : '';
                            $key->seo_keyword_daily_link_vt = isset($val['K']) ? (int)$val['K'] : '';
                            $key->seo_keyword_project = $data['seo_campaign_project_id'];
                            $key->seo_keyword_create_time = time();
                            $key->seo_keyword_create_id = User::user_id();
                            $key->save();
                            $id_key = $key->seo_keyword_id;
                        }
                        $id_campaign = $campaign->seo_campaign_id;
                        $campaign_keyword = new SeoCampaignKeyWord();
                        $campaign_keyword->seo_keyword_id = $id_key;
                        $campaign_keyword->seo_campaign_id = $id_campaign;
                        $campaign_keyword->save();
                    }else{
                        break;
                    }
                }

            }
            DB::connection()->getPdo()->commit();

            return $campaign->seo_campaign_id;
        } catch (\PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function updateCampaign($id,$data = array(),$row = array()){
        
        try {
            // update
            $campaign = SeoCampaign::find($id);
            if(!$campaign){
                return false;
            }
            DB::connection()->getPdo()->beginTransaction();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $campaign->$k = $v;
                }
            }
            $campaign->save();
            // tạo môi quan hê
            if (is_array($row) && count($row) > 0) {

                $aryCategory = SeoCategory::aryCategorySafe();
                SeoCampaignKeyWord::where('seo_campaign_id', $campaign->seo_campaign_id)->delete();
                foreach($row as $val){
                    if(isset($val['C']) && $val['C'] != '' ){
                        $key = SeoKeyWord::where('seo_keyword_encode',base64_encode($val['C']))->where('seo_keyword_project',$data['seo_campaign_project_id'])->first();
                        if($key){
                            $key->seo_keyword_description_before = isset($val['B']) ? $val['B'] : '';
                            $key->seo_keyword_description_after = isset($val['D']) ? $val['D'] : '';
                            $key->seo_keyword_rank = isset($val['E']) ? $val['E'] : '';
                            $key->seo_keyword_landing_url = isset($val['F']) ? $val['F'] : '';
                            $key->seo_keyword_category = isset($aryCategory[strtolower(FunctionLib::safe_title($val['G']))]) ? $aryCategory[strtolower(FunctionLib::safe_title($val['G']))] : 0;
                            $key->seo_keyword_group = isset($val['H']) ? $val['H'] : '';
                            $key->seo_keyword_number_search = isset($val['I']) ? (int)$val['I'] : '';
                            $key->seo_keyword_max_link_vt = isset($val['J']) ? (int)$val['J'] : '';
                            $key->seo_keyword_daily_link_vt = isset($val['K']) ? (int)$val['K'] : '';
                            $key->seo_keyword_update_time = time();
                            $key->seo_keyword_update_id = User::user_id();
                            $key->save();
                            $id_key = $key->seo_keyword_id;
                        }else{
                            $key = new SeoKeyWord();
                            $key->seo_keyword_description_before = isset($val['B']) ? $val['B'] : '';
                            $key->seo_keyword_key = $val['C'];
                            $key->seo_keyword_encode = base64_encode($val['C']);
                            $key->seo_keyword_description_after = isset($val['D']) ? $val['D'] : '';
                            $key->seo_keyword_rank = isset($val['E']) ? $val['E'] : '';
                            $key->seo_keyword_landing_url = isset($val['F']) ? $val['F'] : '';
                            $key->seo_keyword_category = isset($aryCategory[strtolower(FunctionLib::safe_title($val['G']))]) ? $aryCategory[strtolower(FunctionLib::safe_title($val['G']))] : 0;
                            $key->seo_keyword_group = isset($val['H']) ? $val['H'] : '';
                            $key->seo_keyword_number_search = isset($val['I']) ? (int)$val['I'] : '';
                            $key->seo_keyword_max_link_vt = isset($val['J']) ? (int)$val['J'] : '';
                            $key->seo_keyword_daily_link_vt = isset($val['K']) ? (int)$val['K'] : '';
                            $key->seo_keyword_project = $data['seo_campaign_project_id'];
                            $key->seo_keyword_create_time = time();
                            $key->seo_keyword_create_id = User::user_id();
                            $key->save();
                            $id_key = $key->seo_keyword_id;
                        }
                        $id_campaign = $campaign->seo_campaign_id;
                        $campaign_keyword = new SeoCampaignKeyWord();
                        $campaign_keyword->seo_keyword_id = $id_key;
                        $campaign_keyword->seo_campaign_id = $id_campaign;
                        $campaign_keyword->save();
                    }else{
                        break;
                    }
                }

            }
            DB::connection()->getPdo()->commit();

            return $campaign->seo_campaign_id;
        } catch (\PDOException $e) {

            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function search($data = array(),$limit,$offset,&$size){

        $query = SeoCampaign::where('seo_campaign_id', '>', 0);
        $query->where('seo_campaign_status', '>', 0);
        if (isset($data['ary_seo_campaign_id']) && sizeof($data['ary_seo_campaign_id']) > 0) {
            $query->whereIn('seo_campaign_id',$data['ary_seo_campaign_id']);
        }
        if (isset($data['seo_campaign_name']) && $data['seo_campaign_name'] != '') {
            $query->where('seo_campaign_name', 'LIKE', '%' . $data['seo_campaign_name'] . '%');
        }
        if (isset($data['seo_campaign_project_id']) && $data['seo_campaign_project_id'] != 0) {
            $query->where('seo_campaign_project_id', $data['seo_campaign_project_id']);
        }
        if (isset($data['seo_campaign_start_from']) && $data['seo_campaign_start_from'] != 0) {
            $query->where('seo_campaign_start_time','>=', $data['seo_campaign_start_from']);
        }
        if (isset($data['seo_campaign_start_to']) && $data['seo_campaign_start_to'] != 0) {
            $query->where('seo_campaign_start_time','<=', $data['seo_campaign_start_to']);
        }
        $size = $query->count();
        $data = $query->orderBy('seo_campaign_id', 'desc')->take($limit)->skip($offset)->get();
        return $data;
    }
}