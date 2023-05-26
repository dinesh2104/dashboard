<?php

include_once __DIR__."/../trait/SQLGetterSetter.trait.php";

class User{
    use SQLGetterSetter;
    private $conn=null;
    public $id;
    private $username;
    private $table;

    function __construct($username)
    {
        $this->conn=Database::getConnection();
        $this->username=$username;
        $this->table='user';
        $cmd1="SELECT * FROM `user` WHERE `username`='$username' OR email='$username' OR id='$username'";
        
        try{
            $result=$this->conn->query($cmd1);
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $this->id=$row['id'];
                      
            }
        }catch(Exception $e){
            throw new Exception("Username does't exist");
        }
        
    }

    public static function registerUser($username,$email,$password,$confirmpass){

        $username=Util::mysqlFilter($username);
        $email=Util::mysqlFilter($email);
        $password=Util::mysqlFilter($password);
        $confirmpass=Util::mysqlFilter($confirmpass);

        $db=Database::getConnection();
        
        $cmd1="SELECT * FROM `user` WHERE `username`='$username' OR email='$email'";

        try{
            $result=$db->query($cmd1);
            if($result->num_rows>0){
                throw new Exception("User Already exist");
            }
        }catch(Exception $e){
            echo $e;
        }

        if($password==$confirmpass){
            if(isset($username) && isset($password) && isset($email)){
                $password=Util::passwordHash($password);
                $url = 'https://robohash.org/'.hash('md5','$username').'?gravatar=hashed';
                $img_name=hash('md5','$username').'.png';
                $img = $_SERVER['DOCUMENT_ROOT'].'/../workspace/images/'.$img_name;
                file_put_contents($img, file_get_contents($url));
                $cmd="INSERT INTO `user` (`username`, `email`, `password`,`profile_url`) VALUES ('$username', '$email', '$password','$img_name')";
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

    

    public static function login($email,$password){
        $db=Database::getConnection();
        
        $cmd1="SELECT * FROM `user` WHERE `username`='$email' OR email='$email'";

        try{
            $result=$db->query($cmd1);
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                if(password_verify($password,$row['password'])){
                    return $row['username'];
                }
            }
        }catch(Exception $e){
            echo $e;
        }

    }

    public static function logout(){
        $token=Session::get('session_token');

        if(!empty($token) && UserSession::Authorize($token)){
            $usr=new UserSession($token);    
            $usr->removeSession();
            header("Location: /");
            die();
        }
    }
    
}