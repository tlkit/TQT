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
    protected $customer = array();

    public function __construct()
    {
        $this->treeCategory = $this->buildCategoryTree();
        $this->customer = Customers::customer_login();
        $cart = Session::has('cart') ? Session::get('cart') : array();
        View::share('treeCategory', $this->treeCategory);
        View::share('customer_login', $this->customer);
        View::share('cart', $cart);
    }

    public function home(){
        $banner = Banner::getBannerRun();
        $product = Product::getProductHome();
        $this->layout->content = View::make('site.SiteLayouts.home')->with('banner',$banner)->with('product',$product);
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
        $product = Product::find($id);
        $product_relate = Product::getProductRelate($product);
        if(!$product){
            return Redirect::route('site.home');
        }
        $this->layout->content = View::make('site.SiteLayouts.product')->with('product',$product)->with('product_relate',$product_relate);
    }

    public function register(){
        $this->layout->content = View::make('site.SiteLayouts.register');
    }

    public function submitRegister(){
        $param['customers_FirstName'] = htmlspecialchars(trim(Request::get('customers_FirstName','')));
        $param['customers_Email'] = htmlspecialchars(trim(Request::get('customers_Email','')));
        $param['customers_Phone'] = htmlspecialchars(trim(Request::get('customers_Phone','')));
        $param['customers_Fax'] = htmlspecialchars(trim(Request::get('customers_Fax','')));
        $param['customers_BizAddress'] = htmlspecialchars(trim(Request::get('customers_BizAddress','')));
        $param['customers_username'] = htmlspecialchars(trim(Request::get('customers_username','')));
        $param['customers_password'] = htmlspecialchars(trim(Request::get('customers_password','')));
        $param['customers_password_confirm'] = htmlspecialchars(trim(Request::get('customers_password_confirm','')));
        $error = array();
        if($param['customers_FirstName'] == '' || strlen($param['customers_FirstName']) <= 3){
            $error['customers_FirstName'] = 'Tên khách hàng phải lớn hơn 3 ký tự';
        }

        if($param['customers_Email'] == '' || !filter_var($param['customers_Email'],FILTER_VALIDATE_EMAIL)){
            $error['customers_Email'] = 'Email chưa đúng định dạng';
        }

        if($param['customers_Phone'] == ''){
            $error['customers_Phone'] = 'Số điện thoại không được để trống';
        }

        if($param['customers_BizAddress'] == ''){
            $error['customers_BizAddress'] = 'Địa chỉ không được để trống';
        }

        if($param['customers_username'] == '' || strlen($param['customers_username']) < 6 || strlen($param['customers_username']) > 32){
            $error['customers_username'] = 'Tên đăng nhập phải nằm trong khoảng 6-32 ký tự';
        }else{
            $customer = Customers::where('customers_username', $param['customers_username'])->first();
            $customer = $customer->toArray();
            if($customer){
                $error['customers_username'] = 'Tên đăng nhập đã tồn tại';
            }
        }

        if($param['customers_password'] == '' || strlen($param['customers_password']) < 6 || strlen($param['customers_password']) > 32){
            $error['customers_password'] = 'Mật khẩu phải nằm trong khoảng 6-32 ký tự';
        }

        if($param['customers_password'] !== $param['customers_password_confirm']){
            $error['customers_password_confirm'] = 'Xác nhận mật khẩu không chính xác';
        }

        if($error){
            $this->layout->content = View::make('site.SiteLayouts.register')->with('param',$param)->with('error',$error);
        }else{
            unset($param['customers_password_confirm']);
            $param['customers_password'] = md5('xxx_'.$param['customers_password']);
            $param['customers_site'] = 1;
            $id = Customers::add($param);
            $success = 0;
            if($id > 0){
                $success = 1;
                $data = array(
                    'customers_id' => $id,
                    'customers_username' => $param['customers_username'],
                    'customers_FirstName' => $param['customers_FirstName'],
                    'customers_Email' => $param['customers_Email'],
                    'customers_Phone' => $param['customers_Phone'],
                    'customers_BizAddress' => $param['customers_BizAddress'],
                );
                Session::put('customer', $data, 60*60*24);
            }
            return Redirect::route('site.register_success',array('success' => $success));
        }
    }

    public function registerSuccess(){
        $success = (int)Request::get('success',1);
        $this->layout->content = View::make('site.SiteLayouts.register_success')->with('success',$success);
    }

    public function loginInfo()
    {
        if (Session::has('customer')) {
            return Redirect::route('site.home');
        } else {
            $this->layout->content = View::make('site.SiteLayouts.login');
        }
    }

    public function login()
    {
        $username = Request::get('customers_username', '');
        $password = Request::get('customers_password', '');
        $error = '';
        if ($username != '' && $password != '') {
            if (strlen($username) < 6 || strlen($username) > 32 || strlen($password) < 6) {
                $error = 'Không tồn tại tên đăng nhập!';
            } else {
                $user = Customers::where('customers_username', $username)->first();
                $user = $user->toArray();
                if ($user) {
                    if ($user['customers_password'] == md5('xxx_' . $password)) {
                        $data = array(
                            'customers_id' => $user['customers_id'],
                            'customers_username' => $user['customers_username'],
                            'customers_FirstName' => $user['customers_FirstName'],
                            'customers_Email' => $user['customers_Email'],
                            'customers_Phone' => $user['customers_Phone'],
                            'customers_BizAddress' => $user['customers_BizAddress'],
                        );
                        Session::put('customer', $data, 60*60*24);
                        return Redirect::route('site.home');
                    } else {
                        $error = 'Mật khẩu không đúng!';
                    }
                } else {
                    $error = 'Không tồn tại tên đăng nhập!';
                }
            }
        } else {
            $error = 'Chưa nhập thông tin đăng nhập!';
        }
        $this->layout->content = View::make('site.SiteLayouts.login')
            ->with('error', $error)->with('username', $username);
    }

    public function logout()
    {
        if (Session::has('customer')) {
            Session::forget('customer');
        }
        return Redirect::to(URL::previous());
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