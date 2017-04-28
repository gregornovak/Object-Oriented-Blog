<?php

class Input
{
    public static function exists()
    {
        return (!empty($_POST) || !empty($_GET)) ? true : false;
    }

    public static function get($field)
    {
        if(isset($_POST[$field])) {
            return self::sanitize($_POST[$field]);
        } else if (isset($_GET[$field])) {
            return self::sanitize($_GET[$field]);
        }
        return '';
    }

    private function sanitize($string)
    {
        if(strlen($string)) {
            return htmlentities($string, ENT_QUOTES, 'UTF-8');
        }
        return false;
    }
}