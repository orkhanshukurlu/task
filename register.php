<?php

require_once __DIR__.'/autoload.php';

if (logged_in()) {
    die('Səhifəyə giriş etmək üçün icazəniz yoxdur');
}

if (Request::isMethod('POST')) {
    $username = Request::post('username');
    $email    = Request::post('email');
    $password = Request::post('password');
    $policy   = Request::post('terms_policy');

    if (! Validator::required($username)) {
        Redirect::back()->with('username', 'İstifadəçi adı boş ola bilməz');
    } elseif (! Validator::max($username, 256)) {
        Redirect::back()->with('username', 'İstifadəçi adı maksimum 256 simvol ola bilər');
    } elseif (! Validator::required($email)) {
        Redirect::back()->with('email', 'Email adresi boş ola bilməz');
    } elseif (! Validator::max($email, 256)) {
        Redirect::back()->with('email', 'Email adresi maksimum 256 simvol ola bilər');
    } elseif (! Validator::email($email)) {
        Redirect::back()->with('email', 'Email adresi düzgün daxil edilməyib');
    } elseif (! Validator::required($password)) {
        Redirect::back()->with('password', 'Şifrə boş ola bilməz');
    } elseif (! Validator::checked($policy)) {
        Redirect::back()->with('terms_policy', 'Şərtlər və siyasətlə razılaşmamısınız');
    } else {
        (new Auth())->register($username, $email, $password);
        Redirect::to(base_url() . '/dashboard.php');
    }
} else {
    View::render('_register');
}