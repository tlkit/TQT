<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/14/2016
 * Time: 2:44 PM
 */
class SiteManageController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function viewBanner(){
        $data = Banner::all();
        $this->layout->content = View::make('admin.SiteManageLayouts.viewBanner')->with('data',$data);
    }

    public function getAddBanner($id = 0){
        $param = Banner::find($id);
        if($param){
            $param['banner_start_time'] = ($param['banner_start_time'] != '') ? date('d-m-Y',$param['banner_start_time']) : '';
            $param['banner_end_time'] = ($param['banner_end_time'] != '') ? date('d-m-Y',$param['banner_end_time']) : '';
        }
        $this->layout->content = View::make('admin.SiteManageLayouts.addBanner')->with('id',$id)->with('param',$param);
    }

    public function postAddBanner($id = 0){
        $param['banner_name'] = htmlspecialchars(trim(Request::get('banner_name','')));
        $param['banner_url'] = htmlspecialchars(trim(Request::get('banner_url','')));
        $param['banner_start_time'] = htmlspecialchars(trim(Request::get('banner_start_time','')));
        $param['banner_end_time'] = htmlspecialchars(trim(Request::get('banner_end_time','')));
        $error = $file = array();
        if ( Input::hasFile('banner_image')) {
            $file = Input::file('banner_image');
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            if(!in_array($extension,FunctionLib::$array_allow_image) || $size > (2*FunctionLib::$size_image_max)){
                $error[] = 'Ảnh  không hợp lệ';
            }
        }else{
            if($id == 0){
                $error[] = 'Chưa nhập file ảnh';
            }
        }
        if($error){
            $this->layout->content = View::make('admin.SiteManageLayouts.addBanner')->with('id',$id)->with('param',$param)->with('error',$error);
        }else{
            $dataSave['banner_name'] = $param['banner_name'];
            $dataSave['banner_url'] = $param['banner_url'];
            $dataSave['banner_start_time'] = ($param['banner_start_time'] != '') ? strtotime($param['banner_start_time']) : 0;
            $dataSave['banner_end_time'] = ($param['banner_end_time'] != '') ? strtotime($param['banner_end_time']) : 0;
            if ($file) {
                $name = time() . '-' . $file->getClientOriginalName();
                $file->move(Constant::dir_banner, $name);
                $dataSave['banner_image'] = $name;
            }
            if(Banner::add($id,$dataSave)){
                return Redirect::route('admin.mngSite_banner_view');
            }else{
                return Redirect::route('admin.mngSite_banner_add',array('id' => $id));
            }
        }
    }

    public function viewGroupCategory(){
        $data = GroupCategory::all();
        $category = Categories::lists('categories_Name','categories_id');
        $this->layout->content = View::make('admin.SiteManageLayouts.viewGroupCategory')->with('category',$category)->with('data',$data);
    }

    public function getAddGroupCategory($id = 0){
        $param = GroupCategory::find($id);
        $category = Categories::lists('categories_Name','categories_id');
        $this->layout->content = View::make('admin.SiteManageLayouts.addGroupCategory')->with('category',$category)->with('id',$id)->with('param',$param);
    }

    public function postAddGroupCategory($id = 0){
        $param['group_category_name'] = htmlspecialchars(trim(Request::get('group_category_name','')));
        $param['group_category_status'] = (int)Request::get('group_category_status',0);
        $param['category_status'] = (int)Request::get('category_status',0);
        $param['category_list_id'] = Request::get('category_list_id',array());
        $param['category_list_id'] = ($param['category_list_id']) ? implode(',',$param['category_list_id']) : '';
        $error = $image = $icon = $icon_hover = array();
        if ( Input::hasFile('group_category_image')) {
            $image = Input::file('group_category_image');
            $extension_image = $image->getClientOriginalExtension();
            $size_image = $image->getSize();
            if(!in_array($extension_image,FunctionLib::$array_allow_image) || $size_image > FunctionLib::$size_image_max){
                $error[] = 'Ảnh  không hợp lệ';
            }
        }else{
            if($id == 0){
                $error[] = 'Chưa nhập file ảnh';
            }
        }
        if ( Input::hasFile('group_category_icon')) {
            $icon = Input::file('group_category_icon');
            $extension_icon = $icon->getClientOriginalExtension();
            $size_icon = $icon->getSize();
            if(!in_array($extension_icon,FunctionLib::$array_allow_image) || $size_icon > FunctionLib::$size_image_max){
                $error[] = 'Icon không hợp lệ';
            }
        }else{
            if($id == 0){
                $error[] = 'Chưa nhập file icon';
            }
        }
        if ( Input::hasFile('group_category_icon_hover')) {
            $icon_hover = Input::file('group_category_icon_hover');
            $extension_icon_hover = $icon_hover->getClientOriginalExtension();
            $size_icon_hover = $icon_hover->getSize();
            if(!in_array($extension_icon_hover,FunctionLib::$array_allow_image) || $size_icon_hover > FunctionLib::$size_image_max){
                $error[] = 'Icon hover  không hợp lệ';
            }
        }else{
            if($id == 0){
                $error[] = 'Chưa nhập file icon hover';
            }
        }
        if($error){
            if($id > 0){
                $gc = GroupCategory::find($id);
                $param['group_category_image'] = $gc['group_category_image'];
                $param['group_category_icon'] = $gc['group_category_icon'];
                $param['group_category_icon_hover'] = $gc['group_category_icon_hover'];
            }
            $category = Categories::lists('categories_Name','categories_id');
            $this->layout->content = View::make('admin.SiteManageLayouts.addGroupCategory')->with('error',$error)->with('category',$category)->with('id',$id)->with('param',$param);;
        }else{
            $dataSave['group_category_name'] = $param['group_category_name'];
            $dataSave['group_category_status'] = $param['group_category_status'];
            $dataSave['category_status'] = $param['category_status'];
            $dataSave['category_list_id'] = $param['category_list_id'];
            if ($image) {
                $name_image = time() . '-' . $image->getClientOriginalName();
                $image->move(Constant::dir_group_category, $name_image);
                $dataSave['group_category_image'] = $name_image;
            }
            if ($icon) {
                $name_icon = time() . '-' . $icon->getClientOriginalName();
                $icon->move(Constant::dir_group_category, $name_icon);
                $dataSave['group_category_icon'] = $name_icon;
            }
            if ($icon_hover) {
                $name_icon_hover = time() . '-' . $icon_hover->getClientOriginalName();
                $icon_hover->move(Constant::dir_group_category, $name_icon_hover);
                $dataSave['group_category_icon_hover'] = $name_icon_hover;
            }
            if(GroupCategory::add($id,$dataSave)){
                return Redirect::route('admin.mngSite_group_category_view');
            }else{
                return Redirect::route('admin.mngSite_group_category_add',array('id' => $id));
            }
        }
    }

    public function viewPage(){
        $data = Page::all();
        $this->layout->content = View::make('admin.SiteManageLayouts.viewPage')->with('data',$data);
    }

    public function getAddPage($id = 0)
    {
        $param = Page::find($id);
        $this->layout->content = View::make('admin.SiteManageLayouts.addPage')->with('id',$id)->with('param',$param);
    }

    public function postAddPage($id = 0){
        $param['page_content'] = htmlspecialchars(Request::get('page_content',''));
        $param['page_name'] = htmlspecialchars(trim(Request::get('page_name','')));
        $param['page_status'] = (int)Request::get('page_status',0);
        $param['page_is_head'] = (int)Request::get('page_is_head',0);
        $error = array();
        if($error){
            $this->layout->content = View::make('admin.SiteManageLayouts.addBanner')->with('id',$id)->with('param',$param)->with('error',$error);
        }else{
            if(Page::add($id,$param)){
                return Redirect::route('admin.mngSite_page_view');
            }else{
                return Redirect::route('admin.mngSite_page_add',array('id' => $id));
            }
        }
    }

    public function getProductNew(){
        $group = GroupCategory::lists('group_category_name','group_category_id');
        $productSort = ProductSort::getProductShortByTypeAndObject(1,0);
        $str_id = isset($productSort->product_sort_product_ids) ? $productSort->product_sort_product_ids : '';
        $product = array();
        if($str_id != ''){
            $ids = explode(',',$str_id);
            if($ids){
                $arySort = array_flip(array_values($ids));
                $product = Product::getProductByIds($ids)->toArray();
                if(sizeof($product) > 0){
                    foreach($product as $key => $value){
                        $value['special_sort'] = $arySort[$value['product_id']];
                        $product[$key] = $value;
                    }
                    usort($product, 'sortSpecial');
                }
            }
        }
        $this->layout->content = View::make('admin.SiteManageLayouts.getProductNew')->with('group',$group)->with('products',$product);
    }

    public function getProductNewById(){
        $id = (int)Request::get('product_id', 0);
        $product = Product::find($id);
        if (isset($product->product_show_site) && $product->product_show_site == 1) {
            $data['success'] = 1;
            $data['html'] = View::make('admin.SiteManageLayouts.box_product_new')->with('product',$product)->render();
            return Response::json($data);
        } else {
            $data['success'] = 0;
            $data['mess'] = 'Không tìm thấy sản phẩm';
            return Response::json($data);
        }
    }

    public function getProductNewByObject()
    {
        $object_id = (int)Request::get('object_id', 0);
        $productSort = ProductSort::getProductShortByTypeAndObject(1,$object_id);
        $str_id = isset($productSort->product_sort_product_ids) ? $productSort->product_sort_product_ids : '';
        $product = array();
        if($str_id != ''){
            $ids = explode(',',$str_id);
            if($ids){
                $arySort = array_flip(array_values($ids));
                $product = Product::getProductByIds($ids)->toArray();
                if(sizeof($product) > 0){
                    foreach($product as $key => $value){
                        $value['special_sort'] = $arySort[$value['product_id']];
                        $product[$key] = $value;
                    }
                    usort($product, 'sortSpecial');
                }
            }
        }
        $data['success'] = 1;
        $data['html'] = View::make('admin.SiteManageLayouts.list_product_new')->with('products',$product)->render();
        return Response::json($data);
    }

    public function addProductNew(){
        $data['success'] = 0;
        $ids = htmlspecialchars(trim(Request::get('ids', '')));
        $type = (int)Request::get('type', 0);
        $object_id = (int)Request::get('object_id', 0);
        if ($ids == '') {
            $data['mess'] = 'Chưa chọn sản phẩm cần sắp xếp';
            return Response::json($data);
        }
        if($type == 0){
            $data['mess'] = 'Chưa chọn box cần sắp xếp';
            return Response::json($data);
        }
        $ids = str_replace(" ","",$ids);
        $productSort = ProductSort::getProductShortByTypeAndObject($type, $object_id);
        $sort_id = isset($productSort->product_sort_id) ? $productSort->product_sort_id : 0;
        $dataU['product_sort_object_id'] = $object_id;
        $dataU['product_sort_product_ids'] = $ids;
        $dataU['product_sort_type'] = $type;
        if($sort_id == 0){
            $dataU['product_sort_create_id'] = $this->user['user_id'];
            $dataU['product_sort_create_time'] = time();
        }else{
            $dataU['product_sort_update_id'] = $this->user['user_id'];
            $dataU['product_sort_update_time'] = time();
        }
        ProductSort::updData($sort_id,$dataU);
        $data['success'] = 1;
        $data['link'] = URL::route('admin.mngSite_getProductNew');
        return Response::json($data);
    }

    public function getProductHot(){
        $group = GroupCategory::lists('group_category_name','group_category_id');
        $productSort = ProductSort::getProductShortByTypeAndObject(2,0);
        $str_id = isset($productSort->product_sort_product_ids) ? $productSort->product_sort_product_ids : '';
        $product = array();
        if($str_id != ''){
            $ids = explode(',',$str_id);
            if($ids){
                $arySort = array_flip(array_values($ids));
                $product = Product::getProductByIds($ids)->toArray();
                if(sizeof($product) > 0){
                    foreach($product as $key => $value){
                        $value['special_sort'] = $arySort[$value['product_id']];
                        $product[$key] = $value;
                    }
                    usort($product, 'sortSpecial');
                }
            }
        }
        $this->layout->content = View::make('admin.SiteManageLayouts.getProductHot')->with('group',$group)->with('products',$product);
    }

    public function getProductHotById(){
        $id = (int)Request::get('product_id', 0);
        $product = Product::find($id);
        if (isset($product->product_show_site) && $product->product_show_site == 1) {
            $data['success'] = 1;
            $data['html'] = View::make('admin.SiteManageLayouts.box_product_hot')->with('product',$product)->render();
            return Response::json($data);
        } else {
            $data['success'] = 0;
            $data['mess'] = 'Không tìm thấy sản phẩm';
            return Response::json($data);
        }
    }

    public function getProductHotByObject()
    {
        $object_id = (int)Request::get('object_id', 0);
        $productSort = ProductSort::getProductShortByTypeAndObject(2,$object_id);
        $str_id = isset($productSort->product_sort_product_ids) ? $productSort->product_sort_product_ids : '';
        $product = array();
        if($str_id != ''){
            $ids = explode(',',$str_id);
            if($ids){
                $arySort = array_flip(array_values($ids));
                $product = Product::getProductByIds($ids)->toArray();
                if(sizeof($product) > 0){
                    foreach($product as $key => $value){
                        $value['special_sort'] = $arySort[$value['product_id']];
                        $product[$key] = $value;
                    }
                    usort($product, 'sortSpecial');
                }
            }
        }
        $data['success'] = 1;
        $data['html'] = View::make('admin.SiteManageLayouts.list_product_hot')->with('products',$product)->render();
        return Response::json($data);
    }

    public function addProductHot(){
        $data['success'] = 0;
        $ids = htmlspecialchars(trim(Request::get('ids', '')));
        $type = (int)Request::get('type', 0);
        $object_id = (int)Request::get('object_id', 0);
        if ($ids == '') {
            $data['mess'] = 'Chưa chọn sản phẩm cần sắp xếp';
            return Response::json($data);
        }
        if($type == 0){
            $data['mess'] = 'Chưa chọn box cần sắp xếp';
            return Response::json($data);
        }
        $ids = str_replace(" ","",$ids);
        $productSort = ProductSort::getProductShortByTypeAndObject($type, $object_id);
        $sort_id = isset($productSort->product_sort_id) ? $productSort->product_sort_id : 0;
        $dataU['product_sort_object_id'] = $object_id;
        $dataU['product_sort_product_ids'] = $ids;
        $dataU['product_sort_type'] = $type;
        if($sort_id == 0){
            $dataU['product_sort_create_id'] = $this->user['user_id'];
            $dataU['product_sort_create_time'] = time();
        }else{
            $dataU['product_sort_update_id'] = $this->user['user_id'];
            $dataU['product_sort_update_time'] = time();
        }
        ProductSort::updData($sort_id,$dataU);
        $data['success'] = 1;
        $data['link'] = URL::route('admin.mngSite_getProductHot');
        return Response::json($data);
    }

    public function viewTag(){
        $data = ProductSort::all();
        $this->layout->content = View::make('admin.SiteManageLayouts.viewTag')->with('data',$data);
    }

    public function getAddTag($id = 0){
        $param = ProductSort::find($id);
        if($id > 0 && $param['product_sort_type'] != 3){
            return Redirect::route('admin.dashboard');
        }
        $this->layout->content = View::make('admin.SiteManageLayouts.addTag')->with('id',$id)->with('param',$param);
    }

    public function postAddTag($id = 0){
        $param['product_sort_label'] = htmlspecialchars(trim(Request::get('product_sort_label','')));
        $param['product_sort_product_ids'] = htmlspecialchars(trim(Request::get('product_sort_product_ids','')));
        $param['product_sort_status'] = (int)Request::get('product_sort_status',0);
        $error = $file = array();
        if ( Input::hasFile('product_sort_banner')) {
            $file = Input::file('product_sort_banner');
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            if(!in_array($extension,FunctionLib::$array_allow_image) || $size > (2*FunctionLib::$size_image_max)){
                $error[] = 'Ảnh  không hợp lệ';
            }
        }else{
            if($id == 0){
                $error[] = 'Chưa nhập file ảnh';
            }
        }
        if($error){
            $this->layout->content = View::make('admin.SiteManageLayouts.addTag')->with('id',$id)->with('param',$param)->with('error',$error);
        }else{
            $dataSave['product_sort_label'] = $param['product_sort_label'];
            $dataSave['product_sort_product_ids'] = $param['product_sort_product_ids'];
            $dataSave['product_sort_status'] = $param['product_sort_status'];
            if ($file) {
                $name = time() . '-' . $file->getClientOriginalName();
                $file->move(Constant::dir_banner, $name);
                $dataSave['product_sort_banner'] = $name;
            }
            if($id == 0){
                $dataSave['product_sort_create_id'] = $this->user['user_id'];
                $dataSave['product_sort_create_time'] = time();
            }else{
                $dataSave['product_sort_update_id'] = $this->user['user_id'];
                $dataSave['product_sort_update_time'] = time();
            }
            $dataSave['product_sort_type'] = 3;
            if(ProductSort::updData($id,$dataSave)){
                return Redirect::route('admin.mngSite_tag_view');
            }else{
                return Redirect::route('admin.mngSite_tag_add',array('id' => $id));
            }
        }
    }
}
function sortSpecial($a, $b) {
    return $a["special_sort"] - $b["special_sort"];
}