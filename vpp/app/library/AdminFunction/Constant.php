<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/15/2016
 * Time: 10:33 AM
 */
class Constant
{
    const dir_banner = 'uploads/banner/';
    const dir_group_category = 'uploads/groupcategory/';
    const dir_product = 'uploads/product/';

    public static $sort = array(
        'new' => array(
            'label' => 'Mới nhất',
            'field' => 'product_id',
            'type' => 'DESC'
        ),
        'name-az' => array(
            'label' => 'Tên(A - Z)',
            'field' => 'product_Name',
            'type' => 'ASC'
        ),
    );

}