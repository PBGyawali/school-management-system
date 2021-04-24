<?php
    ob_start();
    session_start();
    if (isset($_SERVER['HTTP_HOST']))
    {
        $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $base_url .= '://'. $_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    }    
    else
    {
        $base_url = 'http://localhost/cms';
    } 
    date_default_timezone_set("Europe/Berlin");
     // define global constants   
     define("BASE_URL", $base_url ); //defines the base url to start from in the server   
    
     define("SITE_URL", $base_url);
    //define("SITE_URL", "http://localhost/cms");

    define("DB_HOST", "localhost");
    define("DB_NAME", "cms");
    define("DB_USER", "root");
    define("DB_PWD", "root");

    


    define("SITE_TITLE", "College Management System");
    define("SITE_NAME", "College Management System");
    define("UPLOAD_URL", SITE_URL.'/uploads');
    define("ASSETS_URL", SITE_URL."/assets");
    define("CSS_URL", ASSETS_URL."/css");
    define("JS_URL", ASSETS_URL."/js");
    define("IMAGES_URL", ASSETS_URL."/img");
    define("PLUGINS_URL", ASSETS_URL."/plugins");
    
    // /var/www/html/ => absolute path
    
    // http://domain.tld
    define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']."/cms");
    define("ERROR_LOG", BASE_DIR."/error/error.log");
    define('UPLOAD_DIR', BASE_DIR."/uploads");

    

    define('ALLOWED_IMAGES', array("jpg", "jpeg", "png", "gif", "bmp"));
    define("ALLOWED_DOC", array("pdf", "doc", "docx", "ppt", "pptx","xls","zip","rar"));
    define("ALLOWED_FILES",array_merge(ALLOWED_IMAGES,ALLOWED_DOC)); 
    