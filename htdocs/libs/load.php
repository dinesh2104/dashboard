<?php
global $__site_config;

function customAutoLoader($class) {
    $file1=__DIR__.'/includes/'.$class.'.class.php';
    $file2=__DIR__.'/app/'.$class.'.class.php';
    if(file_exists($file1)){
        include_once $file1;
    }
    else if(file_exists($file2)){
        include_once $file2;
    }
}

spl_autoload_register('customAutoLoader');

$wapi = new WebAPI();
$wapi->initiateSession();

function get_config($key, $default=null)
{
    global $__site_config;
    $array = json_decode($__site_config, true);
    if (isset($array[$key])) {
        return $array[$key];
    } else {
        return $default;
    }
}