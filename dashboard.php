<?php

require_once __DIR__.'/autoload.php';

if (Session::has('user')) {
    die('Authorization Error');
}

View::render('_dashboard');