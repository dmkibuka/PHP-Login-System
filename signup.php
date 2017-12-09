<?php
/*
* Add user to user database
* User confirmation
* Registration of user
*/
if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['password'])){
    //intiate database connection
    $db = new Database;
    //Get registration form variables
    $first_name = $db->escape_value(trim(ucfirst($_POST['firstname'])));
    $last_name = $db->escape_value(trim(ucfirst($_POST['lastname'])));
    $email = $db->escape_value(trim($_POST['email']));
    $password = $db->escape_value(password_hash($_POST['password'], PASSWORD_BCRYPT));
    $hash = $db->escape_value(md5(rand(0,1000)));

    //Validate email
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === False){
        //Invalid email entered
        $msg = 'Please enter valid email address';
        $msgClass = 'alert-danger';
    } else {
        // Check whether user already exists
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result_set = $db->query($sql);
        if($db->num_rows($result_set) > 0){
            //Email already exists in database/ duplicate
            $msgClass = 'alert-danger';
            $msg = 'This user already exists.<br />Please <a href="#login"><strong>Log In.</strong></a>';
        } else {
            //Add user to database
            $sql = "INSERT INTO users (first_name, last_name, email, password, hash)";
            $sql .= "VALUES ('$first_name', '$last_name', '$email', '$password', '$hash')";

            if(!$db->query($sql)){
                //Registration failed
                $msg = 'Sorry {$first_name} your registration failed. Please contact us directly at <a href="mailto:youremail@email.com" target="_blank"><strong>youremail@email.com</strong></a>';
                $msgClass = 'alert-danger';

            } else {
                // Build registration confirmation email to user
                $to = $email;
                $subject = 'Account Registration Verification ('.$_SERVER["HTTP_HOST"].')';
                $message = '
                Hello '.$first_name.',
                Thank you for registering, Welcome!!
                Please click the link below to activate your account before link expires:
                http://localhost/php-login-system/verify.php?email='.$email.'&hash='.$hash;


                //Email headers
                $headers = "MIME-Version: 1.0" ."\r\n";
                $headers .="Content-Type: text/html;charset=UTF-8" ."\r\n";

                //Additional headers
                $headers .="From " .$first_name.'" "' .$last_name ."<" .$email. ">"."\r\n";

                //Send email
                mail($to, $subject, $message, $headers);

                //Success message to User
                $msgClass = 'alert-success';
                $msg = "Thank you ".$first_name.". Confirmation link has been sent to ".$email. ", please verify your account by clicking on the link in the message!";
            }
        }
    }

} else {
    $msgClass = 'alert-danger';
    $msg = 'Please fill all form fields';
}

?>
