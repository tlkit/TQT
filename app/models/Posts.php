<?php

class Posts extends \Eloquent {

    /**
     * The database table admin by the model.
     *
     * @var string
     */
    protected $table = 'posts';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'posts_id';

    public $timestamps = false;

    // define which attributes are mass assignable (for security)
    protected $fillable = array('posts_id','posts_title', 'posts_slug', 'posts_desc', 'posts_content', 'category_id', 'attachment', 'posts_image', 'posts_tags', 'posts_website', 'posts_status', 'posts_created_at','posts_updated_at','posts_user_created_at','posts_username_created_at', 'posts_user_updated_at', 'posts_username_updated_at', 'posts_is_run', 'posts_time_run', 'posts_link_website', 'posts_username_approve', 'website_id', 'projects_id', 'seo_keyword_id');

    /**
     * @desc: Filter website.
     * @param array $data
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws PDOException
     */
    public static function getByID($posts_id) {
        return Website::where('posts_id', $posts_id)->get();
    }

    public static function getPostByCategoryID($category_id, $limit=1) {
        $query = Posts::where('posts_status', '=', 1);
        $query->where('category_id', '=', $category_id);
        $query->where('posts_is_run', '=', 0);
        return $query->take($limit)->get();
    }

    public static function searchByCondition($data = array(), $limit =0, $offset=0){
        try{
            if(!empty($data)) {
                //FunctionLib::debug($data);
                $query = Posts::where('posts_id','>',0);
                if (isset($data['posts_title']) && $data['posts_title'] != '') {
                    $query->where('posts_title','LIKE', '%' . $data['posts_title'] . '%');
                }
                if (isset($data['category_id']) && $data['category_id'] > 0) {
                    $query->where('category_id', '=', $data['category_id']);
                }
                if (isset($data['books_id']) && $data['books_id'] > 0) {
                    $query->where('books_id', '=', $data['books_id']);
                }
                if (isset($data['projects_id']) && $data['projects_id'] > 0) {
                    $query->where('projects_id', '=', $data['projects_id']);
                }
                if (isset($data['posts_is_run']) && $data['posts_is_run'] > 0) {
                    if($data['posts_is_run'] == 1) {
                        $query->where('posts_is_run', '=', 1);
                    } elseif($data['posts_is_run'] == 2) {
                        $query->where('posts_is_run', '=', 0);
                    }
                }

                if (isset($data['username']) && $data['username'] != '') {
                    $query->where('posts_username_created_at','LIKE', '%' . $data['username'] . '%');
                }

                $arrTime = FunctionLib::timeFromTo($data['created_at_start'],'');
                $created_at_start = isset($arrTime['time_start']) ? $arrTime['time_start'] : 0;
                if (isset($data['created_at_start']) && $created_at_start > 0) {
                    $query->where('posts_created_at', '>=', $created_at_start);
                }

                $arrTimeEnd = FunctionLib::timeFromTo('',$data['created_at_end'],'');
                $created_at_end = isset($arrTimeEnd['time_end']) ? $arrTimeEnd['time_end'] : 0;
                if (isset($data['created_at_start']) && $created_at_end > 0) {
                    $query->where('posts_created_at', '<=', $created_at_end);
                }

                if (isset($data['posts_status']) && $data['posts_status'] >= 0) {
                    $query->where('posts_status', $data['posts_status']);
                }

                if (isset($data['is_admin']) && $data['is_admin'] > 0) {
                    $query->where('posts_user_created_at', $data['is_admin']);
                }

                $posts = array(
                    'size'=> $query->count(),
                    'data' => $query->orderBy('posts_id', 'desc')->take($limit)->skip($offset)->get()
                );

                return $posts;
            }else {
                $posts=array(
                    'data' => DB::table('posts')->orderBy('posts_id', 'desc')->take($limit)->skip($offset)->get(),
                    'size'=>DB::table('posts')->count()
                );
                return $posts;
            }
        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    /**
     * @desc: Tao website.
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static function add($data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $posts = new Posts();
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $k => $v) {
                    $posts->$k = $v;
                }
            }
            if ($posts->save()) {
                DB::connection()->getPdo()->commit();
                return true;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            var_dump($e->getMessage()); die;
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update du lieu
     * @param $id
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static  function updData($id, $data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $posts = Posts::find($id);
            foreach($data as $k=>$val) {
                $posts->$k = $val;
            }
            if($posts->update()) {
                DB::connection()->getPdo()->commit();
                return true;
            }
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update trang thai website.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function updStatus($id,$status){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $posts = Posts::find($id);
            $posts->posts_status = $status;
            $posts->update();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update trang thai website.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function delData($id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $posts = Posts::find($id);
            $posts->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function approve($id, $user_id=0, $user_name=''){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $posts = Posts::find($id);
            $posts->posts_approve = 1;
            $posts->posts_approve_created_at = time();
            $posts->posts_user_approve = $user_id;
            $posts->posts_username_approve = $user_name;
            $posts->update();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }
}
