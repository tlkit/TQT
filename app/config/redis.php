<?php
/**
 * Created by ThinhLK.
 * User: MT844
 * Date: 7/31/14
 * Time: 9:52 AM
 */
$host ='127.0.0.1';
$install = '6379';
return array(
    'host' => $host,
    'install'=> $install,
    // config server and db
    'default' => array(
        'servers' => array('host' => $host, 'port' =>$install,'db'=>0)),
    'queue'   => array(
        'servers' => array('host' => $host, 'port' => $install,'db'=>1)),
    'log'   => array(
        'servers' => array('host' => $host, 'port' => $install,'db'=>2)),
);

?>