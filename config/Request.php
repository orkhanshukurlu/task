<?php

class Request
{
    public static function checkFields($fields)
    {
        if (! is_array($fields)) {
            die('Field parameter is not array');
        }

        foreach ($fields as $field) {
            if (! isset($_POST[$field])) {
                die("`$field` field does not exists");
            }
        }
    }

    public static function isMethod($method)
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }

    public static function post($field)
    {
        return isset($_POST[$field]) ? $_POST[$field] : null;
    }
}