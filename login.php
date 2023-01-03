<?php

require_once __DIR__.'/autoload.php';

if (Session::has('user')) {
    die('Authorization Error');
}

if (Request::isMethod('POST')) {
    Request::checkFields(['email', 'password']);

    $email    = Request::post('email');
    $password = Request::post('password');

    $errors = [];

    if (! Validator::required($email)) {
        Flash::put('email', 'Email adresi boş ola bilməz');
        View::render('_login');
    } elseif (! Validator::max($email, 256)) {
        Flash::put('email', 'Email adresi maksimum 256 simvol ola bilər');
        View::render('_login');
    } elseif (! Validator::email($email)) {
        Flash::put('email', 'Email adresi düzgün daxil edilməyib');
        View::render('_login');
    } elseif (! Validator::required($password)) {
        Flash::put('password', 'Şifrə boş ola bilməz');
        View::render('_login');
    } else {
//        print_r((new Auth())->login($email, $password));
    }
} else {
    View::render('_login');
}