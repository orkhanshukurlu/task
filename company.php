<?php

require_once __DIR__.'/autoload.php';

if (! logged_in()) {
    Redirect::to(base_url() . '/login.php');
}

if (Request::isMethod('POST')) {
    $name = Request::post('name');

    if (! Validator::required($name)) {
        Redirect::back()->with('name', 'Şirkət adı boş ola bilməz');
    } elseif (! Validator::max($name, 256)) {
        Redirect::back()->with('name', 'Şirkət adı maksimum 256 simvol ola bilər');
    } else {
        (new Database)->createCompany(Request::post('name'));
        Redirect::to(base_url() . '/dashboard.php')->with('success', 'Şirkət uğurla əlavə olundu');
    }
} else {
    View::render('_company');
}