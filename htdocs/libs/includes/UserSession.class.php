<?php

include_once __DIR__."/../trait/SQLGetterSetter.trait.php";

class UserSession{
    use SQLGetterSetter;
    private $conn;
    private $table;
    public $id;
    private $uid;
    private $login_time;
    private $token;
    function __construct($token){
        $this->conn=Database::getConnection();
        $this->token=$token;
        $this->table='session';
        $cmd="Select * from session where token='$this->token'";
        try{
            $res=$this->conn->query($cmd);
            if($res->num_rows>0){
                $row=$res->fetch_assoc();
                $this->id=$row['id'];
                $this->uid=$row['uid'];
                $this->login_time=$row['login_time'];
            }
        }catch(Exception $e){
            echo $e;
        }
    }
    public static function Authenticate($user,$pass){
        $user=Util::mysqlFilter($user);
        $pass=Util::mysqlFilter($pass);
        $username=User::login($user,$pass);
        
        if($username){
            $user=new User($username);
            $conn=Database::getConnection();
            $ip = $_SERVER['REMOTE_ADDR'];
            $agent = $_SERVER['HTTP_USER_AGENT'];
            $token = md5(rand(0, 9999999) . $ip . $agent . time());
            
            $cmd="Select * from session where uid='$user->id'";
            $res=$conn->query($cmd);
            if($res->num_rows>0){
                $sql = "DELETE FROM session WHERE uid='$user->id'";
                try{
                    $conn->query($sql);
                } catch(Exception $e) {
                    throw new Exception("Error while deleting id");
                }
            }
            $sql = "INSERT INTO `session` (`uid`, `token`, `login_time`, `ip`, `user_agent`, `active`)
            VALUES ('$user->id', '$token', now(), '$ip', '$agent', '1')";
            try{
                $conn->query($sql);
                Session::set('session_token', $token);
                return true;
            } catch(Exception $e) {
                throw new Exception("Error in adding token in session table");
            }
            
        } else {
            return false;
        }
        
    }

    public static function Authorize($token){
        try {
            $session = new UserSession($token);
            if($session->id!=NULL){
            if (isset($_SERVER['REMOTE_ADDR']) and isset($_SERVER["HTTP_USER_AGENT"])) {
                if ($session->isValid($session->getLoginTime()) and $session->getActive()==1) {
                    if ($_SERVER['REMOTE_ADDR'] == $session->getIp()) {
                        if ($_SERVER['HTTP_USER_AGENT'] == $session->getUserAgent()) {    
                            Session::$user = $session->getUser();
                            return true;
                        } else {
                            throw new Exception("User agent does't match");
                        }
                    } else {
                        throw new Exception("IP does't match");
                    }
                } else {
                    $session->removeSession();
                    throw new Exception("Invalid session");
                }
            } else {
                throw new Exception("IP and User_agent is null");
            }
        }
        else{
            return false;
        }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    
    }

    public function isValid($login_time)
    {
        //print_r($login_time);

        if (isset($login_time)) {
            $login_time = DateTime::createFromFormat('Y-m-d H:i:s', $login_time);
            //print_r($login_time);
            if (3600 > time() - $login_time->getTimestamp()) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new Exception("login time is null");
        }
    }

    public function getUser()
    {
        return new User($this->uid);
    }

    public function removeSession()
    {
        print_r($this->id);
        if (isset($this->id)) {
            if (!$this->conn) {
                $this->conn = Database::getConnection();
            }
            $sql = "DELETE FROM `session` WHERE `id` = $this->id;";
            if ($this->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deactivate()
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "UPDATE `session` SET `active` = 0 WHERE `id`=$this->id";

        return $this->conn->query($sql) ? true : false;
    }

}