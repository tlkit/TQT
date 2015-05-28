<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 6/21/14
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */
class GroupUserPermission extends Eloquent
{

    protected $table = 'group_user_permission';

    public $timestamps = false;

    protected $primaryKey = 'group_user_permission_id';

    protected $fillable = array('group_user_id','permission_id');


    /**
     * Get list permission by group id
     *
     * @param $aryGroupId
     * @return mixed
     */
    public static function getListPermissionByGroupId($aryGroupId) {

        $tbl_permission = with(new Permission())->getTable();
        $tbl_group_user_permission = with(new GroupUserPermission())->getTable();
        $query = DB::table($tbl_group_user_permission);
        $query->join($tbl_permission, function ($join) use ($tbl_permission,$tbl_group_user_permission) {

            $join->on($tbl_group_user_permission . '.permission_id', '=', $tbl_permission . '.permission_id');
        });
        $query->where($tbl_permission.'.permission_status', '=', 1);
        $query->whereIn($tbl_group_user_permission.'.group_user_id', $aryGroupId);
        $query->select($tbl_group_user_permission.'.group_user_id', $tbl_permission. '.*');
        return $query->get();
    }

    /**
     * Get list Group by permission
     *
     * @param $aryPermissionId
     * @return mixed
     */
    public function getListGroupByPermissionId($aryPermissionId) {
        $groupUser = new GroupUser();
        $table = $groupUser->getTable();
        $query = DB::table($this->table);
        $query->join($table, function ($join) {
            $groupUser1 = new GroupUser();
            $table1 = $groupUser1->getTable();
            $join->on($this->table . '.group_user_id', '=', $table1 . '.group_user_id');
        });
        $query->where($table.'.group_user_status', '=', 1);
        $query->whereIn($this->table.'.permission_id', $aryPermissionId);
        $query->select($this->table.'.permission_id', $table. '.*');
        return $query->get();
    }
}