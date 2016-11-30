<?php

/**
 * Created by PhpStorm.
 * User: tuanna
 * Date: 17/04/2016
 * Time: 3:29 CH
 */
class BaseSiteController extends BaseController
{
    protected $layout = 'site.SiteLayouts.dt_index';
    protected $treeCategory = array();
    protected $customer = array();

    public function __construct()
    {
        $this->treeCategory = $this->buildCategoryTree();
        $this->customer = Customers::customer_login();
        $cart = Session::has('cart') ? Session::get('cart') : array();
        $page = Page::all();
        $keyword = htmlspecialchars(trim(Request::get('q','')));
        View::share('treeCategory', $this->treeCategory);
        View::share('customer_login', $this->customer);
        View::share('cart', $cart);
        View::share('page_menu', $page);
        View::share('keyword', $keyword);
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

    public function search(){
        $param['q'] = htmlspecialchars(trim(Request::get('q','')));
        $param['sort'] = trim(Request::get('sort', 'new'));
        $param['limit'] = (int)Request::get('limit', 16);
        $page = (int)Request::get('page', 1);
        $offset = ($page - 1) * $param['limit'];
        $orderBy = isset(Constant::$sort[$param['sort']]['field']) ? Constant::$sort[$param['sort']]['field'] : '';
        $orderType = isset(Constant::$sort[$param['sort']]['type']) ? Constant::$sort[$param['sort']]['type'] : '';
        $total = 0;
        if(strlen($param['q']) >= 3 ){
            $data = Product::getProductSearch($param['q'], $orderBy, $orderType, $offset, $param['limit'], $total);
        }else{
            $data = array();
        }
        $paging = $this->buildPaging(10,$page,$total,$param['limit'],$param);
        $this->layout->content = View::make('site.SiteLayouts.search')->with('data',$data)->with('param',$param)->with('paging',$paging);
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
        $param['customers_ContactAddress'] = htmlspecialchars(trim(Request::get('customers_ContactAddress','')));
        $param['customers_IsNeededVAT'] = (int)Request::get('customers_IsNeededVAT',0);
        $param['customers_TaxCode'] = htmlspecialchars(trim(Request::get('customers_TaxCode','')));
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

        if($param['customers_ContactAddress'] == ''){
            $error['customers_ContactAddress'] = 'Địa chỉ không được để trống';
        }

        if($param['customers_username'] == '' || strlen($param['customers_username']) < 6 || strlen($param['customers_username']) > 32){
            $error['customers_username'] = 'Tên đăng nhập phải nằm trong khoảng 6-32 ký tự';
        }else{
            $customer = Customers::where('customers_username', $param['customers_username'])->first();
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

        if($param['customers_IsNeededVAT'] == 1){
            if($param['customers_TaxCode'] == ''){
                $error['customers_TaxCode'] = 'Bạn chưa nhập mã số thuế';
            }
            if($param['customers_BizAddress'] == ''){
                $error['customers_BizAddress'] = 'Bạn chưa nhập địa chỉ xuất hóa đơn';
            }
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
                    'customers_ContactAddress' => $param['customers_ContactAddress'],
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
        $url = htmlspecialchars(trim(Request::get('url','')));
        if (Session::has('customer')) {
            if($url == ''){
                return Redirect::route('site.home');
            }else{
                return Redirect::to(base64_decode($url));
            }
        } else {
            $this->layout->content = View::make('site.SiteLayouts.login')->with('url',$url);
        }
    }

    public function login()
    {
        $username = Request::get('customers_username', '');
        $password = Request::get('customers_password', '');
        $url = htmlspecialchars(trim(Request::get('url','')));
        $error = '';
        if ($username != '' && $password != '') {
            if (strlen($username) < 6 || strlen($username) > 32 || strlen($password) < 6) {
                $error = 'Không tồn tại tên đăng nhập!';
            } else {
                $user = Customers::where('customers_username', $username)->first();
                //$user = $user->toArray();
                if ($user) {
                    if ($user['customers_password'] == md5('xxx_' . $password)) {
                        $data = array(
                            'customers_id' => $user['customers_id'],
                            'customers_username' => $user['customers_username'],
                            'customers_FirstName' => $user['customers_FirstName'],
                            'customers_Email' => $user['customers_Email'],
                            'customers_Phone' => $user['customers_Phone'],
                            'customers_ContactAddress' => $user['customers_ContactAddress'],
                            'customers_IsNeededVAT' => $user['customers_IsNeededVAT'],
                        );
                        Session::put('customer', $data, 60*60*24);
                        if($url == ''){
                            return Redirect::route('site.home');
                        }else{
                            return Redirect::to(base64_decode($url));
                        }
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
            ->with('error', $error)->with('url', $url)->with('username', $username);
    }

    public function logout()
    {
        if (Session::has('customer')) {
            Session::forget('customer');
        }
        return Redirect::to(URL::previous());
    }

    public function viewCart(){
        $this->layout->content = View::make('site.SiteLayouts.view_cart');
    }

    public function checkoutCart(){
        $vat = (isset($this->customer['customers_IsNeededVAT']) && $this->customer['customers_IsNeededVAT'] == 1) ? 1 : 0;
        $this->layout->content = View::make('site.SiteLayouts.checkout')->with('payment_address',1)->with('vat',$vat);
    }

    public function submitCheckoutCart(){
        $cart = Session::has('cart') ? Session::get('cart') : array();
        if(!$cart){
            return Redirect::route('cart.checkout_cart');
        }
        $payment_address = (int)Request::get('payment_address',1);
        $param['customers_name'] = htmlspecialchars(trim(Request::get('customers_name', '')));
        $param['customers_email'] = htmlspecialchars(trim(Request::get('customers_email', '')));
        $param['customers_phone'] = htmlspecialchars(trim(Request::get('customers_phone', '')));
        $param['customers_address'] = htmlspecialchars(trim(Request::get('customers_address', '')));
        $param['customers_note'] = htmlspecialchars(trim(Request::get('customers_note', '')));
        $vat = (int)Request::get('customers_IsNeededVAT',1);
        $error = array();
        $dataOrder = $dataOrderItem = array();
        if($this->customer){
            $dataOrder['customers_id'] = $this->customer['customers_id'];
            $dataOrder['customers_name'] = $this->customer['customers_FirstName'];
            $dataOrder['customers_email'] = $this->customer['customers_Email'];
            $dataOrder['customers_phone'] = $this->customer['customers_Phone'];
            if($payment_address == 1){
                $dataOrder['customers_address'] = $this->customer['customers_ContactAddress'];
            }else{
                if($param['customers_address'] == ''){
                    $error['address'] = 'Chưa nhập địa chỉ giao hàng';
                }else{
                    $dataOrder['customers_address'] = $param['customers_address'];
                }
            }
        }else{
            if($param['customers_name'] == ''){
                $error['name'] = 'Chưa nhập tên khách hàng';
            }
            if($param['customers_email'] == '' || !filter_var($param['customers_email'],FILTER_VALIDATE_EMAIL)){
                $error['email'] = 'Email không đúng định dạng';
            }
            if($param['customers_phone'] == ''){
                $error['phone'] = 'Chưa nhập số điện thoại';
            }
            if($param['customers_address'] == ''){
                $error['address'] = 'Chưa nhập địa chỉ giao hàng';
            }
            if(!$error){
                $dataOrder['customers_name'] = $param['customers_name'];
                $dataOrder['customers_email'] = $param['customers_email'];
                $dataOrder['customers_phone'] = $param['customers_phone'];
                $dataOrder['customers_address'] = $param['customers_address'];
            }
        }
        $dataOrder['customers_note'] = $param['customers_note'];
        if($error){
            $this->layout->content = View::make('site.SiteLayouts.checkout')->with('error',$error)->with('vat',$vat)->with('param',$param)->with('payment_address',$payment_address);
        }else{
            $sub_total = 0;
            foreach($cart as $k => $v){
                $dataOrderItem[$k]['product_id'] = $v['product_id'];
                $dataOrderItem[$k]['product_name'] = $v['product_Name'];
                $dataOrderItem[$k]['product_code'] = $v['product_Code'];
                $dataOrderItem[$k]['product_price'] = $v['product_price_buy'];
                $dataOrderItem[$k]['product_num'] = $v['product_num'];
                $dataOrderItem[$k]['order_item_price'] = ($v['product_num'] * $v['product_price_buy']);
                $dataOrderItem[$k]['order_item_create'] = time();
                $sub_total += $v['product_num'] * $v['product_price_buy'];
            }
            $dataOrder['order_create_time'] = time();
            $dataOrder['order_status'] = 1;
            $dataOrder['order_price_item'] = $sub_total;
            $dataOrder['order_vat'] = ($vat == 1) ? ceil($sub_total/10) : 0;
            $dataOrder['order_price_total'] = $dataOrder['order_vat'] + $dataOrder['order_price_item'];
            Order::add($dataOrder,$dataOrderItem);
            Session::forget('cart');
            return Redirect::route('cart.checkout_cart_success');
        }

    }

    public function successOrder(){
        $this->layout->content = View::make('site.SiteLayouts.order_success');
    }

    public function changeInfo(){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $customer = Customers::find($this->customer['customers_id']);
        $this->layout->content = View::make('site.SiteLayouts.changeInfo')->with('customer',$customer);
    }

    public function submitChangeInfo(){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $param['customers_FirstName'] = htmlspecialchars(trim(Request::get('customers_FirstName','')));
        $param['customers_Email'] = htmlspecialchars(trim(Request::get('customers_Email','')));
        $param['customers_Phone'] = htmlspecialchars(trim(Request::get('customers_Phone','')));
        $param['customers_ContactAddress'] = htmlspecialchars(trim(Request::get('customers_ContactAddress','')));
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

        if($param['customers_ContactAddress'] == ''){
            $error['customers_ContactAddress'] = 'Địa chỉ không được để trống';
        }
        if($error){
            $this->layout->content = View::make('site.SiteLayouts.changeInfo')->with('customer',$param)->with('error',$error);
        }else{
            if(Customers::updData($this->customer['customers_id'],$param)){
                $data = array(
                    'customers_id' => $this->customer['customers_id'],
                    'customers_username' => $this->customer['customers_username'],
                    'customers_FirstName' => $param['customers_FirstName'],
                    'customers_Email' => $param['customers_Email'],
                    'customers_Phone' => $param['customers_Phone'],
                    'customers_ContactAddress' => $param['customers_ContactAddress'],
                );
                Session::put('customer', $data, 60*60*24);
            }
            return Redirect::route('site.changeInfo_success');
        }
    }

    public function changeInfoSuccess(){
        if(!$this->customer){
            return Rediect::route('site.login');
        }
        $this->layout->content = View::make('site.SiteLayouts.changeInfo_success');
    }

    public function changePass(){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $this->layout->content = View::make('site.SiteLayouts.changePass');
    }

    public function submitChangePass(){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $param['customers_password_old'] = htmlspecialchars(trim(Request::get('customers_password_old','')));
        $param['customers_password'] = htmlspecialchars(trim(Request::get('customers_password','')));
        $param['customers_password_confirm'] = htmlspecialchars(trim(Request::get('customers_password_confirm','')));
        $error = array();
        $customer = Customers::find($this->customer['customers_id']);
        if($customer['customers_password'] !== md5('xxx_'.$param['customers_password_old'])){
            $error['customers_password_old'] = 'Mật khẩu hiện tại không đúng';
        }
        if($param['customers_password'] == '' || strlen($param['customers_password']) < 6 || strlen($param['customers_password']) > 32){
            $error['customers_password'] = 'Mật khẩu phải nằm trong khoảng 6-32 ký tự';
        }

        if($param['customers_password'] !== $param['customers_password_confirm']){
            $error['customers_password_confirm'] = 'Xác nhận mật khẩu không chính xác';
        }
        if($error){
            $this->layout->content = View::make('site.SiteLayouts.changePass')->with('error',$error);
        }else{
            unset($param['customers_password_old']);
            unset($param['customers_password_confirm']);
            $param['customers_password'] = md5('xxx_'.$param['customers_password']);
            Customers::updData($this->customer['customers_id'],$param);
            return Redirect::route('site.changePass_success');
        }
    }

    public function changePassSuccess(){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $this->layout->content = View::make('site.SiteLayouts.changePass_success');
    }

    public function account(){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $this->layout->content = View::make('site.SiteLayouts.account');
    }

    public function orderHistory(){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $aryStatus = array(0 => 'Đã hủy', 1 => 'Đang xử lý', 2 => 'Đã xác nhận, chờ giao', 3 => 'Hoàn thành');
        $orders = Order::getByCustomerId($this->customer['customers_id']);
        $this->layout->content = View::make('site.SiteLayouts.order_history')->with('orders',$orders)->with('aryStatus',$aryStatus);
    }

    public function orderDetail($id){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $order = Order::find($id);
        if(!$order || $order['customers_id'] != $this->customer['customers_id']){
            return Redirect::route('site.home');
        }
        $item = $order->orderitem;
        $aryStatus = array(0 => 'Đã hủy', 1 => 'Đang xử lý', 2 => 'Đã xác nhận, chờ giao', 3 => 'Hoàn thành');
        $this->layout->content = View::make('site.SiteLayouts.order_detail')->with('order',$order)->with('aryStatus',$aryStatus)->with('item',$item);
    }

    public function exportHistory(){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $aryStatus = array(1 => 'Đang xử lý', 2 => 'Đã cho COD giao hàng', 3 => 'Khách đã nhận hàng');
        $exports = Export::getExportForCustomer($this->customer['customers_id']);
        $this->layout->content = View::make('site.SiteLayouts.export_history')->with('exports',$exports)->with('aryStatus',$aryStatus);
    }

    public function exportDetail($id){
        if(!$this->customer){
            return Redirect::route('site.login');
        }
        $export = Export::find($id);
        if(!$export || $export['customers_id'] != $this->customer['customers_id']){
            return Redirect::route('site.home');
        }
        $item = $export->exportproduct;
        foreach($item as $product){
            $product->product;
        }
        $aryStatus = array(1 => 'Đang xử lý', 2 => 'Đã cho COD giao hàng', 3 => 'Khách đã nhận hàng');
        $this->layout->content = View::make('site.SiteLayouts.export_detail')->with('export',$export)->with('aryStatus',$aryStatus)->with('item',$item);
    }

    public function page($id,$name){
        $page = Page::find($id);
        $this->layout->content = View::make('site.SiteLayouts.page')->with('page',$page);
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