<?php

session_start();

$GLOBALS['config'] = [
    'database' => [
        'host'          => '127.0.0.1',
        'username'      => 'root',
        'password'      => 'geslo123',
        'db_table'      => 'blog',
        'charset'       => 'utf8'
    ],
    'cookie' => [
        'cookie_name'   => 'hash',
        'cookie_expiry' => 86400
    ],
    'session' => [
        'session_name'  => 'session',
        'token_name'    => 'token'
    ],
    'email' => [
        'type'          => 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8' . "\r\n",
        'from'          => 'From: Info info@gregornovak.si' . "\r\n" // TO DO spremeni email
    ]
];

spl_autoload_register(function($class){
    require_once 'classes' . DIRECTORY_SEPARATOR . $class . '.php';
});