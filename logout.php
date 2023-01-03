<?php

require_once __DIR__.'/autoload.php';

if (! logged_in()) {
    die('Səhifəyə giriş etmək üçün icazəniz yoxdur');
}

(new Auth)->logout();
Redirect::to(base_url() . '/login.php')->with('logout', 'Şifrə boş ola bilməz');