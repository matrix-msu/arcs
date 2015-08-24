<div class="intro">
    <h1>The Archaeological Resource Cataloging System</h1>
    <br>
    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex. Nulla fermentum, est ut suscipit interdum, lorem eros gravida lorem, eu lobortis purus ligula in orci. Duis massa neque, rhoncus sit amet sem ut, cursus interdum ligula. Duis ultricies euismod ligula, sed lacinia turpis laoreet ac. Donec tristique scelerisque tristique. Aliquam non enim non purus faucibus viverra. Phasellus euismod vestibulum enim.</p>
    
    <div id="map"></div>
</div>
 
<script>
    var map = L.map('map', { zoomControl:true });

    map.scrollWheelZoom.disable();

    L.tileLayer('http://{s}.tiles.mapbox.com/v3/austintruchan.m3e777m7/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18 }).addTo(map);
	
	map.on('popupopen', function(e) {
	    var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
	    px.y -= e.popup._container.clientHeight/2 // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
	    map.panTo(map.unproject(px),{animate: true}); // pan to new center
	});

    var marker_array = []
	<?php 
		//$projects_array = json_decode($projects, true);
		foreach($projects as $item) {
			$link = $this->Html->link(
				'VIEW PROJECT',
				array(
					'controller' => 'projects',
					'action' => 'single_project',
					$item["Name"]
				)
			);
			$html = "";
			$html = "var marker = L.marker([".$item['Latitude'].",".$item['Longitude']."])";
			$html .= ".addTo(map);";
			$html .= "marker_array.push(marker);";
			$brief = str_replace("'", "\'", $item['Brief Description']);
			$html .= 'marker.bindPopup(\'<h1>'.$item['Name'].'</h1><p style="margin:0;">'.$brief.'</p><br>'.$link.'\');';
			print $html;
			//print "console.log('".$html."');";
		}
	?>
	var group = new L.featureGroup(marker_array);

	map.fitBounds(group.getBounds()).setZoom(4);

</script>