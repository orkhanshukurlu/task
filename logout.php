<?php

require_once __DIR__.'/autoload.php';

if (! logged_in()) {
    Redirect::to(base_url() . '/login.php')->with('', '');
}

(new Auth)->logout();
Redirect::to(base_url() . '/login.php')->with('success', 'Uğurla çıxış etdiniz');