<!DOCTYPE html>
<html>
    <head>
        <title>Create Account - Cloud Conferece Room</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/signup.css">
        <link rel="stylesheet" type="text/css" href="css/theme.css">
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    </head>
    <body>    
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="index.html">
                        <img src="img/logo.png" alt="logo" />
                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">

                            <li><a href="/index.html">Home</a></li>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Features</a></li>
                            <li><a href="/pricing.html">Pricing</a></li>
                            <li><a href="/affiliate.html">Affiliate</a></li>
                            <li>
                                <a class="btn-header" href="/client/signup">Sign up</a>
                            </li>
                            <li><a class="btn-header" href="/client/signin">Sign in</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="box_sign">
            <div class="container">
                <div class="span12 box_wrapper">

                    <div class="hero-unit" style="margin-top:40px">
                        <?php
                        if ($this->getVar("title")) :
                            ?>
                            <h3><?php echo $title; ?></h3>
                            <?php
                        else :
                            ?>
                            <h3>Thank you for your registeration. </h3>
                        <?php
                        endif;
                        ?>
                        <?php
                        if ($this->getVar("message")) :
                            ?>
                            <p><?php echo $message; ?></p>
                            <?php
                        else :
                            ?>
                            <p>Thank you for your registeration. Your account is ready, we need to verify your email address before it works. We have already sent you email with a full instruction to active your account, if you didn't find our email, it may be in your spam folder, if not, you can re-send it with link below. This validation process will be expired within 24hours. If you have anything need help, please contact us soon.</p>
                            <p>
                            <?php
                            endif;
                            ?>
                            <?php
                            if ($this->getVar("success")) :
                            ?>
<!--                            <a class="btn btn-primary btn-large">
                                Sigin in
                            </a>-->
                            <?php
                            else : 
                            ?>
                            <a class="btn btn-primary btn-large" href="/client/signup2?p=<?php echo $guid; ?>&a=resend">
                                Send me active code again
                            </a>
                            <?php
                            endif;
                            ?>
                        </p>
                    </div>

                    <p class="already">Already have an account? 
                        <a href="/client/signin">Sign in</a></p>
                </div>
            </div>
        </div>

        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/theme.js"></script>
    </body>
</html>