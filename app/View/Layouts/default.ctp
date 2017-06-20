<!doctype html>

<?php

    $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(strpos($url, 'arcs/about') != false){
         echo $this->Session->flash();
         $this->set('index_toolbar', true);
    }
?>

<html lang="en">

    <head>

      <meta charset="utf-8">
        <title><?php echo $title_for_layout; ?> - ARCS</title>
        <link rel="shortcut icon"
            href="<?php echo $this->Html->url('/favicon.ico') ?>"
            type="image/x-icon" />
        <meta name="language" http-equiv="language" content="english" />
        <!-- ios devices go full screen! -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

        <!--<link href='http://fonts.googleapis.com/css?family=Pontano+Sans' rel='stylesheet' type='text/css'>-->

        <!-- app/webroot/js/vendor/leaflet-src.js and app/webroot/js/vendor/leaflet.js don't make the leaflet map. -->
        <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>

        <script>window.CAKE_DEBUG = <?php echo Configure::read('debug') ?>;</script>

        <?php
        // Add the filename to app/Config/assets.ini to automatically call the css/js files her
				echo globaljsvars;
        echo $this->Assets->stylesheets();

        echo $this->Assets->scripts();
        ?>

        <script>arcs.user = new arcs.models.User(<?php echo json_encode($user) ?>);</script>
    </head>
    <body class="<?php echo $body_class ?>">
	<div class="wrap">
            <div class="page fluid-container">

            <?php

                echo $this->element('toolbar');
                if (isset($resourceAccess) && !(bool)$resourceAccess) {
                    if (isset($user['loggedIn']) && $user['loggedIn'] != '' ) {
                        // echo $this->element('Permissions/request_permission');
                    } else {
                        // echo $this->element('Permissions/resource_permission');
                    }
                    echo "<script>var resourceAccess = false;</script>";
                }
                if ($title_for_layout == 'Collections' || $title_for_layout == 'Resources' || $title_for_layout == 'Search' || $title_for_layout == 'AdvancedSearch' || $title_for_layout == 'Users' || $title_for_layout == 'Projects') {
                    if (isset($user['loggedIn']) && $user['loggedIn'] != '' ) {
                        echo $this->element('Permissions/request_permission');
                    } else {
                        echo $this->element('Permissions/resource_permission');
                    }
                }
                if (isset($this->request->data["flashSet"])) {
                  echo $this->element("flash_success", array(
                    "message" => $this->request->data["flashSet"]
                  ));
                }
                echo $this->Session->flash();
                echo $this->Session->flash('auth');
                echo $this->fetch('content');
            ?>
            </div>
            <?php if ($footer): ?>
                <div class="push"></div>
            <?php endif ?>
        </div>
        <?php echo $this->element('footer') ?>
        <?php if ($user['role'] == "Admin" && Configure::read('debug') == 2) echo $this->element('sql') ?>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-20946399-6', 'msu.edu');
		  ga('send', 'pageview');

		</script>
    </body>
</html>
