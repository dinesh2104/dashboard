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

// print_r(Customer::getAllCustomer());

$cust=new Customer(1);
print_r($cust);
print_r($cust->getFirstName());
$cust->sample();

?>