<?php

class Config
{
    /**
     * @param null $path
     * @return string
     */
    public static function get($path = null)
    {
        $exploded   = explode("/", $path);
        $config     = $GLOBALS['config'];

        if(count($exploded) == 2) {
            if(isset($config[$exploded[0]][$exploded[1]])) {
                return $config[$exploded[0]][$exploded[1]];
            } else {
                return 'Parameters not found';
            }
        } else {
            return 'Two parameters allowed.';
        }
    }
}