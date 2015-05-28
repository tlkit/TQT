<?php
/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 4/10/2015
 * Time: 9:41 AM
 */

class SeoKeyWord extends Eloquent {

    protected $table = 'seo_keyword';

    public $timestamps = false;

    protected $primaryKey = 'seo_keyword_id';

    protected $fillable = array('seo_keyword_key', 'seo_keyword_encode', 'seo_keyword_description_before', 'seo_keyword_description_after', 'seo_keyword_rank', 'seo_keyword_landing_url', 'seo_keyword_category', 'seo_keyword_group', 'seo_keyword_number_search', 'seo_keyword_max_link_vt', 'seo_keyword_daily_link_vt', 'seo_keyword_project', 'seo_keyword_create_id', 'seo_keyword_create_time','seo_keyword_update_id', 'seo_keyword_update_time', 'seo_keyword_run_link_vt', 'seo_keyword_run_last_time');

    public function campaign(){

        return $this->belongsToMany('SeoCampaign', 'seo_campaign_keyword', 'seo_keyword_id', 'seo_campaign_id');
    }

    /**
     * @desc: Update du lieu
     * @param $id
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static function updData($id, $data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $key = SeoKeyWord::find($id);
            foreach($data as $k=>$val) {
                $key->$k = $val;
            }
            $key->update();
            DB::connection()->getPdo()->commit();
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function getCampaignByKeyName($name)
    {
        $key = SeoKeyWord::where('seo_keyword_key', 'LIKE', '%' . $name . '%')->get();
        $ids = array();
        if ($key) {
            foreach ($key as $cam) {
                foreach ($cam->campaign as $c) {
                    $ids[] = $c['seo_campaign_id'];
                }

            }
        }
        return $ids;
    }
	
	public static function getDescKey($num=0, $category_id=0, $seo_keyword_id=0) {
        try {
            if($num == 0) {
                return false;
            }
            $query = SeoKeyWord::select('seo_keyword_description_before', 'seo_keyword_description_after');
            $query->where('seo_keyword_category', '=', $category_id);
            $query->where('seo_keyword_id', '<>', $seo_keyword_id);
            $query->orderBy(DB::raw('RAND()'));
            return $query->take($num)->skip(0)->get();
        } catch (\PDOException $e) {
            var_dump($e->getMessage()); die;
            throw new PDOException();
        }

    }
}