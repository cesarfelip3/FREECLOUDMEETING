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

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js");  ?>
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
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="/client/panel/account">Account</a></li>
                        <li><a href="/client/panel/upgrade">Upgrades</a></li>
                        <li><a href="/client/logout">Sign out</a></li>
                    </ul>
                    <a class="brand" href="">
                        <?php echo $this->Html->image("logo.png", array("alt" => "logo")); ?>
                    </a>
                </div>

                <hr>
                <h2>Create Your Own Meeting</h2>
                <div class="jumbotron">
                    <?php echo $this->Form->create ("", array ("inputDefaults" => array("label"=>false, "div"=>false))); ?>
                        <fieldset>
                            <legend>Create your own meeting. </legend>
                            <style type="text/css">.message {color:red}</style>
                            <?php echo $this->Session->flash(); ?>
                            <label>Enter your room name:</label>
                            <?php echo $this->Form->input("meeting_name", array("placeholder"=>"Enter your name…")); ?>
                            <label class="checkbox">
                            </label>
                            <button type="submit" class="btn">Create Meeting</button>
                        </fieldset>
                    <?php $this->Form->end (); ?>
                    <h2>My rooms</h2>

                    <table class="table">
                        <tr>
                            <td>Id</td>
                            <td>Name</td>
                            <td>Link to your guests</td>
                            <td>Login as Admin</td>
                        </tr>
                        <?php
                        if (empty ($data)) :
                        ?>
                        <tr>
                            <td colspan="4">Not Found Any Meeting</td>
                        </tr>
                        <?php
                        else :
                            
                            foreach ($data as $value) :
                        ?>
                        <tr>
                            <td><?php echo $value['Meeting']['meeting_id']; ?></td>
                            <td><?php echo $value['Meeting']['meeting_name']; ?></td>
                            <td><?php echo $inviteLink . $value['Meeting']['meeting_guid']; ?></td>
                            <td><a class="btn btn-small btn-primary" href="<?php echo $joinLink . $value['Meeting']['meeting_guid']; ?>" target="_blank">Open</a></td>
                        </tr>
                        <?php
                            endforeach;
                            
                        endif;
                        ?>
                    </table>        

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
