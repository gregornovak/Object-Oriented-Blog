<?php

class Client
{
    private static  $_ip_address,
                    $_time,
                    $_os;

    public static function ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            self::$_ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            self::$_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
            self::$_ip_address = $_SERVER['HTTP_X_FORWARDED'];
        } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            self::$_ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_FORWARDED'])) {
            self::$_ip_address = $_SERVER['HTTP_FORWARDED'];
        } else if(isset($_SERVER['REMOTE_ADDR'])) {
            self::$_ip_address = $_SERVER['REMOTE_ADDR'];
        } else {
            self::$_ip_address = '0.0.0.0';
        }
        return self::$_ip_address;
    }

    public static function requestTime()
    {
        self::$_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        return self::$_time;
    }

    public static function os()
    {
        $reg = '/\(.*?\)/';
        preg_match($reg, $_SERVER['HTTP_USER_AGENT'], self::$_os);
        return self::$_os[0];
    }
}