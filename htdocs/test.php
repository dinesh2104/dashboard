<?php

include_once "./libs/load.php";

// $r=User::login("dinesh@example.com","dinesh1");
// print_r($r);

// $usr=UserSession::Authenticate("dinesh","dinesh1");
// print_r($usr."\n");
// print_r(Session::get("session_token"));

// print_r(UserSession::Authorize(Session::get("session_token")));
// $s=new UserSession(Session::get('session_token'));
// print_r($s->id);
// print_r(UserSession::Authorize(Session::get('session_token')));

$url = 'https://robohash.org/'.hash('md5','dinesh').'?gravatar=hashed';

// Image path
print_r(__DIR__.'/../workspace/images/codexworld.png');
$img = __DIR__.'/../workspace/images/'.hash('md5','dinesh').'.png';

// Save image 
file_put_contents($img, file_get_contents($url));

?>