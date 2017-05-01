<?php

session_start();

$GLOBALS['config'] = [
    'database' => [
        'host'      => '127.0.0.1',
        'username'  => 'root',
        'password'  => '',
        'db_table'  => 'blog',
        'charset'   => 'utf8'
    ],
    'cookie' => [
        'cookie_name'   => 'hash',
        'cookie_expiry' => 86400
    ]
];

spl_autoload_register(function($class){
    require_once 'classes' . DIRECTORY_SEPARATOR . $class . '.php';
});