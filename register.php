<?php

require_once __DIR__.'/autoload.php';

if (Session::has('user')) {
    die('Authorization Error');
}

if (Request::isMethod('POST')) {
    Request::checkFields(['username', 'email', 'password']);

    $username = Request::post('username');
    $email    = Request::post('email');
    $password = Request::post('password');
    $policy   = Request::post('terms_policy');

    $errors = [];

    if (! Validator::required($username)) {
        Flash::put('username', 'İstifadəçi adı boş ola bilməz');
        View::render('_register');
    } elseif (! Validator::max($username, 256)) {
        Flash::put('username', 'İstifadəçi adı maksimum 256 simvol ola bilər');
        View::render('_register');
    } elseif (! Validator::required($email)) {
        Flash::put('email', 'Email adresi boş ola bilməz');
        View::render('_register');
    } elseif (! Validator::max($email, 256)) {
        Flash::put('email', 'Email adresi maksimum 256 simvol ola bilər');
        View::render('_register');
    } elseif (! Validator::email($email)) {
        Flash::put('email', 'Email adresi düzgün daxil edilməyib');
        View::render('_register');
    } elseif (! Validator::required($password)) {
        Flash::put('password', 'Şifrə boş ola bilməz');
        View::render('_register');
    } elseif (! Validator::checked($policy)) {
        Flash::put('terms_policy', 'Şərtlər və siyasətlə razılaşın');
        View::render('_register');
    } else {
        print_r((new Auth())->register($username, $email, $password));
    }
} else {
    View::render('_register');
}