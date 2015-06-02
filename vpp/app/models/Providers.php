<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class Providers extends Eloquent
{
    protected $table = 'providers';
    protected $primaryKey = 'providers_id';
    public $timestamps = false;
    protected $fillable = array('providers_id','providers_Code', 'providers_Name', 'providers_Address', 'providers_StoreAddress', 'providers_Phone', 'providers_Website', 'providers_Description', 'providers_TotalImport','providers_TotalExport');

    public static function getByID($id) {
        return Providers::where('providers_id', $id)->get();
    }

    public static function getProviderssAll() {
        $categories = Providers::where('providers_id', '>', 0)->where('book_status', '=', 1)->get();
        $data = array();
        foreach($categories as $itm) {
            $data[$itm['providers_id']] = $itm['customers_FirstName'];
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Providers::where('providers_id','>',0);
            if (isset($dataSearch['customers_FirstName']) && $dataSearch['customers_FirstName'] != '') {
                $query->where('customers_FirstName','LIKE', '%' . $dataSearch['customers_FirstName'] . '%');
            }
            if (isset($dataSearch['customers_Type']) && $dataSearch['customers_Type'] != -1) {
                $query->where('customers_Type', $dataSearch['customers_Type']);
            }
            $total = $query->count();
            $query->orderBy('providers_id', 'desc');
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
            $data = new Providers();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->providers_id;
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
            $dataSave = Providers::find($id);
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
            $dataSave = Providers::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

}