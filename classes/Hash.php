<?php

class Hash
{
    public static function make($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function check($password, $password_hash)
    {
        return password_verify($password, $password_hash);
    }

    public static function email()
    {
        return md5('email_verification' . uniqid());
    }

    public static function unique()
    {
        return self::make(uniqid());
    }
}