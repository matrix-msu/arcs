
<script src="<?php  echo Router::url('/', true);  ?>js/vendor/chosen.jquery.js"></script>
<script>
//PAGE GLOBALS
var PROJECTS = <?php echo json_encode($projectsArray);?>;
var SEASONS = <?php echo json_encode($seasons);?>;
var RESOURCES = <?php echo json_encode($resources);?>;
var EXCAVATIONS = <?php echo json_encode($excavations);?>;
var SUBJECTS = <?php echo json_encode($subjects);?>;
var PAGESET = "<?php echo isset($pageSet)? $pageSet : "0";?>";

var showButNoEditArray = <?=json_encode($showButNoEditArray)?>;
var annotationFlags = <?php echo json_encode($flags['annotationFlags']);?>;

var resourceKid = "";
 var ADMIN = 0;
// // preloader image and images
 var JSON_KEYS = {};
  var LEN = 0;
///comments.js variables
var CM_URL = "<?php echo Router::url('/', true); ?>comments/findall"
var CM_R_ID = "<?= !empty($resources)? array_keys($resources)[0] : null?>"
var NEW_COM_URL = "<?php echo Router::url('/', true); ?>api/comments.json"
</script>

<?=  $this->Html->script("views/viewer/Multi/dynamic_accordion.js") ?>
<?=  $this->Html->script("views/viewer/Multi/flag.js") ?>
<?=  $this->Html->script("views/viewer/Multi/accordion.js") ?>
<!-- <?=  $this->Html->script("views/viewer/Multi/details.js")  ?> -->
<?=  $this->Html->script("views/viewer/Multi/resources.js")  ?>
<?=  $this->Html->script("views/viewer/Multi/newResource.js")  ?>
<?=  $this->Html->script("views/viewer/Multi/export.js")  ?>
<?=  $this->Html->script("views/viewer/Multi/keyword.js")  ?>

<?=  $this->Html->script("views/viewer/Multi/annotation.js") ?>
<?=  $this->Html->script("views/viewer/Multi/slider_helpers.js") ?>
<?=  $this->Html->script("views/viewer/Multi/edit_metadata.js") ?>
<?=  $this->Html->script("views/viewer/Multi/collection.js") ?>
<?=  $this->Html->script("views/viewer/Multi/comments.js") ?>
<?=  $this->Html->script("views/viewer/Multi/scroll_bar.js") ?>


<div class="viewers-container">

    <div class="flagModalBackground">
        <div class="flagWrap">
            <div id="flagModal">
                <div class="flagModalHeader">NEW FLAG
                    <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" class="modalClose flagModalClose"/>
                </div>
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
                        <option value="Incoming Relation">Incoming Relation</option>
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
							<img class='leftExpandedArrow' src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" height="220px" width="10px" />
						</div>

					</div>
					<div class="rightHalf">
						<div class='expandedArrowBoxRight'>
							<img class='rightExpandedArrow' src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" height="220px" width="10px" />
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
                    <form class="annotateSearchForm">
                        <input class="annotateSearch" placeholder="SEARCH"/>
                    </form>
                    <div class="resultsContainer"></div>
                    <div class="annotation_pagination">
                        <span class="annotation_begin"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg"></span>
                        <span class="annotation_prev"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg"></span>
                        <span class="annotation_numbers"></span>
                        <span class="annotation_next"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg"></span>
                        <span class="annotation_end"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg"></span>
                    </div>
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
                <div class="collectionModalHeader">Add to Collection
                    <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" class="modalClose collectionModalClose"/>
                </div>
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
                <div class="collectionModalHeader">ADDED TO COLLECTION!
                    <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" class="modalClose collectionModalClose"/>
                </div>
                <hr>
                <div id="collectionMessage" style="margin-left:6px;">1 resource added to <p id="collectionName" style="display:inline;color:#4899CF"></p>.</div>
                <br>
                <div id="collectionWarning" style="margin-left:6px;"></div>
                <br>
                <a id="viewCollectionLink" ><button class="viewCollection" type="submit">VIEW COLLECTION</button></a>
                <button class="backToSearch" type="submit">BACK TO RESOURCE</button>
            </div>
        </div>
    </div>

    <div class="associatorModalBackground">
            <div class="collectionWrap" id="associatorSelectModal" style="margin-top:9em;">
                <div id="collectionModal" style="width:35em;">
                    <div class="collectionModalHeader">
                        <p id="associatorTitle" style='display:inline-block'>Add Associators</p>
                        <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" id="modalCloseAssociatorSelect" class="modalCloseAssociator"/>
                    </div>
                    <hr>
                    <div class="collectionSearchContainer">
                        <form id="associatorSearchBarForm" onsubmit="event.preventDefault();">
                            <input id="associatorSearchInput" type="text" class="associatorSearchBar first" placeholder="Search for records by exact KID values">
                        </form>
                        <div id="associatorSearchForm">
                            <div id="associatorSearchObjects">
                            </div>
                            <div class="associator_pagination" style="display: block;cursor:default;">
                            	<span class="associator_begin" style="display: inline;cursor:pointer;">
                            	    <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg">
                            	    <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg" style="margin-right:10px;">
                                </span>
                            	<span class="associator_prev" style="display: inline;cursor:pointer;">
                            	    <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg" style="margin-right:3px;">
                                </span>
                            	<span class="associator_numbers">

                            	</span>
                            	<span class="associator_next" style="display: inline;cursor:pointer;">
                            		<img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" style="margin-left:3px;">
                            	</span>
                            	<span class="associator_end" style="display: inline;cursor:pointer;">
                            		<img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" style="margin-left:10px;">
                            		<img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg">
                            	</span>
                            </div>
                            <button class="associatorSearchSubmit" id="associatorSearchSubmitFirst">SAVE ASSOCIATORS</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collectionWrap" id="associatorSubmitConfirm" style="margin-top:9em;display:none;">
                <div id="collectionModal" style="width:35em;">
                    <div class="collectionModalHeader">
                        <p id="associatorTitle" style='display:inline-block'></p>
                        <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" id="closeAssociatorConfirm" class="modalCloseAssociator"/>
                    </div>
                    <hr>
                    <p id="associatorTitle" style='text-align: center;vertical-align: middle;'>Are you sure you want to save the following associators?</p>
                    <p id="associatorsToSubmit" style="text-align: center;vertical-align: middle;"></p>
                    <button class="associatorSearchSubmit" id="associatorSearchSubmitConfirm">CONFIRM SUBMISSION</button>
                </div>
             </div>
        </div>

    <div id="viewer-left">
        <div id="viewer-tools">
            <div class="container1">
                <h3><?php  ?> </h3>

                <div class="tools" style="visibility:hidden;" >
                    <a id="collection-modal-btn" href="#">
                                        <span class="content">
                                                Add To Collection
                                        </span>
                        <div class="icon-collection"></div>
                    </a>

                    <a id="annotate-new-btn" class="annotate" style="cursor:pointer">
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
                <img src="<?php ?> " id="PageImage">
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
                  <div class="accordion metadata-accordion" style="width:100%;">
                    <?= $this->element("Metadata/generate"); ?>
                    <?php
                        $metadataFlags = $flags['metadataFlags'];
                        Generate_Metadata("project",$projectsArray,$metadataEdits,$metadataEditsControlOptions,$metadataFlags);
                        Generate_Metadata("Seasons",$seasons,$metadataEdits,$metadataEditsControlOptions,$metadataFlags);
                        Generate_Metadata("excavations",$excavations,$metadataEdits,$metadataEditsControlOptions,$metadataFlags);
                        Generate_Metadata("archival objects",$resources,$metadataEdits,$metadataEditsControlOptions,$metadataFlags);
                        Generate_Metadata("subjects",$subjects,$metadataEdits,$metadataEditsControlOptions,$metadataFlags);
                    ?>
                  </div>
                </div>
              </div>


            <div id="tabs-2" class="metadata-content" style="display:none;">
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

                    <h3 class="level-tab" id="keyword-tab">Keywords<span id="keyword-edit-btn" class="keyword-edit-btn">Edit</span></h3>

                    <div class="level-content">
                        <p id="keyword-text" style="text-transform:none;padding-left:11px;padding-top:16px;">Enter keywords below. Use commas to seperate keywords.</p>
                        <form class="keywords-uploadForm" id="urlform" method="post" enctype="multipart/form-data"></form>
                        <div id="keyword-search-links" style="width:90%;margin-left:auto;margin-right:auto;"></div>

                        <p id="keyword-common" style="text-transform:none;padding-left:11px;padding-top:20px;">
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

            <div id="tabs-3" class="metadata-content" style="display:none;">
                <div id="discussionTab">
                    <div class="commentContainer"></div>

                    <div class="submitContainer">
                        <button class="newComment">ADD NEW DISCUSSION</button>

                        <form class="newCommentForm"><textarea name="comment" class="commentTextArea"
                                                               placeholder="Enter discussion here ..."></textarea><br>
                            <button type="submit">ADD NEW DISCUSSION</button>

                        </form>

                        <form class="newReplyForm"><textarea name="comment" class="replyTextArea"
                                                             placeholder="Enter reply here..."></textarea><br>
                            <button type="submit">ADD NEW REPLY</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>
</div>
<div id="resources-nav" class="pages-resource-nav" style="display:none;">
    <div class="button-left" id="button-left">
        <a id="left-button">
            <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg" height="110px" width="10px">
        </a>
    </div>

    <div id="other-resources-container" class = "page-slider" >
        <div id="other-resources" class = "other-page" style="min-width:  px">
              <?php
              $cnt = 0;

              foreach($resources as $r){


                  $page = $r['page'];

                  foreach ($page as $p) {

                      $img = isset($p['Image Upload']['localName']) ? $p['Image Upload']['localName'] : "";
                      echo "<a class = 'other-resources' id = '".$r['kid']."'><img class = 'other-resource'";
                      if(isset($p['kid'])) {
                          echo "id = '" . $p['kid'] . "'";
                      }
                      else {
                          // When we don't have a page, it sets id to resource_kid-default-page
                          // For setting pageImage in newResource.js
                          echo "id = '" . $r['kid'] . "-default-page'";
                      }
                      echo "src = '" . AppController::smallThumb($img) . "'  />";
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
          <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" height="110px" width="10px">
      </a>
  </div>
</div>

<div id="scroll" class="scroll">
    <div id="scrollLine" class="scroll-line ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
        <span id="scroll-handle" class="ui-slider-handle ui-state-default ui-corner-all">
        </span>
    </div>
</div>

<div id="resources-nav" class = "resource-nav-level top-border" style="display:none;">

    <div class="button-left" id="button-left">
        <a  id="left-button">
            <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg" height="110px" width="10px" />
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
        <a class='other-resources' data-projectKid="<?=$r['project_kid']?>" >

            <img id="identifier-<?=$r['kid']?>" class="other-resource<?php if ( in_array($r['kid'], $showButNoEditArray) ){echo ' showButNoEdit'; }  ?>"
                src="<?php echo AppController::smallThumb($p); ?> " height="200px"/>

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
        <img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" height="110px" width="10px" />
    </a>
</div>
</div>

<div id="scroll2" class="scroll" style="background-color: #D2D2D2;">
    <div id="scrollLine2" class="scroll-line ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
    <span id="scroll-handle2" class="ui-slider-handle ui-state-default ui-corner-all">
    </span>
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

$('#soo').ready(function(){
    $('.selectedCurrentPage').find('img')[0].click();
});

</script>
