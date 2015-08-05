<div class="intro">
    <h1>The Archaeological Resource Cataloging System</h1>
    <br>
    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex. Nulla fermentum, est ut suscipit interdum, lorem eros gravida lorem, eu lobortis purus ligula in orci. Duis massa neque, rhoncus sit amet sem ut, cursus interdum ligula. Duis ultricies euismod ligula, sed lacinia turpis laoreet ac. Donec tristique scelerisque tristique. Aliquam non enim non purus faucibus viverra. Phasellus euismod vestibulum enim.</p>
    
    <div id="map"></div>
</div>
 
<script>
    var map = L.map('map', { zoomControl:false }).setView([38.6, 26.049], 6);

    map.scrollWheelZoom.disable();

    L.tileLayer('http://{s}.tiles.mapbox.com/v3/austintruchan.m3e777m7/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18 }).addTo(map);

	<?php 
		//$projects_array = json_decode($projects, true);
		foreach($projects as $item) {
			$link = $this->Html->link(
				'VIEW PROJECT',
				array(
					'controller' => 'projects',
					'action' => 'display',
					'single_project'
				)
			);
			$html = "";
			$html = "var marker = L.marker([".$item['Latitude'].",".$item['Longitude']."])";
			$html .= ".addTo(map);";
			$html .= 'marker.bindPopup(\'<h1>'.$item['Name'].'</h1><br><p style="margin:0;">This is a Description</p><br>'.$link.'\').openPopup();';
			print $html;
			//print "console.log('".$html."');";
		}
	?>
</script>