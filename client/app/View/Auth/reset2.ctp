<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password Now - Cloud Conferece Room</title>
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
                            <li><a href="#">Pricing</a></li>
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
					<?php $step = $this->getVar("step"); ?>
					<?php if ($step == "1") : ?>
                    <div class="hero-unit" style="margin-top:40px">
                        
                      <h3>We have sent you an email to instruct you</h3>
                      
					  
                            <p>Hi your password have reset, you have to follow the instruction in the email to have a new password. Note : if you haven't found the email, it could be found in the SPAM folder. You are welcome to contact with our service support if any question.</p>
				    </div>
                      <?php else : ?>
					  <div class="span12 box">
				    <div>
					  <div class="head">
                            <h4>Enter your new password below.</h4>
                            <style type="text/css">.message {color:red}</style>
                            <?php echo $this->Session->flash(); ?>
                        </div>
					  <div class="form">
                            <?php 
                            echo $this->Form->create("", array ("inputDefaults" => array("label"=>false, "div"=>false)));
                            ?>
                                <?php echo $this->Form->input('user_password', array("placeholder"=>"Your password")); ?>
								<?php echo $this->Form->input('user_confirm', array("placeholder"=>"Your password again")); ?>
                                <input type="submit" class="btn" value="Reset password"/>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
					</div>
					  <?php endif; ?>

                    <!--<p class="already">Already have an account? 
                        <a href="/client/signin">Sign in</a></p>-->
                </div>
            </div>
        </div>

        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/theme.js"></script>
    </body>
</html>