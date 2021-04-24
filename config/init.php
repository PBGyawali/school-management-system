<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once $_SERVER['DOCUMENT_ROOT']."/cms/config/config.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/cms/config/functions.php";

    spl_autoload_register(function($class_name){    
        $path=  $_SERVER['DOCUMENT_ROOT']."/cms/class/";   
        if (file_exists($path.$class_name.".php"))
        require_once $path.$class_name.".php";
    });