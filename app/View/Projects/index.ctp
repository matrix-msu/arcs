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
        
        <div class="header">
            <div class="logo"><a href="index.html"><img class="logo" src="img/ARCS-Logo.png"/><h1>ARCS</h1></a></div>
            <div class="navigation"><a class="nav-link" href="#"><div class="nav">ABOUT</div></a>
               <div class="nav projects">PROJECTS
                    <div class="subnav"><a href="polis.html">POLIS</a>
                        <a>ISTHMIA</a>
                        <a>NEMEA</a>
                        <a>CHERSONESOS</a></div></div>
                <a class="nav-link" href="#"><div class="nav">HELP</div></a>
                <a><form><input type="text" name="search" spellcheck="false"><button class="search"><img class="search_icon" src="img/search.png"/></button></form></a></div></div>
        
        <div class="intro">
            <h1>The Archaeological Resource Cataloging System</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex. Nulla fermentum, est ut suscipit interdum, lorem eros gravida lorem, eu lobortis purus ligula in orci. Duis massa neque, rhoncus sit amet sem ut, cursus interdum ligula. Duis ultricies euismod ligula, sed lacinia turpis laoreet ac. Donec tristique scelerisque tristique. Aliquam non enim non purus faucibus viverra. Phasellus euismod vestibulum enim.</p>
        </div>
        
         <div id="map"></div>
        
        <div class="footer-wrap">
        <footer class="row clearfix dark-background" role="contentinfo" id="standard-MSU-footer">
						<div class="twelve columns">

							<div id="standard-footer-site-links">
								<ul>
									
									<li>Call us: <strong>(###) ###-####</strong></li>
									<li><a href="contact/index.html">Contact Information</a></li>
									<li><a href="site-map.html">Site Map</a></li>
									<li><a href="privacy.html">Privacy Policy</a></li>
									<li><a href="accessibility.html">Site Accessibility</a></li>
								</ul>
								
							</div>

							<div class="clearfix" id="standard-footer-MSU-info">
							
									<ul class="msu-info-list">
										<li>Call MSU: <strong><span class="msu-phone">(517) 355-1855</span></strong></li>
										<li>Visit: <strong><a href="http://msu.edu">msu.edu</a></strong></li>
										<li>MSU is an affirmative-action, <span>equal-opportunity employer.</span></li>
									</ul>
									<ul class="copyright">
										<li class="spartans-will">Spartans Will.</li>
										<li>&#169; Michigan State University</li> 
										
									</ul>
							</div>
						</div>
						<div class="four columns" id="standard-footer-MSU-wordmark">
								<a href="http://www.msu.edu">

									<!-- If using a light background change the img src to images/msu-wordmark-green-221x47.png-->
									<img class="screen-msuwordmark" alt="Michigan State University Wordmark" src="img/msu-wordmark-white.png"/>
									<img class="print-msuwordmark" alt="Michigan State University Wordmark" src="images/msu-wordmark-black.png"/>
								</a>
						</div>

					</footer></div>
        
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
<!--



-->
