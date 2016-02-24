<div class="viewers-container">

<div class="flagModalBackground">
	<div class="flagWrap">
		<div id="flagModal">
			<div class="flagModalHeader">NEW FLAG <img src="../app/webroot/assets/img/Close.svg" class="modalClose"></img></div>
			<hr>
			<form id="flagForm" action="/">
				<p class="flagSuccess">Flag submitted successfully.</p>
				<p class="formError reasonError">Select a reason for this flag.</p>
				<select class="formInput" id="flagReason">
				  <option value="">SELECT REASON</option>
				  <option value="incorrect">Incorrect Attribute</option>
				  <option value="spam">Spam</option>
				  <option value="duplicate">Duplicate</option>
				  <option value="other">Other</option>
				</select>
				<p class="formError explanationError">Give an explanation for this flag.</p>
				<textarea class="formInput" id="flagExplanation" placeholder="EXPLAIN REASONING"></textarea>
				
				<button class="flagSubmit" type="submit">CREATE FLAG</button>
			</form>
		</div>
	</div>
</div>

<div class="annotateModalBackground">
	<div class="annotateWrap">
		<div id="annotateModal">
			<div class="annotateModalHeader">NEW ANNOTATION<img src="../app/webroot/assets/img/Close.svg" class="modalClose"></img></div>
			<hr class="annotateHeaderDivider">
			<p class="annotateTab annotateTabRelation activeTab">RELATION</p>
			<p class="annotateTab annotateTabTranscript">TRANSCRIPT</p>
			<p class="annotateTab annotateTabUrl">URL</p>
			<div class="annotateRelationContainer">
				<form class="annotateSearchForm" action="#">
				  <input class="annotateSearch" placeholder="SEARCH"/>
				</form>
				<div class="resultsContainer"></div>
			</div>
			<div class="annotateTranscriptContainer">
				<textarea class="annotateTranscript" placeholder="ENTER TRANSCRIPT"></textarea>
			</div>
			<div class="annotateUrlContainer">
				<textarea class="annotateUrl" placeholder="ENTER URL"></textarea>
			</div>
			<button class="annotateSubmit" type="submit">CREATE ANNOTATION</button>
		</div>
		
	</div>
</div>

<div class="collectionModalBackground">
	<div class="collectionWrap">
		<div id="collectionModal">
			<div class="collectionModalHeader">Add to collection <img src="../app/webroot/assets/img/Close.svg" class="modalClose"></img></div>
			<hr>
			<form id="collectionForm" action="/">
				<textarea class="formInput" id="collectionTitle" placeholder="ENTER NEW COLLECTION TITLE"></textarea>
				<button class="collectionSubmit" type="submit">Add to new collection</button>
			</form>
		</div>
	</div>
</div>

<div id="viewer-left">
	<div id="viewer-tools">
		<div class="container1">
			<h3><?php echo $resource['Title']; ?></h3>
			
			<div class="tools">
				<a id="collection-new-btn" href="#">
					<span class="content">
						Collection
					</span>
					<div class="icon-collection"></div>
				</a>

				<a id="annotate-new-btn" class="annotate" href="#">
					<span class="content">
						Annotate
					</span>
					<div class="icon-annotate"></div>
				</a>
				
				<a href="#">
					<span class="content">
						Export
					</span>
					<div class="icon-export"></div>
				</a>
			</div>
		</div>
	</div>
	
	<div id="viewer-window">
		<div class="annotateHelp">Click and drag to outline the area you would like to annotate. <div class="annotationHelpOk">OK</div></div>
		<img src="<?php echo $resource['thumb'] ?>" id="PageImage">
		<div class='canvas'></div>
	</div>
	
	<div id="resource-tools">
		<div class="resource-tools-container">
			<!-- TO DO: Add onClick events here for each icon -->
			<div>
				<img class="arrow-left-icon" src="../img/ArrowLeft.svg">
			</div>
			<div class="annotate-fullscreen-div">
	  			<img class="resources-annotate-icon" src="../img/AnnotationsTooltip.svg">
				<img class="resources-fullscreen-icon" src="../img/Fullscreen.svg">
			</div>
			<div class="zoom-out-div">
				<img class="resources-zoom-out-icon" src="../img/zoomOut.svg">
			</div>
			<div class="zoom-range-div">
	  			<input type="range" min="1" max="5" value="1" step="0.1" class="zoom-bar">
			</div>
			<div class="zoom-in-div">
				<img class="resources-zoom-in-icon" src="../img/ZoomIn.svg">
			</div>
			<div class="rotate-div">
				<img class="resources-rotate-icon" src="../img/Rotate.svg">
			</div>
			<div>
				<img class="arrow-right-icon" src="../img/ArrowRight.svg">
			</div>
		</div>	
	</div>
</div>

<div id="viewer-right">
	
	<div id="tabs" class="metadata">
		
		<!-- TO DO: Add click events for highlighting the text on the tabs (in Arcs blue) -->
		<ul class="metadata-tabs">
			<li class="metadata-tab"><a href="#tabs-1">Info</a></li>
			<li class="metadata-tab"><a href="#tabs-2">Notations</a></li>
			<li class="metadata-tab"><a href="#tabs-3">Discussions</a></li>
			<li class="metadata-tab"><a href="#tabs-4">Instances</a></li>
		</ul>
		
		<div id="search">
			<span class="title">
				<p>Collection Title</p>
			</span>
			
			<input type="text" placeholder="SEARCH COLLECTION">
		</div>
		
		<div id="tabs-1" class="metadata-content">
			
			<div class="accordion metadata-accordion">
	
				<h3 class="level-tab">Project Level Metadata <div class="icon-edit"></div><span>Edit</span></h3>
				
				<div class="level-content">
					
					<table>
						<tr>
							<td>Name</td>
							<td><?php echo $project['Name'] ?></td>
						</tr>
						
						<tr>
							<td>Country</td>
							<td><?php echo $project['Country'] ?></td>
						</tr>
						
						<tr>
							<td>Region</td>
							<td><?php echo $project['Region'] ?></td>
						</tr>
						
						<tr>
							<td>Geolocation</td>
							<td><?php foreach($project['Geolocation'] as $geolocation) {echo $geolocation."<br>";} ?></td>
						</tr>
						
						<tr>
							<td>Modern Name</td>
							<td><?php echo $project['Modern Name'] ?></td>
						</tr>
						
						<tr>
							<td>Location Identifier</td>
							<td><?php echo $project['Location Identifier'] ?></td>
						</tr>
						
						<tr>
							<td>Location Identifier Scheme</td>
							<td><?php echo $project['Location Identifier Scheme'] ?></td>
						</tr>
						
						<tr>
							<td>Elevation</td>
							<td><?php echo $project['Elevation'] ?></td>
						</tr>
						
						<tr>
							<td>Earliest Date</td>
							<td><?php echo $project['Earliest Date'] ?></td>
						</tr>
						
						<tr>
							<td>Latest Date</td>
							<td><?php echo $project['Latest Date'] ?></td>
						</tr>
						
						<tr>
							<td>Records Archive</td>
							<td><?php echo $project['Records Archive'] ?></td>
						</tr>
						
						<tr>
							<td>Persistent Name</td>
							<td><?php echo $project['Persistent Name'] ?></td>
						</tr>
						
						<tr>
							<td>Complex Title</td>
							<td><?php echo $project['Complex Title'] ?></td>
						</tr>
						
						<tr>
							<td>Terminus Ante Quem</td>
							<td><?php echo $project['Terminus Ante Quem'] ?></td>
						</tr>
						
						<tr>
							<td>Terminus Post Quem</td>
							<td><?php echo $project['Terminus Post Quem'] ?></td>
						</tr>
						
						<tr>
							<td>Period</td>
							<td><?php echo $project['Period'] ?></td>
						</tr>
						
						<tr>
							<td>Archaeological Culture</td>
							<td><?php echo $project['Archaeological Culture'] ?></td>
						</tr>
						
						<tr>
							<td>Description</td>
							<td><?php echo $project['Description'] ?></td>
						</tr>
						
						<tr>
							<td>Brief Description</td>
							<td><?php echo $project['Brief Description'] ?></td>
						</tr>
						
						<tr>
							<td>Permitting Heritage Body</td>
							<td><?php echo $project['Permitting Heritage Body'] ?></td>
						</tr>
					</table>
					
				</div>
				
				<h3 class="level-tab">Season Level Metadata <div class="icon-edit"></div><span>Edit</span></h3>
				
				<div class="level-content">
					
					<table>
						<?php foreach($seasons as $season) { ?>
						<tr>
							<td>Title</td>
							<td><?php echo $season['Title'] ?></td>
						</tr>
						
						<tr>
							<td>Type</td>
							<td><?php echo $season['Type'] ?></td>
						</tr>
						
						<tr>
							<td>Director</td>
							<td><?php echo $season['Director'] ?></td>
						</tr>
						
						<tr>
							<td>Registrar</td>
							<td><?php echo $season['Registrar'] ?></td>
						</tr>
						
						<tr>
							<td>Sponsor</td>
							<td><?php echo $season['Sponsor'] ?></td>
						</tr>
						
						<tr>
							<td>Earliest Date</td>
							<td><?php if ($season['Earliest Date']['year']) {echo $season['Earliest Date']['year'] . "/" . $season['Earliest Date']['month'] . "/" . $season['Earliest Date']['day'];} ?></td>
							
						</tr>
						
						<tr>
							<td>Latest Date</td>
							<td><?php if ($season['Latest Date']['year']) {echo $season['Latest Date']['year'] . "/" . $season['Latest Date']['month'] . "/" . $season['Latest Date']['day'];} ?></td>
						</tr>
						
						<tr>
							<td>Terminus Ante Quem</td>
							<td><?php echo $season['Terminus Ante Quem'] ?></td>
						</tr>
						
						<tr>
							<td>Terminus Post Quem</td>
							<td><?php echo $season['Terminus Post Quem'] ?></td>
						</tr>
						
						<tr>
							<td>Description</td>
							<td><?php echo $season['Description'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor</td>
							<td><?php echo $season['Contributor'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor Role</td>
							<td><?php echo $season['Contributor Role'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor</td>
							<td><?php echo $season['Contributor 2'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor Role</td>
							<td><?php echo $season['Contributor Role 2'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor</td>
							<td><?php echo $season['Contributor 3'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor Role</td>
							<td><?php echo $season['Contributor Role 3'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor</td>
							<td><?php echo $season['Contributor 4'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor Role</td>
							<td><?php echo $season['Contributor Role 4'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor</td>
							<td><?php echo $season['Contributor 5'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor Role</td>
							<td><?php echo $season['Contributor Role 5'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor</td>
							<td><?php echo $season['Contributor 6'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor Role</td>
							<td><?php echo $season['Contributor Role 6'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor</td>
							<td><?php echo $season['Contributor 7'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor Role</td>
							<td><?php echo $season['Contributor Role 7'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor</td>
							<td><?php echo $season['Contributor 8'] ?></td>
						</tr>
						
						<tr>
							<td>Contributor Role</td>
							<td><?php echo $season['Contributor Role 8'] ?></td>
						</tr>
						
						<?php } ?>
						
					</table>
					
				</div>
				
				<h3 class="level-tab">Excavation/Survey Level Metadata <div class="icon-edit"></div><span>Edit</span></h3>
				
				<div class="level-content">
					
					<table>
						<tr>
							<td>Metadata Title</td>
							<td><?php var_dump($survey); ?></td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information</td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information</td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information</td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information</td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information needs more room so it will expand the height of the column like so.</td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information</td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information</td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information</td>
						</tr>
						
						<tr>
							<td>Metadata Title</td>
							<td>Metadata Information</td>
						</tr>
					</table>
					
				</div>
				
				<h3 class="level-tab">Archival Object Level Metadata <div class="icon-edit"></div><span>Edit</span></h3>
				
				<div class="level-content">
					
					<table>
						<tr>
							<td>Resource Identifier</td>
							<td><?php echo $resource['Resource Identifier']; ?></td>
						</tr>
						
						<tr>
							<td>Type</td>
							<td><?php echo $resource['Type']; ?></td>
						</tr>
						
						<tr>
							<td>Tile</td>
							<td><?php echo $resource['Title']; ?></td>
						</tr>
						
						<?php if ($resource['Sub-title'] != null) {?>
						<tr>
							<td>Sub-Tile</td>
							<td><?php echo $resource['Sub-Tile']; ?></td>
						</tr>
						<?php } ?>
						
						<tr>
							<td>Creator</td>
							<td><?php foreach($resource['Creator'] as $creator) {echo $creator.'<br>'; } ?></td>
						</tr>
						
						<tr>
							<td>Role</td>
							<td><?php foreach($resource['Role'] as $role) {echo $role.'<br>'; } ?></td>
						</tr>
						
						<tr>
							<td>Earliest Date</td>
							<td><?php if ($resource['Earliest Date']['year']) {echo $resource['Earliest Date']['year'] . "/" . $resource['Earliest Date']['month'] . "/" . $resource['Earliest Date']['day'];} ?></td>
						</tr>
						
						<tr>
							<td>Date Range</td>
							<td><?php echo $resource['Date Range']; ?></td>
						</tr>
						
						<tr>
							<td>Description</td>
							<td><?php echo $resource['Description']; ?></td>
						</tr>
						
						<tr>
							<td>Pages</td>
							<td><?php echo $resource['Pages']; ?></td>
						</tr>
						
						<tr>
							<td>Condition</td>
							<td><?php echo $resource['Condition']; ?></td>
						</tr>
						
						<tr>
							<td>Access Level</td>
							<td><?php echo $resource['Access Level']; ?></td>
						</tr>
						
						<tr>
							<td>Accession Number</td>
							<td><?php echo $resource['Accession Number']; ?></td>
						</tr>
					</table>
					
				</div>
			</div>
			
		</div>
		
		<div id="tabs-2" class="metadata-content">
			
			<p>Notations</p>
			
		</div>
		
		<div id="tabs-3" class="metadata-content">
			
			<p>Discussions</p>
			
		</div>
		
		<div id="tabs-4" class="metadata-content">
			
			<p>Instances</p>
			
		</div>
		
	</div>	
		
</div>
</div>

<div id="other-resources">
	<?php foreach($pages as $r): ?>
		<a href="#" onclick="GetNewResource(<?php echo "'".$r['kid']."'"?>)">
		<img class="other-resource"
		     src="<?php echo $r['thumb'] ?>"


		     height="100px"
			 width="100px"
			 style="padding: 10px 10px"
			>
		</a>
	<?php endforeach ?>
</div>

<script>
	var kid = "<?php echo $kid; ?>";
	function GetNewResource(id) {
	  	image = document.getElementById('PageImage')
	  	image.src = '../img/arcs-preloader.gif';
	  	image.style.height = '100%';
	  	image.style.width = '100%';
	  	setTimeout(function(){}, 10000);
		return $.ajax({
		  url: "<?php echo Router::url('/', true); ?>resources/loadNewResource/"+id,
		  type: 'GET',
		  success: function(res) {
			res = JSON.parse(res);
			kid = res['kid'];
			document.getElementById('PageImage').src = "<?php echo $kora_url; ?>"+res['Image Upload']['localName'];
			$(".canvas").height($("#PageImage").height());
			$(".canvas").width($("#PageImage").width());
			$(".canvas").css({bottom:$("#PageImage").height()});
		  }
		});
	}
</script>

<!-- Give the resource array to the client-side code -->
<script>
	$( "#tabs" ).tabs();

	$( ".accordion" ).accordion({
		heightStyle: "fill"
	});
		
	$( '.metadata-accordion' ).height( $( '#viewer-window' ).height() );
	
	$( window ).resize(function() {
		$( '.metadata-accordion' ).height( $( '#viewer-window' ).height() );
	});
		
	$( "#flag-new-btn" ).click(function(){
		$( ".flagModalBackground" ).show();
	});
	
	$( ".modalClose" ).click(function(){
		$( ".flagModalBackground" ).hide();
		$( ".annotateModalBackground" ).hide();
		$( ".collectionModalBackground" ).hide();
		$( ".annotateHelp" ).hide();
		if (gen_box != null) {
			$(gen_box).remove();
			gen_box = null;
		}
		ResetAnnotationModal();
	});
	
	$( "#flagForm" ).submit(function( event ) {

		// Stop form from submitting normally
		event.preventDefault();
		
		$(".flagSuccess").hide();
		
		if ($("#flagReason").val() == '') {
			$(".reasonError").show();
		} else {
			$(".reasonError").hide();
		}
		
		if ($("#flagExplanation").val() == '') {
			$(".explanationError").show();
		} else {
			$(".explanationError").hide();
		}
		
		if ($("#flagReason").val() != '' && $("#flagExplanation").val() != '') {
			var formdata = {
				kid: kid,
				resource_kid: "<?php echo $resource['kid']; ?>",
				resource_name: "<?php echo $resource['Resource Identifier']; ?>",
				reason: $("#flagReason").val(),
				explanation: $("#flagExplanation").val(),
				status: "pending"				
			}
							
			$.ajax({
				url: "<?php echo Router::url('/', true); ?>resources/flags/add",
				type: "POST",
				data: formdata,
				statusCode: {
					201: function() {
						$("#flagReason").val('');
						$("#flagExplanation").val('');
						$(".flagSuccess").show();
					}
				}
				
			});
		}
	});
	
	$("#PageImage").mouseenter(function() {
		$( ".canvas" ).show();
	});
	
	$(".canvas").mouseleave(function() {
		if (disabled) {
			$( ".canvas" ).hide();
		}
	});
			
	var annotateData = {
		transcript: "",
		url: "",
		page_kid: "",
		resource_kid: "",
		resource_name: "",
		relation_resource_kid: "",
		relation_page_kid: "",
		relation_resource_name: "",
		x1: "",
		x2: "",
		y1: "",
		y2: ""
	};
	var selected = false;
	
	function waitForElement(){
		if($("#PageImage").height() !== 0){
			$(".canvas").height($("#PageImage").height());
			$(".canvas").width($("#PageImage").width());
			$(".canvas").css({bottom:$("#PageImage").height()});
			$(".canvas").hide();
			DrawBoxes(kid);
		}
		else{
			setTimeout(function(){
				waitForElement();
			},250);
		}
	}
	waitForElement();
	
	var gen_box = null;
	var disabled = true;
	$( ".annotate" ).click(function(){
		$(this).addClass("annotateActive");
		$( ".canvas" ).show();
		$( ".annotateHelp" ).show();
		$(".canvas").addClass("select");
		//Draw box
		var i = 0;
		disabled = false;
		$(".canvas").selectable({ 
			disabled: false,
			start: function(e) {
				if (!disabled) {
					//get the mouse position on start
					x_begin = e.pageX,
					y_begin = e.pageY;
				}
			},
			stop: function(e) {
				if (!disabled) {
					//get the mouse position on stop
					x_end = e.pageX,
					y_end = e.pageY;

					/***  if dragging mouse to the right direction, calcuate width/height  ***/
					if( x_end - x_begin >= 1 ) {
						width  = x_end - x_begin;
					
					/***  if dragging mouse to the left direction, calcuate width/height (only change is x) ***/
					} else {
						
						width  = x_begin - x_end;
						var drag_left = true;
					}
					
					/***  if dragging mouse to the down direction, calcuate width/height  ***/
					if( y_end - y_begin >= 1 ) {
						height = y_end - y_begin;
					
					/***  if dragging mouse to the up direction, calcuate width/height (only change is x) ***/
					} else {
						
						height =  y_begin - y_end;
						var drag_up = true;
					}
					
					//append a new div and increment the class and turn it into jquery selector
					$(this).append('<div class="gen_box gen_box_' + i + '"></div>');
					gen_box = $('.gen_box_' + i);

					//add css to generated div and make it resizable & draggable
					$(gen_box).css({
						 'width'     : width,
						 'height'    : height,
						 'left'      : x_begin,
						 'top'       : y_begin - 120
					})
					//.draggable({ grid: [20, 20] })
					//.resizable();

					//if the mouse was dragged left, offset the gen_box position 
					drag_left ? $(gen_box).offset({ left: x_end }) : $(gen_box).offset({ left: x_begin });
					drag_up ? $(gen_box).offset({ top: y_end }) : $(gen_box).offset({ top: y_begin });
					
					i++;
					
					//Add coordinates to annotation to save
					annotateData.x1 = parseFloat($(gen_box).css('left'), 10) / $(".canvas").width();
					annotateData.x2 = (parseFloat($(gen_box).css('left')) + width) / $(".canvas").width();
					annotateData.y1 = (parseFloat($(gen_box).css('top'))) / $(".canvas").height();
					annotateData.y2 = (parseFloat($(gen_box).css('top')) + height) / $(".canvas").height();
					
					$( ".annotateModalBackground" ).show();
				}
			}
		});
	});
	
	//Load boxes
	function DrawBoxes(pageKid) {
		$.ajax({
			url: "<?php echo Router::url('/', true); ?>api/annotations/findall.json",
			type: "POST",
			data: {
				id: pageKid
			},
			success: function(data) {
				$.each(data, function (k, v) {
					$(".canvas").append('<div class="gen_box" id="'+v.id+'"></div>');
					gen_box = $('#' + v.id);
					
					//add css to generated div and make it resizable & draggable
					$(gen_box).css({
						 'width'     : $(".canvas").width() * v.x2 - $(".canvas").width() * v.x1,
						 'height'    : $(".canvas").height() * v.y2 - $(".canvas").height() * v.y1,
						 'left'      : $(".canvas").width() * v.x1,
						 'top'       : $(".canvas").height() * v.y1
					})
				})
			}
		});
	}
	
	
	
	//Annotation search
	$( ".annotateSearchForm" ).submit(function( event ) {
		$(".resultsContainer").empty();
		$.ajax({
			url: "<?php echo Router::url('/', true); ?>resources/search?q="+encodeURIComponent(
				"(Type,like,"+$(".annotateSearch").val()
				+"),or,(Title,like,"+$(".annotateSearch").val()
				+"),or,(Resource Identifier,like,"+$(".annotateSearch").val()
				+"),or,(Description,like,"+$(".annotateSearch").val()
				+"),or,(Accession Number,like,"+$(".annotateSearch").val()
				+"),or,(Earliest Date,like,"+$(".annotateSearch").val()
				+"),or,(Latest Date,like,"+$(".annotateSearch").val()
				+")")+"&sid=736",
			type: "POST",
			success: function(data) {
				BuildResults(data);
			}
		}); 
		
		event.preventDefault();
	});
	
	function BuildResults(data) {
		// var icons = ["annotations", "comments", "keywords", "bookmarks", "metadata"];
		if (data.total > 0) {
			//Iterate search results
			$.each( data.results, function( key, value ) {
				/* $.each( icons, function (k, v) {
					// $.ajax({
						// url: "<?php echo Router::url('/', true); ?>api/"+v+"/kid/"+value.kid+".json",
						// type: "POST",
						// success: function(data) {
							
						// }
					// });
				// });*/
				
				$(".resultsContainer").append("<div class='annotateSearchResult' id='"+value.kid+"'></div>");
				if (value.thumb == "img/DefaultResourceImage.svg") {
					$("#"+value.kid).append("<div class='imageWrap'><img class='resultImage' src='<?php echo Router::url('/', true); ?>app/webroot/"+value.thumb+"'/></div>");
				}
				else {
					$("#"+value.kid).append("<div class='imageWrap'><img class='resultImage' src='"+value.thumb+"'/></div>");
				}
				
				//$(".resultsContainer").append("<div class='icon-annotate'></div>");
				  
				$("#"+value.kid).append(
					"<div class='resultInfo'>" +
					"<p>"+ value['Accession Number'] + "</p>" +
					"<p>"+ value['Type'] + "</p>" +
					"</div>"
				);
					
				$("#"+value.kid).append("<hr class='resultDivider'>");
				
				//Get related pages
				$.ajax({
					url: "<?php echo Router::url('/', true); ?>resources/search?q="+encodeURIComponent("(Resource Associator,like,"+value.kid+"),or,(Resource Identifier,like,"+value['Resource Identifier']+")")+"&sid=738",
					type: "POST",
					success: function(pages) {
						$.each( pages.results, function( k, v ) {
							$("#"+value.kid).after("<div class='annotateSearchResult resultPage' id='"+v.kid+"'></div>");
							if (v.thumb == "img/DefaultResourceImage.svg") {
								$("#"+v.kid).append("<div class='imageWrap'><img class='resultImage' src='<?php echo Router::url('/', true); ?>app/webroot/"+v.thumb+"'/></div>");
							}
							else {
								$("#"+v.kid).append("<div class='imageWrap'><img class='resultImage' src='"+v.thumb+"'/></div>");
							}
						
							$("#"+v.kid).append(
								"<div class='pageInfo'>" +
								"<p>"+ v['Page Identifier'] + "</p>" +
								"</div>"
							);
							
							$("#"+v.kid).append("<hr class='resultDivider'>");
							
							//Clicked a page
							$("#"+v.kid).click(function() {
								if ($(this).hasClass("selectedRelation")) {
									$(this).removeClass("selectedRelation");
									selected = false;
									annotateData.page_kid = "";
									annotateData.resource_kid = "";
									annotateData.resource_name = "";
									annotateData.relation_resource_kid = "";
									annotateData.relation_page_kid = "";
									annotateData.relation_resource_name = "";
								}
								else {
									$(".annotateSearchResult").removeClass('selectedRelation');
									$(this).addClass("selectedRelation");
									selected = true;
									annotateData.page_kid = kid;
									annotateData.resource_kid = "<?php echo $resource['kid']; ?>";
									annotateData.resource_name = "<?php echo $resource['Resource Identifier']; ?>";
									annotateData.relation_resource_name = v['Resource Identifier'];
									annotateData.relation_resource_kid = v['Resource Associator'][0];
									annotateData.relation_page_kid = v.kid;
								}
								
								if (selected || annotateData.transcript.length > 0 || annotateData.url.length > 0) {
									$(".annotateSubmit").show();
								}
								else {
									$(".annotateSubmit").hide();
								}
							})
						})
					}
				}); 
				
				//Clicked a resource
				$("#"+value.kid).click(function() {
					//console.log($(this).attr('id'));
					if ($(this).hasClass("selectedRelation")) {
						$(this).removeClass("selectedRelation");
						selected = false;
						annotateData.relation_resource_kid = "";
						annotateData.relation_page_kid = "";
						annotateData.relation_resource_name = "";
					}
					else {
						$(".annotateSearchResult").removeClass('selectedRelation');
						$(this).addClass("selectedRelation");
						selected = true;
						annotateData.relation_resource_name = value['Resource Identifier'];
						annotateData.relation_resource_kid = $(this).attr('id');
					}
					
					if (selected || annotateData.transcript.length > 0 || annotateData.url.length > 0) {
						$(".annotateSubmit").show();
					}
					else {
						$(".annotateSubmit").hide();
					}
				})
	
			});
		}
	}
	
	//Set transcript and url
	var lastValue = '';
	$(".annotateTranscript, .annotateUrl").on('change keyup paste mouseup', function() {
		if ($(this).val() != lastValue) {
			lastValue = $(this).val();
			annotateData.transcript = $(".annotateTranscript").val();
			annotateData.url = $(".annotateUrl").val();
			if (selected || annotateData.transcript.length > 0 || annotateData.url.length > 0) {
				$(".annotateSubmit").show();
			}
			else {
				$(".annotateSubmit").hide();
			}
		}
	});
	
	$(".annotateSubmit").click(function() {
		annotateData.page_kid = kid;
		annotateData.resource_kid = "<?php echo $resource['kid']; ?>";
		annotateData.resource_name = "<?php echo $resource['Resource Identifier']; ?>";
		
		//First relation
		$.ajax({
			url: "<?php echo Router::url('/', true); ?>api/annotations.json",
			type: "POST",
			data: annotateData,
			success: function(data) {
				$(gen_box).attr("id", data.id);
				gen_box = null;
			}
		});
		
		if (annotateData.relation_resource_kid != "") {
			//Backwards relation
			$.ajax({
				url: "<?php echo Router::url('/', true); ?>api/annotations.json",
				type: "POST",
				data: {
					resource_kid: annotateData.relation_resource_kid,
					page_kid: annotateData.relation_page_kid,
					resource_name: annotateData.relation_resource_name,
					relation_resource_kid: annotateData.resource_kid,
					relation_page_kid: annotateData.page_kid,
					relation_resource_name: annotateData.resource_name,
					transcript: annotateData.transcript,
					url: annotateData.url
				},
				success: function(data) {
				}
			});
		}
		//location.reload();
		ResetAnnotationModal();
	});
	
	function ResetAnnotationModal() {
		//Reset modal
		$(".annotateSearchResult").removeClass('selectedRelation');
		selected = false;
		annotateData.page_kid = "";
		annotateData.resource_kid = "";
		annotateData.relation_resource_kid = "";
		annotateData.relation_page_kid = "";
		annotateData.resource_name = "";
		annotateData.url = "";
		annotateData.transcript = "";
		annotateData.x1 = "";
		annotateData.x2 = "";
		annotateData.y1 = "";
		annotateData.y2 = "";
		
		disabled = true;
		
		$(".annotateRelationContainer").show();
		$(".annotateTranscriptContainer").hide();
		$(".annotateUrlContainer").hide();
		$(".annotateTabRelation").addClass("activeTab");
		$(".annotateTabTranscript").removeClass("activeTab");
		$(".annotateTabUrl").removeClass("activeTab");
		
		$( ".annotateModalBackground" ).hide();
		$( ".annotateHelp" ).hide();
		$(".annotateSearch").val("");
		$(".annotateTranscript").val("");
		$(".annotateUrl").val("");
		$(".resultsContainer").empty();
		$( ".canvas" ).selectable({ disabled: true });
		$( ".canvas" ).hide();
		$(".annotate").removeClass("annotateActive");
		$(".annotateSubmit").hide();
	}
	
	//Tabs
	$(".annotateTabRelation").click(function() {
		$(".annotateRelationContainer").show();
		$(".annotateTranscriptContainer").hide();
		$(".annotateUrlContainer").hide();
		$(".annotateTabRelation").addClass("activeTab");
		$(".annotateTabTranscript").removeClass("activeTab");
		$(".annotateTabUrl").removeClass("activeTab");
	})
	
	$(".annotateTabTranscript").click(function() {
		$(".annotateTranscriptContainer").show();
		$(".annotateRelationContainer").hide();
		$(".annotateUrlContainer").hide();
		$(".annotateTabTranscript").addClass("activeTab");
		$(".annotateTabRelation").removeClass("activeTab");
		$(".annotateTabUrl").removeClass("activeTab");
	})
	
	$(".annotateTabUrl").click(function() {
		$(".annotateUrlContainer").show();
		$(".annotateTranscriptContainer").hide();
		$(".annotateRelationContainer").hide();
		$(".annotateTabUrl").addClass("activeTab");
		$(".annotateTabTranscript").removeClass("activeTab");
		$(".annotateTabRelation").removeClass("activeTab");
	})
	
	$( ".annotationHelpOk" ).click(function(){
		$( ".annotateHelp" ).hide();
	});

	$( "#collection-new-btn" ).click(function(){
		$( ".collectionModalBackground" ).show();
	});
	
	$("#new-collection-resource").click(function() {
		var formdata = {
			kid: kid,
			title: "Test",
			description: "Test from ajax call",
			members: ["<?php echo $resource['kid']; ?>"],
			public: 1,
			user_id: "<?php echo $user['id']; ?>"
		};
						
		$.ajax({
			url: "<?php echo Router::url('/', true); ?>collections/add",
			type: "POST",
			data: formdata,
			success: function() {
				console.log("success");
			},
			error: function() {
				console.log("failure");
			}
		});		
	});
</script>