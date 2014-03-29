<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Cloud Conference Room</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <?php echo $this->Html->css("bootstrap.css"); ?>
        <?php echo $this->Html->css("bootstrap-responsive.css"); ?>

        <!--<link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">-->

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="../assets/ico/favicon.png">
    </head>

    <body>
        <div class="container">
            <div class="container-narrow">

                <div class="masthead">
                    <ul class="nav nav-pills pull-right">
                        <li><a href="/client/panel">Home</a></li>
                        <li class="active"><a href="#">Account</a></li>
                        <li><a href="/client/panel/upgrade">Upgrade</a></li>
                        <li><a href="/client/logout">Sign out</a></li>
                    </ul>
                    <a class="brand" href="">
                        <?php echo $this->Html->image("logo.png", array("alt" => "logo")); ?>
                    </a>
                </div>

                <hr>
                <h2>Your account details</h2>
                <div class="jumbotron">
                    <?php echo $this->Form->create ("User", array ("url"=>"/panel/account", "inputDefaults" => array("label"=>false, "div"=>false))); ?>
                        <?php echo $this->Form->input("form", array("type"=>"hidden", "value"=>"form_profile")); ?>
                        <legend>Current package: Trial </legend>
                        <p>You are currently on a trial subscription. Your trial runs until April 18, 2013.</p>
                        <p><a href="/client/panel/upgrade">Choose your plan</a></p>	
                        <style type="text/css">.message {color:red}</style>
                        <?php echo $this->Session->flash(); ?>
                        <fieldset>
                            <legend>Personal </legend>
                            <label>Full Name:</label>
                            <?php echo $this->Form->input("user_name", array("value"=>$userName)); ?>
                            <label>Email:</label>
                            <?php echo $this->Form->input("user_email", array("value"=>$userEmail, "readonly"=>"readonly")); ?>
                            <label>New Password:</label>
                            <?php echo $this->Form->input("user_password", array("type"=>"password", "value"=>"", "placeholder"=>"Password")); ?><br>
                            <?php echo $this->Form->input("user_confirm", array("type"=>"password", "value"=>"", "placeholder"=>"Confirm password")); ?><br>

                            <button type="submit" class="btn">Update</button>
                        </fieldset>
                    <?php echo $this->Form->end(); ?>

                    <?php echo $this->Form->create ("User", array ("type"=>"file", "url"=>"/panel/account", "inputDefaults" => array("label"=>false, "div"=>false))); ?>
                        <?php echo $this->Form->input("form", array("type"=>"hidden", "value"=>"form_invitepage")); ?>
                        <fieldset>
                            <legend>Customize Your Invite Page</legend>
                            <label>Title:</label>
                            <?php echo $this->Form->input("post_title", array("placeholder"=>"Your page title is here", "value"=>$postTitle)); ?>
                            <p><img src="<?php echo $postLogo; ?>" /></p>
                            <label>Logo: (image type allowed : jpg, jpeg, png, gif. Size < 1MB)</label>
                            <?php echo $this->Form->input("post_logo", array("type"=>"file")); ?>
                            <label>Description:</label>
                            <?php echo $this->Form->input("post_content", array("type"=>"textarea", "placeholder"=>"Your page description is here", "value"=>$postContent)); ?><br>
                            <button type="submit" class="btn">Update</button>
                        </fieldset>
                    <?php echo $this->Form->end(); ?>
                    <legend>Need to cancel?</legend>
                    <p>We'll be sorry to see you go. You won't be charged again once you've cancelled. Your data will be permanently deleted after 30 days.</p>
                    <p><a href="#">Cancel your account</a></p>




                </div>

                <hr>



                <div class="footer">
                    <p>Cloud Conferece Room &copy; Company 2013</p>
                </div>

            </div> </div><!-- /container -->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php echo $this->Html->script("jquery.js"); ?>
        <?php echo $this->Html->script("bootstrap-transition.js"); ?>
        <?php echo $this->Html->script("bootstrap-alert.js"); ?>
        <?php echo $this->Html->script("bootstrap-modal.js"); ?>
        <?php echo $this->Html->script("bootstrap-dropdown.js"); ?>
        <?php echo $this->Html->script("bootstrap-scrollspy.js"); ?>
        <?php echo $this->Html->script("js/bootstrap-tab.js"); ?>
        <?php echo $this->Html->script("js/bootstrap-tooltip.js"); ?>
        <?php echo $this->Html->script("js/bootstrap-popover.js"); ?>
        <?php echo $this->Html->script("js/bootstrap-button.js"); ?>
        <?php echo $this->Html->script("js/bootstrap-collapse.js"); ?>
        <?php echo $this->Html->script("js/bootstrap-carousel.js"); ?>
        <?php echo $this->Html->script("js/bootstrap-typeahead.js"); ?>

    </body>
</html>
