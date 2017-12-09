<?php
require 'database.php';
require 'session.php';


//message classes
$msg = '';
$msgClass = '';

//Process form submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Require appropriate files
    if(isset($_POST['login-btn'])){
        //User logging in
        require 'login.php';
    } elseif(isset($_POST['signup-btn'])) {
        //User registering
       require 'signup.php';
    }
}

?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>Log In/Sign-Up Form</title>
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
                    <div class="col-lg-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#login" role="tab">Log In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#signup" role="tab">Sign Up</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="login" role="tabpanel">
                                <h1>Welcome!</h1>
                                <!--Login Form -->
                                <form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" autocomplete="off">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon" id="sizing-addon1">Email</span>
                                        <input type="email" class="form-control" name="email" id="email" aria-describedby="sizing-addon1">
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon" id="sizing-addon2">Password</span>
                                        <input type="password" class="form-control" name="password" id="password" aria-describedby="sizing-addon2">
                                    </div>
                                    <div class="form-group input-group justify-content-end"><button type="submit" name="login-btn" id="login-btn" class="btn btn-outline-default">Log In</button></div>
                                </form>
                                <div class="col-lg-12 text-center">
                                    <p class="forgot"><a href="forgot.php"><small>Forgot Password</small></a></p>
                                </div>
                            </div>
                            <div class="tab-pane" id="signup" role="tabpanel">
                                <h1>Sign Up for Free</h1>
                                <!--Sign up Form -->
                                <form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" autocomplete="off">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon" id="sizing-addon1">First Name</span>
                                        <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="sizing-addon1">
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon" id="sizing-addon2">Last Name</span>
                                        <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="sizing-addon2">
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon" id="sizing-addon3">Email</span>
                                        <input type="email" class="form-control" name="email" id="email" aria-describedby="sizing-addon3">
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon" id="sizing-addon4">Password</span>
                                        <input type="password" class="form-control" name="password" id="password" aria-describedby="sizing-addon4">
                                    </div>
                                    <div class="form-group input-group justify-content-end"><button type="submit" name="signup-btn" id="signup-btn" class="btn btn-outline-default">Register</button></div>
                                </form>
                            </div>
                        </div>
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
