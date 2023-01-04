<?php

require_once __DIR__.'/autoload.php';

if (! logged_in()) {
    Redirect::to(base_url() . '/login.php');
}

$id = Request::get('id');

if (is_integer((int)$id) && !is_null($id)) {
    if (Request::isMethod('POST')) {
        $username = Request::post('username');
        $email    = Request::post('email');
        $password = Request::post('password');
        $phone    = Request::post('phone');

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
        } elseif (! Validator::max($phone, 256)) {
            Redirect::back()->with('phone', 'Telefon nömrəsi maksimum 256 simvol ola bilər');
        } else {
            $password = empty($password) ? null : $password;
            (new Database)->editUser($id, $username, $email, $password, $phone);
            Redirect::to(base_url() . '/users.php')
                ->with('success', 'İstifadəçi məlumatları uğurla dəyişdirildi');
        }
    } else {
        View::render('_edit_user');
    }
}