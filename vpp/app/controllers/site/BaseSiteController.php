<?php

/**
 * Created by PhpStorm.
 * User: tuanna
 * Date: 17/04/2016
 * Time: 3:29 CH
 */
class BaseSiteController extends BaseController
{
    protected $layout = 'site.SiteLayouts.index';
    protected $treeCategory = array();

    public function __construct()
    {
        $this->treeCategory = $this->buildCategoryTree();
        View::share('treeCategory', $this->treeCategory);
    }

    public function home(){
        $banner = Banner::getBannerRun();
        $this->layout->content = View::make('site.SiteLayouts.home')->with('banner',$banner);
    }

    public function group($id,$name){
        $param['sort'] = trim(Request::get('sort','new'));
        $param['limit'] = (int)Request::get('limit',16);

        $this->layout->content = View::make('site.SiteLayouts.group');
    }

    public function buildCategoryTree(){
        $category = Categories::lists('categories_Name','categories_id');
        $group = GroupCategory::getGroupForSite()->toArray();
        foreach($group as $k => $v){
            $child = ($v['category_list_id'] != '') ? explode(',',$v['category_list_id']) : array();
            if($child){
                foreach($child as $ke => $c){
                    $v['child'][$c] = $category[$c];
                }
            }
            $group[$k] = $v;
        }
        return $group;
    }

}