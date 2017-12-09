<?php
/* Verify user email from confirmation email link sent to users email */
require 'database.php';
$msgClass = "";
$msg = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['newPwd']) && !empty($_POST['confirmPwd']) && $_POST['newPwd'] === $_POST['confirmPwd']){
        // Fetch and sanitize password
        $new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);

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

            $sql = "SELECT * FROM users WHERE email='$email' AND hash='$hash'";
            //Query database
            $result_set = $db->query($sql);

            if($db->num_rows($result_set) == 0){
                //Account does not exist or expired url
                $msgClass = "alert-danger";
                $msg = "This account does not exist! or the link is expired";
            } else {
                // update user
                $sql = "UPDATE users SET password='$new_password', hash='$hash' WHERE email='$email'";
                $db->query($sql);

                if($db->affected_rows() > 0){
                    $msgClass = "alert-success";
                    $msg = "Your password has been reset successfully!";
                    header("location: index.php");
                } else {
                    $msgClass = "alert-danger";
                    $msg = "Sorry!! Your password could not be reset.";
                }
            }

        } else {
            $msgClass = 'alert-danger';
            $msg = "Invalid parameters provided for account reset!";
        }
    } else {
        // Blank fields or passwords don't match
        $msgClass = 'alert-danger';
        $msg = "Two passwords you entered don't match, try again!";
    }
}
?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>New Password</title>
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
                    <div class="col-lg-12 pwd-reset">
                        <h1>Reset Your Password</h1>
                        <!--Reset password Form -->
                        <form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" autocomplete="off">
                            <!--Extract email and harsh from forgot email link -->
                            <input type="hidden" name="email" value="<?=$email?>">
                            <input type="hidden" name="harsh" value="<?=$harsh?>">
                            <!--Set new password -->
                            <div class="form-group input-group">
                                <span class="input-group-addon" id="sizing-addon1">New Password</span>
                                <input type="text" class="form-control" name="newPwd" id="newPwd" aria-describedby="sizing-addon1" required>
                            </div>
                            <!--Confirm new password -->
                            <div class="form-group input-group">
                                <span class="input-group-addon" id="sizing-addon2">Confirm Password</span>
                                <input type="text" class="form-control" name="confirmPwd" id="confirmPwd" aria-describedby="sizing-addon2" required>
                            </div>
                            <button type="submit" name="pwdset" id="pwdset" class="btn btn-outline-secondary">Set New Password</button>
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
