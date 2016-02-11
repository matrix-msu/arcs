<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>ARCS</title>
        <meta name="description" content="An interactive getting started guide for Brackets.">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="js/leaflet/leaflet.css"/>
        <script src="js/leaflet/leaflet.js"></script>
    </head>
    <body>
        <!-- Useless Header
		
        <div class="header">
            <div class="logo"><a href="index.html"><img class="logo" src="img/ARCS-Logo.png"/><h1>ARCS</h1></a></div>
            <div class="project-navigation"><div class="nav projects active">POLIS
                    <div class="subnav">
                        <a>ISTHMIA</a>
                        <a>NEMEA</a>
                        <a>CHERSONESOS</a></div></div>
                <a class="nav-link" href="#"><div class="nav">RESOURCES</div></a>
                <a class="nav-link" href="#"><div class="nav">COLLECTIONS</div></a>
                <a class="nav-link" href="#"><div class="nav">SEARCH</div></a>
                <a class="nav-link" href="#"><div class="nav">HELP</div></a>
                <a class="nav-link" href="#loginRegister"><div class="nav">LOGIN / REGISTER</div></a>
			</div>
		</div>
        -->
        <div class="intro">
            <h1><?php echo $project["Name"]; ?></h1>
            <p><?php echo $project["Description"]; ?></p>
        </div>
        
        <script>
            var map = L.map('map', { zoomControl:false }).setView([38.6, 26.049], 6);
            map.scrollWheelZoom.disable();
        L.tileLayer('http://{s}.tiles.mapbox.com/v3/austintruchan.m3e777m7/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18 }).addTo(map);
        
            var marker = L.marker([38.6, 26.049])
            .addTo(map);
            marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
            
             var marker = L.marker([39.6, 26.049])
            .addTo(map);
            marker.bindPopup("<h1>Polis</h1><br><p style='margin:0;'>This is a Description</p><br><a href='polis.html'>VIEW PROJECT</a>").openPopup();
        
        </script>
		

    </body>
</html>

