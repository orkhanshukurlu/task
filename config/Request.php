<?php

class Request
{
    public static function isMethod($method)
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }

    public static function post($field)
    {
        return isset($_POST[$field]) ? $_POST[$field] : null;
    }
}