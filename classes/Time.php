<?php

class Time
{
    private static $_timeZone = 'Europe/Ljubljana';

    /**
     * @return DateTime
     */
    public static function now()
    {
        return new DateTime('now', new DateTimeZone(self::$_timeZone));
    }

    /**
     * @return string
     */
    public static function nowDate()
    {
        $now = new DateTime('now', new DateTimeZone(self::$_timeZone));
        return $now->format('d.m.Y');
    }

    /**
     * @return string
     */
    public static function nowTime()
    {
        $now = new DateTime('now', new DateTimeZone(self::$_timeZone));
        return $now->format('H:i:s');
    }

    /**
     * @return DateTime
     */
    public static function nextWeek()
    {
        return new DateTime('next week', new DateTimeZone(self::$_timeZone));
    }


}