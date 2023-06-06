<?php

use FTP\Connection;

include_once __DIR__ . "/../trait/SQLGetterSetter.trait.php";

class User
{
    use SQLGetterSetter;
    private $conn = null;
    public $id;
    private $username;
    private $table;

    function __construct($username)
    {
        $this->conn = Database::getConnection();
        $this->username = $username;
        $this->table = 'user';
        $cmd1 = "SELECT * FROM `user` WHERE `username`='$username' OR email='$username' OR id='$username'";

        try {
            $result = $this->conn->query($cmd1);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
            }
        } catch (Exception $e) {
            throw new Exception("Username does't exist");
        }
    }

    public static function registerUser($username, $email, $password, $confirmpass)
    {

        $username = Util::mysqlFilter($username);
        $email = Util::mysqlFilter($email);
        $password = Util::mysqlFilter($password);
        $confirmpass = Util::mysqlFilter($confirmpass);

        $db = Database::getConnection();

        $cmd1 = "SELECT * FROM `user` WHERE `username`='$username' OR email='$email'";

        try {
            $result = $db->query($cmd1);
            if ($result->num_rows > 0) {
                throw new Exception("User Already exist");
            }
        } catch (Exception $e) {
            echo $e;
        }

        if ($password == $confirmpass) {
            if (isset($username) && isset($password) && isset($email)) {
                $password = Util::passwordHash($password);
                $url = 'https://robohash.org/' . hash('md5', '$username') . '?gravatar=hashed';
                $img_name = hash('md5', '$username') . '.png';
                $img = $_SERVER['DOCUMENT_ROOT'] . '/../workspace/images/' . $img_name;
                file_put_contents($img, file_get_contents($url));
                $cmd = "INSERT INTO `user` (`username`, `email`, `password`,`profile_url`) VALUES ('$username', '$email', '$password','$img_name')";
                try {
                    if ($db->query($cmd)) {
                        return true;
                    } else {
                        return false;
                    }
                } catch (Exception $e) {
                    echo "$e";
                }
            }
        } else {
            throw new Exception("Password do not match");
        }
    }



    public static function login($email, $password)
    {
        $db = Database::getConnection();

        $cmd1 = "SELECT * FROM `user` WHERE `username`='$email' OR email='$email'";

        try {
            $result = $db->query($cmd1);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    return $row['username'];
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

    public static function logout()
    {
        $token = Session::get('session_token');

        if (!empty($token) && UserSession::Authorize($token)) {
            $usr = new UserSession($token);
            $usr->removeSession();
            header("Location: /");
            die();
        }
    }

    public static function resetPassword($email)
    {
        $db = Database::getConnection();
        $email = Util::mysqlFilter($email);
        $token = md5(rand(0, 9999999) . time());

        $searchcmd = "select * from user where email='$email'";

        try {
            $result = $db->query($searchcmd);
            if ($result->num_rows <= 0) {
                return "Email Not available";
            }
        } catch (Exception $e) {
            echo $e;
        }

        $cmd = "Select * from resetpassword where email='$email'";
        try {
            $res = $db->query($cmd);
            if ($res->num_rows > 0) {
                $cmd1 = "DELETE FROM `resetpassword` WHERE `email` = '$email';";
                $db->query($cmd1);
            }
            $cmd2 = "INSERT INTO `dinesh2104_dashboard`.`resetpassword` (`email`, `token`) VALUES ('$email', '$token')";
            $db->query($cmd2);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public static function validateResetToken($token)
    {
        $token = Util::mysqlFilter($token);

        $db = Database::getConnection();
        $cmd = "Select * from resetpassword where token='$token'";
        //print_r($cmd);
        try {
            $result = $db->query($cmd);
            //print_r($result->fetch_Assoc());
            if ($result->num_rows != 1) {
                throw new Exception("Invalid Token");
            }
            $res = $result->fetch_Assoc();
            $tokenTime = $res['created_at'];
            if (isset($tokenTime)) {
                $login_time = DateTime::createFromFormat('Y-m-d H:i:s', $tokenTime);
                //print_r($login_time);
                //print_r($login_time);
                print_r(time() - $login_time->getTimestamp());

                if (3600 > time() - $login_time->getTimestamp()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                throw new Exception("Token Expired. Please try again with new Token");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function changePassword($new_pass, $token)
    {
        $db = Database::getConnection();
        $cmd = "Select * from resetpassword where token='$token'";
        try {
            $result = $db->query($cmd);
            if ($result->num_rows > 0) {
                $res = $result->fetch_Assoc();
                print_r($res);
                $email = $res['email'];
                $new_pass = Util::passwordHash($new_pass);
                $cmd1 = "UPDATE `user` SET `password` = '$new_pass' WHERE `email` = '$email'";
                print_r($cmd1);
                $ans = $db->query($cmd1);

                if ($ans) {
                    $cmd2 = "delete from resetpassword where token='$token'";
                    $db->query($cmd2);
                }

                return true;
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}
