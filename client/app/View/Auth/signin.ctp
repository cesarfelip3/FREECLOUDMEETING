<!DOCTYPE html>
<html>
<head>
	<title>Create Account - Cloud Conference Room</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/signin.css">
    <link rel="stylesheet" type="text/css" href="css/theme.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
</head>
<body>    
<!-- begin nav bar -->
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
<!-- end nav bar -->
    <div id="box_login">
        <div class="container">
            <div class="span12 box_wrapper">
                <div class="span12 box">
                    <div>
                        <div class="head">
                            <h4>Log in to your account</h4>
                            <style type="text/css">.message {color:red}</style>
                            <?php echo $this->Session->flash(); ?>
                        </div>
                        <div class="social">
                            <a class="face_login" href="#">
                                <span class="face_icon">
                                    <img src="img/i_face.png" alt="fb" alt=""/>
                                </span>
                                <span class="text">Sign in with Facebook</span>
                            </a>
                            <div class="division">
                                <hr class="left">
                                <span>or</span>
                                <hr class="right">
                            </div>
                        </div>
                        <div class="form">
                            <?php 
                            echo $this->Form->create("", array ("inputDefaults" => array("label"=>false, "div"=>false)));
                            ?>
                                <?php echo $this->Form->input('user_email', array("placeholder"=>"Email")); ?>
                                <?php echo $this->Form->input('user_password', array("placeholder"=>"Password", "type"=>"password")); ?>
                                <div class="remember">
                                    <div class="left">
                                        <?php echo $this->Form->input('remember_me', array("type"=>"checkbox")); ?>
                                        <label for="remember_me">Remember me</label>
                                    </div>
                                    <div class="right">
                                        <a href="/client/reset">Forgot password?</a>
                                    </div>
                                </div>
                                <input type="submit" class="btn" value="Sign in"/>
                            </form>
                        </div>
                    </div>
                </div>
                <p class="already">Don't have an account? <a href="/client/signup"> Sign up</a></p>
            </div>
        </div>
    </div>

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/theme.js"></script>
</body>
</html>