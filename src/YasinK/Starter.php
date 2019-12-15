<?php

namespace YasinK;

    function critical_error($message){
        echo "[ERROR] $message";
    }

    if(PHP_INT_SIZE < 8) critical_error("PHP binary must be x64");
    if(version_compare("7.2.0", PHP_VERSION) > 0) critical_error("Your PHP version must be 7.2.0 or higher version");

    date_default_timezone_set('Europe/Istanbul');
    ini_set('memory_limit', '-1');

    if(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'vendor/autoload.php' !== false and is_file(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'vendor/autoload.php')) require_once(dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'vendor/autoload.php');
    else{
        critical_error("We can't find composer, please run this command on cmd => 'composer install'");
        exit(1);
    }

    new Main;

