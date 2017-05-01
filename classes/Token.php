<?php

class Token
{
    /**
     * Makes a unique token and saves it to the session
     *
     * @return bool
     */
    public static function make()
    {
        return Session::make(Config::get('session/token_name'), md5(uniqid()));
    }

    /**
     * Checks whether the token exists and if tokens from the form and session are the same
     *
     * @param $token_value
     *
     * @return bool
     */
    public static function exists($token_value)
    {
        $token_name = Config::get('session/token_name');
        if(Session::exists($token_name) && $token_value === Session::get($token_name)) {
            Session::delete($token_name);
            return true;
        }

        return false;

    }
}