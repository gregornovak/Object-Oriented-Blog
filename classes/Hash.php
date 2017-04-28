<?php

class Hash
{
    public static function make($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function reveal($password, $password_hash)
    {
        return password_verify($password, $password_hash);
    }
}