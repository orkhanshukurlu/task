<?php

require_once __DIR__.'/autoload.php';

if (logged_in()) {
    die('Səhifəyə giriş etmək üçün icazəniz yoxdur');
}

if (Request::isMethod('POST')) {
    $email = Request::post('email');
    $pass  = Request::post('password');

    if (! Validator::required($email)) {
        Redirect::back()->with('email', 'Email adresi boş ola bilməz');
    } elseif (! Validator::max($email, 256)) {
        Redirect::back()->with('email', 'Email adresi maksimum 256 simvol ola bilər');
    } elseif (! Validator::email($email)) {
        Redirect::back()->with('email', 'Email adresi düzgün daxil edilməyib');
    } elseif (! Validator::required($pass)) {
        Redirect::back()->with('password', 'Şifrə boş ola bilməz');
    } else {
        $hasUser = (new Auth())->login($email, $password);

        if ($hasUser) {
            View::render('_dashboard');
        } else {
            Flash::put('login', 'Daxil edilən email və ya şifrə yanlışdır');
            View::render('_login');
        }
    }
} else {
    View::render('_login');
}