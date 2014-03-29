<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Cloud Conference Room</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">

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

                    <a class="brand" href="/index.html">
                        <img src="<?php echo $logo; ?>" alt="logo" />
                    </a>
                </div>

                <hr>
                <h2><?php echo $title; ?></h2>
                <?php if ($step == 1) : ?>
                    <div class="jumbotron">
                        <?php
                        echo $this->Form->create("", array("inputDefaults" => array("label" => false, "div" => false)));
                        ?>

                        <fieldset>
                            <legend><?php echo $description; ?></legend>
                            <style type="text/css">.message {color:red}</style>
                            <?php echo $this->Session->flash(); ?>
                            <label>Name:</label>
                            <?php echo $this->Form->input('username', array("placeholder" => "Enter your name…")); ?>
                            <label class="checkbox">
                            </label>
                            <button type="submit" class="btn">Submit</button>
                        </fieldset>
                        <?php echo $this->Form->end(); ?>
                    </div>
                <?php endif; ?>

                <?php if ($step == 2) : ?>
                    <div class="alert alert-block">
                        <h4>Notice</h4>
                        Hello <?php echo $guestname; ?>, your request is submitted sucessfully and the meeting didn't open yet, it will redirect to the meeting room automatically when it open, please waiting...
                    </div>
                <?php endif; ?>

                <hr>



                <div class="footer">
                    <p>Cloud Conferece Room &copy; Company 2013</p>
                </div>

            </div> </div><!-- /container -->

        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script>
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap-transition.js"></script>
        <script src="js/bootstrap-alert.js"></script>
        <script src="js/bootstrap-modal.js"></script>
        <script src="js/bootstrap-dropdown.js"></script>
        <script src="js/bootstrap-scrollspy.js"></script>
        <script src="js/bootstrap-tab.js"></script>
        <script src="js/bootstrap-tooltip.js"></script>
        <script src="js/bootstrap-popover.js"></script>
        <script src="js/bootstrap-button.js"></script>
        <script src="js/bootstrap-collapse.js"></script>
        <script src="js/bootstrap-carousel.js"></script>
        <script src="js/bootstrap-typeahead.js"></script>

        <?php if ($step == 2) : ?>
        <script type="text/javascript">
            var progress = 0;
            var handler;
            
            $(document).ready (
            function () {
                
                $("#alert-box").hide();
                //handler = window.setInterval(doProgress, 10);
                doDetect ();
                
            });
            
            function doDetect ()
            {
                $.ajax (
                {
                    url : "/client/meeting/detect?i=<?php echo $meetingId; ?>",
                    beforeSend: function () {},
                    statusCode: {},
                    success: function (data, status, xhr) {
                        if (data == "no") {
                            handler = window.setTimeout(doDetect, 1000);
                        }
                            
                        if (data == "yes") {
                            //alert ("yes");
                            location.href = "/client/invite?i=<?php echo $meetingId; ?>&username=<?php echo $guestname; ?>&ajax=true";                           
                        }
                    },
                    error: function (xhr, status, error) {alert (error);},
                    timeout: 30000
                }
            );
            }
            
            function doProgress ()
            {
                progress++;
                if (progress > 100) {
                    progress = 0;
                }
                //alert ("hello");
                $("#progress-bar").css("width", progress + "%");
                
            }            
            
        </script>
        <?php endif; ?>

    </body>
</html>
