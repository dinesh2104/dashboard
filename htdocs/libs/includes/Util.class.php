<?php

class Util{
    public static function passwordHash($pass){
        $options = [
            'cost' => 12,
        ];
        try{
            $p= password_hash("$pass", PASSWORD_BCRYPT, $options);
            
        }catch(Exception $e){
            echo $e;         
        }
        return $p;
    }

    public static function mysqlFilter($str){
        $db=Database::getConnection();
        return mysqli_real_escape_string($db, $str);
    }
}