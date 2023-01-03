<?php

class Validator
{
    public static function checked($data)
    {
        return $data === 'on';
    }

    public static function email($data)
    {
        return filter_var($data, FILTER_VALIDATE_EMAIL);
    }

    public static function max($data, $length)
    {
        return strlen($data) <= $length;
    }

    public static function required($data)
    {
        return isset($data) && !empty($data);
    }
}