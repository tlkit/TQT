<?php
/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 4/10/2015
 * Time: 3:15 PM
 */

class SeoCampaignKeyWord extends Eloquent{

    protected $table = 'seo_campaign_keyword';

    public $timestamps = false;

//    protected $primaryKey = 'group_user_permission_id';

    protected $fillable = array('seo_campaign_id','seo_keyword_id');
}