<?php
class Session{
    public static $user=null;
    public static $userSession=null;
    public static $isError=null;

    public static function start(){
        session_start();
    }
    public static function unset(){
        session_unset();
    }
    public static function destroy(){
        session_destroy();
    }
    public static function set($key,$value){
        $_SESSION[$key]=$value;
    }

    public static function delete($key){
        unset($_SESSION[$key]); 
    }

    public static function isset($key){
        return isset($_SESSION[$key]);
    }

    public static function get($key,$default=false){
        if(Session::isset($key)){
            return $_SESSION[$key];
        }else{
            return $default;
        }
    }

    public static function loadTemplate($name){
        $path=$_SERVER['DOCUMENT_ROOT']."/templates/$name.php";
        // print_r($path);
        if(is_file($path)){
            include $path;
        }else{
            Session::loadTemplate("_error");
        }
    }

    public static function renderPage()
    {
        Session::loadTemplate('_master');
    }

    public static function currentScript()
    {
        return basename($_SERVER['SCRIPT_NAME'], '.php');
    }

}