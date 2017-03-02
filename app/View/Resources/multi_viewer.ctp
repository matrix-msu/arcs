

<script src="<?php  echo Router::url('/', true);  ?>js/vendor/chosen.jquery.js"></script>
<script>
//PAGE GLOBALS
var PROJECTS = <?php echo json_encode($projects);?>;
var SEASONS = <?php echo json_encode($seasons);?>;
var RESOURCES = <?php echo json_encode($resources);?>;
var EXCAVATIONS = <?php echo json_encode($excavations);?>;
var SUBJECTS = <?php echo json_encode($subjects);?>;

var resourceKid = "";//"<?php  ?> ";
 var ADMIN = 0;//"<?php  ?> ";
// var kora_url = "<?php  ?> ";
// // preloader image and images
// var kid = "<?php  ?> "; // needs to stay
// var resourceName = "<?php  ?> ";
 var JSON_KEYS = {};//<?php  ?> ;
  var LEN = 0;<?php // $length = count($pages); echo "$length";  ?> ;
// var SCHEMES = ['<?php  ?> ',
//                 '<?php  ?> ',
//                 '<?php  ?> ',
//                 '<?php  ?> '];
// var SUBJECTS = [ <?php  ?>  ];
// var PAGES = [ <?php  ?>  ];
//
 //var PAGESOBJECT = <?php  ?> ;
// var PROJECT_KID = "<?php  ?> "
</script>
<?php
//var_dump($resources);

?>
<!-- <?=  $this->Html->script("views/viewer/Multi/flag.js") ?> -->
<?=  $this->Html->script("views/viewer/Metadata/accordion.js") ?>
<?=  $this->Html->script("views/viewer/Multi/temp_file.js") ?>
<?=  $this->Html->script("views/viewer/Multi/collection.js")  ?>
<!-- <?=  $this->Html->script("views/viewer/Multi/details.js")  ?> -->
<?=  $this->Html->script("views/viewer/Multi/resources.js")  ?>
<?=  $this->Html->script("views/viewer/Multi/newResource.js")  ?>
<?=  $this->Html->script("views/viewer/Multi/export.js")  ?>
<?=  $this->Html->script("views/viewer/Multi/keyword.js")  ?>


<div class="viewers-container">

    <div class="modalBackground">
        <div class="flagWrap">
            <div id="flagModal">
                <div class="flagModalHeader">NEW FLAG <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"
                                                           class="modalClose"/></div>
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
                    <p class="formError targetError">Give a target for this annotation.</p>
                    <select class="formInput" id="flagTarget">
                        <option value="">SELECT TARGET</option>
                        <option value="Outgoing Relation">Outgoing Relation</option>
                        <option value="Transcript">Transcript</option>
                        <option value="URL">URL</option>
                    </select>
                    <p class="formError explanationError">Give an explanation for this flag.</p>
                    <textarea class="formInput" id="flagExplanation" placeholder="EXPLAIN REASONING"></textarea>
                    <input id="flagAnnotation_id"/>

                    <button class="flagSubmit" type="submit">CREATE FLAG</button>
                </form>
            </div>
        </div>

    </div>

	<div class="deleteWrap">
		<div id="deleteModel">
			<div class="deleteModalHeader"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"class="deleteModalClose"/></div>
			<div class="deleteBody"> Are you sure you want to delete this annotation?</div>
			<div class="deleteFooter">
				<div class='deleteCancel'>cancel</div>
				<div class='deleteButton'>Delete</div>
			</div>
		</div>
	</div>

	<div class='fullscreenWrap'>
		<div class='fullscreenOverlay'>
			<div class='fullscreenOuter'>
				<div class='fullscreenInner'>
					<img id='fullscreenImage' class='fullscreenImage' src='http://kora.matrix.msu.edu/files/123/738/7B-2E2-1A-90-72-HEX-001-040.jpeg'>
				    <div class='leftHalf'>
						<div class='expandedArrowBoxLeft'>
							<img class='leftExpandedArrow' src="/<?php echo BASE_URL; ?>img/arrowRight-White.svg" height="220px" width="10px" />
						</div>

					</div>
					<div class="rightHalf">
						<div class='expandedArrowBoxRight'>
							<img class='rightExpandedArrow' src="/<?php echo BASE_URL; ?>img/arrowRight-White.svg" height="220px" width="10px" />
						</div>

					</div>
				</div>
			</div>
			<div class='fullscreenTitle' style="display:none;">
				<span class='titleText'>Test.jpg</span>
			</div>

			<div class='fullscreenClose'>
				<img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"class="closeExpand"/>
			</div>
		</div>
	</div>

    <div class="annotateModalBackground">
        <div class="annotateWrap">
            <div id="annotateModal">
                <div class="annotateModalHeader">NEW ANNOTATION<img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"
                                                                    class="modalClose annotationClose"/></div>
                <hr class="annotateHeaderDivider">
                <p class="annotateTab annotateTabRelation activeTab">RELATION</p>
                <!--<p class="annotateTab annotateTabTranscript">TRANSCRIPT</p>-->
                <p class="annotateTab annotateTabUrl">URL</p>
                <div class="annotateRelationContainer">
                    <form class="annotateSearchForm" action="#">
                        <input class="annotateSearch" placeholder="SEARCH"/>
                    </form>
                    <div class="resultsContainer"></div>
                </div>
                <!--<div class="annotateTranscriptContainer">-->
                    <!--<textarea class="annotateTranscript" placeholder="ENTER TRANSCRIPT"></textarea>-->
                <!--</div>-->
                <div class="annotateUrlContainer">
                    <textarea class="annotateUrl" placeholder="ENTER URL"></textarea>
                </div>
                <button class="annotateSubmit" type="submit">CREATE ANNOTATION</button>
            </div>

        </div>
    </div>

    <div class="collectionModalBackground">
        <div class="collectionWrap" style="margin-top:9em;">
            <div id="collectionModal" style="width:35em;">
                <div class="collectionModalHeader">Add to Collection <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"
                                                                          class="modalClose"/></div>
                <hr>
                <p class="collectionTab collectionTabSearch activeTab" style="margin-left:.6em;">Search</p>
                <p class="collectionTab collectionTabNew">Add to a new collection</p>
                <div class="collectionSearchContainer">
                    <form id="collectionSearchBarForm" onsubmit="collectionsSearch(); return false;">
                        <input type="text" class="collectionSearchBar first" placeholder="Search for collections">
                    </form>
                    <div id="collectionSearchForm">
                        <div id="collectionSearchObjects">
                        </div>
                        <button class="collectionSearchSubmit">ADD TO COLLECTION</button>
                    </div>
                </div>
                <div class="collectionNewContainer">
                    <div id="collectionNewForm">
                        <textarea class="formInput" id="collectionTitle"
                                  placeholder="ENTER NEW COLLECTION TITLE"></textarea>
                        <button class="collectionNewSubmit">ADD TO NEW COLLECTION</button>
                    </div>
                </div>
            </div>
            <div id="addedCollectionModal" style="width:35em;display:none;">
                <div class="collectionModalHeader">ADDED TO COLLECTION! <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"
                                                                          class="modalClose"/></div>
                <hr>
                <div>1 resource added to <p id="collectionName" style="display:inline;color:#4899CF"></p>!</div>
                <br>
                <button class="viewCollection" type="submit">VIEW COLLECTION</button>
                <button class="backToSearch" type="submit">BACK TO RESOURCE</button>
            </div>
        </div>
    </div>

    <div class="associatorModalBackground">
            <div class="collectionWrap" style="margin-top:9em;">
                <div id="collectionModal" style="width:35em;">
                    <div class="collectionModalHeader">
                        <p id="associatorTitle" style='display:inline-block'>Add Associators</p>
                        <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" class="modalCloseAssociator"/>
                    </div>
                    <hr>
                    <!-- p class="collectionTab collectionTabSearch activeTab" style="margin-left:.6em;">Search</p>
                    <p class="collectionTab collectionTabNew">Add to a new collection</p -->
                    <div class="collectionSearchContainer">
                        <form id="associatorSearchBarForm" onsubmit="associatorSearch(); return false;">
                            <input type="text" class="associatorSearchBar first" placeholder="Search for records by exact KID values">
                        </form>
                        <div id="associatorSearchForm">
                            <div id="associatorSearchObjects">
                            </div>
                            <button class="associatorSearchSubmit">SAVE ASSOCIATORS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div id="viewer-left">
        <div id="viewer-tools">
            <div class="container1">
                <h3><?php  ?> </h3>

                <div class="tools">
                    <a id="collection-modal-btn" href="#">
                                        <span class="content">
                                                Add To Collection
                                        </span>
                        <div class="icon-collection"></div>
                    </a>

                    <a id="annotate-new-btn" class="annotate" href="#">
                                        <span class="content">
                                                Annotate
                                        </span>
                        <div class="icon-annotate"></div>
                    </a>

                    <!--<a id="flag" href="#">-->
                    <!--<span class="content">-->
                    <!--Flag-->
                    <!--</span>-->
                    <!--<div class="icon-flag"></div>-->
                    <!--</a>-->

                    <a id="export-btn" href="#">
                                        <span class="content">
                                                Export
                                        </span>
                        <div class="icon-export"></div>
                    </a>
                </div>
            </div>
        </div>

        <div id="viewer-window">

            <div class="annotateHelp">Click and drag to outline the area you would like to annotate.
                <div class="annotationHelpOk">OK</div>
            </div>
            <div id="ImageWrap">
                <img src="<?php  ?> " id="PageImage">
                <div id="canvas" class='canvas'></div>
            </div>
        </div>

        <?= $this->element("resourceTool") ?>
    </div>

    <div id="viewer-right" style="position:relative;">


          <div id="tabs" class="metadata">
              <ul class="metadata-tabs">
                  <li class="metadata-tab"><a href="#tabs-1">Metadata</a></li>
                  <li class="metadata-tab details"><a href="#tabs-2">Details</a></li>
                  <li class="metadata-tab discussion"><a href="#tabs-3">Discussions</a></li>
              </ul>
              <div id="tabs-1" class="metadata-content">
                  <div class="accordion metadata-accordion">
                <?= $this->element("Metadata/generate"); ?>
                <?php
                    Generate_Metadata("project",$projects, $metadataEdits);
                    Generate_Metadata("Seasons",$seasons, $metadataEdits);
                    Generate_Metadata("excavations",$excavations, $metadataEdits);
                    Generate_Metadata("archival objects",$resources, $metadataEdits);
                    Generate_Metadata("subjects",$subjects, $metadataEdits);
                ?>
                </div>
              </div>


            <div id="tabs-2" class="metadata-content">
                <div class="accordion metadata-accordion">
                    <h3 class="level-tab transcriptionTab">
                        Transcriptions
                        <div class="editTranscriptions">Edit</div>
                        <div class="editOptions">
                            <div class="newTranscription">Add New</div>
                            <div class="saveTranscription">Save</div>
                        </div>
                    </h3>

                    <div class="level-content">
                        <div class="content_transcripts"></div>
						<div class="editInstructions">			Drag and drop transcriptions to reorder them.</div>
                        <form class="newTranscriptionForm">
                            <textarea name="transcript" class="transcriptionTextarea" placeholder="Enter New Transcription Here..."></textarea><br>
                            <button type="submit">SUBMIT NEW TRANSCRIPTION</button>
                        </form>
                    </div>

                    <h3 class="level-tab">Annotations</h3>

                    <div class="level-content content_annotations">
						<div class="outgoing_relations">
							<h4 class="annotationLabel">Outgoing Relations</h4>
						</div>
						<div class="incoming_relations">
                            <h4 class="annotationLabel">Incoming Relations</h4>
						</div>
						<div class="urls">
                            <h4 class="annotationLabel">URLs</h4>
						</div>
                    </div>

                    <h3 class="level-tab">Keywords</h3>

                    <div class="level-content">
                        <p style="text-transform:none;padding-left:11px;padding-top:16px;">Enter keywords below. Use commas to seperate keywords.</p>
                        <form class="keywords-uploadForm" id="urlform" method="post" enctype="multipart/form-data"></form>

                        <p style="text-transform:none;padding-left:11px;padding-top:20px;">
                            Commonly used keywords are featured below. Select any to add to the keyword list above.
                        </p>
                        <form class="keywords-uploadForm2" id="urlform2" method="post" enctype="multipart/form-data"></form>

                    </div>

                    <h3 class="level-tab" id="collections_tab">Collections</h3>

                    <div class="level-content">
                        <div id="collections_table"></div>
                    </div>
                </div>
            </div>

            <div id="tabs-3" class="metadata-content">
                <div id="discussionTab">
                    <div class="commentContainer"></div>

                    <div class="submitContainer">
                        <button class="newComment">ADD NEW DISCUSSION</button>

                        <form class="newCommentForm"><textarea name="comment" class="commentTextArea"
                                                               placeholder="Enter discussion here ..."></textarea><br>
                            <button type="submit">ADD NEW DISCUSSION</button>
                            <?php  ?>
                        </form>

                        <form class="newReplyForm"><textarea name="comment" class="replyTextArea"
                                                             placeholder="Enter reply here..."></textarea><br>
                            <button type="submit">ADD NEW REPLY</button>
                            <?php  ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>
</div>
<div id="resources-nav">
    <div class="button-left" id="button-left">
        <a id="left-button">
            <img src="/<?php echo BASE_URL; ?>img/arrowLeft-White.svg" height="220px" width="10px">
        </a>
    </div>

    <div id="other-resources-container" class = "page-slider" >
        <div id="other-resources" class = "other-page" style="min-width:  px">
              <?php
              $cnt = 0;
              foreach($resources as $r){
                  $page = $r['page'];

                  foreach ($page as $p) {

                      $img = isset($p['Image Upload']['localName'])?
                      $p['Image Upload']['localName'] : "";
                      echo "<a class = 'other-resources' id = '".$r['kid']."'><img class = 'other-resource' id = '".$p['kid']."' src = '" . AppController::smallThumb($img) . "'  />";
                      echo "<div  class='numberOverResources'>";
                      echo ++$cnt;
                      echo "</div></a>";
                  }
              }
              ?>
            </div>
    </div>



  <div class="button-right" id="button-right">
      <a  id="right-button">
          <img src="/<?php echo BASE_URL; ?>img/arrowRight-White.svg" height="220px" width="10px">
      </a>
  </div>
</div>
<div id="resources-nav" class = "resource-nav-level top-border">

    <div class="button-left" id="button-left">
        <a  id="left-button">
            <img src="/<?php echo BASE_URL; ?>img/arrowLeft-White.svg" height="220px" width="10px" />
        </a>
    </div>

    <div id="other-resources-container" class = "resource-container-level">
        <div id="other-resources" class="resource-slider" style="position:relative;">
          <span class="p-select">
            <div class="select-pointer pointer-border"></div>
            <div class="select-pointer"></div>
          </span>

		<?php  $cnt = 0; ?>
        <?php  foreach($resources as $r):  ?>
		<?php  $cnt++; ?>
        <?php

            $p = $r['page'];
            $p = isset(array_values($p)[0]['Image Upload']['localName'])?
            array_values($p)[0]['Image Upload']['localName'] : "";
         ?>
        <a class='other-resources' href="#" data-projectKid="<?=$r['project_kid']?>" >

            <img id="identifier-<?=$r['kid']?>" class="other-resource" src="<?php echo AppController::smallThumb($p); ?> " height="200px"/>
			<?php if ($cnt ==1) :  ?>
				<div class='numberOverResources selectedResource'>
					<?php  echo $cnt;   ?>
				</div>
			<?php  endif   ?>
			<?php if ($cnt !=1) : ?>
				<div class='numberOverResources'>
					<?php  echo $cnt;   ?>
				</div>
			<?php endif  ?>
        </a>

        <?php  endforeach   ?>
    </div> <!--#other-resources-contain -->
</div> <!--#other-resources-container -->


<div class="button-right" id="button-right">
    <a id="right-button">
        <img src="/<?php echo BASE_URL; ?>img/arrowRight-White.svg" height="220px" width="10px" />
    </a>
</div>
</div>



<script>

//update the toolbar page urls with project.

//get project name
var pName = $('#project1').find("[id='Persistent Name']").html();
pName = pName.replace(/ /g, '_').toLowerCase();

//add the project kid to the resources url.
var href = $('#resources').attr('href');
href = href.split('/'); href.pop(); href = href.join('/');
var href = href+'/'+pName;
$('#resources').attr('href', href);

//add project kid to the collections url.
var href = $('#collections').attr('href');
href = href.split('/'); href.pop(); href = href.join('/');
var href = href+'/'+pName;
$('#collections').attr('href', href);

//add project kid to the search url.
var href = $('#search').attr('href');
href = href.split('/'); href.pop(); href = href.join('/');
var href = href+'/'+pName;
$('#search').attr('href', href);

</script>
