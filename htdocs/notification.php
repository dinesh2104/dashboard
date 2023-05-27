<?php

include_once "./libs/load.php";

if(!Session::isAuthenticated()){
    header("Location: /login.php");
    die();
}

Session::renderPage();