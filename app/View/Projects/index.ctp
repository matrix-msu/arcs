
<?php echo $this->Session->flash();
echo $this->Session->flash('flash_success'); ?>
<!--?php print_r( $this->Session ); ? -->
<?php $this->set('index_toolbar', true); ?>

<div class="intro">
    <div class="landing_header">The Archaeological Resource Cataloging System</div>

    <div class="landing_body_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex. Nulla fermentum, est ut suscipit interdum, lorem eros gravida lorem, eu lobortis purus ligula in orci. Duis massa neque, rhoncus sit amet sem ut, cursus interdum ligula. Duis ultricies euismod ligula, sed lacinia turpis laoreet ac. Donec tristique scelerisque tristique. Aliquam non enim non purus faucibus viverra. Phasellus euismod vestibulum enim.</div>

	<div class="landing_header_two">Choose a project site below to get started.</div>

</div>

<div id="map"></div>


<script>
    var map = L.map('map', { zoomControl:false });

    map.scrollWheelZoom.disable();

    L.tileLayer('http://{s}.tiles.mapbox.com/v3/austintruchan.m3e777m7/{z}/{x}/{y}.png', {
                maxZoom: 18 }).addTo(map);

	map.on('popupopen', function(e) {
	    var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
	    px.y -= e.popup._container.clientHeight/2 // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
	    map.panTo(map.unproject(px),{animate: true}); // pan to new center
	});

    var marker_array = [];
	var coords_array = [];

	// Customize map pin using MapPin.svg and default shadow
    var marker_icon = L.icon({
      iconUrl: 'img/MapPin.svg',
      shadowUrl: 'img/marker-shadow.png',
      iconSize: [33, 42],
      shadowSize: [41, 41],
      iconAnchor: [16.5, 39],
      shadowAnchor: [7, 41],
      popupAnchor: [2,-40]
    });
	<?php
		//$projects_array = json_decode($projects, true);

		foreach($projects as $item) {
			$link = $this->Html->link(
				'VIEW PROJECT',
				array(
					'controller' => 'projects',
					'action' => 'single_project',
					str_replace(' ', '_', strtolower($item["Persistent Name"]))
				)
			);

			//Convert KORA Geolocation to array of coordinate pairs
			$geo = $item['Geolocation'];

			//commented out markers in case we choose to reuse them later. Not using them as of 11/5/15
			foreach($geo as $marker) {
				$coords = explode(",", $marker);
				//markers
				$html = "";
				$html = "var marker = L.marker([".$coords[0].",".$coords[1]."], {icon: marker_icon}, {opacity: 1})";
				$html .= ".addTo(map);";
				$html .= "marker_array.push(marker);";
				$html .= "coords_array.push([".$coords[0].",".$coords[1]."]);";
				$brief = str_replace("'", "\'", $item['Description']);
				$html .= 'marker.bindPopup(\'<h1>'.$item['Name'].'</h1><p style="margin:0;">'.$brief.'</p><br>'.$link.'\');';
				print $html; //print markers and set coords_array
				//print "console.log('".$coords[0]."', '".$coords[1]."');";
			}

			//print polygon
			$html = "";
			$html = "var polygon = L.polygon(coords_array)";
			$html .= ".addTo(map);";
			$brief = str_replace("'", "\'", $item['Description']);
			$html .= 'polygon.bindPopup(\'<h1>'.$item['Name'].'</h1><p style="margin:0;">'.$brief.'</p><br>'.$link.'\');';
			//$html .= '.removeLayer('.L.polyline().');';
			print $html;
			//print "console.log(coords_array);";
		}
	?>
	window.map.removeLayer(window.polygon);
	
	var group = new L.featureGroup(marker_array);

	map.fitBounds(group.getBounds()).setZoom(7);

</script>
