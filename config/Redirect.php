<?php

class Redirect
{
    private static $sessKey = '_flashdata';

    public static function back()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        return new static;
    }

    public function with($key, $value)
    {
        $_SESSION[self::$sessKey][$key] = $value;
        exit;
    }
}