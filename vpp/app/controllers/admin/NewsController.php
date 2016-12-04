<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 12/4/2016
 * Time: 10:34 AM
 */
class NewsController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function view(){

        $dataSearch['news_title'] = htmlspecialchars(trim(Request::get('news_title', '')));
        $dataSearch['news_start_time'] = htmlspecialchars(trim(Request::get('news_start_time', '')));
        $dataSearch['news_end_time'] = htmlspecialchars(trim(Request::get('news_end_time', '')));
        $dataSearch['news_created_id'] = (int)Request::get('news_created_id', 0);
        $page_no = Request::get('page_no', 1);
        $limit = 30;
        $total = 0;
        $offset = ($page_no - 1) * $limit;
        $param = $dataSearch;
        $admin = User::getListAllUser();
        $tag = NewsTag::getAllListTag();
        $param['news_start_time'] = ($param['news_start_time'] != '') ? strtotime($param['news_start_time']) : 0;
        $param['news_end_time'] = ($param['news_end_time'] != '') ? strtotime($param['news_end_time'])+86400 : 0;
        $data = News::search($param, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';
        $this->layout->content = View::make('admin.NewsLayouts.view')
            ->with('param',$dataSearch)
            ->with('data',$data)
            ->with('tag',$tag)
            ->with('total', $total)
            ->with('admin', $admin)
            ->with('start', ($page_no - 1) * $limit)
            ->with('paging',$paging);
    }

    public function getAdd($id = 0){
        $param = News::find($id);
        if($param){
            $param['news_start_time'] = ($param['news_start_time'] != '') ? date('d-m-Y',$param['news_start_time']) : '';
            $param['news_end_time'] = ($param['news_end_time'] != '') ? date('d-m-Y',$param['news_end_time']) : '';
            $param['news_tag_ids'] = ($param['news_tag_ids'] != '') ? explode(',', $param['news_tag_ids']) : array();
        }
        $tag = NewsTag::getAllListTag();
        $this->layout->content = View::make('admin.NewsLayouts.add')->with('id',$id)->with('tag',$tag)->with('param',$param);
    }

    public function postAdd($id = 0){
        $param['news_title'] = htmlspecialchars(trim(Request::get('news_title','')));
        $param['news_short_content'] = htmlspecialchars(trim(Request::get('news_short_content','')));
        $param['news_start_time'] = htmlspecialchars(trim(Request::get('news_start_time','')));
        $param['news_end_time'] = htmlspecialchars(trim(Request::get('news_end_time','')));
        $param['news_content'] = htmlspecialchars(Request::get('news_content',''));
        $param['news_tag_ids'] = Request::get('tag', array());
        $error = $file = array();
        if ( Input::hasFile('news_image')) {
            $file = Input::file('news_image');
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
        if($param['news_title'] == ''){
            $error[] = 'Chưa nhập tiêu đề bài viết';
        }
        if($param['news_start_time'] == '' || $param['news_end_time'] == ''){
            $error[] = 'Chưa nhập tiêu đề bài viết';
        }
        if($error){
            $tag = NewsTag::getAllListTag();
            $this->layout->content = View::make('admin.NewsLayouts.add')->with('id',$id)->with('param',$param)->with('tag',$tag)->with('error',$error);
        }else{
            $dataSave['news_title'] = $param['news_title'];
            $dataSave['news_short_content'] = $param['news_short_content'];
            $dataSave['news_content'] = $param['news_content'];
            $dataSave['news_start_time'] = ($param['news_start_time'] != '') ? strtotime($param['news_start_time']) : 0;
            $dataSave['news_end_time'] = ($param['news_end_time'] != '') ? strtotime($param['news_end_time']) + 86399 : 0;
            if($param['news_tag_ids']){
                $dataSave['news_tag_ids'] = implode(',', $param['news_tag_ids']);
            }
            if($id == 0){
                $dataSave['news_created_id'] = $this->user['user_id'];
                $dataSave['news_created_name'] = $this->user['user_full_name'];
                $dataSave['news_created_time'] = time();
            }else{
                $dataSave['news_update_id'] = $this->user['user_id'];
                $dataSave['news_update_name'] = $this->user['user_full_name'];
                $dataSave['news_update_time'] = time();
            }
            if ($file) {
                $name = time() . '-' . $file->getClientOriginalName();
                $file->move(Constant::dir_news, $name);
                $dataSave['news_image'] = $name;
            }
            if(News::add($id,$dataSave)){
                return Redirect::route('admin.news_view');
            }else{
                return Redirect::route('admin.news_add',array('id' => $id));
            }
        }
    }

    public function viewTag(){
        $data = NewsTag::all();
        $this->layout->content = View::make('admin.NewsLayouts.viewTag')->with('data',$data);
    }

    public function getAddTag($id = 0){
        $param = NewsTag::find($id);
        $this->layout->content = View::make('admin.NewsLayouts.addTag')->with('id',$id)->with('param',$param);
    }

    public function postAddTag($id = 0){
        $param['news_tag_name'] = htmlspecialchars(trim(Request::get('news_tag_name', '')));
        $param['news_tag_status'] = (int)Request::get('news_tag_status', 0);
        $error = array();
        if($param['news_tag_name']  == '' ){
            $error[] = 'Chưa nhập chủ đề';
        }
        if($error){
            $this->layout->content = View::make('admin.NewsLayouts.addTag')->with('id',$id)->with('param',$param)->with('error',$error);
        }else{
            $dataSave['news_tag_name'] = $param['news_tag_name'];
            $dataSave['news_tag_status'] = $param['news_tag_status'];
            $dataSave['news_tag_create_id'] = $this->user['user_id'];
            if(NewsTag::add($id,$dataSave)){
                return Redirect::route('admin.news_tag_view');
            }else{
                return Redirect::route('admin.news_tag_add',array('id' => $id));
            }
        }
    }
}