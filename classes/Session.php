<?php

class Session
{
    /**
     * Checks whether session with this parameter exists
     *
     * @param $name
     *
     * @return bool
     */
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Gets the session or returns false if it doesn't exist
     *
     * @param $name
     *
     * @return bool | $_SESSION
     */
    public static function get($name)
    {
        return (isset($_SESSION[$name])) ? $_SESSION[$name] : false;
    }

    /**
     * Makes the session with the name and value specified in the parameters
     *
     * @param $name
     *
     * @param $value
     *
     * @return bool
     */
    public static function make($name, $value)
    {
        return (isset($name) && isset($value)) ? $_SESSION[$name] = $value : false;
    }

    /**
     * Deletes the specified session if it exists
     *
     * @param $name
     */
    public static function delete($name)
    {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Sends a message that shows only once to the user
     *
     * @param $name
     *
     * @param string $msg
     *
     * @return bool
     */
    public static function flash($name, $msg = '')
    {
        if(self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::make($name, $msg);
        }
    }


}