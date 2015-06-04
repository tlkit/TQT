<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class Product extends Eloquent
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    public $timestamps = false;
    protected $fillable = array('product_id','product_Code', 'product_Name','product_Category', 'product_CategoryName', 'product_Alias', 'product_OriginID', 'product_UnitID', 'product_PackedWayID', 'product_Price', 'product_Description','product_Image', 'product_Thumbnail', 'product_Quantity', 'product_MinimumQuantity', 'product_IsAvailable','product_CreatorID', 'product_CreatedTime', 'product_ModifiedTime','product_Status');

    public static function getByID($id) {
        return Product::where('product_id', $id)->get();
    }

    public static function getProductsAll() {
        $categories = Product::where('product_id', '>', 0)->get();
        $data = array();
        foreach($categories as $itm) {
            $data[$itm['product_id']] = $itm['providers_Name'];
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Product::where('product_id','>',0);
            if (isset($dataSearch['product_Name']) && $dataSearch['product_Name'] != '') {
                $query->where('product_Name','LIKE', '%' . $dataSearch['product_Name'] . '%');
            }
            if (isset($dataSearch['product_Category']) && $dataSearch['product_Category'] != 0) {
                $query->where('product_Category', '=', $dataSearch['product_Category']);
            }
            $total = $query->count();
            $query->orderBy('product_id', 'desc');
            return ($offset == 0) ? $query->take($limit)->get() : $query->take($limit)->skip($offset)->get();

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
    public static function add($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Product();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->product_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
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
    public static  function updData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Product::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
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
            $dataSave = Product::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function getByName($name){
        $data = Product::where('product_id','>',0)->take(10)->lists('product_Name');
        return $data;
    }

}