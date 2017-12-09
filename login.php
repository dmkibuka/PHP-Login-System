<?php
/*
User login processing
Validate user existence with email
Validate password
*/
if(!empty($_POST['email']) && !empty($_POST['password'])){
    //initiate database
    $db = new Database;

    //Fetch values from the login form
    $email = $db->escape_value(trim($_POST['email']));

    //Query email from database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result_set = $db->query($sql);

    //Check if user exists
    if($db-> num_rows($result_set)== 0){
        //User does not exist
        $msgClass = 'alert-danger';
        $msg = 'This user does not exist.<br />Please <a href="#signup"><strong>SIGN UP.</strong></a>';
    } else {
        //User exists and found
        $user = $db->fetch_assoc($result_set);
        //Verify password
        if(password_verify($_POST['password'], $user['password'])){
            $session = new Session;
            $session->login($user);
        } else {
            $msgClass = 'alert-danger';
            $msg = 'You have entered a wrong password, please try again!';
        }
    }

} else {
    $msgClass = 'alert-danger';
    $msg = 'Please fill all form fields';
}

?>
