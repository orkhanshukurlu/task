<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function ($file) {
    require_once __DIR__."/config/$file.php";
});

require_once __DIR__.'/functions.php';