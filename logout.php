<?php
/**
* User logout
* Unset session variables
* Destroy session
**/
require 'sessions.php';
//initiate session
$session = new Session;

if($session->is_logged_in() == true):
$session->logout();
//Success logout message to User
$msgClass = 'alert-success';
$msg = "You've successfully logout, Thank you.";
header("location: index.php");
endif;

?>
