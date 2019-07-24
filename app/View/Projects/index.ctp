
<?php echo $this->Session->flash();
echo $this->Session->flash('flash_success'); ?>
<?php $this->set('index_toolbar', true); 
//echo json_encode($projects);die;
?>

<div class="intro">
    <div class="landing_header">The Archaeological Resource Cataloging System</div>

    <div class="landing_body_text">
        The Archaeological Resource Cataloging System (ARCS) is a free, open-source software solution,
        created to allow archaeological projects to share more easily and efficiently the records stored
        in their traditional paper-based archives.  Far more than a simple transcription tool, ARCS is
        designed to foster the upload, augmentation, and presentation of digitized copies of various types
        of archaeological documentation. Each installation of ARCS can be customized to reflect the
        unique organizational systems of archaeological surveys and excavations focused on a variety of
        periods and places.  ARCS is built upon the KORA Digital Repository and Publishing Platform and
        has been developed with the support of the National Endowment for the Humanities, the MATRIX
        Center for Digital Humanities & Social Sciences and the Michigan State University College of Arts
        and Letters.
    </div>

	<div class="landing_header_two">
        To learn more about ARCS, click
        <a href="<?php echo ARCS_PROMO_URL;?>" target="_blank">here</a>
        or choose a project from the map below to get started.
    </div>

</div>

<div id="map"></div>


<script>
    var map = L.map('map', { zoomControl:false });

    map.scrollWheelZoom.disable();

     L.tileLayer('https://api.mapbox.com/styles/v1/matrix-msu/cja9rwjz71s2r2rpa006vmr81/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWF0cml4LW1zdSIsImEiOiJmU1NPbUFjIn0.MWCWCMSJ8Ar-6KZtNPzy4w', {
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
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

    foreach($projects as $item) {
        $link = $this->Html->link(
            'VIEW PROJECT',
            array(
                'controller' => 'projects',
                'action' => 'single_project',
                str_replace(' ', '_', strtolower($item["Persistent_Name"]))
            )
        );

		//Convert KORA Geolocation to array of coordinate pairs
		if (isset($item['Geolocation'])){
			$geo = $item['Geolocation'];
		}else{
			$geo = false;
		}
        $country = $item['Country'];


        //commented out markers in case we choose to reuse them later. Not using them as of 11/5/15
        if($geo && isset($geo[0]) && count(explode(",", $geo[0])) == 2){
            echo 'console.log("in if");';
            foreach($geo as $marker) {
                $coords = explode(",", $marker);
                if (count($coords) < 2) {
                    continue;
                }
                //markers
                $html = "";
                $html = "var marker = L.marker([".$coords[0].",".$coords[1]."], {icon: marker_icon}, {opacity: 1})";
                $html .= ".addTo(map);";
                $html .= "marker_array.push(marker);";
                $html .= "coords_array.push([".$coords[0].",".$coords[1]."]);";
                $brief = str_replace("'", "\'", $item['Description']);
                $html .= 'marker.bindPopup(\'<h1 style="font-size:22px;padding-bottom:15px;">'.$item['Name'].'</h1><p style="margin:0;">'.$brief.'</p><br>'.$link.'\');';
                print $html; //print markers and set coords_array
            }
        }else{
            $setupurl = "https://restcountries.eu/rest/v2/name/";
            
            $url = $setupurl.$country;
            $headers = get_headers($url);
            $response = substr($headers[0], 9, 3);
            if ($response == "200"){
                $page = file_get_contents($url);
                if ($page != false){
                    $obj = json_decode($page, true);

                    $coords1 = $obj[0]['latlng'][0];
                    $coords2 = $obj[0]['latlng'][1];
                    
                    $coords = $coords1.",".$coords2;
                    
                    $coords = explode(",", $coords);
                    $html = "";
                    $html = "var marker = L.marker([".$coords[0].",".$coords[1]."], {icon: marker_icon}, {opacity: 1})";
                    $html .= ".addTo(map);";
                    $html .= "marker_array.push(marker);";
                    $html .= "coords_array.push([".$coords[0].",".$coords[1]."]);";
                    $brief = str_replace("'", "\'", $item['Description']);
                    $html .= 'marker.bindPopup(\'<h1 style="font-size:22px;padding-bottom:15px;">'.$item['Name'].'</h1><p style="margin:0;">'.$brief.'</p><br>'.$link.'\');';
                    print $html;  
                }
            } else {
                continue;
            }
        }

        //print polygon
        $html = "";
        $html = "var polygon = L.polygon(coords_array)";
        $html .= ".addTo(map);";
        $brief = str_replace("'", "\'", $item['Description']);
        $html .= 'polygon.bindPopup(\'<h1>'.$item['Name'].'</h1><p style="margin:0;">'.$brief.'</p><br>'.$link.'\');';
        //$html .= '.removeLayer('.L.polyline().');';
        print $html;
    }
	?>
    if (marker_array.length > 0){
        window.map.removeLayer(window.polygon);
        var group = new L.featureGroup(marker_array);
	    map.fitBounds(group.getBounds()).setZoom(7);
    } else {
        var hidden_icon = L.icon({
        iconUrl: 'img/MapPin.svg',
        shadowUrl: 'img/marker-shadow.png',
        iconSize: [0,0],
        shadowSize: [0,0],
        iconAnchor: [0,0],
        shadowAnchor: [0,0],
        popupAnchor: [0,0]
        });

        var marker = L.marker([37.915833, 22.993056], {icon: hidden_icon}, {opacity: 1})
        .addTo(map);
        marker_array.push(marker);
        coords_array.push([37.915833,22.993056]);
        var polygon = L.polygon(coords_array).addTo(map);

        window.map.removeLayer(window.polygon);
        var group = new L.featureGroup(marker_array);
	    map.fitBounds(group.getBounds()).setZoom(7);
    }

</script>
