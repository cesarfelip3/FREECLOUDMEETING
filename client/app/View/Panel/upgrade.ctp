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
          <li><a href="/client/panel/">Home</a></li>
          <li><a href="/client/panel/account">Account</a></li>
          <li class="active"><a href="#">Upgrade</a></li>
		  <li><a href="/client/logout">Sign out</a></li>
        </ul>
        <a class="brand" href="">
                        <?php echo $this->Html->image("logo.png", array("alt" => "logo")); ?>
                    </a>
      </div>

      <hr>
<h2>Upgrade</h2>
      <div class="jumbotron">
            <form>
	 <legend>Current package: Trial </legend>
	 <p>You are currently on a trial subscription. Your trial runs until April 18, 2013.</p>
	  		
    <fieldset>
    <legend>Select your plan </legend>
	<select>
	<option>Lite - $35</option>
	<option>Standart - $65</option>
	<option>Pro - $99</option>
	</select>
	<legend>Please enter your billing information. </legend>
    <label>Credit card number:</label>
    <input type="number">
	<label>Expires on:</label>
	<input type="month" placeholder="month">
	<input type="number" placeholder="year">
	<label>Billing ZIP::</label>
	<input type="number" /><br>
    <button type="submit" class="btn">Start my subcription</button>
    </fieldset>
    </form>
	
	
    
	 
	
     
        
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
