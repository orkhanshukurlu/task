<?php

class View
{
    public static function render($view, $data = [])
    {
        if (! file_exists($file = __DIR__."/../views/$view.php")) {
            die("$file does not exists");
        }

        extract($data);
        require_once $file;
        exit;
    }
}