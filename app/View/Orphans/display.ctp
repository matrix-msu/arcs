
<style media="screen">
.metadata-tab{
    width: 100% !important;
}
.resources-annotate-icon:nth-child(2) {
    display: none;
}
#resource-tools > .resource-icons {
    display: none;
}
#resource-tools > .resource-icons ~ .resource-icons {
    display: table-cell;
}
.numberOverResources{
  border: 2px solid white;
  font-size: 26px;
}
.wrap{
  min-height: 0px;
}
#other-resources{
  display: flex !important;
}
#next-resource, #prev-resource {
  display: none !important;
}
#resource-tools{
  text-align: center;
}
@media screen and (max-width: 930px) {
    .tools{
      display: none !important;
    }
    .container1 h3{
      display: table !important;
      margin: auto;
    }
    .resource-reset-icon,
    .resources-fullscreen-icon,
    .resources-rotate-icon,
    .zoom-div{
      display: none !important;
    }
    .resource-icons{
      position: initial !important;
    }
    .resources-annotate-icon{
        display:none;
      position: absolute;
      right: 0;
      left: 0;
      top: 0;
      bottom: 0;
      margin: auto;
    }
    #viewer-left, #viewer-right{
      float: none;
      width: 100%;
      height: auto !important;
      display: table !important;
    }
    .canvas{
      height: auto !important;
      width: 100% !important;
    }
    #viewer-window{
      height: auto !important;
      border: none !important;
      overflow: visible !important;
    }
    #button-left, #button-right{
      display: none !important;
    }
    #resources-nav{
      white-space: normal;
      display: table;
    }
    #next-resource{
      margin-right: 6% !important;
    }
    #prev-resource{
      margin-left: 6% !important;
    }
    #viewer-tools h3{
      font-size: 18px;
    }
    #resource-tools{
      border: none !important;
      height: 65px !important;
    }
    #other-resources-container{
      width: auto !important;
      height: auto !important;
      padding-bottom: 16px;
    }
    #other-resources{
      display: block !important;
    }
    .viewers-container{
      height: auto !important;
    }
    a:hover{
      text-decoration: none;
    }
    img.other-resource{

      width: 100%;
      height: 100%;
      border-radius: 2px;
      box-shadow: 0px 1px 6px 3px rgba(0, 0, 0, 0.2);
      display: inline-block;

      margin-left: 0%;
      margin-right: 0%;
      margin-bottom: 0%;
      margin-top: 0%;
  }
  .accordion{
    min-height: 500px;
  }
  #ImageWrap img{
    max-width: 90% !important;
    position: initial !important;
    right: initial !important;
    left: initial !important;
    top: initial !important;
    bottom: initial !important;
    box-shadow: 0px 0px 6px 4px rgba(0,0,0,.2);
  }
  #viewer-tools{
    border-bottom: none !important;
  }


  .img-holder{
    position: relative;
    width: 40%;
    margin-left: 6%;
    margin-right: 2%;
    margin-bottom: 3%;
    margin-top: 3%;
    float: none !important;
    height: 250px ;
  }
  /*​http://dev2.matrix.msu.edu/~austin.rix/arcs/resource/7B-2E0-1
  Mobile breakpoints have been set for the resources preview because you can not set a percent height on something unknown. Im sure they will have to be adjusted, but right now they are set for .img-holder at:
  1000px = height: 250px;
  700px = height: 190px;
  500px = height: 140px;
  Annotation is broken for mobile, but that should go on a different ticket. It is a js issue.*/
}
@media screen and (max-width: 700px) {
  .img-holder{
    height: 190px ;
  }

}
@media screen and (max-width: 500px) {
  .img-holder{
    height: 140px ;
  }

}
</style>
<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
<?= $this->Html->script("views/viewer/Multi/accordion.js")?>
<?= $this->Html->script("views/viewer/Metadata/resources.js")?>
<?= $this->Html->script("views/orphan/toolbar.js")?>

<div class="viewers-container">

    <div class="modalBackground">
        <div class="flagWrap">
            <div id="flagModal">
                <div class="flagModalHeader">NEW FLAG<img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Close.svg"
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
				</div>
			</div>
      <ul class="fullscreen-toolbar">
        <li class="full-tool-btns">
          <img  class="fullscreen-prev" src="/<?php echo BASE_URL; ?>app/img/ArrowLeft.svg">
        </li>
        <li class="full-tool-btns">
          <img class="resources-rotate-icon rotate-overlay" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/Rotate.svg">
        </li>
        <li class="full-tool-btns">
          <img class="fullscreen-next" src="/<?php echo BASE_URL; ?>app/webroot/assets/img/ArrowRight.svg">
        </li>
      </ul>


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
                <p class="annotateTab annotateTabUrl">URL</p>
                <div class="annotateRelationContainer">
                    <form class="annotateSearchForm" action="#">
                        <input class="annotateSearch" placeholder="SEARCH"/>
                    </form>
                    <div class="resultsContainer"></div>
                    <div class="annotation_pagination">
                        <span class="annotation_prev"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowLeft-White.svg"></span>
                        <span class="annotation_numbers"></span>
                        <span class="annotation_next"><img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/arrowRight-White.svg"></span>
                    </div>
                </div>
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
                  <h3><?php echo $pageName ?></h3>


            </div>
        </div>

        <div id="viewer-window">
            <div class="annotateHelp">Click and drag to outline the area you would like to annotate.
                <div class="annotationHelpOk">OK</div>
            </div>
            <div id="ImageWrap">
                <img src="<?=$image?>" id="PageImage">
                <div id="canvas" class='canvas'></div>
            </div>
        </div>

        <?= $this->element("resourceTool") ?>
    </div>

    <div id="viewer-right" style="position:relative;">

        <div id="tabs" class="metadata">

            <!-- TO DO: Add click events for highlighting the text on the tabs (in Arcs blue) -->
            <ul class="metadata-tabs">
                <li class="metadata-tab"><a style="cursor:default;" href="#tabs-1">Metadata</a></li>
            </ul>

            <div id="tabs-1" class="metadata-content">

                <div class="accordion metadata-accordion">
                    <h3 class="level-tab" style="cursor:default;display:none;">Page
                        
                    </h3>
                    <div class="level-content">
                        <table id="Project">
<?php
                          foreach($pageMetadata as $key => $value){
?>
                            <tr>
                              <td><?=$key?></td>
                              <?php if(is_array($value)){ ?>
                              <td><?php foreach($value as $val)echo $val . "</br>" ?></td>
                              <?php }else {?>
                              <td><?= $value ?></td>
                              <?php }?>
                            </tr>

<?php
                          }

?>

                        </table>

                    </div>



                </div>

            </div>


        </div>

    </div>
</div>

<script>
	//update the single-resource's resources, collections, and search links
	//add the project kid to the resources url.
    var pName = '<?php echo $projectName; ?>';

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
