<?php
/**
 * Created by PhpStorm.
 * User: Vietlh89
 * Date: 6/19/14
 * Time: 4:20 PM
 */
if(Session::has('user')){
    $user = Session::get('user');
}
else{
    $user['admin_fullname'] = 'no name';
    $user['admin_id'] = 0;
}

return array(
    'USER' => $user
);