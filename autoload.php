<?php

spl_autoload_register(function ($file) {
    require_once __DIR__."/config/$file.php";
});

require_once __DIR__.'/functions.php';