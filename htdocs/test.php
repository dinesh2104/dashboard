<?php

include_once "./libs/load.php";

$r=User::registerUser("dinesh","dinesh@example.com","dinesh","dinesh");
print($r);

?>