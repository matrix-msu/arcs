
<script src="<?php  echo Router::url('/', true);  ?>js/vendor/chosen.jquery.js"></script>
<script>
//PAGE GLOBALS
var PROJECTS = <?php echo json_encode($projectsArray);?>;
var SEASONS = <?php echo json_encode($seasons);?>;
var RESOURCES = <?php echo json_encode($resources);?>;
var EXCAVATIONS = <?php echo json_encode($excavations);?>;
var SUBJECTS = <?php echo json_encode($subjects);?>;
var PAGESET = "<?php echo isset($pageSet)? $pageSet : "0";?>";
//console.log(PROJECTS);
var showButNoEditArray = <?=json_encode($showButNoEditArray)?>;
var annotationFlags = <?php echo json_encode($flags['annotationFlags']);?>;
var controllerFlags = <?php echo json_encode($flags);?>;
var controllerMetadataEdits = <?php echo json_encode($metadataEdits);?>;
var controllerMetadataOptions = <?php echo json_encode($metadataEditsControlOptions);?>;

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
<?=  $this->Html->script("views/viewer/Multi/metadataLoad.js") ?>


<?php
$totalNumResources = 1;
if( $multiInfo !== 0 &&
    isset($_SESSION['multi_viewer_resources']) &&
    isset($_SESSION['multi_viewer_resources'][$multiInfo])
){
    $totalNumResources = count($_SESSION['multi_viewer_resources'][$multiInfo]);
}
?>

<div class="viewers-container">

    <div class="flagModalBackground">
        <div class="flagWrap">
            <div id="flagModal">
                <div class="flagModalHeader">NEW FLAG
                    <img alt='close' src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" class="modalClose flagModalClose"/>
                </div>
                <hr>
                <form id="flagForm" action="/">
                    <p class="flagSuccess">Flag submitted successfully! Your flag will now be reviewed by an administrator and action will be taken accordingly. Thank you for helping us improve this project.</p>
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
			<div class="deleteModalHeader"><img alt="close" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"class="deleteModalClose"/></div>
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
				                <img alt="full screen" id='fullscreenImage' class='fullscreenImage' src=''>
				    <div class='leftHalf'>
						<!-- <div class='expandedArrowBoxLeft'>
							<img class='leftExpandedArrow' src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" height="220px" width="10px" />
						</div>

					</div>
					<div class="rightHalf">
						<div class='expandedArrowBoxRight'>
							<img class='rightExpandedArrow' src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" height="220px" width="10px" />
						</div> -->

					</div>
				</div>
			</div>
			<div class='fullscreenTitle' style="display:none;">
				<span class='titleText'>Test.jpg</span>
			</div>

			<div class='fullscreenClose'>
				<img alt="close full screen"src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"class="closeExpand"/>
			</div>
		</div>
	</div>

    <div class="annotateModalBackground">
        <div class="annotateWrap">
            <div id="annotateModal">
                <div class="annotateModalHeader">NEW ANNOTATION<img alt="close" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"
                                                                    class="modalClose annotationClose"/></div>
                <hr class="annotateHeaderDivider">
                <p class="annotateTab annotateTabRelation activeTab">RELATION</p>
                <!--<p class="annotateTab annotateTabTranscript">TRANSCRIPT</p>-->
                <p class="annotateTab annotateTabUrl">URL</p>
                <div class="annotateRelationContainer">
                    <form class="annotateSearchForm">
                        <input class="annotateSearch" placeholder="SEARCH FOR A RESOURCE TO RELATE TO"/>
                    </form>
                    <div class="resultsContainer"></div>
                    <div class="annotation_pagination">
                        <span class="annotation_begin"><img alt="left-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg"></span>
                        <span class="annotation_prev"><img alt="left-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg"></span>
                        <span class="annotation_numbers"></span>
                        <span class="annotation_next"><img alt="right-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg"></span>
                        <span class="annotation_end"><img alt="right-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg"></span>
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
                    <img alt="close"src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" class="modalClose collectionModalClose"/>
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
                    <img alt="close" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" class="modalClose collectionModalClose"/>
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
                        <img alt="close"src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" id="modalCloseAssociatorSelect" class="modalCloseAssociator"/>
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
                            	    <img alt="left-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg">
                            	    <img alt="left-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg" style="margin-right:10px;">
                                </span>
                            	<span class="associator_prev" style="display: inline;cursor:pointer;">
                            	    <img alt="left-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg" style="margin-right:3px;">
                                </span>
                            	<span class="associator_numbers">

                            	</span>
                            	<span class="associator_next" style="display: inline;cursor:pointer;">
                            		<img alt="right-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" style="margin-left:3px;">
                            	</span>
                            	<span class="associator_end" style="display: inline;cursor:pointer;">
                            		<img alt="right-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" style="margin-left:10px;">
                            		<img alt="right-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg">
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
                        <img alt="close"src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg" id="closeAssociatorConfirm" class="modalCloseAssociator"/>
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
            <div class="annotateHelp">Click and drag to outline the area you would like to annotate.
                <div class="annotationHelpOk">OK</div>
                <div class="annotateDontShowAgain">Don't Show Again</div>
            </div>
            <div class="container1">
                <h3 id="res-header"> </h3>
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

		<div id="export-btn" style="display:inline-block">
			<div id="options-buttons" class="btn-group actions-right">
				<div id="export-data-buttons" class="filter-btn btn-group opacitied" style="float:left;opacity:.2">
					<button id="options-btn" class="btn dropdown-toggle" data-toggle="dropdown" style="display:block;background-color:inherit;border:none;box-shadow:none;-webkit-box-shadow:none">
						<span class="content" id="multi-export-btn">
							EXPORT
							<span class="pointerDown sort-arrow pointerSearch" style="top:inherit;transform:rotate(135deg);"></span>
						</span>
					</button>
					<ul class="dropdown-menu" id="export-resources-per" style="top:57px;left:13px;max-height:none;padding-left:4px;padding-right:4px;display:none">
						<li><a class="sort-btn export-data-num" data-num="50" id="export-data-50">50 RESOURCES/ZIP</a></li>
						<li><a class="sort-btn export-data-num" data-num="100" id="export-data-100">100 RESOURCES/ZIP</a></li>
						<li><a class="sort-btn active export-data-num" id="export-data-all">ALL RESOURCES/ZIP</a></li>
						<hr>
						<!--li><a class="sort-btn active export-data-type" id="export-as-xml">XML</a></li>
						<li><a class="sort-btn export-data-type">JSON</a></li>
						<hr -->
						<li><a class="sort-btn export-data-link" data-pack="1">DATA PACK 1</a></li>
					</ul>
				</div>
				<div id="export-images-buttons" class="filter-btn btn-group opacitied" style="display:none">
					<button class="export-options" id="export-images-btn" href="#" style="padding-right:0">
						<span class="content">
							IMAGES
							<span class="pointerDown sort-arrow pointerSearch" style="top:inherit;transform:rotate(135deg);"></span>
						</span>
					</button>
					<ul class="dropdown-menu" id="export-images-per"  style="top:57px;left:-253px;max-height:none">
						<li><a class="sort-btn export-image-num" data-num="20" id="export-image-20">20 IMAGES/ZIP</a></li>
						<li><a class="sort-btn active export-image-num" data-num="30" id="export-image-30">30 IMAGES/ZIP<i class="icon-ok"></i></a></li>
						<li><a class="sort-btn export-image-num" data-num="40" id="export-image-40">40 IMAGES/ZIP</a></li>
						<li><a class="sort-btn export-image-num" id="export-image-all">ALL IMAGES/ZIP</a></li>
						<hr>
					</ul>
				</div>
                <div id="export-modal" class="filter-btn btn-group" style="display:none">
                    <ul class="dropdown-menu" style="margin:0;top:58px;left:-376px;width:397px!important;line-height:normal">
                        <li><br>
<p id="export-modal-title" style="display:inline">EXPORT</p> SELECTED RESOURCES
<img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/ClearText.svg" class="modalClose exportModalClose new-open" style="margin-top:-3px"/>
<hr>
<div id="export-modal-explain">
<p class="sort-btn" style="white-space:pre;margin-top:-19px;line-height:19px">
Exports are split into a series of zip files that contain the data
and images for the selected Resources.
The data zip file exports before the images zip file(s).
Select your data export format: <a class="sort-btn active export-data-type" id="export-as-xml">XML</a> | <a class="sort-btn export-data-type">JSON</a>
</p>
<hr>
<a class="sort-btn active" id="export-automatic" style="margin-bottom:10px">START DOWNLOAD<br></a><br>
</div>
                        <p class="sort-btn" style="white-space:pre;display:none;margin-top:-19px;line-height:19px;margin-bottom:0" id="export-modal-exporting">
Your export could take a little while.
You are downloading <span class="export-rem-data" style="margin:0"><?=$totalNumResources?></span> records and <span class="export-rem-images" style="margin:0">TBD</span> images,
which will be exported in a series of zip files.

Records --- Downloaded: <span class="export-downed-data">0</span> | Remaining: <span class="export-rem-data export-rem-decreasing-data"><?=$totalNumResources?></span>
Images ---- Downloaded: <span class="export-downed-images">0</span> | Remaining: <span class="export-rem-images export-rem-decreasing-images">TBD</span>
                        </p></li>
                    </ul>
                </div>
			</div>
		</div>


                </div>
            </div>
        </div>

        <div id="viewer-window">


            <div id="ImageWrap" class="canvasGrabCursor">
                <img alt="page" src="<?php ?> " id="PageImage">
                <div id="PageImagePreloader" style="display:none;height:100%;display:flex;align-items:center;">
                    <?php echo ARCS_LOADER_HTML; ?>
                </div>
                <div>
                    <div id="canvas" class='canvas'><div id="missingPictureIcon">
                            <p>NOTIFY ADMIN OF MISSING IMAGE</p>
                            <img alt="missing image" src="/<?php echo BASE_URL?>app/webroot/img/camera-off.svg" />
                        </div></div>

                </div>
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
                    Generate_Metadata("excavations",$excavations,$metadataEdits,$metadataEditsControlOptions,$metadataFlags,$seasons);
                    Generate_Metadata("archival objects",$resources,$metadataEdits,$metadataEditsControlOptions,$metadataFlags,$excavations,$seasons);
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
                    <div class="transcripts_clone" id="transcripts_clone"></div>
                    <div class="editInstructions">			Drag and drop transcriptions to reorder them.</div>
                    <form class="newTranscriptionForm">
                        <textarea name="transcript" class="transcriptionTextarea" placeholder="Enter New Transcription Here..."></textarea><br>
                        <button class="transcriptSubmit" type="submit">SUBMIT NEW TRANSCRIPTION</button>
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
                <div class="commentContainer" style="overflow-y: scroll"></div>

                <div class="submitContainer">
                    <button class="newComment">ADD NEW DISCUSSION</button>

                    <form class="newCommentForm"><textarea name="comment" class="commentTextArea"
                                                           placeholder="Enter discussion here ..."></textarea><br>
                        <button type="submit">SAVE NEW DISCUSSION</button>
                    </form>

                    <form class="newReplyForm"><textarea name="comment" class="replyTextArea"
                                                         placeholder="Enter reply here..."></textarea><br>
                        <button type="submit">SAVE NEW REPLY</button>
                    </form>

                    <form class="newEditDiscussionReplyForm"><textarea name="comment" class="editDiscussionTextArea"
                                                         placeholder="Enter discussion edit here..."></textarea><br>
                        <button type="submit">SAVE DISCUSSION EDIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
<?php
    $hideDrawer = 1;
    foreach($resources as $r) {
        $page = $r['page'];
        $length = sizeof($page);
        if ($length > 1){
            $hideDrawer = 0;
            break;
        }
    }
?>
<div id="resources-nav" class="pages-resource-nav" data-hideFirstDrawer="<?php echo $hideDrawer; ?>" style="display:none;">
    <div class="button-left" id="button-left">
        <a id="left-button">
            <img alt="left-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg" style="height:110px;width:10px">
        </a>
    </div>

    <div id="other-resources-container" class = "page-slider" >
        <div id="other-resources" class = "other-page" style="min-width:  px">
              <?php
              $cnt = 0;

              foreach($resources as $r){


                  $page = $r['page'];

                  foreach ($page as $p) {

                      $img = isset($p['Image_Upload']['localName']) ? $p['Image_Upload']['localName'] : "";
                      echo "<a class = 'other-resources' id = '".$r['kid']."'><img alt='other resource' class = 'other-resource'";
                      $pageThingKid = '';
                      if(isset($p['kid'])) {
                          $pageThingKid = $p['kid'];
                          echo "id = '" . $p['kid'] . "'";
                      }
                      else {
                          // When we don't have a page, it sets id to resource_kid-default-page
                          // For setting pageImage in newResource.js
                          echo "id = '" . $r['kid'] . "-default-page'";
                      }

                      echo "alt = 'resource image'";
                      echo "src = '" . AppController::smallThumb($img, $pageThingKid) . "'  />";
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
          <img alt="right-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" style="height:110px;width:10px">
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
            <img alt="left-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg" style="height:110px;width:10px" />
        </a>
    </div>

    <div id="other-resources-container" class = "resource-container-level">
        <div id="other-resources" class="resource-slider" style="position:relative;">
			<div id="resource-drawer-loader" style="float:right;position:relative;top:-5px;right:-10px;}">
				<?php echo ARCS_LOADER_HTML; ?>
			</div>
			<span class="p-select">
				<div class="select-pointer pointer-border"></div>
				<div class="select-pointer"></div>
			</span>

		<?php  $cnt = 0; ?>
        <?php  foreach($resources as $r):  ?>
		<?php  $cnt++; ?>
        <?php

            $p = $r['page'];
            $p = isset(array_values($p)[0]['Image_Upload']['localName'])?
            array_values($p)[0]['Image_Upload']['localName'] : "";
            $pageThingKid = (array_values($r['page'])[0]['kid']);
         ?>
        <a class='other-resources' data-projectKid="<?=$r['project_kid']?>" >

            <img alt="other resource" id="identifier-<?=$r['kid']?>" class="other-resource<?php if ( in_array($r['kid'], $showButNoEditArray) ){echo ' showButNoEdit'; }  ?>"
                src="<?php echo AppController::smallThumb($p, $pageThingKid); ?>" height="200px"/>
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

    <?php  endforeach; ?>
    </div> <!--#other-resources-contain -->
</div> <!--#other-resources-container -->

<div class="button-right" id="button-right">
    <a id="right-button">
        <img alt="right-arrow" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg" style="height:110px;width:10px" />
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
//set variables for multipage delayed loading
var multiInfo = <?php if(isset($multiInfo)){echo $multiInfo;}else{echo '""';} ?>;

//update the toolbar page urls with project.

//get project name
var pName = $('#project1').find("[id='Persistent_Name']").html();
if( typeof pName !== 'undefined' ) {
    pName = pName.replace(/ /g, '_').toLowerCase();

    console.log('here', pName)

//add the project kid to the resources url.
    var href = $('#resources').attr('href');
    href = href.split('/');
    href.pop();
    href = href.join('/');
    var href = href + '/' + pName;
    $('#resources').attr('href', href);

//add project kid to the collections url.
    var href = $('#collections').attr('href');
    href = href.split('/');
    href.pop();
    href = href.join('/');
    var href = href + '/' + pName;
    $('#collections').attr('href', href);

//add project kid to the search url.
    var href = $('#search').attr('href');
    href = href.split('/');
    href.pop();
    href = href.join('/');
    var href = href + '/' + pName;
    $('#search').attr('href', href);

    $('#soo').ready(function(){
        console.log('before soo ready page click', $('.selectedCurrentPage').html())
        $('.selectedCurrentPage').find('img')[0].click();
    });

    console.log($('#toolbarHead'));
    pName = pName.replace('_', ' ');
    $('#toolbarHead').html(pName + $('#dropArrow')[0].outerHTML);


    $('#viewer-right').on('click', '.stable-url', function(){
        var url = $(this).attr('href');
        var win = window.open(url, '_blank');
        win.focus();
    });
}



//$('#viewer-right').on('click', '.js-textareacopybtn', function(){
//    var copyTextarea = document.querySelector('.js-copytextarea');
//    copyTextarea.select();
//    document.execCommand('copy')
//});


// function myFunction() {
//
//     console.log('HIHIHIHIHI');
//
//     $('#myInput').css('display', 'block');
//     var copyText = document.getElementById("myInput");
//     copyText.select();
//     document.execCommand("Copy");
//     $("#myTooltip").text("Copied!");// + copyText.value;
//     $('#myInput').css('display', 'none');
//
//
//
//
//     // console.log('link', link);
//     // var uri_dec = decodeURIComponent(url);
//     // console.log('hi i go t', url)
//     // $('#myInput').css('display', 'block');
//     // var copyText = document.getElementById("myInput");
//     // copyText.select();
//     // document.execCommand("Copy");
//     // $('#myInput').css('display', 'none');
//
//     // var t = document.createTextNode(url);
//
//     // document.execCommand('copy', false, t);
//
//     // var url = $url;
//     // var url = $('#viewer-right .stable-url').attr('href');
//     //     console.log(url);
//     // var win = window.open(url, '_blank');
//     // win.focus();
//
// //     var copyText = $(".stable-url").attr("href");
// //     var copyText = ('0');
// //     console.log(copyText);
// }


</script>
