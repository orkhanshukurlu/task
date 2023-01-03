<?php

class Session
{
    public static function forget($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}