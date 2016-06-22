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
        $param['sort'] = trim(Request::get('sort', 'new'));
        $param['limit'] = (int)Request::get('limit', 16);
        $param['page'] = (int)Request::get('page', 1);
        $c_ids = array();
        if($id > 0){
            $cate = isset($this->treeCategory[$id]['child']) ? $this->treeCategory[$id]['child'] : array();
            $c_ids = array_keys($cate);
        }
        $offset = ($param['page'] - 1) * $param['limit'];
        $orderBy = isset(Constant::$sort[$param['sort']]['field']) ? Constant::$sort[$param['sort']]['field'] : '';
        $orderType = isset(Constant::$sort[$param['sort']]['type']) ? Constant::$sort[$param['sort']]['type'] : '';
        $total = 0;
        $data = Product::getProductCate($c_ids, $orderBy, $orderType, $offset, $param['limit'], $total);
        $this->layout->content = View::make('site.SiteLayouts.group')->with('data',$data)->with('id',$id)->with('param',$param);
    }

    public function buildCategoryTree(){
        $category = Categories::lists('categories_Name','categories_id');
        $group = GroupCategory::getGroupForSite()->toArray();
        $data = array();
        foreach($group as $k => $v){
            $child = ($v['category_list_id'] != '') ? explode(',',$v['category_list_id']) : array();
            if($child){
                foreach($child as $ke => $c){
                    $v['child'][$c] = $category[$c];
                }
            }
            $data[$v['group_category_id']] = $v;
        }
        return $data;
    }

    public function buildPaging(){
        $html = '<div class="pagination">
<div class="links">
<b>1</b>
<a href="http://www.homenoffice.sg/basic-stationery?page=2">2</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=3">3</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=4">4</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=5">5</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=6">6</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=7">7</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=8">8</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=9">9</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=10">10</a>
<a href="http://www.homenoffice.sg/basic-stationery?page=11">11</a>
</div>
<div class="results">Showing 1 to 16 of 697 (44 Pages)</div>
</div>';
    }

    public static function getNewPager($numPageShow = 10, $page = 1,$total = 1,$limit = 1,$dataSearch){
        $total_page = ceil($total/$limit);
        if($total_page == 1) return '';
        $next = '';
        $last = '';
        $prev = '';
        $first= '';
        $left_dot  = '';
        $right_dot = '';
        $from_page = ($page - (int)($numPageShow/2)) > 0 ? $page - (int)($numPageShow/2) : 1;
        $to_page = ($from_page + $numPageShow - 1 < $total_page) ? $from_page + $numPageShow - 1 : $total_page;

        //get prev & first link
        if($page > 1){
            $prev = self::parseNewLink($page-1, '', "&lt; Trước", $page_name,$dataSearch);
            $first= self::parseNewLink(1, '', "&laquo; Đầu", $page_name,$dataSearch);
        }
        //get next & last link
        if($page < $total_page){
            $next = self::parseNewLink($page+1, '', "Sau &gt;", $page_name,$dataSearch);
            $last = self::parseNewLink($total_page, '', "Cuối &raquo;", $page_name,$dataSearch);
        }
        //get dots & from_page & to_page
        if($from_page > 0)	{
            $left_dot = ($from_page > 1) ? '<li><span>...</span></li>' : '';
        }else{
            $from_page = 1;
        }

        if($to_page < $total_page)	{
            $right_dot = '<li><span>...</span></li>';
        }else{
            $to_page = $total_page;
        }
        $pagerHtml = '';
        for($i=$from_page;$i<=$to_page;$i++){
            $pagerHtml .= self::parseNewLink($i, (($page == $i) ? 'active' : ''), $i, $page_name,$dataSearch);
        }
        return '<ul class="pagination">'.$first.$prev.$left_dot.$pagerHtml.$right_dot.$next.$last.'</ul>';
    }

}