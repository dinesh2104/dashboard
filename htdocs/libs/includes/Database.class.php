<?php

class Database{
    public static $conn=null;

    public static function getConnection(){

        if(Database::$conn==null){
            $servername = get_config("db_server");
            $username = get_config("db_username");
            $password = get_config("db_password");
            $dbname=get_config("db_name");

            // Create connection
            $dbconn = new mysqli($servername, $username, $password,$dbname);
            
            // Check connection
            if ($dbconn->connect_error) {
                die("Connection failed: " . $dbconn->connect_error);
            }
            else{
                Database::$conn=$dbconn;
                return Database::$conn;
            }
        }else{
            return Database::$conn;
        }
        
    }
}