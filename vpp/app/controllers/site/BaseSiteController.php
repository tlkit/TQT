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
        $param['id'] = $id;
        $param['name'] = $name;
        $param['sort'] = trim(Request::get('sort', 'new'));
        $param['limit'] = (int)Request::get('limit', 16);
        $page = (int)Request::get('page', 1);
        $c_ids = array();
        if($id > 0){
            $cate = isset($this->treeCategory[$id]['child']) ? $this->treeCategory[$id]['child'] : array();
            $c_ids = array_keys($cate);
        }
        $offset = ($page - 1) * $param['limit'];
        $orderBy = isset(Constant::$sort[$param['sort']]['field']) ? Constant::$sort[$param['sort']]['field'] : '';
        $orderType = isset(Constant::$sort[$param['sort']]['type']) ? Constant::$sort[$param['sort']]['type'] : '';
        $total = 0;
        $data = Product::getProductCate($c_ids, $orderBy, $orderType, $offset, $param['limit'], $total);
        $paging = $this->buildPaging(10,$page,$total,$param['limit'],$param);
        $this->layout->content = View::make('site.SiteLayouts.group')->with('data',$data)->with('id',$id)->with('param',$param)->with('paging',$paging);
    }

    public function cate($gid,$id,$name){
        $param['gid'] = $gid;
        $param['id'] = $id;
        $param['name'] = $name;
        $param['sort'] = trim(Request::get('sort', 'new'));
        $param['limit'] = (int)Request::get('limit', 16);
        $page = (int)Request::get('page', 1);
        $c_ids = array($id);
        $offset = ($page - 1) * $param['limit'];
        $orderBy = isset(Constant::$sort[$param['sort']]['field']) ? Constant::$sort[$param['sort']]['field'] : '';
        $orderType = isset(Constant::$sort[$param['sort']]['type']) ? Constant::$sort[$param['sort']]['type'] : '';
        $total = 0;
        $data = Product::getProductCate($c_ids, $orderBy, $orderType, $offset, $param['limit'], $total);
        $paging = $this->buildPaging(10,$page,$total,$param['limit'],$param);
        $this->layout->content = View::make('site.SiteLayouts.cate')->with('data',$data)->with('gid',$gid)->with('id',$id)->with('param',$param)->with('paging',$paging);
    }

    public function product($id,$name){

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

    public static function buildPaging($numPageShow = 10, $page = 1,$total = 1,$limit = 1,$dataSearch){
        $total_page = ceil($total/$limit);
        if($total_page == 1) return '';
        $from_page = ($page - $numPageShow/2) > 0 ? ceil($page - $numPageShow/2) : 1;
        $to_page = ($from_page + $numPageShow - 1 < $total_page) ? $from_page + $numPageShow - 1 : $total_page;
        $action = Route::currentRouteAction();
        $html = '<div class="pagination"><div class="links">';
        if($page > 1){
            $dataSearch['page'] = $page -1;
            $html .= '<a href="' . action($action, $dataSearch) . '"><img valign="middle" onmouseout="this.src=' . "'" . asset('assets/site/image/prev.png') . "'" . '" onmouseover="this.src=' . "'" . asset('assets/site/image/prev-r.png') . "'" . '" src="' . asset('assets/site/image/prev.png') . '"></a>';
        }
        if($from_page > 1){
            $html .= '....';
        }
        while ($from_page <= $to_page) {
            if ($from_page == $page) {
                $html .= '<b>' . $from_page . '</b>';
            } else {
                $dataSearch['page'] = $from_page;
                $html .= '<a href="' . action($action, $dataSearch) . '">' . $from_page . '</a>';
            }
            $from_page++;
        }
        if($to_page < $total_page){
            $html .= '....';
        }
        if($page < $total_page){
            $dataSearch['page'] = $page +1;
            $html .= '<a href="' . action($action, $dataSearch) . '"><img valign="middle" onmouseout="this.src=' . "'" . asset('assets/site/image/next.png') . "'" . '" onmouseover="this.src=' . "'" . asset('assets/site/image/next-r.png') . "'" . '" src="'.asset('assets/site/image/next.png').'"></a>';
        }
        $html .= '</div></div>';
        return $html;
    }

}