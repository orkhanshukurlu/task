<?php

require_once __DIR__.'/autoload.php';

if (! logged_in()) {
    Redirect::to(base_url() . '/login.php');
}

if (Request::isMethod('POST')) {
    $price = Request::post('price');

    if (! Validator::required($price)) {
        Redirect::back()->with('price', 'İstifadəçi adı boş ola bilməz');
    } elseif (! Validator::max($price, 256)) {
        Redirect::back()->with('price', 'İstifadəçi adı maksimum 256 simvol ola bilər');
    } else {
        $image = File::upload('photo');
        (new Database)->createPayment(user()->id, Request::post('price'), $image);
        Redirect::back()->with('success', 'Əməliyyat uğurla başa çatdı');
    }
} else {
    View::render('_users');
}