<?php
/* Verify user email from confirmation email link sent to users email */
require 'database.php';
// Validate email and harsh results
if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['harsh']) && !empty($_GET['harsh'])){
    // Initiate database
    $db = new Database;
    //Process values
    $email = $db->escape_value(trim($_GET['email']));
    $harsh = $db->escape_value(trim($_GET['harsh']));
    /**
    *Query matching email from database
    *Query identical harsh from database
    *Result must have active status = 0
    **/

    $sql = "SELECT * FROM users WHERE email='$email' AND hash='$hash' AND active='0'";
    //Query database
    $result_set = $db->query($sql);
    if($db->num_rows($result_set) == 0){
        //Account exists and activated or expired url
        $msgClass = "alert-success";
        $msg = "Your account is active! or URL link is expired";
        header("location: error.php");
    } else {
        /**
        * Activate account
        * Set active to 1
        **/
        $sql = "UPDATE users SET active='1' WHERE email='$email'";
        $db->query($sql);

        $msgClass = "alert-success";
        $msg = "Your account has been activated!";
        header("location: index.php");
    }

} else {
    $msgClass = 'alert-danger';
    $msg = "Invalid parameters provided for account verification!";
    header("location: index.php");
}
?>
