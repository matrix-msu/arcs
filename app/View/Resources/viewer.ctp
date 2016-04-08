<div class="viewers-container">

<div class="modalBackground">
	<div class="flagWrap">
		<div id="flagModal">
			<div class="flagModalHeader">NEW FLAG <img src="../app/webroot/assets/img/Close.svg" class="modalClose"/></div>
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
			<div class="annotateModalHeader">NEW ANNOTATION<img src="../app/webroot/assets/img/Close.svg" class="modalClose annotationClose"/></div>
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
			<div class="collectionModalHeader">Add to collection <img src="../app/webroot/assets/img/Close.svg" class="modalClose"/></div>
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
				
				<a id="flag" href="#">
					<span class="content">
						Flag
					</span>
					<div class="icon-flag"></div>
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
		<!--<div class="annotateHelp">Click and drag to outline the area you would like to annotate. <div class="annotationHelpOk">OK</div></div>-->
        <div id="ImageWrapper">
		<div id="ImageWrap">
        <img src="<?php echo $resource['thumb'] ?>" id="PageImage">
		<div id="canvas" class='canvas'></div>
        </div>
	</div>
	
	<div id="resource-tools">
		<div class="resource-tools-container">
			<!-- TO DO: Add onClick events here for each icon -->
            

			<div id="prev-resource">
                <a href="#" >
				<img class="arrow-left-icon" src="../img/ArrowLeft.svg">
                </a>
			</div>
			<div class="annotate-fullscreen-div">
	  			<img class="resources-annotate-icon" src="../img/AnnotationsTooltip.svg">
				<img class="resources-fullscreen-icon" src="../img/Fullscreen.svg">
			</div>
			<div id="zoom-out" class="zoom-out-div">
                <a href="#">
				<img class="resources-zoom-out-icon" src="../img/zoomOut.svg">
                </a>
			</div>
			<div id="zoom-range-div" class="zoom-range-div">
                <a href="#">
	  			<input type="range" min="1" max="10" value="1" step="0.1" class="zoom-bar" id="zoom-range">
                </a>
			</div>
			<div id="zoom-in" class="zoom-in-div">
                <a href="#">
				<img class="resources-zoom-in-icon" src="../img/ZoomIn.svg">
                </a>
			</div>
			<div class="rotate-div">
				<img class="resources-rotate-icon" src="../img/Rotate.svg">
			</div>
			<div id="next-resource">
                <a href="#" >
				<img class="arrow-right-icon" src="../img/ArrowRight.svg">
                </a>
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
			<li class="metadata-tab discussion"><a href="#tabs-3">Discussions</a></li>
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
						
					<?php if($season['Title'] != "") { ?>
									
						<table>
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
										
									</table>
							
								<?php } else { ?> 
								<div class="no-data">
									This is a dig find, which doesn’t have associated season metadata.
								</div>				
							<?php } ?> 
				</div>
				
				<h3 class="level-tab">Excavation/Survey Level Metadata <div class="icon-edit"></div><span>Edit</span></h3>
				
				<div class="level-content">
				
					<div id="tabs-1" class="metadata-content">
					
						<div class="accordion metadata-accordion">
							
							<?php if(count($surveys) > 0) { ?>
									<?php $count=0; ?>
									<?php foreach($surveys as $survey) { $count++; ?>		
							
								<h3 class="level-tab smaller">Excavation/Survey Level Metadata Section <?php echo $count ?></h3>	
								
									<div class="level-content auto-height">
									
										<table>
											<tr>
												<td>Name</td>
												<td><?php echo $survey['Name'] ?></td>
											</tr>
											<tr>
												<td>Type</td>
												<td><?php echo $survey['Type'] ?></td>
											</tr>
											<tr>
												<td>Supervisor</td>
												<td><?php echo $survey['Supervisor'] ?></td>
											</tr>
											<tr>
												<td>Earliest Date</td>
												<td><?php if ($survey['Earliest Date']['year']) {echo $survey['Earliest Date']['year'] . "/" . $survey['Earliest Date']['month'] . "/" . $survey['Earliest Date']['day'];} ?></td>
											</tr>
											<tr>
												<td>Latest Date</td>
												<td><?php if ($survey['Latest Date']['year']) {echo $survey['Latest Date']['year'] . "/" . $survey['Latest Date']['month'] . "/" . $survey['Latest Date']['day'];} ?></td>
											</tr>
											<tr>
												<td>Terminus Ante Quem</td>
												<td><?php echo $survey['Terminus Ante Quem'] ?></td>
											</tr>
											<tr>
												<td>Terminus Post Quem</td>
												<td><?php echo $survey['Terminus Post Quem'] ?></td>
											</tr>
											<tr>
												<td>Excavation Stratigraphy</td>
												<td><?php echo $survey['Excavation Stratigraphy'] ?></td>
											</tr>
											<tr>
												<td>Survey Conditions</td>
												<td><?php echo $survey['Survey Conditions'] ?></td>
											</tr>
											<tr>
												<td>Post Dispositional Transformation</td>
												<td><?php echo $survey['Post Dispositional Transformation'] ?></td>
											</tr>
											<tr>
												<td>Legacy</td>
												<td><?php echo $survey['Legacy'] ?></td>
											</tr>
																					
											</table>
									</div>
											
							<?php } ?>
							<?php } else { ?> 
								<div class="no-data">
									This is a surface find, which doesn’t have associated excavation metadata.
								</div>				
							<?php } ?> 
						
						</div>
						
					</div>	
					
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
				
				
				
					<h3 class="level-tab">Subject of Observation<div class="icon-edit"></div><span>Edit</span></h3>
				
				<div class="level-content">
				
					<div id="tabs-1" class="metadata-content">
					
						<div class="accordion metadata-accordion">
							
							<?php if(count($subject) > 0) { ?>
									<?php $count=0; ?>
									<?php foreach($subject as $subjects) { $count++; ?>		
							
								<h3 class="level-tab smaller">Subject of Observation Section <?php echo $count ?></h3>	
								
									<div class="level-content auto-height">
									
										<table>
											<tr>
												<td>Pages Associator</td>
												<td><?php echo $subjects['Pages Associator'] ?></td>
											</tr>
											<tr>
												<td>Resource Identifier</td>
												<td><?php echo $subjects['Resource Identifier'] ?></td>
											</tr>
											<tr>
												<td>Subject of Observation Associator</td>
												<td><?php echo $subjects['Subject of Observation Associator'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Classification</td>
												<td><?php echo $subjects['Artifact - Structure Classification'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Type</td>
												<td><?php echo $subjects['Artifact - Structure Type'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Terminus Ante Quem</td>
												<td><?php echo $subjects['Artifact - Structure Terminus Ante Quem'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Terminus Post Quem</td>
												<td><?php echo $subjects['Artifact - Structure Terminus Post Quem'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Title</td>
												<td><?php echo $subjects['Artifact - Structure title'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Geolocation</td>
												<td><?php echo $subjects['Artifact - Structure Geolocation'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Excavation Unit</td>
												<td><?php echo $subjects['Artifact - Structure Excavation Unit'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Description</td>
												<td><?php echo $subjects['Artifact - Structure Description'] ?></td>
											</tr>
											<tr>
												<td>Artifact - Structure Location</td>
												<td><?php echo $subjects['Artifact - Structure Location'] ?></td>
											</tr>
																					
											</table>
									</div>
											
							<?php } ?>
							<?php } else { ?> 
								<div class="no-data">
									This resource doesn’t have associated SOO data.
								</div>				
							<?php } ?> 
						
						</div>
						
					</div>	
					
				</div>
				
				
				
				<!-- <h3 class="level-tab">Subject of Observation<div class="icon-edit"></div><span>Edit</span></h3>
				
				<div class="level-content">	
					<div class="no-data">
						<?php foreach($subject as $subjects) {echo $subjects['Resource Identifier'].'<br>'; } ?>
					</div>	
				</div> -->
				
			</div>
			
		</div>
		
		<div id="tabs-2" class="metadata-content">
			
			<p>Notations</p>
			
		</div>
		
		<div id="tabs-3" class="metadata-content">
			<div id="discussionTab">
				<div class="commentContainer"></div>
				<button class="newComment">ADD NEW DISCUSSION</button>
				<form class="newCommentForm"><textarea name="comment" class="commentTextArea" placeholder="Enter text here ..."></textarea><br><button type="submit">SUBMIT</button></form>
			</div>
		</div>
		
		<div id="tabs-4" class="metadata-content">
			
			<p>Instances</p>
			
		</div>
		
	</div>	
		
</div>
</div>

<div id="resources-nav">
    <div id="button-left">
        <a href="#" id="left-button">
            <img src="..arcs/img/Arrow-White.svg" height="220px" width="50px"/>
        </a>
    </div>
    <div id="other-resources-container">
    <div id="other-resources" style="min-width: <?php $length = 220*count($pages); echo "$length";?>px">
        <?php foreach($pages as $r): ?>
            <a href="#">
            <img class="other-resource"
            <img class="other-resource"
                 src="<?php echo $r['thumb'] ?>" height="200px" width="200px"/>
            </a>
        <?php endforeach ?>
    </div>
    </div>
    <div id="button-right">
        <a href="#" id="right-button">
            <img src="../img/Arrow-White.svg" height="220px" width="50px"/>
        </a>
    </div>
</div>

<!-- Give the resource array to the client-side code -->
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	
	$(function() {
		$( ".accordion" ).accordion({
			heightStyle: "fill"
		});
	});
		
	$( '.metadata-accordion' ).height( $( '#viewer-window' ).height() );
	
	$( window ).resize(function() {
		$( '.metadata-accordion' ).height( $( '#viewer-window' ).height() );
	});
</script>

<script>
	// preloader image and images
	var kid = "<?php echo $kid; ?>";
	function GetNewResource(id) {
	  	image = document.getElementById('PageImage')
	  	image.src = '../img/arcs-preloader.gif';
	  	//image.style.height = '100%';
	  	//image.style.width = '100%';
	  	setTimeout(function(){
		    console.log("See the loader? I'm waiting.");
		}, 10000);
		return $.ajax({
		  url: "<?php echo Router::url('/', true); ?>resources/loadNewResource/"+id,
		  type: 'GET',
		  success: function(res) {
			//document.getElementById('PageImage').src = res;
			res = JSON.parse(res);
			kid = res['kid'];
			//console.log(res['kid']);
			document.getElementById('PageImage').src = "<?php echo $kora_url; ?>"+res['Image Upload']['localName'];
		  }
		});
	}
</script>


<script>	
	// flag
	$(function() {
		$( "#flag" ).click(function(){
			$( ".modalBackground" ).show();
		});
		
		$( ".modalClose" ).click(function(){
			$( ".modalBackground" ).hide();
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
	});
</script>

<script>
	// Annotations
	var showAnnotations = true;
    
    $( ".annotationClose" ).click(function(){
        $( ".annotateModalBackground" ).hide();
        ResetAnnotationModal();
    });

	$(".resources-annotate-icon").click(function() {
		if (showAnnotations) {
			$( ".canvas" ).hide();
			showAnnotations = false;
		}
		else {
			$( ".canvas" ).show();
			showAnnotations = true;
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

					//Mouse over annotation
					$(".gen_box").mouseenter(function() {
						ShowAnnotation($(this).attr('id'));
					});

					$(gen_box).append("<div class='deleteAnnotation'>X</div>");
					$(gen_box).append("<div class='flagAnnotation '><div class='icon-flag'></div></div>");

					$(".deleteAnnotation").click(function() {
						$.ajax({
							url: "<?php echo Router::url('/', true); ?>api/annotations/"+$(this).parent().attr("id")+".json",
							type: "DELETE",
							success: function(data) {
								$(gen_box).remove();
							}
						})
					});

					$( ".flagAnnotation" ).click(function(){
						$( ".modalBackground" ).show();
					});
				}
			}
		});
	});

	//Load boxes
	function DrawBoxes(pageKid) {
		$(gen_box).remove();
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
					});

					$(gen_box).append("<div class='deleteAnnotation'>X</div>");
					$(gen_box).append("<div class='flagAnnotation '><div class='icon-flag'></div></div>");

					$(".deleteAnnotation").click(function() {
						$.ajax({
							url: "<?php echo Router::url('/', true); ?>api/annotations/"+$(this).parent().attr("id")+".json",
							type: "DELETE",
							success: function(data) {
								$(gen_box).remove();
							}
						})
					});
				});

				$( ".flagAnnotation" ).click(function(){
					$( ".modalBackground" ).show();
				});

				//Mouse over annotation
				$(".gen_box").mouseenter(function() {
					ShowAnnotation($(this).attr('id'));
				});

				$(".gen_box").mouseleave(function() {
					$(".annotationPopup").remove();
				});
			}
		});
	}

	function ShowAnnotation(id) {
		$.ajax({
			url: "<?php echo Router::url('/', true); ?>api/annotations/"+id+".json",
			type: "GET",
			success: function(data) {
				$(".annotationPopup").remove();
				$("#"+id).append("<div class='annotationPopup'><img class='annotationImage'/><div class='annotationData'></div></div>");
				$(".annotationPopup").css("left", $("#"+id).width()+10);
				if (data.relation_resource_name != "") {
					var paramKid = (data.relation_resource_kid == data.relation_page_kid) ? data.relation_resource_kid : data.relation_page_kid;
					var paramSid = (data.relation_resource_kid == data.relation_page_kid) ? 736 : 738;
					$.ajax({
						url: "<?php echo Router::url('/', true); ?>resources/search?q="+encodeURIComponent(
								"kid,=,"+paramKid)+"&sid="+paramSid,
						type: "POST",
						success: function(page) {
							$(".annotationImage").attr('src', page.results[0].thumb);
							$(".annotationData").append("<p>Relation</p>");
							$(".annotationData").append("<p>Name: "+data.relation_resource_name+"</p>");
							$(".annotationData").append("<p>Type: "+page.results[0].Type+"</p>");
							$(".annotationData").append("<p>Scan #: "+page.results[0]["Scan Number"]+"</p>");
						}
					});
				}

				if (data.transcript != "") {
					$(".annotationData").append("<p>Transcript: "+data.transcript+"</p>");
				}

				if (data.url != "") {
					$(".annotationData").append("<p>URL: "+data.url+"</p>");
				}
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
		//$( ".canvas" ).removeClass("select ui-selectable ui-selectable-disabled");
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
</script>

<script>
	// other resources
    $(document).ready(function() {
        var $item = $('#other-resources a'),
            $pics = $('#other-resources a img'),
            index = 0, //Starting index
            current = 0,
            keys = <?php echo json_encode(array_keys($pages)); ?>,
            visible = 3,
            shift = visible * 220,
            anim = {},
            value = "",
            oldzoom = 1,
            endIndex = <?php $length = count($pages); echo "$length";?> / visible -1;
            
            for(var i=0; i<$pics.length; i++){
                $pics[i].style.borderColor = "#0094BC";
                $pics[i].style.borderStyle = "solid";
                $item[i].onclick = createFunc(i);
            }
            
            $pics[0].style.borderWidth = "5px";
            
        function createFunc(i){
            return function(event){
                    event.preventDefault();
                    $pics[current].style.borderWidth = "0px";
                    current = i;
                    $pics[current].style.borderWidth = "5px";
                    var kid = keys[current];
                    GetNewResource(kid);
                }
        }
        
        $('#button-right').click(function(event){
            event.preventDefault();
            if(index < endIndex ){
                if(index == 0){
                    $('#button-left').css('display', 'block');
                    $('#other-resources-container').css('width', '90%');
                }
                index++;
                visible = 3;
                shift = visible * 220;
                value = "-=" + shift + "px";
                anim['left'] = value;
                $item.animate(anim, "fast");
            }
        });
        
        $('#button-left').click(function(event){
            event.preventDefault();
            if(index > 0){
                index--; 
                if(index == 0){
                    $('#button-left').css('display', 'none');
                    $('#other-resources-container').css('width', '95%');
                }
                visible = 3;
                shift = (visible) * 220;
                value = "+=" + shift + "px";
                anim['left'] = value;
                $item.animate(anim, "fast");
            }
        });
        
        $('#prev-resource').click(function(event){
            event.preventDefault();
            if(current > 0){
                $pics[current].style.borderWidth = "0px";
                current--;
                $pics[current].style.borderWidth = "5px";
                var kid = keys[current];
                GetNewResource(kid);
            }
        });
        
        $('#next-resource').click(function(event){
            event.preventDefault();
            if(current < keys.length-1){
                $pics[current].style.borderWidth = "0px";
                current++; 
                $pics[current].style.borderWidth = "5px";
                var kid = keys[current];
                GetNewResource(kid);
            }
        });
        
        $('#zoom-out').click(function(event){
            event.preventDefault();
            var zoomrange = document.getElementById("zoom-range");
            var image = document.getElementById("PageImage");
            var canvas = $('.canvas');
            var wrapper = document.getElementById("ImageWrapper");
            var zoom, ratio;
            if(zoomrange.value > 1){
                zoomrange.value -= 1;
                zoom = zoomrange.value;
                zoomratio = 10/(11-zoom);
                canvas.css("transform" , "scale(" + zoomratio + ")");
                image.style.transform = "scale(" + zoomratio + ")";
                wrapper.style.left = "0px";
                wrapper.style.top = "0px";
            }
            
            console.log(zoomrange.value);
        });
        
        $('#zoom-in').click(function(event){
            event.preventDefault();
            var zoomrange = document.getElementById("zoom-range");
            var canvas = document.getElementById("canvas");
            var image = document.getElementById("PageImage");
            var zoom;
            if(zoomrange.value < 10){
                zoom = zoomrange.value;
                zoom = Number(zoom) + Number(1); 
                zoomrange.value = zoom;
                zoomratio = 10/(11-zoom);
                canvas.style.transform = "scale(" + zoomratio + ")";
                image.style.transform = "scale(" + zoomratio + ")";
            }
            
            console.log(zoomrange.value);
        });
        
        $('#zoom-range').click(function(event){
            console.log("range click");
            event.preventDefault();
            var zoomrange = document.getElementById("zoom-range");
            var canvas = $('.canvas');
            var image = document.getElementById("PageImage");
            var wrapper = document.getElementById("ImageWrapper");
            var zoom;
            
            zoom = zoomrange.value;
            
            if(oldzoom > zoom){
                wrapper.style.left = "0px";
                wrapper.style.top = "0px";
            }
            
            oldzoom = zoom;
            zoomratio = 10/(11-zoom);
            canvas.css("transform" , "scale(" + zoomratio + ")");
            image.style.transform = "scale(" + zoomratio + ")";
            
            console.log(zoomrange.value);
        });
        
        var jq = document.createElement('script');
        jq.src = "//code.jquery.com/ui/1.11.4/jquery-ui.js";
        document.querySelector('head').appendChild(jq);
        
        jq.onload = drag;
        
        function waitForElement(){
            if($("#PageImage").height() !== 0){
                $(".canvas").height($("#PageImage").height());
                $(".canvas").width($("#PageImage").width());
                $(".canvas").css({left: $("#PageImage").css("left")});
                $(".canvas").css({bottom:$("#PageImage").height()});
                DrawBoxes(kid);
            }
            else{
                setTimeout(function(){
                    waitForElement();
                },250);
            }
        }
        
        
        function drag(){
            $("#ImageWrap").draggable();
            //$("#canvas").draggable({
            //handle: $('#ImageWrap')
            //});
        }
        
    });
</script>


<script>
	var kid = "<?php echo $kid; ?>";
	function GetNewResource(id) {
        //console.log(current);
	  	image = document.getElementById('PageImage')
	  	image.src = '../img/arcs-preloader.gif';
	  	image.style.height = '100%';
	  	image.style.width = '100%';
	  	setTimeout(function(){
		    console.log("See the loader? I'm waiting.");
		}, 10000);
		return $.ajax({
		  url: "<?php echo Router::url('/', true); ?>resources/loadNewResource/"+id,
		  type: 'GET',
		  success: function(res) {
			//document.getElementById('PageImage').src = res;
			res = JSON.parse(res);
			kid = res['kid'];
			//console.log(res['kid']);
			document.getElementById('PageImage').src = "<?php echo $kora_url; ?>"+res['Image Upload']['localName'];
		  }
		});
	}

	var parent;

	function getComments() {
		$.ajax({
			url: "<?php echo Router::url('/', true); ?>api/comments/findall.json",
			type: "POST",
			data: {
				id: "<?php echo $resource['kid']; ?>"
			},
			success: function (data) {
				$(".commentContainer").empty();

				$.each(data, function(index, comment) {
					if (!comment.parent_id) {
						$(".commentContainer").append(
								"<div class='discussionComment' id='" + comment.id + "'>" +
								"<div class='commentName'>" + comment.name + "</div>" +
								"<br>" +
								formatDate(comment.created) +
								"<br>" +
								comment.content +
								"<div class='reply'>Reply</div>" +
								"</div>"
						);
					}
				});

				$.each(data, function(index, comment) {
					if (comment.parent_id) {
						$("#" + comment.parent_id).append(
								"<div class='discussionReply' id='" + comment.id + "'>" +
								"In reply to " + $("#" + comment.parent_id + " > .commentName").html() +
								"<br>" +
								comment.name +
								"<br>" +
								formatDate(comment.created) +
								"<br>" +
								comment.content +
								"</div>");
					}
				});

				$(".reply").click(function () {
					$(".commentTextArea").val("");
					$(this).parent().append($(".newCommentForm"));
					$(".newCommentForm").show();
					$(".newComment").show();
					parent = $(this).parent().attr("id");
				});
			}
		});
	}

	function formatDate(input) {
		var d = new Date(Date.parse(input.replace(/-/g, "/")));
		var month = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
		var date = month[d.getMonth()] + "." + d.getDate() + "." + d.getFullYear();
		return (date);
	}

	$(".discussion").click(function () {
		getComments();
	});

	$(".newComment").click(function () {
		$("#tabs-3").append($(".newCommentForm"));
		$(".commentTextArea").val("");
		$(".newCommentForm").show();
		$(".newCommentForm").removeAttr('style');
		$(".newCommentForm").css("display", "inline");
		$(this).hide();
		parent = null;
	});

	$(".newCommentForm").submit(function (e) {
		e.preventDefault();
		if ($(".commentTextArea").val() != "") {
			$.ajax({
				url: "<?php echo Router::url('/', true); ?>api/comments.json",
				type: "POST",
				data: {
					resource_kid: "<?php echo $resource['kid']; ?>",
					content: $(".commentTextArea").val(),
					parent_id: parent
				},
				success: function (data) {
					$(".commentTextArea").val("");
					$("#tabs-3").append($(".newCommentForm"));
					$(".newCommentForm").hide();
					$(".newComment").show();
					getComments();
				}
			});
		}
	});
</script>
