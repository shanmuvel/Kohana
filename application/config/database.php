<?php defined('SYSPATH') OR die('No direct access allowed.');


return array
(
    'default' => array
    (
        'type'       => 'mysqli',
        'connection' => array(
            'hostname'   => 'localhost',
            'username'   => 'root',
            'password'   => 'sa',
            'persistent' => FALSE,
            'database'   => 'cfm',
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
    ),
    'remote' => array(
        'type'       => 'MySQL',
        'connection' => array(
            'hostname'   => '55.55.55.55',
            'username'   => 'remote_user',
            'password'   => 'mypassword',
            'persistent' => FALSE,
            'database'   => 'my_remote_db_name',
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
    ),
);