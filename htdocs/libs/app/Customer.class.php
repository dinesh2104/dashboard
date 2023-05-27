<?php

include_once __DIR__."/../trait/SQLGetterSetter.trait.php";

class Customer{
    use SQLGetterSetter;
    public $id;
    private $conn=null;
    private $table;

    public function __construct($id){
        $this->id=$id;
        $this->conn=Database::getConnection();
        $this->table='customer';

        //$cmd="select * from customer where id='$this->id'";
        //     try{
        //         $res=$this->conn->query($cmd);
        //         print_r("result: adsssssssssssssssssssssssssss");
        //         print_r($res->fetch_assoc());
        //     }catch(Exception $e){
        //         echo $e;
        //     }
    }

    
    public static function getAllCustomer(){
        $db=Database::getConnection();
        $cmd="select * from customer";
        try{
            $result=$db->query($cmd);
            return iterator_to_array($result);
        }
        catch(Exception $e){
            echo "$e";
        }
    }
}