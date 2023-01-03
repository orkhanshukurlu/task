<?php

class Flash
{
    private static $sessKey = '_flashdata';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function get($key)
    {
        if (self::has($key)) {
            $data = $_SESSION[self::$sessKey][$key];
            unset($_SESSION[self::$sessKey][$key]);
            return $data;
        }
    }

    public static function has($key)
    {
        return isset($_SESSION[self::$sessKey][$key]);
    }

    public static function put($key, $value)
    {
        $_SESSION[self::$sessKey][$key] = $value;
    }
}