<?php
require 'database.php';

//message classes
$msg = '';
$msgClass = '';

//Process form submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Validate posted fields
 if(empty($_POST['email']) || (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))){
        $msg = 'Please enter valid email address';
        $msgClass = 'alert-danger';
    } else {
        /**
        * Check if its a valid user email
        * initiate database connection
        **/
        $db = new Database;

        //Fetch and sanitize inputs
        $email = $db->escape_value(trim($_POST['email']));

        // Check whether user already exists
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result_set = $db->query($sql);

        if($db->num_rows($result_set) == 0){
            // Email address not in database
            $msgClass = 'alert-danger';
            $msg = 'User with that email doesn\'t exist!.<br />Try different email address or <a href="index.php#signup">sign up</a>';
        } else {
            /**
            * User exists with num_rows > 0
            * create user array
            * Generate email
            **/
            $user = $db->fetch_assoc($result_set);
            $email = $user['email'];
            $hash = $user['hash'];
            $first_name = $user['first_name'];
            $last_name = $user['last_name'];
            // Send registration confirmation link (pwdReset.php)
            $to      = $user['email'];
            $subject = 'Password Reset Link ( clevertechie.com )';
            $message = '
            Hello '.$first_name.',
            You have requested password reset!
            Please click this link to reset your password:
            http://localhost/php-login-system/pwdReset.php?email='.$email.'&hash='.$hash;

            //Email headers
            $headers = "MIME-Version: 1.0" ."\r\n";
            $headers .="Content-Type: text/html;charset=UTF-8" ."\r\n";

            //Additional headers
            $headers .="From " .$first_name.'" "' .$last_name ."<" .$email. ">"."\r\n";

            //Send email
            mail($to, $subject, $message, $headers);

            // Email address not in database
            $msgClass = 'alert-success';
            $msg = 'Please check your email <span>'.$email.'</span> for a confirmation link to complete your password reset!';
        }
    }
}

?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>Reset Password</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="login.css">

    </head>

    <body>
        <div class="login-form">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 forgot">
                        <h1>Reset Password</h1>
                        <p>Please enter email address associated with this account</p>
                        <!--Reset password Form -->
                        <form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" autocomplete="off">
                            <div class="form-group input-group">
                                <span class="input-group-addon" id="sizing-addon3">Email Address</span>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="sizing-addon3">
                            </div>
                            <button type="submit" name="pwdReset" id="pwdReset" class="btn btn-outline-secondary">Request Reset</button>
                        </form>
                    </div>
                    <div class="results col-lg-12 <?php echo $msgClass; ?> p-3 mt-2">
                        <?php echo $msg; ?>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 py-0">
                        <hr>
                        <p class="copyright"><small><?php echo "&copy;" .date("Y"). " " .$_SERVER["HTTP_HOST"]. " | "; ?><a href="copyright.php" target="_blank">Terms of use</a></small></p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>

    </html>
