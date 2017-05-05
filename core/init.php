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
        'cookie_expiry' => '86400'
    ],
    'session' => [
        'session_name'  => 'user',
        'token_name'    => 'token'
    ],
    'email' => [
        'type'          => 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8' . "\r\n",
        'from'          => 'From: Info info@gregornovak.si' . "\r\n"
    ]
];

spl_autoload_register(function($class){
    require_once 'classes' . DIRECTORY_SEPARATOR . $class . '.php';
});

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = Database::getInstance()->select('users_sessions', ['hash', '=', $hash]);

    if($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}