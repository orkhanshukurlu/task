<?php

class Redirect
{
    public static function back()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}