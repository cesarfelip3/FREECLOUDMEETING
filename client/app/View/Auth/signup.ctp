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

                            <li><a href="http://cloudconferenceroom.com/index.html">Home</a></li>
                            <li><a href="http://cloudconferenceroom.com/aboutus.html">About us</a></li>
                            <li><a href="http://cloudconferenceroom.com/features.html">Features</a></li>
                            <li><a href="http://cloudconferenceroom.com/pricing.html">Pricing</a></li>
                            <li><a href="http://cloudconferenceroom.com/affiliate.html">Affiliate</a></li>
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
                    <div class="span12 box">
                        <div>
                            <div class="head">
                                <h4>Start your free trial.</h4>
                                <p>You will be up and running in less than a minute.</p>
                                <style type="text/css">.message {color:red}</style>
                                <?php echo $this->Session->flash(); ?>
                            </div>
                            <div class="form">
                                <?php
                                echo $this->Form->create("", array("inputDefaults" => array("label" => false, "div" => false)));
                                ?>
                                <?php echo $this->Form->input('user_name', array("placeholder" => "Full Name")); ?>
                                <?php echo $this->Form->input('user_email', array("placeholder" => "Email")); ?>
                                <?php echo $this->Form->input('user_password', array("placeholder" => "Password", "type" => "password")); ?>
                                <?php echo $this->Form->input('confirm', array("placeholder" => 'Confirm Password', "type" => "password")); ?>
                                <input type="submit" class="btn" value="Start your free trial"/>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
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