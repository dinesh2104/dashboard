<?php

include_once("includes/Database.class.php");
include_once("includes/Session.class.php");
include_once("includes/User.class.php");

global $__site_config;
$__site_config=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../dashboard.json');

// Session::start();

function get_config($key, $default=null)
{
    global $__site_config;
    $array=json_decode($__site_config, true);
    if (isset($array[$key])) {
        return $array[$key];
    } else {
        return $default;
    }
}

function load_template($name)
{
    include $_SERVER['DOCUMENT_ROOT']."/Dashboard/__templates/$name.php";
}
