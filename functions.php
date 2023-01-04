<?php

if (! function_exists('base_url'))
{
    function base_url()
    {
        return 'http://localhost/task';
    }
}

if (! function_exists('logged_in'))
{
    function logged_in()
    {
        return Session::has('user');
    }
}

if (! function_exists('price'))
{
    function price()
    {
        if ($user = (new Database())->getUserPayment()) {
            return $user->price;
        }

        return 0;
    }
}

if (! function_exists('show_error'))
{
    function show_error($field)
    {
        if (Flash::has($field)) {
            return '<small style="color: red">' . Flash::get($field) . '</small>';
        }
    }
}

if (! function_exists('user'))
{
    function user()
    {
        if (Session::has('user')) {
            return Session::get('user');
        }
    }
}