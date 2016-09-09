

<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
<script>
//PAGE GLOBALS
var resourceKid = "<?php echo $resource['kid']; ?>";
var ADMIN = "<?php echo $admin ?>";
var kora_url = "<?php echo $kora_url ?>";
// preloader image and images
var kid = "<?php echo $kid; ?>"; // needs to stay
var resource_sid = "<?php echo RESOURCE_SID;?>";
var page_sid = "<?php echo PAGES_SID;?>";
var webroot = "<?php echo Router::url('/', true); ?>app/webroot/";
var resourceName = "<?php echo $resource['Resource Identifier']; ?>";
var JSON_KEYS = <?php echo json_encode(array_keys($pages)); ?>;
var LEN = "<?php $length = count($pages); echo "$length";?>";
var SCHEMES = ['<?php $project2 = $project; unset($project2['url']); echo  json_encode($project2)?>',
                '<?php echo json_encode($season)?>',
                '<?php echo json_encode($surveys)?>',
                '<?php echo json_encode($resource)?>'];
var SUBJECTS = [ <?php $text=''; foreach($subject as $subjects){ $text=$text."'". json_encode($subjects)."',";} rtrim($text,','); echo $text;?> ];
var PAGES = [ <?php $text=''; foreach($pages as $page){ $text=$text."'". json_encode($page)."',";} rtrim($text,','); echo $text;?> ];

var PAGESOBJECT = <?php echo json_encode($pages); ?>;
var PROJECT_KID = "<?php echo $project['kid']; ?>"
</script>

<?= $this->Html->script("views/viewer/Metadata/flag.js")?>
<?= $this->Html->script("views/viewer/Metadata/accordion.js")?>
<?= $this->Html->script("views/viewer/Metadata/collection.js")?>
<?= $this->Html->script("views/viewer/Metadata/details.js")?>
<?= $this->Html->script("views/viewer/Metadata/resources.js")?>
<?= $this->Html->script("views/viewer/Metadata/newResource.js")?>
<?= $this->Html->script("views/viewer/Metadata/export.js")?>
<?= $this->Html->script("views/viewer/Metadata/keyword.js")?>
<?= $this->Html->script("views/viewer/Metadata/annotation.js")?>

<div class="viewers-container">

    <div class="modalBackground">
        <div class="flagWrap">
            <div id="flagModal">
                <div class="flagModalHeader">NEW FLAG<img src="../app/webroot/assets/img/Close.svg"
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
			<div class="deleteModalHeader"><img src="../app/webroot/assets/img/Close.svg"class="deleteModalClose"/></div>
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
							<img class='leftExpandedArrow' src="../img/arrowRight-White.svg" height="220px" width="10px" />
						</div>

					</div>
					<div class="rightHalf">
						<div class='expandedArrowBoxRight'>
							<img class='rightExpandedArrow' src="../img/arrowRight-White.svg" height="220px" width="10px" />
						</div>

					</div>
				</div>
			</div>
			<div class='fullscreenTitle' style="display:none;">
				<span class='titleText'>Test.jpg</span>
			</div>

			<div class='fullscreenClose'>
				<img src="../app/webroot/assets/img/Close.svg"class="closeExpand"/>
			</div>
		</div>
	</div>

    <div class="annotateModalBackground">
        <div class="annotateWrap">
            <div id="annotateModal">
                <div class="annotateModalHeader">NEW ANNOTATION<img src="../app/webroot/assets/img/Close.svg"
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
                <div class="collectionModalHeader">Add to Collection <img src="../app/webroot/assets/img/Close.svg"
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
                <div class="collectionModalHeader">ADDED TO COLLECTION! <img src="../app/webroot/assets/img/Close.svg"
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
                        <img src="../app/webroot/assets/img/Close.svg" class="modalCloseAssociator"/>
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
                <h3><?php echo $resource['Title']; ?></h3>

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
                <img src="<?php echo $resource['thumb'] ?>" id="PageImage">
                <div id="canvas" class='canvas'></div>
            </div>
        </div>

        <div id="resource-tools">
            <div class="resource-tools-container">
                <!-- TO DO: Add onClick events here for each icon -->


                <div id="prev-resource">
                    <a href="#">
                        <img class="arrow-left-icon" src="../img/ArrowLeft.svg">
                    </a>
                </div>
                <div class="annotate-fullscreen-div">
                    <img class="resources-annotate-icon" src="../img/annotationsProfile.svg" class='annotationsThumb' >
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
                    <a href="#">
                        <img class="arrow-right-icon" src="../img/ArrowRight.svg">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="viewer-right" style="position:relative;">

        <div id="tabs" class="metadata">

            <!-- TO DO: Add click events for highlighting the text on the tabs (in Arcs blue) -->
            <ul class="metadata-tabs">
                <li class="metadata-tab"><a href="#tabs-1">Metadata</a></li>
                <li class="metadata-tab details"><a href="#tabs-2">Details</a></li>
                <li class="metadata-tab discussion"><a href="#tabs-3">Discussions</a></li>
            </ul>

            <!--<div id="search">-->
            <!--<span class="title">-->
            <!--<p>Collection Title</p>-->
            <!--</span>-->
            <!---->
            <!--<input type="text" placeholder="SEARCH COLLECTION">-->
            <!--</div>-->

            <div id="tabs-1" class="metadata-content">

                <div class="accordion metadata-accordion">

                    <h3 class="level-tab">Project
                        <!--<div class="icon-edit"></div>-->
                        <span class="edit-btn">Edit</span></h3>

                    <div class="level-content">


                        <table id="Project">
                            <tr>
                                <td>Name</td>
                                <td<?php $name = "Name";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Country</td>
                                <td<?php $name = "Country";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $options = '<option value=&quot;Greece&quot;>Greece</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Region</td>
                                <td<?php $name = "Region";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $options = '<option value=&quot;Corinthia&quot;>Corinthia</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Geolocation</td>
                                <td<?php $name = "Geolocation";
                                if( array_key_exists( $name, $project ) ){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        foreach($project['Geolocation'] as $geolocation) {$text = $text.$geolocation."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_input">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_input"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Modern Name</td>
                                <td<?php $name = "Modern Name";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $options = '<option value=&quot;Kyras Vrisi&quot;>Kyras Vrisi</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Location Identifier</td>
                                <td<?php $name = "Location Identifier";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Location Identifier Scheme</td>
                                <td<?php $name = "Location Identifier Scheme";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Elevation</td>
                                <td<?php $name = "Elevation";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date";
                                if( array_key_exists( $name, $project ) ){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        $text = $text . $project[$name]['month'] . "/" . $project[$name]['day'] . "/" . $project[$name]['year'] . " ". $project[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Latest Date</td>
                                <td<?php $name = "Latest Date";
                                if( array_key_exists( $name, $project ) ){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        $text = $text . $project[$name]['month'] . "/" . $project[$name]['day'] . "/" . $project[$name]['year'] . " ". $project[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Records Archive</td>
                                <td<?php $name = "Records Archive";
                                if( array_key_exists( $name, $project ) ){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        foreach( $project[$name] as $record) { $text = $text.$record."<br>";}
                                    }
                                    $options = '<option value=&quot;The Ohio State University Excavations at Isthmia Archives&quot;>The Ohio State University Excavations at Isthmia Archives</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Persistent Name</td>
                                <td<?php $name = "Persistent Name";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Complex Title</td>
                                <td<?php $name = "Complex Title";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Terminus Ante Quem</td>
                                <td<?php $name = "Terminus Ante Quem";
                                if( array_key_exists( $name, $project ) ){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        if($project[$name]['prefix']){
                                            $text = $project[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $project[$name]['month'] . "/" . $project[$name]['day'] . "/" . $project[$name]['year'] . " ". $project[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Post Quem</td>
                                <td<?php $name = "Terminus Post Quem";
                                if( array_key_exists( $name, $project ) ){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        if($project[$name]['prefix']){
                                           $text = $project[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $project[$name]['month'] . "/" . $project[$name]['day'] . "/" . $project[$name]['year'] . " ". $project[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Period</td>
                                <td<?php $name = "Period";
                                if( array_key_exists( $name, $project ) ){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        foreach( $project[$name] as $period) { $text = $text.$period."<br>";}
                                    }
                                    $options = '<option value=&quot;Bronze Age&quot;>Bronze Age</option><option value=&quot;Geometric&quot;>Geometric</option><option value=&quot;Archaic&quot;>Archaic</option><option value=&quot;Classical&quot;>Classical</option><option value=&quot;Hellenistic&quot;>Hellenistic</option><option value=&quot;Roman&quot;>Roman</option><option value=&quot;Late Roman/Byzantine&quot;>Late Roman/Byzantine</option><option value=&quot;Frankish&quot;>Frankish</option><option value=&quot;Ottoman&quot;>Ottoman</option><option value=&quot;Modern&quot;>Modern</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Archaeological Culture</td>
                                <td<?php $name = "Archaeological Culture";
                                if( array_key_exists( $name, $project )){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        foreach( $project[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Description</td>
                                <td<?php $name = "Description";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Brief Description</td>
                                <td<?php $name = "Brief Description";
                                if( array_key_exists( $name, $project )){
                                    $text = $project[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Permitting Heritage Body</td>
                                <td<?php $name = "Permitting Heritage Body";
                                if( array_key_exists( $name, $project ) ){
                                    $text = '';
                                    if( !is_string($project[$name]) ){
                                        foreach( $project[$name] as $period) { $text = $text.$period."<br>";}
                                    }
                                    $options = '<option value=&quot;Greek Ministry of Culture&quot;>Greek Ministry of Culture</option><option value=&quot;American School of Classical Studies, Athens&quot;>American School of Classical Studies, Athens</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                        </table>

                    </div>

                    <h3 class="level-tab">Season
                        <!--<div class="icon-edit"></div>-->
                        <span class="edit-btn">Edit</span></h3>

                    <div class="level-content">

                        <?php if($season['Title'] != "") { ?>

                        <table id="Season">
                            <tr>
                                <td>Project Associator</td>
                                <td<?php $name = "Project Associator";
                                if( array_key_exists( $name, $season ) ){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach($season[$name] as $associator) { $text = $text.$associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td<?php $name = "Title";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td<?php $name = "Type";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Excavation&quot;>Excavation</option><option value=&quot;Study&quot;>Study</option><option value=&quot;Survey&quot;>Survey</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Director</td>
                                <td<?php $name = "Director";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Broneer, Oscar&quot;>Broneer, Oscar</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Registrar</td>
                                <td<?php $name = "Registrar";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;&quot;></option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Sponsor</td>
                                <td<?php $name = "Sponsor";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;University of California, Los Angeles&quot;>University of California, Los Angeles</option><option value=&quot;Ohio State University&quot; selected=&quot;selected&quot;>Ohio State University</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date";
                                if( array_key_exists( $name, $season ) ){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        $text = $text . $season[$name]['month'] . "/" . $season[$name]['day'] . "/" . $season[$name]['year'] . " ". $season[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Latest Date</td>
                                <td<?php $name = "Latest Date";
                                if( array_key_exists( $name, $season ) ){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        $text = $text . $season[$name]['month'] . "/" . $season[$name]['day'] . "/" . $season[$name]['year'] . " ". $season[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Ante Quem</td>
                                <td<?php $name = "Terminus Ante Quem";
                                if( array_key_exists( $name, $season ) ){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        if($season[$name]['prefix']){
                                            $text = $season[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $season[$name]['month'] . "/" . $season[$name]['day'] . "/" . $season[$name]['year'] . " ". $season[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Post Quem</td>
                                <td<?php $name = "Terminus Post Quem";
                                if( array_key_exists( $name, $season ) ){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        if($season[$name]['prefix']){
                                           $text = $season[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $season[$name]['month'] . "/" . $season[$name]['day'] . "/" . $season[$name]['year'] . " ". $season[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td<?php $name = "Description";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 2";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 2";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 3";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 3";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 4";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 4";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 5";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 5";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 6";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 6";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 7";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 7";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 8";
                                if( array_key_exists( $name, $season )){
                                    $text = $season[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 8";
                                if( array_key_exists( $name, $season )){
                                    $text = '';
                                    if( !is_string($season[$name]) ){
                                        foreach( $season[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>

                        </table>

                        <?php } else { ?>
                        <div class="no-data">
                            This is a dig find, which doesn’t have associated season metadata.
                        </div>
                        <?php } ?>
                    </div>

                    <h3 class="level-tab">Excavation/Survey
                        <!--<div class="icon-edit"></div>-->
                        <span class="edit-btn">Edit</span></h3>

                    <div class="level-content">

                        <div id="tabs-1" class="metadata-content">

                            <!-- div class="accordion metadata-accordion" -->
                            <div class="survey-accordion">

                                <?php if(count($surveys) > 0) { ?>
                                <?php $count=0; ?>
                                <?php foreach($surveys as $survey) { $count++; ?>

                                <h3 class="level-tab smaller">Excavation/Survey Level Metadata
                                    Section <?php echo $count ?></h3>

                                <div class="level-content auto-height" data-kid="<?php echo $survey['kid']; ?>">

                                    <table id="Excavation/Survey">
                                        <tr>
                                            <td>Season Associator</td>
                                            <td<?php $name = "Season Associator";
                                            if( array_key_exists( $name, $survey ) ){
                                                $text = '';
                                                if( !is_string($survey[$name]) ){
                                                    foreach($survey[$name] as $associator) { $text = $text.$associator."<br>";}
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td<?php $name = "Name";
                                            if( array_key_exists( $name, $survey )){
                                                $text = $survey[$name];
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td<?php $name = "Type";
                                            if( array_key_exists( $name, $survey )){
                                                $text = $survey[$name];
                                                $options = '<option value=&quot;Trench&quot;>Trench</option><option value=&quot;Survey&quot;>Survey</option><option value=&quot;Study/Lab&quot;>Study/Lab</option>';
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                            '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Supervisor</td>
                                            <td<?php $name = "Supervisor";
                                            if( array_key_exists( $name, $survey ) ){
                                                $text = '';
                                                if( !is_string($survey[$name]) ){
                                                    foreach($survey[$name] as $survey_sup) {$text = $text.$survey_sup."<br>";}
                                                }
                                                $options = '<option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Frey, Jon M.&quot;>Frey, Jon M.</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                            '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Earliest Date</td>
                                            <td<?php $name = "Earliest Date";
                                            if( array_key_exists( $name, $survey ) ){
                                                $text = '';
                                                if( !is_string($survey[$name]) ){
                                                    $text = $text . $survey[$name]['month'] . "/" . $survey[$name]['day'] . "/" . $survey[$name]['year'] . " ". $survey[$name]['era'];
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Latest Date</td>
                                            <td<?php $name = "Latest Date";
                                            if( array_key_exists( $name, $survey ) ){
                                                $text = '';
                                                if( !is_string($survey[$name]) ){
                                                    $text = $text . $survey[$name]['month'] . "/" . $survey[$name]['day'] . "/" . $survey[$name]['year'] . " ". $survey[$name]['era'];
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Terminus Ante Quem</td>
                                            <td<?php $name = "Terminus Ante Quem";
                                            if( array_key_exists( $name, $survey ) ){
                                                $text = '';
                                                if( !is_string($survey[$name]) ){
                                                    if($survey[$name]['prefix']){
                                                       $text = $survey[$name]['prefix'] . " ";
                                                    }
                                                    $text = $text . $survey[$name]['month'] . "/" . $survey[$name]['day'] . "/" . $survey[$name]['year'] . " ". $survey[$name]['era'];
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Terminus Post Quem</td>
                                            <td<?php $name = "Terminus Post Quem";
                                            if( array_key_exists( $name, $survey ) ){
                                                $text = '';
                                                if( !is_string($survey[$name]) ){
                                                    if($survey[$name]['prefix']){
                                                       $text = $survey[$name]['prefix'] . " ";
                                                    }
                                                    $text = $text . $survey[$name]['month'] . "/" . $survey[$name]['day'] . "/" . $survey[$name]['year'] . " ". $survey[$name]['era'];
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Excavation Stratigraphy</td>
                                            <td<?php $name = "Excavation Stratigraphy";
                                            if( array_key_exists( $name, $survey )){
                                                $text = $survey[$name];
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Survey Conditions</td>
                                            <td<?php $name = "Survey Conditions";
                                            if( array_key_exists( $name, $survey )){
                                                $text = $survey[$name];
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Post Dispositional Transformation</td>
                                            <td<?php $name = "Post Dispositional Transformation";
                                            if( array_key_exists( $name, $survey )){
                                                $text = $survey[$name];
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Legacy</td>
                                            <td<?php $name = "Legacy";
                                            if( array_key_exists( $name, $survey )){
                                                $text = $survey[$name];
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                            ?>
                                            </td>
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

                    <h3 class="level-tab">Archival Object
                        <!--<div class="icon-edit"></div>-->
                        <span class="edit-btn">Edit</span></h3>

                    <div class="level-content">

                        <table id="Archival_Object">
                            <tr>
                                <td>Excavation - Survey Associator</td>
                                <td<?php $name = "Excavation - Survey Associator";
                                if( array_key_exists( $name, $resource ) ){
                                    $text = '';
                                    if( !is_string($resource[$name]) ){
                                        foreach($resource[$name] as $associator) { $text = $text.$associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Season Associator</td>
                                <td<?php $name = "Season Associator";
                                if( array_key_exists( $name, $resource ) ){
                                    $text = '';
                                    if( !is_string($resource[$name]) ){
                                        foreach($resource[$name] as $associator) { $text = $text.$associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Resource Identifier</td>
                                <td<?php $name = "Resource Identifier";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Type</td>
                                <td<?php $name = "Type";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $options = '<option value=&quot;Drawing&quot;>Drawing</option><option value=&quot;Field journal&quot;>Field journal</option><option value=&quot;Inventory card&quot;>Inventory card</option><option value=&quot;Photograph&quot;>Photograph</option><option value=&quot;Photographic negative&quot;>Photographic negative</option><option value=&quot;Plan or elevation&quot;>Plan or elevation</option><option value=&quot;Report&quot;>Report</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Title</td>
                                <td<?php $name = "Title";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <?php if ($resource['Sub-title'] != null) {?>
                            <tr>
                                <td>Sub-Title</td>
                                <td<?php $name = "Sub-title";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td>Creator</td>
                                <td<?php $name = "Creator";
                                if( array_key_exists( $name, $resource ) ){
                                    $text = '';
                                    if( !is_string($resource[$name]) ){
                                        foreach($resource['Creator'] as $creator) {$text = $text.$creator.'<br>'; }
                                    }
                                    $options = '<option value=&quot;Anderson, Candace E.&quot;>Anderson, Candace E.</option><option value=&quot;Barletta, Barbara&quot;>Barletta, Barbara</option><option value=&quot;Batcheller, James&quot;>Batcheller, James</option><option value=&quot;Bauslaugh, Robert&quot;>Bauslaugh, Robert</option><option value=&quot;Blackmore, Judy&quot;>Blackmore, Judy</option><option value=&quot;Bleistein, Charlene&quot;>Bleistein, Charlene</option><option value=&quot;Bogle, Cynthia&quot;>Bogle, Cynthia</option><option value=&quot;Bolas, B.&quot;>Bolas, B.</option><option value=&quot;Bolas, Barbara&quot;>Bolas, Barbara</option><option value=&quot;Bowman, Michael&quot;>Bowman, Michael</option><option value=&quot;Broneer, Oscar&quot;>Broneer, Oscar</option><option value=&quot;Brunner, Judith&quot;>Brunner, Judith</option><option value=&quot;Camp II, John&quot;>Camp II, John</option><option value=&quot;Camp, Margot&quot;>Camp, Margot</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Carpenter, J. D.&quot;>Carpenter, J. D.</option><option value=&quot;Cassimatis, Maria&quot;>Cassimatis, Maria</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Dinsmoor, Jr., William Bell&quot;>Dinsmoor, Jr., William Bell</option><option value=&quot;Downs, Joanie&quot;>Downs, Joanie</option><option value=&quot;Farnsworth, Marie&quot;>Farnsworth, Marie</option><option value=&quot;Feder, Debbie&quot;>Feder, Debbie</option>'.
                                                    '<option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M.&quot;>Frey, Jon M.</option><option value=&quot;Gais, Ruth&quot;>Gais, Ruth</option>'.
                                                    '<option value=&quot;Giesen, Myra J.&quot;>Giesen, Myra J.</option><option value=&quot;Gill, Alyson A.&quot;>Gill, Alyson A.</option><option value=&quot;Greenberg, Barbara Bolas&quot;>Greenberg, Barbara Bolas</option><option value=&quot;Gregory, Adelia E.&quot;>Gregory, Adelia E.</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Guven, Suna&quot;>Guven, Suna</option><option value=&quot;Harris, A.&quot;>Harris, A.</option><option value=&quot;Hartswick, Kim J.&quot;>Hartswick, Kim J.</option><option value=&quot;Howell, Jesse&quot;>Howell, Jesse</option><option value=&quot;Hull, Don&quot;>Hull, Don</option><option value=&quot;Hull, Susan&quot;>Hull, Susan</option><option value=&quot;Jacoby, Tom&quot;>Jacoby, Tom</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Johnson, Matthew&quot;>Johnson, Matthew</option>'.
                                                    '<option value=&quot;Kaljakin, Tania&quot;>Kaljakin, Tania</option><option value=&quot;Kallemeyer, Susan&quot;>Kallemeyer, Susan</option><option value=&quot;Kardulias, P. Nick&quot;>Kardulias, P. Nick</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Keating, Richard&quot;>Keating, Richard</option><option value=&quot;Kieit, S.&quot;>Kieit, S.</option><option value=&quot;Kouvaris, Michael S.&quot;>Kouvaris, Michael S.</option><option value=&quot;Lanham, Carol&quot;>Lanham, Carol</option><option value=&quot;Leander-Touati, Anne-Marie&quot;>Leander-Touati, Anne-Marie</option><option value=&quot;Lease, L.&quot;>Lease, L.</option><option value=&quot;Liddle, G.&quot;>Liddle, G.</option><option value=&quot;Lindros-Wohl, Birgitta&quot;>Lindros-Wohl, Birgitta</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;Luongo, C.&quot;>Luongo, C.</option><option value=&quot;Marty, Jeanne M.&quot;>Marty, Jeanne M.</option>'.
                                                    '<option value=&quot;McCaslin, Dan&quot;>McCaslin, Dan</option><option value=&quot;McClure, Robert&quot;>McClure, Robert</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Mitchell, Maria&quot;>Mitchell, Maria</option><option value=&quot;Moore, Allen&quot;>Moore, Allen</option><option value=&quot;Moore, Debra W.&quot;>Moore, Debra W.</option><option value=&quot;Mucha, Ashley E.&quot;>Mucha, Ashley E.</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Nicols, John&quot;>Nicols, John</option><option value=&quot;Okin, Louis&quot;>Okin, Louis</option><option value=&quot;Pallas, Demetrios&quot;>Pallas, Demetrios</option><option value=&quot;Pattengale, Jerry&quot;>Pattengale, Jerry</option><option value=&quot;Peirce, Sarah&quot;>Peirce, Sarah</option><option value=&quot;Peppers, Anne Beaton&quot;>Peppers, Anne Beaton</option><option value=&quot;Peppers, James&quot;>Peppers, James</option><option value=&quot;Peppers, Jeanne Marty&quot;>Peppers, Jeanne Marty</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Pierce, Charles&quot;>Pierce, Charles</option><option value=&quot;Platz, Ralph&quot;>Platz, Ralph</option><option value=&quot;Pollak, Barbara A.&quot;>Pollak, Barbara A.</option><option value=&quot;Porter, Alexander&quot;>Porter, Alexander</option><option value=&quot;Rife, Joseph L.&quot;>Rife, Joseph L.</option><option value=&quot;Rothaus, Richard M.&quot;>Rothaus, Richard M.</option>'.
                                                    '<option value=&quot;Rudrick, Anna M.&quot;>Rudrick, Anna M.</option><option value=&quot;Sarefield, Daniel&quot;>Sarefield, Daniel</option><option value=&quot;Sasel, Marjeta&quot;>Sasel, Marjeta</option><option value=&quot;Schaar, Kenneth W.&quot;>Schaar, Kenneth W.</option><option value=&quot;Scott, Ruth&quot;>Scott, Ruth</option><option value=&quot;Semeli S.&quot;>Semeli S.</option><option value=&quot;Shaw, Joseph W.&quot;>Shaw, Joseph W.</option><option value=&quot;Silberberg, Susan R.&quot;>Silberberg, Susan R.</option><option value=&quot;Snively, Carolyn&quot;>Snively, Carolyn</option><option value=&quot;Stein, Carol A.&quot;>Stein, Carol A.</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tache, Hannah&quot;>Tache, Hannah</option><option value=&quot;Thorne, Margaret MacVeagh&quot;>Thorne, Margaret MacVeagh</option><option value=&quot;Thorne, Stuart E.&quot;>Thorne, Stuart E.</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Vernon, Catherine&quot;>Vernon, Catherine</option><option value=&quot;von Sternberg, Meri&quot;>von Sternberg, Meri</option><option value=&quot;Walker, B.&quot;>Walker, B.</option><option value=&quot;Walters, Elizabeth J.&quot;>Walters, Elizabeth J.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option><option value=&quot;Wittman, Barbara&quot;>Wittman, Barbara</option><option value=&quot;Wittmann, Barbara K.&quot;>Wittmann, Barbara K.</option><option value=&quot;Wohl, Birgitta&quot;>Wohl, Birgitta</option><option value=&quot;Zidar, Charles M.&quot;>Zidar, Charles M.</option><option value=&quot;Zuckerman, T. B.&quot;>Zuckerman, T. B.</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Creator Role</td>
                                <td<?php $name = "Creator Role";
                                if( array_key_exists( $name, $resource ) ){
                                    $text = '';
                                    if( !is_string($resource[$name]) ){
                                        foreach($resource[$name] as $role) {$text = $text.$role.'<br>'; }
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Registrar&quot;>Registrar</option><option value=&quot;Field Coordinator&quot;>Field Coordinator</option><option value=&quot;Draftsman&quot;>Draftsman</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date";
                                if( array_key_exists( $name, $resource ) ){
                                    $text = '';
                                    if( !is_string($resource[$name]) ){
                                        $text = $text . $resource[$name]['month'] . "/" . $resource[$name]['day'] . "/" . $resource[$name]['year'] . " ". $resource[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Date Range</td>
                                <td<?php $name = "Date Range";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Description</td>
                                <td<?php $name = "Description";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Pages</td>
                                <td<?php $name = "Pages";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Condition</td>
                                <td<?php $name = "Condition";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $options = '<option value=&quot;Good&quot;>Good</option><option value=&quot;Fair&quot;>Fair</option><option value=&quot;Poor&quot;>Poor</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Access Level</td>
                                <td<?php $name = "Access Level";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $options = '<option value=&quot;Closed&quot;>Closed</option><option value=&quot;Metadata&quot;>Metadata</option><option value=&quot;Metadata and digital file&quot; selected=&quot;selected&quot;>Metadata and digital file</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Accession Number</td>
                                <td<?php $name = "Accession Number";
                                if( array_key_exists( $name, $resource )){
                                    $text = $resource[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    foreach($metadataEdits as $value) {
                                        if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                            $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                        }} echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                        </table>

                    </div>


                    <h3 class="level-tab">Subject of Observation
                        <!--<div class="icon-edit"></div>-->
                        <span class="edit-btn">Edit</span><span id="new">Add New</span></h3>

                    <div class="level-content">

                        <div id="soo" class="metadata-content">

                            <!--<div class="metadata-accordion">-->

                                <ul>
                                <?php if(count($subject) > 0) { ?>
                                <?php $count=0; ?>
                                <?php foreach($subject as $subjects) { $count++; ?>
                                <li class="soo-li"><a href="#soo-<?php echo $count; ?>" class="soo-click<?= $count ?>  soo-click"><?php echo $count; ?></a></li>
                                <?php } ?>
                                </ul>

                                <?php $count=0;

                                ?>
                                <?php foreach($subject as $subjects) { $count++; ?>

                                <div class="level-content soo auto-height" id="soo-<?php echo $count; ?>" data-kid="<?php echo $subjects['kid']; ?>">

                                    <table id="Subject_Of_Observation">
                                        <tr>
                                            <td>Pages Associator</td>
                                            <td<?php $name = "Pages Associator";
                                            if( array_key_exists( $name, $subjects ) ){
                                                $text = '';
                                                if( !is_string($subjects[$name]) ){
                                                    foreach($subjects['Pages Associator'] as $page_associator) { $text = $text.$page_associator."<br>";}
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Resource Identifier</td>
                                            <td<?php $name = "Resource Identifier";
                                            if( array_key_exists( $name, $subjects )){
                                                $text = $subjects[$name];
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Subject of Observation Associator</td>
                                            <td<?php $name = "Subject of Observation Associator";
                                            if( array_key_exists( $name, $subjects ) ){
                                                $text = '';
                                                if( !is_string($subjects[$name]) ){
                                                    foreach($subjects[$name] as $subject_associator) {$text = $text.$subject_associator."<br>";}
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Classification</td>
                                            <td<?php $name = "Artifact - Structure Classification";
                                            if( array_key_exists( $name, $subjects )){
                                                $text = $subjects[$name];
                                                $options = '<option value=&quot;Arrentine&quot;>Arrentine</option><option value=&quot;Black Figure&quot;>Black Figure</option><option value=&quot;Candarli&quot;>Candarli</option><option value=&quot;Coarseware&quot;>Coarseware</option><option value=&quot;Corinthian&quot;>Corinthian</option><option value=&quot;Diamond shaped&quot;>Diamond shaped</option><option value=&quot;Doric&quot;>Doric</option><option value=&quot;Eastern Sigillata A&quot;>Eastern Sigillata A</option><option value=&quot;Eastern Sigillata B&quot;>Eastern Sigillata B</option><option value=&quot;Fineware&quot;>Fineware</option><option value=&quot;Floor tile&quot;>Floor tile</option><option value=&quot;Hydraulic&quot;>Hydraulic</option><option value=&quot;Imitation&quot;>Imitation</option><option value=&quot;Ionic&quot;>Ionic</option><option value=&quot;Kitchen ware&quot;>Kitchen ware</option><option value=&quot;Megarian&quot;>Megarian</option><option value=&quot;Micaceous&quot;>Micaceous</option><option value=&quot;Miniature&quot;>Miniature</option><option value=&quot;Non-rotary&quot;>Non-rotary</option><option value=&quot;Opus Sectile&quot;>Opus Sectile</option><option value=&quot;Plain ware&quot;>Plain ware</option><option value=&quot;Polygonal&quot;>Polygonal</option><option value=&quot;Pompeian Red&quot;>Pompeian Red</option><option value=&quot;Pontic Ware&quot;>Pontic Ware</option><option value=&quot;Red Figure&quot;>Red Figure</option><option value=&quot;Sgraffito&quot;>Sgraffito</option><option value=&quot;Slavic&quot;>Slavic</option><option value=&quot;Unknown&quot;>Unknown</option>';
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                            '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Type</td>
                                            <td<?php $name = "Artifact - Structure Type";
                                            if( array_key_exists( $name, $subjects ) ){
                                                $text = '';
                                                if( !is_string($subjects[$name]) ){
                                                    foreach($subjects['Artifact - Structure Type'] as $structure_type) {$text = $text.$structure_type."<br>";}
                                                }
                                                $options = '<option value=&quot;Amphora&quot;>Amphora</option><option value=&quot;Antefix&quot;>Antefix</option><option value=&quot;Ashlar&quot;>Ashlar</option><option value=&quot;Base&quot;>Base</option><option value=&quot;Basin&quot;>Basin</option><option value=&quot;Bead&quot;>Bead</option><option value=&quot;Block&quot;>Block</option><option value=&quot;Body Sherd&quot;>Body Sherd</option><option value=&quot;Bottle&quot;>Bottle</option><option value=&quot;Bowl&quot;>Bowl</option><option value=&quot;Brick&quot;>Brick</option><option value=&quot;Buckle&quot;>Buckle</option><option value=&quot;Capital&quot;>Capital</option><option value=&quot;Casserole&quot;>Casserole</option><option value=&quot;Coin&quot;>Coin</option><option value=&quot;Column Base&quot;>Column Base</option><option value=&quot;Column shaft&quot;>Column shaft</option><option value=&quot;Cooking pot&quot;>Cooking pot</option><option value=&quot;Cornice&quot;>Cornice</option><option value=&quot;Crown moulding&quot;>Crown moulding</option><option value=&quot;Cup&quot;>Cup</option><option value=&quot;Dish&quot;>Dish</option><option value=&quot;Disk&quot;>Disk</option><option value=&quot;Drinking cup&quot;>Drinking cup</option><option value=&quot;Epistyle&quot;>Epistyle</option><option value=&quot;Epistyle/frieze&quot;>Epistyle/frieze</option><option value=&quot;Figurine&quot;>Figurine</option><option value=&quot;Flake&quot;>Flake</option><option value=&quot;Foot&quot;>Foot</option><option value=&quot;Foundation&quot;>Foundation</option><option value=&quot;Fragment&quot;>Fragment</option><option value=&quot;Frying pan&quot;>Frying pan</option><option value=&quot;Furnace ribbing&quot;>Furnace ribbing</option><option value=&quot;Grill&quot;>Grill</option><option value=&quot;Gutta&quot;>Gutta</option><option value=&quot;Hammer stone&quot;>Hammer stone</option><option value=&quot;Hand stone&quot;>Hand stone</option><option value=&quot;Handle&quot;>Handle</option><option value=&quot;Hook&quot;>Hook</option><option value=&quot;Inscription&quot;>Inscription</option><option value=&quot;Jug&quot;>Jug</option><option value=&quot;Kernos&quot;>Kernos</option><option value=&quot;Kiln Foot&quot;>Kiln Foot</option><option value=&quot;Kiln lining&quot;>Kiln lining</option><option value=&quot;Kiln support&quot;>Kiln support</option><option value=&quot;Knife blade&quot;>Knife blade</option><option value=&quot;Krater&quot;>Krater</option><option value=&quot;Lamp&quot;>Lamp</option><option value=&quot;Lekythos&quot;>Lekythos</option><option value=&quot;Lid&quot;>Lid</option><option value=&quot;Lime&quot;>Lime</option><option value=&quot;Loomweight&quot;>Loomweight</option><option value=&quot;Millstone&quot;>Millstone</option><option value=&quot;Moulding&quot;>Moulding</option><option value=&quot;Nail&quot;>Nail</option><option value=&quot;Neck&quot;>Neck</option><option value=&quot;Oinochoe&quot;>Oinochoe</option><option value=&quot;Pantile&quot;>Pantile</option><option value=&quot;Pendant&quot;>Pendant</option><option value=&quot;Pin&quot;>Pin</option><option value=&quot;Pitcher&quot;>Pitcher</option>'.
                                                                '<option value=&quot;Plate&quot;>Plate</option><option value=&quot;Polishing stone&quot;>Polishing stone</option><option value=&quot;Pot&quot;>Pot</option><option value=&quot;Pyxis&quot;>Pyxis</option><option value=&quot;Rain spout&quot;>Rain spout</option><option value=&quot;Relief&quot;>Relief</option><option value=&quot;Revetment&quot;>Revetment</option><option value=&quot;Rim&quot;>Rim</option><option value=&quot;Ring&quot;>Ring</option><option value=&quot;Ring foot&quot;>Ring foot</option><option value=&quot;Rooftile&quot;>Rooftile</option><option value=&quot;Rubble&quot;>Rubble</option><option value=&quot;Sample&quot;>Sample</option><option value=&quot;Scotia&quot;>Scotia</option><option value=&quot;Sculpture&quot;>Sculpture</option><option value=&quot;Sima&quot;>Sima</option><option value=&quot;Skyphos&quot;>Skyphos</option><option value=&quot;Spindle whorl&quot;>Spindle whorl</option><option value=&quot;Stewpot&quot;>Stewpot</option><option value=&quot;Stopper&quot;>Stopper</option><option value=&quot;Strap&quot;>Strap</option><option value=&quot;Stucco&quot;>Stucco</option><option value=&quot;Tablewear&quot;>Tablewear</option><option value=&quot;Tegula mammata&quot;>Tegula mammata</option><option value=&quot;Tessera&quot;>Tessera</option><option value=&quot;Tile&quot;>Tile</option><option value=&quot;Toe&quot;>Toe</option><option value=&quot;Top&quot;>Top</option><option value=&quot;Torus&quot;>Torus</option><option value=&quot;Trefoil&quot;>Trefoil</option><option value=&quot;Tube&quot;>Tube</option><option value=&quot;Unguentarium&quot;>Unguentarium</option><option value=&quot;Vessel&quot;>Vessel</option><option value=&quot;Votive&quot;>Votive</option><option value=&quot;Wall&quot;>Wall</option><option value=&quot;Water Jar&quot;>Water Jar</option><option value=&quot;Wire&quot;>Wire</option>';
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                            '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Terminus Ante Quem</td>
                                            <td<?php $name = "Artifact - Structure Terminus Ante Quem";
                                            if( array_key_exists( $name, $subjects ) ){
                                                $text = '';
                                                if( !is_string($subjects[$name]) ){
                                                    if($subjects[$name]['prefix']){
                                                       $text = $subjects[$name]['prefix'] . " ";
                                                    }
                                                    $text = $text . $subjects[$name]['month'] . "/" . $subjects[$name]['day'] . "/" . $subjects[$name]['year'] . " ". $subjects[$name]['era'];
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Terminus Post Quem</td>
                                            <td<?php $name = "Artifact - Structure Terminus Post Quem";
                                            if( array_key_exists( $name, $subjects ) ){
                                                $text = '';
                                                if( !is_string($subjects[$name]) ){
                                                    if($subjects[$name]['prefix']){
                                                       $text = $subjects[$name]['prefix'] . " ";
                                                    }
                                                    $text = $text . $subjects[$name]['month'] . "/" . $subjects[$name]['day'] . "/" . $subjects[$name]['year'] . " ". $subjects[$name]['era'];
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Title</td>
                                            <td<?php $name = "Artifact - Structure Title";
                                            if( array_key_exists( $name, $subjects )){
                                                $text = $subjects[$name];
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Geolocation</td>
                                            <td<?php $name = "Artifact - Structure Geolocation";
                                            if( array_key_exists( $name, $subjects ) ){
                                                $text = '';
                                                if( !is_string($subjects[$name]) ){
                                                    foreach( $subjects[$name] as $geolocation) { $text = $text.$geolocation."<br>";}
                                                }
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_input">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_input"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Excavation Unit</td>
                                            <td<?php $name = "Artifact - Structure Excavation Unit";
                                            if( array_key_exists( $name, $subjects ) ){
                                                $text = '';
                                                if( !is_string($subjects[$name]) ){
                                                    foreach( $subjects['Artifact - Structure Excavation Unit'] as $excavation_unit) { $text = $text.$excavation_unit."<br>";}
                                                }
                                                $options = '<option value=&quot;HEX-72-1&quot;>HEX-72-1</option><option value=&quot;HEX-72-2&quot;>HEX-72-2</option><option value=&quot;HEX-72-3&quot;>HEX-72-3</option><option value=&quot;HEX-72-4&quot;>HEX-72-4</option><option value=&quot;HEX-72-5&quot;>HEX-72-5</option><option value=&quot;HEX-72-6&quot;>HEX-72-6</option><option value=&quot;HEX-72-7&quot;>HEX-72-7</option><option value=&quot;HEX-72-8&quot;>HEX-72-8</option><option value=&quot;Trench 93-1&quot;>Trench 93-1</option><option value=&quot;Trench 95-6&quot;>Trench 95-6</option><option value=&quot;Trench 95-7&quot;>Trench 95-7</option><option value=&quot;Trench 2003-1&quot;>Trench 2003-1</option><option value=&quot;Trench 2003-2&quot;>Trench 2003-2</option><option value=&quot;Trench 2004-1&quot;>Trench 2004-1</option><option value=&quot;Trench 2004-2&quot;>Trench 2004-2</option><option value=&quot;Trench 2004-3&quot;>Trench 2004-3</option><option value=&quot;Trench 2004-4&quot;>Trench 2004-4</option><option value=&quot;Trench 2005-1&quot;>Trench 2005-1</option><option value=&quot;Trench 2005-2&quot;>Trench 2005-2</option><option value=&quot;Trench 2005-3&quot;>Trench 2005-3</option><option value=&quot;Trench 2005-4&quot;>Trench 2005-4</option><option value=&quot;Trench 2005-5&quot;>Trench 2005-5</option><option value=&quot;Trench 2005-6&quot;>Trench 2005-6</option><option value=&quot;Trench 2006-1&quot;>Trench 2006-1</option><option value=&quot;Trench 2006-2&quot;>Trench 2006-2</option><option value=&quot;Trench 2007-1&quot;>Trench 2007-1</option><option value=&quot;Trench 2007-2&quot;>Trench 2007-2</option><option value=&quot;Trench 2007-3&quot;>Trench 2007-3</option><option value=&quot;Trench 2008-1&quot;>Trench 2008-1</option>'.
                                                            '<option value=&quot;Trench 2008-2&quot;>Trench 2008-2</option><option value=&quot;Trench 2008-3&quot;>Trench 2008-3</option><option value=&quot;Trench 2008-4&quot;>Trench 2008-4</option><option value=&quot;Trench 2009-1&quot;>Trench 2009-1</option><option value=&quot;Trench 2009-2&quot;>Trench 2009-2</option><option value=&quot;Trench 2009-3&quot;>Trench 2009-3</option><option value=&quot;Trench 2010-1&quot;>Trench 2010-1</option><option value=&quot;Trench 2010-2&quot;>Trench 2010-2</option><option value=&quot;Trench 2010-3&quot;>Trench 2010-3</option><option value=&quot;Trench 2010-4&quot;>Trench 2010-4</option><option value=&quot;Trench 2010-5&quot;>Trench 2010-5</option><option value=&quot;Trench 2011-1&quot;>Trench 2011-1</option><option value=&quot;Trench 2011-2&quot;>Trench 2011-2</option><option value=&quot;Trench 2011-3&quot;>Trench 2011-3</option><option value=&quot;Trench 2011-4&quot;>Trench 2011-4</option><option value=&quot;Trench 2011-5&quot;>Trench 2011-5</option><option value=&quot;Trench GB-70-1&quot;>Trench GB-70-1</option><option value=&quot;Trench GB-70-2&quot;>Trench GB-70-2</option><option value=&quot;Trench GB-70-3&quot;>Trench GB-70-3</option><option value=&quot;Trench GB-70-4&quot;>Trench GB-70-4</option><option value=&quot;Trench GB-70-5&quot;>Trench GB-70-5</option><option value=&quot;Trench GB-70-6&quot;>Trench GB-70-6</option><option value=&quot;Trench GB-70-7&quot;>Trench GB-70-7</option><option value=&quot;Trench GB-70-8&quot;>Trench GB-70-8</option><option value=&quot;Trench GB-70-9&quot;>Trench GB-70-9</option><option value=&quot;Trench GB-70-10&quot;>Trench GB-70-10</option><option value=&quot;Surface Find&quot;>Surface Find</option>';
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                            '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Description</td>
                                            <td<?php $name = "Artifact - Structure Description";
                                            if( array_key_exists( $name, $subjects )){
                                                $text = $subjects[$name];
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Location</td>
                                            <td<?php $name = "Artifact - Structure Location";
                                            if( array_key_exists( $name, $subjects ) ){
                                                $text = '';
                                                if( !is_string($subjects[$name]) ){
                                                    foreach($subjects['Artifact - Structure Location'] as $structure_location) { $text = $text.$structure_location."<br>";}
                                                }
                                                $options = "<option value=&quot;Architecture&quot;>Architecture</option><option value=&quot;Area Northwest of Temple&quot;>Area Northwest of Temple</option><option value=&quot;Bones&quot;>Bones</option><option value=&quot;Broneer Excavation Dump&quot;>Broneer Excavation Dump</option><option value=&quot;Decauville Graves&quot;>Decauville Graves</option><option value=&quot;Dump&quot;>Dump</option><option value=&quot;Early Stadium&quot;>Early Stadium</option><option value=&quot;East Field&quot;>East Field</option><option value=&quot;Field Notes&quot;>Field Notes</option><option value=&quot;Filis Area&quot;>Filis Area</option><option value=&quot;Fortress&quot;>Fortress</option><option value=&quot;Fortress Stairways&quot;>Fortress Stairways</option><option value=&quot;Fortress Tower&quot;>Fortress Tower</option><option value=&quot;Fortress Tower 5&quot;>Fortress Tower 5</option><option value=&quot;Fortress Wall&quot;>Fortress Wall</option><option value=&quot;Gellis Wall&quot;>Gellis Wall</option><option value=&quot;Gully Bastion&quot;>Gully Bastion</option><option value=&quot;Gully Bastion Grave 2&quot;>Gully Bastion Grave 2</option><option value=&quot;Hexamilion&quot;>Hexamilion</option><option value=&quot;Hexamillion Outworks&quot;>Hexamillion Outworks</option><option value=&quot;House of Dimitrios Spanos&quot;>House of Dimitrios Spanos</option><option value=&quot;Iconic Base&quot;>Iconic Base</option><option value=&quot;IΣ Box 2&quot;>IΣ Box 2</option><option value=&quot;Lambrou Cemetery&quot;>Lambrou Cemetery</option><option value=&quot;Later Stadium&quot;>Later Stadium</option>".
                                                            "<option value=&quot;Loukos&quot;>Loukos</option><option value=&quot;Loukos Dump&quot;>Loukos Dump</option><option value=&quot;Loukos Grave&quot;>Loukos Grave</option><option value=&quot;N of T1 Wall&quot;>N of T1 Wall</option><option value=&quot;National Road&quot;>National Road</option><option value=&quot;North Drain&quot;>North Drain</option><option value=&quot;Northeast Gate&quot;>Northeast Gate</option><option value=&quot;Northwest Gate&quot;>Northwest Gate</option><option value=&quot;Northwest Precinct&quot;>Northwest Precinct</option><option value=&quot;Northwest Reservoir&quot;>Northwest Reservoir</option><option value=&quot;Roman Bath&quot;>Roman Bath</option><option value=&quot;Sanctuary of Poseidon&quot;>Sanctuary of Poseidon</option><option value=&quot;South Gate&quot;>South Gate</option><option value=&quot;Stadium&quot;>Stadium</option><option value=&quot;Stray Find&quot;>Stray Find</option><option value=&quot;Surface Find&quot;>Surface Find</option><option value=&quot;Temple&quot;>Temple</option><option value=&quot;Theater&quot;>Theater</option><option value=&quot;Theater Court&quot;>Theater Court</option><option value=&quot;Theater Court 2&quot;>Theater Court 2</option><option value=&quot;Tower 2&quot;>Tower 2</option><option value=&quot;Tower 5&quot;>Tower 5</option><option value=&quot;Tower 6&quot;>Tower 6</option><option value=&quot;Tower 10&quot;>Tower 10</option><option value=&quot;Tower 14&quot;>Tower 14</option><option value=&quot;Tower 15&quot;>Tower 15</option><option value=&quot;West Cemetery&quot;>West Cemetery</option><option value=&quot;Theatre&quot;>Theatre</option><option value=&quot;Area Southwest of Stadium&quot;>Area Southwest of Stadium</option><option value=&quot;Northwest of Temple&quot;>Northwest of Temple</option><option value=&quot;Unknown&quot;>Unknown</option><option value=&quot;Tower 18&quot;>Tower 18</option><option value=&quot;Dump: 1969-72&quot;>Dump: 1969-72</option><option value=&quot;Justinian's Fortress Tower 14&quot;>Justinian's Fortress Tower 14</option><option value=&quot;Justinian's Fortress&quot;>Justinian's Fortress</option><option value=&quot;Justinian's Wall Tower 14&quot;>Justinian's Wall Tower 14</option><option value=&quot;Surface&quot;>Surface</option><option value=&quot;Ionic Base&quot;>Ionic Base</option><option value=&quot;Fortress Tower 15&quot;>Fortress Tower 15</option><option value=&quot;Fortress Tower 2&quot;>Fortress Tower 2</option><option value=&quot;Agios Vasilios&quot;>Agios Vasilios</option><option value=&quot;Site&quot;>Site</option><option value=&quot;North of Temple&quot;>North of Temple</option><option value=&quot;Area North of Temple&quot;>Area North of Temple</option><option value=&quot;Gate&quot;>Gate</option>";
                                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                            '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                                foreach($metadataEdits as $value) {
                                                    if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                    }} echo $string;
                                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                            ?>
                                            </td>
                                        </tr>

                                    </table>
                                </div>

                                <?php } ?>
                                <?php } else { ?>
                                <div class="no-data">
                                    This resource doesn’t have associated SOO data.
                                </div>
                                <?php } ?>

                            <!--</div>-->

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
                            <?php echo $this->Html->image('CloseComment.svg', array('class' => 'closeComment'));?>
                        </form>

                        <form class="newReplyForm"><textarea name="comment" class="replyTextArea"
                                                             placeholder="Enter reply here..."></textarea><br>
                            <button type="submit">ADD NEW REPLY</button>
                            <?php echo $this->Html->image('CloseComment.svg', array('class' => 'closeComment'));?>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<div id="resources-nav">
    <div id="button-left">
        <a href="#" id="left-button">
            <img src="../img/arrowLeft-White.svg" height="220px" width="10px" />
        </a>
    </div>
    <div id="other-resources-container">
        <div id="other-resources" style="min-width: <?php $length = 220*count($pages); echo " $length
        ";?>px">
		<?php $cnt = 0;?>
        <?php foreach($pages as $r): ?>
		<?php $cnt++;?>

        <a  class='other-resources' href="#">
            <img id="identifier-<?= $r["kid"]; ?>" class="other-resource" src="<?php echo $r['thumbnail'] ?>" height="200px" width="200px"/>
			<?php if ($cnt ==1) :?>
				<div class='numberOverResources selectedResource'>
					<?php echo $cnt; ?>
				</div>
			<?php endif ?>
			<?php if ($cnt !=1) :?>
				<div class='numberOverResources'>
					<?php echo $cnt; ?>
				</div>
			<?php endif ?>
        </a>

        <?php endforeach ?>
    </div> <!--#other-resources-contain -->
</div> <!--#other-resources-container -->
<div id="button-right">
    <a href="#" id="right-button">
        <img src="../img/arrowRight-White.svg" height="220px" width="10px" />
    </a>
</div>
</div>


<pre id="preview"></pre>


<script>



    //addMetadataEdits();
    //console.log($session);
    function addMetadataEdits() {
        switch (meta_scheme_name){
            case "Project":
                meta_scheme_id = "<?php echo PROJECT_SID; ?>";
                meta_resource_kid = "<?php echo $project['kid']; ?>";
                break;
            case "Season":
                meta_scheme_id = "<?php echo SEASON_SID; ?>";
                meta_resource_kid = "<?php echo $season['kid']; ?>";
                break;
            case "Excavation/Survey":
                meta_scheme_id = "<?php echo SURVEY_SID; ?>";
                //finds the kid somewhere else.
                break;
            case "Archival_Object":
                meta_scheme_id = "<?php echo RESOURCE_SID; ?>";
                meta_resource_kid = resourceKid;
                break;
            case "Subject_Of_Observation":
                meta_scheme_id = "<?php echo SUBJECT_SID; ?>";
                //finds the kid somewhere else
                break;
        }
        $.ajax({
            url: arcs.baseURL + "metadataedits/add",
            type: "post",
            data: {
                resource_kid: resourceKid,
                resource_name: "<?php echo $resource['Title']; ?>",
                scheme_id: meta_scheme_id,
                //scheme_name: meta_scheme_name, //no longer used
                control_type: meta_control_type,
                field_name: meta_field_name,
                user_id: "idk",   //this is set somewhere else
                value_before: meta_value_before,
                new_value: meta_new_value,
                approved: 0,
                rejected: 0,
                reason_rejected: "",
                metadata_kid: meta_resource_kid
            },
            success: function (data) {
                //console.log("MetadataEditsHere");
                //console.log(data);
                window.location.reload();
            }
        })
    }
    var metadataIsSelected = 0;     //0 or 1 to know if there is one selected
    var editBtnClick = 0;           //0 or 1
    var meta_field_name = '';       //data sent to arcs kora plugin---
    var meta_control_type = '';
    var meta_options = '';
    var meta_value_before = '';
    var meta_new_value = '';
    var meta_scheme_name = '';
    var meta_resource_kid = '';
    var meta_scheme_id = 0;

    var associator_full_array = new Array();  //used for associator modal
    var associator_selected = new Array();

    $(".metadataEdit").click(function(e) {
        //console.log("metadataEdit click");
        $(this).each(
            function(){

                if( metadataIsSelected == 1 ){ // a metadata is already being edited

                    //check if the one being clicked on is the one being edited and return if it is.
                    var parent_edit = $('#meta_textarea').parent();
                    console.log
                    if( $(e.target).is('#meta_textarea') || $(e.target).is(parent_edit) || $('#meta_textarea').has($(e.target)[0]).length == 1 ){
                            return;
                    }

                    // there is already an edit within the same scheme.
                    // remove the first edit and fire another click to get the new edit.

                    //$(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
                    //var id = $("#meta_textarea").parent().children("div").eq(0).text();
                    var text = $("#meta_textarea").text();
                    if( meta_options == '' ){
                        if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                            meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
                        }
                        var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'">'+meta_value_before+"</div>";
                    }else{
                        meta_options = meta_options.replace(/["]+/g, '&quot;');
                        //console.log(meta_options);
                        if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                            meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
                        }
                        var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'" data-options="'+meta_options+'">'+meta_value_before+"</div>";
                    }
                    $("#meta_textarea").parent().replaceWith(fill);
                    metadataIsSelected = 0;
                    $(e.target).click(); // reclick to begin editing the new metadata

                }else if ($(this).find('textarea').length || editBtnClick == 0){
                    //the edit button wasn't clicked so do nothing
                    return;

                }else {
                    // removes the text, appends an input and sets the value to the text-value
                    meta_field_name = $(this).children('div').eq(1).attr('id');
                    meta_control_type = $(this).children('div').eq(1).attr('data-control');
                    meta_options = '';
                    //console.log('meta control');
                    //console.log(meta_control_type);
                    meta_scheme_name = $(this).parent().parent().parent().attr('id');
                    meta_resource_kid = $(this).parent().parent().parent().parent().attr('data-kid');
                    var temp_element = $(this).children('div').eq(1).clone();
                    temp_element.find('br').replaceWith('\n');
                    meta_value_before = temp_element.text();
                    //console.log('meta_value before:');
                    //console.log(meta_value_before);

                    //give different control edits based on the kora control type
                    var html = '';
                    if( meta_control_type == 'text' ){
                        html = $('<textarea />',{'value' : meta_value_before, 'id' : 'meta_textarea'}).val(meta_value_before);
                        $(this).children('div').eq(1).html(html);

                    }else if( meta_control_type == 'date' ){
                        html= '<div class="kora_control" id="meta_textarea">'+
                                    '<select class="kcdc_month" id="month_select">'+
                                        '<option value="">&nbsp;</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>'+
                                    '</select>'+
                                    '<select class="kcdc_day" id="day_select">'+
                                        '<option value="">&nbsp;</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>'+
                                    '</select>'+
                                    '<select class="kcdc_year"  id="year_select">'+
                                        '<option value="">&nbsp;</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option>'+
                                    '</select>'+
                                    '<input type="hidden" class="kcdc_era" id="era" value="CE">'+
                                    '<div class="ajaxerror"></div>'+
                                '</div>';
                        $(this).children('div').eq(1).html(html);

                        var month = '';
                        var day = '';
                        var year = '';

                        if( meta_value_before != '' ){
                            var valueArray = meta_value_before.split(" ");
                            var dateString = valueArray[0];
                            var dateArray = dateString.split("/");
                            month = dateArray[0];
                            day = dateArray[1];
                            year = dateArray[2];
                            //console.log('year:');
                            //console.log(year);
                            $('#month_select option[value="'+ month +'"]').prop('selected', true);
                            $('#day_select option[value="'+ day +'"]').prop('selected', true);
                            $('#year_select option[value="'+ year +'"]').prop('selected', true);
                        }

                    }else if( meta_control_type == 'terminus' ){
                        html= '<div class="kora_control" id="meta_textarea">'+
                                    '<select class="kcdc_month" id="month_select">'+
                                        '<option value="">&nbsp;</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>'+
                                    '</select>'+
                                    '<select class="kcdc_day" id="day_select">'+
                                        '<option value="">&nbsp;</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>'+
                                    '</select>'+
                                    '<select class="kcdc_year" id="year_select"><option value="">&nbsp;</option>';
                                        for (i = 1; i < 10000; i++) {
                                            html += '<option value="'+i+'">'+i+'</option>';
                                        }
                                    html += '</select>'+
                                    '<select class="kcdc_era" id="era_select"><option value="" selected="selected">'+
                                        '</option><option value="CE">CE</option><option value="BCE">BCE</option>'+
                                    '</select><br />Prefix: '+
                                    '<select class="kcdc_prefix"  id="prefix_select">'+
                                        '<option></option><option value="ca">ca</option>'+
                                    '</select>'+
                                    '<div class="ajaxerror"></div>'+
                                '</div>';
                        $(this).children('div').eq(1).html(html);

                        var month = '';
                        var day = '';
                        var year = '';
                        var prefix = '';
                        var era = '';

                        /////change text date to date array----
                        if( meta_value_before != '' ){
                            var valueArray = meta_value_before.split(" ");
                            var dateString = '';
                            if( valueArray[0].indexOf('/') == -1 ){     // '/' does not exist in array, it is the prefix
                                prefix = valueArray[0];
                                dateString = valueArray[1];
                                if(typeof valueArray[2] !== 'undefined') { //does exist
                                    era = valueArray[2];
                                }

                            }else{      // '/' does exit it is the date
                                dateString = valueArray[0];
                                if(typeof valueArray[1] !== 'undefined') { //does exist
                                    era = valueArray[1];
                                }
                            }
                            var dateArray = dateString.split("/");
                            month = dateArray[0];
                            day = dateArray[1];
                            year = dateArray[2];
                            $('#month_select option[value="'+ month +'"]').prop('selected', true);
                            $('#day_select option[value="'+ day +'"]').prop('selected', true);
                            $('#year_select option[value="'+ year +'"]').prop('selected', true);
                            if( prefix != '' ){
                                $('#prefix_select option[value="'+ prefix +'"]').prop('selected', true);
                            }
                            if( era != ''){
                                $('#era_select option[value="'+ era +'"]').prop('selected', true);
                            }
                        }

                    }else if( meta_control_type == 'multi_input' ){
                        html = '<div class="kora_control" id="meta_textarea">'+
                                    '<table>'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<td><input type="text" class="kcmtc_additem" name="Input135" id="Input135" value=""></td>'+
                                                '<td><input type="button" class="kcmtc_additem" id="multi_input_add" value="Add"></td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td rowspan="3">'+
                                                    '<select id="p123c135" class="kcmtc_curritems fullsizemultitext" name="p123c135[]" multiple="multiple" size="5">';
                                                        if( meta_value_before != '' ){
                                                            var valueArray = meta_value_before.split("\n");
                                                            valueArray.pop(); //remove the trailing ''
                                                            valueArray.forEach(function (tempdata) {
                                                                html += '<option class="multi_input_option" value="'+ tempdata +'" selected>'+ tempdata +'</option>';
                                                            });
                                                        }
                                                    html += '</select>'+
                                                '</td>'+
                                                '<td><input type="button" class="kcmtc_removeitem" id="multi_input_remove" value="Remove"></td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td><input type="button" class="kcmtc_moveitemup" id="multi_input_up" value="Up"></td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td><input type="button" class="kcmtc_moveitemdown" id="multi_input_down" value="Down"></td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                    '<div class="ajaxerror"></div>'+
                                '</div>';
                        $(this).children('div').eq(1).html(html);
                        $('#multi_input_add').click(function(e) {
                            var textBar = $('#Input135');
                            var text = textBar.val();
                            html = '<option class="multi_input_option" value="'+ text +'" selected>'+ text +'</option>';
                            $('#p123c135').append(html);
                            textBar.val('');
                        });
                        $('#multi_input_remove').click(function(e) {
                            var $option = $( "#meta_textarea option:selected" );
                            if( $option.length == 1 ){
                                $option.remove();
                            }
                        });
                        $('#multi_input_up').click(function(e) {
                            var $option = $( "#meta_textarea option:selected" );
                            if( $option.length == 1 && $option.prev().hasClass('multi_input_option') ){
                                $option.insertBefore( $option.prev() );
                            }
                        });
                        $('#multi_input_down').click(function(e) {
                            var $option = $( "#meta_textarea option:selected" );
                            if( $option.length == 1 && $option.next().hasClass('multi_input_option') ){
                                $option.insertAfter( $option.next() );
                            }
                        });

                    }else if( meta_control_type == 'multi_select'){
                        meta_options = $(this).children('div').eq(1).attr('data-options');
                        html = '<div class="kora_control" id="meta_textarea">'+
                                    '<select id="p123c25" class="kcmlc_curritems" name="p123c25[]" multiple="multiple" size="5">'+
                                        meta_options +
                                    '</select>'+
                                    '<div class="ajaxerror"></div>'+
                                '</div>';
                        $(this).children('div').eq(1).html(html);
                        if( meta_value_before != '' ){
                            var valueArray = meta_value_before.split("\n");
                            valueArray.pop(); //remove the trailing ''
                            valueArray.forEach(function (tempdata) {
                                $('#meta_textarea option[value="'+ tempdata +'"]').prop('selected', true);
                            });
                        }

                    }else if( meta_control_type == 'list' ){
                        meta_options = $(this).children('div').eq(1).attr('data-options');
                        html = '<div class="kora_control" id="meta_textarea">'+
                                    '<select name="p123c15">'+
                                    '<option value="">&nbsp;</option>'+
                                    meta_options +
                               '</select></div>';
                        $(this).children('div').eq(1).html(html);
                        if( meta_value_before != '' ){
                            $('#meta_textarea option[value="'+ meta_value_before +'"]').prop('selected', true);
                        }
                    }else if( meta_control_type == 'associator' ){
                        $('#associatorTitle').html('Edit ' + meta_field_name + ' Metadata' );
                        $('.associatorModalBackground').show();
                        //add the preloader gif
                        var html = '<img alt="preloader gif" src="'+ arcs.baseURL + 'img/arcs-preloader.gif" style="display:block;margin:20px auto 0 auto;" />';
                        $('#associatorSearchObjects').append(html);
                        associator_modal = $('.associatorModalBackground')[0].outerHTML;

                        $.ajax({
                            url: arcs.baseURL + "metadataedits/getAllKidsByScheme",
                            type: "POST",
                            data: {
                                scheme_name: meta_field_name
                            },
                            success: function (data) {
                                associator_full_array = new Array();
                                for (var key in data) {
                                    if (data.hasOwnProperty(key)) {

                                        var obj = data[key];
                                        obj.kid = key;
                                        associator_full_array.push(obj);
                                    }
                                }
                                //console.log(associator_full_array);
                                populateAssociatorCheckboxes();
                            }
                        });

                    }
                    metadataIsSelected = 1;
                }
            })
    });
    $('.associatorSearchSubmit').on('click', function(evt){
        evt.stopImmediatePropagation();
        //console.log('associator submit clicked');
        meta_new_value = '';
        $('#associatorSearchObjects input:checked').each(function () {
             meta_new_value += $( this ).val() + "\n";
        });
        if( meta_new_value != '' ){
            meta_new_value = meta_new_value.substring(0, meta_new_value.length - 1);
        }
        addMetadataEdits();

    });

    $('#associatorSearchObjects').on('click', 'label', function(evt){
        //console.log('clicked label');
        if( meta_field_name == 'Project Associator' || meta_field_name == 'Season Associator' ){
            $('#associatorSearchObjects input:checked').each(function () {
                 $(this).attr('checked', false);
            });
        }
    });
    $('.modalCloseAssociator').click(function() {
        if( associator_full_array.length > 1000 ){
            //needs to reload the page or else it can suffer severe ui lags
            location.reload();
        }else{
            $('#associatorSearchObjects').html('');
            $(".associatorModalBackground").hide();
            $(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
            metadataIsSelected = 0;
            editBtnClick = 0;
        }
    });

    function populateAssociatorCheckboxes() {
        //console.log('start associator populate');

        var populateCheckboxes = "<hr>";
        for (i = 0; i < associator_full_array.length; i++) {
            var obj = associator_full_array[i];
            var kid = '';
            var text = '';
            for (var field in obj) {
                if (obj.hasOwnProperty(field) && field != 'pid' && field != 'schemeID' && field != 'linkers' ) {
                    if( field == 'kid' ){
                        kid = obj[field];
                    }else if( field == 'Image Upload' ){
                        text += 'Original Name: ' + obj[field]['originalName'] + '<br />';
                    }else{
                        text += field + ': ' + obj[field] + '<br />';
                    }
                }
            }
            populateCheckboxes += "<input type='checkbox' class='checkedboxes' name='associator-item-" + i + "' id='associator-item-" + i + "' value='" + kid + "' />"
                                + "<label for='associator-item-" + i + "'><div style='float:left'>" + kid + " </div><div style='float:right'>" + text + "</div></label><br />";

        }
        $('#associatorSearchObjects').html(populateCheckboxes);
        if( meta_value_before != '' ){
            var valueArray = meta_value_before.split("\n");
            valueArray.pop(); //remove the trailing ''
            valueArray.forEach(function (tempdata) {
                var label_for = $('#associatorSearchObjects input[value="'+ tempdata +'"]').attr('name');
                $("#associatorSearchObjects label[for="+label_for+"]").trigger('click');
            });
        }
    }
    function associatorSearch() {
        var query = $(".associatorSearchBar").val();
        if( query == '' ){
            return;
        }
        for (i = 0; i < associator_full_array.length; i++) {
            var obj = associator_full_array[i];
            if (obj.hasOwnProperty('kid') && obj.kid == query ) {
                $('label[for="associator-item-'+ i +'"]')[0].scrollIntoView();
            }
        }


    }

    $(document).on("click", ".edit-btn", function() {
        //console.log("edit-btn clicked");
        $('.metadataEdit').css('cursor', 'default');
        if (editBtnClick != 1) {
            $(this).text("SAVE");
            $(this).css({'color':'#0093be'});
            $(this).addClass("save-btn").removeClass("edit-btn");
        }
        editBtnClick = 1;
        $(this).parent().next().find('.metadataEdit').css('cursor', 'pointer');
    });

    // Details tab
    $(".details").click(function () {
        GetDetails();

    });

    $(".level-tab span .save-btn").click(function() {
        //console.log("level tab save btn click");
    });

    $(".soo-click").click(function() {
        //console.log("sso click change");
        $(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
        var id = $("#meta_textarea").parent().children("div").eq(0).text();
        var text = $("#meta_textarea").text();
        if( meta_options == '' ){
            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'">'+meta_value_before+"</div>";
        }else{
            meta_options = meta_options.replace(/["]+/g, '&quot;');
            //console.log(meta_options);
            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'" data-options="'+meta_options+'">'+meta_value_before+"</div>";
        }
        $("#meta_textarea").parent().replaceWith(fill);
        metadataIsSelected = 0;
        editBtnClick = 0;
    });

    $(".level-tab").click(function(e) {
        //console.log("clicked thingy");
        //console.log(e);
        $('.metadataEdit').css('cursor', 'default');
        if( e.target.getAttribute("class") == 'save-btn' ){
            //console.log("level tab save btn click");
             e.stopPropagation();
            if (metadataIsSelected == 1) {
                $(".save-btn").removeClass("save-btn");
                meta_new_value = '';
                if( meta_control_type == 'text' ){
                    meta_new_value = $("#meta_textarea").val();

                }else if( meta_control_type == 'list' ){
                    meta_new_value = $( "#meta_textarea option:selected" ).text();

                }else if( meta_control_type == 'date' ){
                    var month='', day='', year='';
                    month = $('#month_select option:selected').text();
                    day = $('#day_select option:selected').text();
                    year = $('#year_select option:selected').text();

                    meta_new_value = month + '/' + day + '/' + year + ' CE';

                }else if( meta_control_type == 'terminus' ){
                    var month='', day='', year='', prefix='', era='';
                    month = $('#month_select option:selected').text();
                    day = $('#day_select option:selected').text();
                    year = $('#year_select option:selected').text();
                    prefix = $('#prefix_select option:selected').text();
                    era = $('#era_select option:selected').text();

                    if( prefix != '' ){
                        meta_new_value = prefix + ' ';
                    }
                    meta_new_value += month + '/' + day + '/' + year;

                    if( era != '' ){
                        meta_new_value += ' ' + era;
                    }

                }else if( meta_control_type == 'multi_input' ){
                    $( "#meta_textarea option" ).each(function() {
                          meta_new_value += $( this ).text() + "\n";
                    });
                    if( meta_new_value != '' ){
                        meta_new_value = meta_new_value.substring(0, meta_new_value.length - 1);
                    }

                }else if( meta_control_type == 'multi_select' ){
                    $( "#meta_textarea option:selected" ).each(function() {
                          meta_new_value += $( this ).text() + "\n";
                    });
                    if( meta_new_value != '' ){
                        meta_new_value = meta_new_value.substring(0, meta_new_value.length - 1);
                    }

                }
                addMetadataEdits();
            }
            return;
        }
        if( e.target.getAttribute("aria-expanded") == 'true' ){
            //console.log("already expanded");
            return;
        }
        $(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
        var id = $("#meta_textarea").parent().children("div").eq(0).text();
        var text = $("#meta_textarea").text();
        if( meta_options == '' ){
            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'">'+meta_value_before+"</div>";
        }else{
            meta_options = meta_options.replace(/["]+/g, '&quot;');
            //console.log(meta_options);
            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'" data-options="'+meta_options+'">'+meta_value_before+"</div>";
        }
        $("#meta_textarea").parent().replaceWith(fill);
        metadataIsSelected = 0;
        editBtnClick = 0;
        if ($(this).hasClass("transcriptionTab") && !$(".editTranscriptions").is(":visible") && !$(".editOptions").is(":visible")) $(".editTranscriptions").show();
        if (!$(this).hasClass("transcriptionTab")) {
            $(".editTranscriptions").hide();
            $(".editOptions").hide();
            $(".newTranscriptionForm").hide();
        }
    });

    $(".editTranscriptions").click(function() {
        $(".editOptions").show();
        $(".editTranscriptions").hide();

        $(".content_transcripts").sortable({
            disabled: false,
            sort: function(e) {
                $(".newTranscriptionForm").hide();
            }
        });

        $('.transcript_display').addClass("editable");
        $(".editInstructions").show();
    });

    $(".newTranscription").click(function() {
        $('.content_transcripts').append($(".newTranscriptionForm"));
        $(".newTranscriptionForm").show();
    });

    $(".saveTranscription").click(function() {
        $(".transcriptionTextarea").val('');
        $(".newTranscriptionForm").hide();
        $(".editOptions").hide();
        $(".editTranscriptions").show();

        var sortedIDs = $(".content_transcripts").sortable("toArray");
        $.each(sortedIDs, function(k, v) {
            $.ajax({
                url: arcs.baseURL + "api/annotations/"+ v +".json",
                type: "POST",
                data: {
                    order_transcript: k
                }
            });
        });

        $(".content_transcripts").sortable({disabled: true});
        $('.transcript_display').removeClass("editable");
        $(".editInstructions").hide();
    });

    $(".newTranscriptionForm").submit(function(e) {
        e.preventDefault();
        annotateData.page_kid = kid;
        annotateData.resource_kid = resourceKid;
        annotateData.resource_name = "<?php echo $resource['Resource Identifier']; ?>";
        annotateData.transcript = $(".transcriptionTextarea").val();
        annotateData.order_transcript = 1000000;

        if (annotateData.transcript.length > 0)
            $.ajax({
                url: arcs.baseURL + "api/annotations.json",
                type: "POST",
                data: annotateData,
                success: function () {
                    $(".transcriptionTextarea").val('');
                    $(".newTranscriptionForm").hide();
                    ResetAnnotationModal();
                    GetDetails();
                }
            });
    });

</script>
