<?php

require_once __DIR__.'/autoload.php';

if (logged_in()) {
    Redirect::to(base_url() . '/dashboard.php');
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
        if ((new Auth())->login($email, $pass)) {
            Redirect::to(base_url() . '/dashboard.php')->with('success', 'Uğurla daxil oldunuz');
        } else {
            Redirect::back()->with('error', 'Daxil edilən email və ya şifrə yanlışdır');
        }
    }
} else {
    View::render('_login');
}