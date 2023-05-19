<?php

class User{
    private $conn=null;

    function __construct($username)
    {
        
    }

    public static function registerUser($username,$email,$password,$confirmpass){
        $db=Database::getConnection();
        if($password==$confirmpass){
            if(isset($username) && isset($password) && isset($email)){
                $cmd="INSERT INTO `dashboard`.`user` (`username`, `email`, `password`) VALUES ('$username', '$email', '$password')";
                try{
                    if($db->query($cmd)){
                        return true;
                    }else{
                        return false;
                    }
                }catch(Exception $e){
                    echo "$e";
                }
                
            }
        }else{
            throw new Exception("Password do not match");
        }
    }

    public static function login(){

    }

    public static function logout(){

    }
    
}