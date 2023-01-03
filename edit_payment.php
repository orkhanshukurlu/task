<?php

require_once __DIR__.'/autoload.php';

if (! logged_in()) {
    Redirect::to(base_url() . '/login.php');
}

$id     = Request::get('id');
$status = Request::get('status');

if (is_integer((int)$id) && in_array($status, [0, 1])) {
    (new Database)->editPayment($id, $status);
    Redirect::back()->with('success', 'Status uğurla dəyişdirildi');
}