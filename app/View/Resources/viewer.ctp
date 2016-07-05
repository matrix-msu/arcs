<!-- pre><?php var_dump($surveys); ?></pre -->
<div class="viewers-container">

    <div class="modalBackground">
        <div class="flagWrap">
            <div id="flagModal">
                <div class="flagModalHeader">NEW FLAG <img src="../app/webroot/assets/img/Close.svg"
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
                        <input type="text" class="collectionSearchBar" placeholder="Search for collections">
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
                    <img class="resources-annotate-icon" src="../img/AnnotationsOff.svg">
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
                                <td<?php $name = "Name"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Country</td>
                                <td<?php $name = "Country"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Region</td>
                                <td<?php $name = "Region"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Geolocation</td>
                                <td<?php $name = "Geolocation"; $text = ''; foreach($project['Geolocation'] as $geolocation) {$text = $text.$geolocation."<br>";}
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Modern Name</td>
                                <td<?php $name = "Modern Name"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Location Identifier</td>
                                <td<?php $name = "Location Identifier"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Location Identifier Scheme</td>
                                <td<?php $name = "Location Identifier Scheme"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Elevation</td>
                                <td<?php $name = "Elevation"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Latest Date</td>
                                <td<?php $name = "Latest Date"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Records Archive</td>
                                <td<?php $name = "Records Archive"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Persistent Name</td>
                                <td<?php $name = "Persistent Name"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Complex Title</td>
                                <td<?php $name = "Complex Title"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Terminus Ante Quem</td>
                                <td<?php $name = "Terminus Ante Quem"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Terminus Post Quem</td>
                                <td<?php $name = "Terminus Post Quem"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Period</td>
                                <td<?php $name = "Period"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Archaeological Culture</td>
                                <td<?php $name = "Archaeological Culture"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Description</td>
                                <td<?php $name = "Description"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Brief Description</td>
                                <td<?php $name = "Brief Description"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Permitting Heritage Body</td>
                                <td<?php $name = "Permitting Heritage Body"; $text = $project[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $project['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
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
                                <td>Title</td>
                                <td<?php $name = "Title"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td<?php $name = "Type"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Director</td>
                                <td<?php $name = "Director"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Registrar</td>
                                <td<?php $name = "Registrar"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Sponsor</td>
                                <td<?php $name = "Sponsor"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date"; $text = ''; if ($season['Earliest Date']['year']) {$text = $season['Earliest Date']['year'] . "/" . $season['Earliest Date']['month'] . "/" . $season['Earliest Date']['day'];}
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Latest Date</td>
                                <td<?php $name = "Earliest Date"; $text = ''; if ($season['Latest Date']['year']) {$text = $season['Latest Date']['year'] . "/" . $season['Latest Date']['month'] . "/" . $season['Latest Date']['day'];}
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Ante Quem</td>
                                <td<?php $name = "Terminus Ante Quem"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Post Quem</td>
                                <td<?php $name = "Terminus Post Quem"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td<?php $name = "Description"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 2"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 2"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 3"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 3"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 4"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 4"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 5"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 5"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 6"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 6"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <tdContributor</td>
                                <td><?php $name = "Contributor 7"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <tdContributor Role</td>
                                <td><?php $name = "Contributor Role 7"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 8"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 8"; $text = $season[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $season['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
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
                                            <td>Name</td>
                                            <td<?php $name = "Name"; $text = $survey[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td<?php $name = "Type"; $text = $survey[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Supervisor</td>
                                            <td<?php $name = "Supervisor"; $text = ''; foreach($survey[$name] as $survey_sup) {$text = $text.$survey_sup."<br>";}
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Earliest Date</td>
                                            <td<?php $name = "Earliest Date"; $text = ''; if ($survey['Earliest Date']['year']) {$text = $survey['Earliest Date']['year'] . "/" . $survey['Earliest Date']['month'] . "/" . $survey['Earliest Date']['day'];}
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Latest Date</td>
                                            <td<?php $name = "Latest Date"; $text = ''; if ($survey['Latest Date']['year']) {$text = $survey['Latest Date']['year'] . "/" . $survey['Latest Date']['month'] . "/" . $survey['Latest Date']['day'];}
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Terminus Ante Quem</td>
                                            <td<?php $name = "Terminus Ante Quem"; $text = $survey[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Terminus Post Quem</td>
                                            <td<?php $name = "Terminus Post Quem"; $text = $survey[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Excavation Stratigraphy</td>
                                            <td<?php $name = "Excavation Stratigraphy"; $text = $survey[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Survey Conditions</td>
                                            <td<?php $name = "Survey Conditions"; $text = $survey[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Post Dispositional Transformation</td>
                                            <td<?php $name = "Post Dispositional Transformation"; $text = $survey[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Legacy</td>
                                            <td<?php $name = "Legacy"; $text = $survey[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $survey['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
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
                                <td>Resource Identifier</td>
                                <td<?php $name = "Resource Identifier"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Type</td>
                                <td<?php $name = "Type"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Title</td>
                                <td<?php $name = "Title"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <?php if ($resource['Sub-title'] != null) {?>
                            <tr>
                                <td>Sub-Title</td>
                                <td<?php $name = "Sub-title"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td>Creator</td>
                                <td<?php $name = "Creator"; $text = ''; foreach($resource['Creator'] as $creator) {$text = $text.$creator.'<br>'; }
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Role</td>
                                <td<?php $name = "Role"; $text = ''; foreach($resource['Role'] as $role) {$text = $text.$role.'<br>'; }
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date"; $text = ''; if ($resource['Earliest Date']['year']) {$text = $resource['Earliest Date']['year'] . "/" . $resource['Earliest Date']['month'] . "/" . $resource['Earliest Date']['day'];}
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Date Range</td>
                                <td<?php $name = "Date Range"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Description</td>
                                <td<?php $name = "Description"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Pages</td>
                                <td<?php $name = "Pages"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Condition</td>
                                <td<?php $name = "Condition"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Access Level</td>
                                <td<?php $name = "Access Level"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Accession Number</td>
                                <td<?php $name = "Accession Number"; $text = $resource[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                foreach($metadataEdits as $value) {
                                    if( $value['metadata_kid'] == $resource['kid'] && $value['field_name'] == $name){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                    }} echo $string; ?>
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
                                
                                <?php if(count($subject) > 0) { ?>
                                <ul>
                                <?php $count=0; ?>
                                <?php foreach($subject as $subjects) { $count++; ?>
                                <li><a href="#soo-<?php echo $count; ?>" class="soo-click"><?php echo $count; ?></a></li>
                                <?php } ?>
                                </ul>

                                <?php $count=0; ?>
                                <?php foreach($subject as $subjects) { $count++; ?>

                                <div class="level-content soo auto-height" id="soo-<?php echo $count; ?>" data-kid="<?php echo $subjects['kid']; ?>">

                                    <table id="Subject_Of_Observation">
                                        <tr>
                                            <td>Pages Associator</td>
                                            <td<?php $name = "Pages Associator"; $text = ''; foreach($subjects['Pages Associator'] as $page_associator) { $text = $text.$page_associator."<br>";}
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Resource Identifier</td>
                                            <td<?php $name = "Resource Identifier"; $text = $subjects[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Subject of Observation Associator</td>
                                            <td<?php $name = "Subject of Observation Associator"; $text = ''; foreach($subjects['Subject of Observation Associator'] as $subject_associator) {$text = $text.$subject_associator."<br>";}
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Classification</td>
                                            <td<?php $name = "Artifact - Structure Classification"; $text = $subjects[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Type</td>
                                            <td<?php $name = "Artifact - Structure Type"; $text = ''; foreach($subjects['Artifact - Structure Type'] as $structure_type) {$text = $text.$structure_type."<br>";}
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Terminus Ante Quem</td>
                                            <td<?php $name = "Artifact - Structure Terminus Ante Quem"; $text = '';
                                            foreach( $subjects['Artifact - Structure Terminus Ante Quem'] as $ante_quem) {if($ante_quem != ''){$text = $text.$ante_quem."/";}}
                                            $text = substr($text, 0, -1);
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Terminus Post Quem</td>
                                            <td<?php $name = "Artifact - Structure Terminus Post Quem"; $text = '';
                                            foreach( $subjects['Artifact - Structure Terminus Post Quem'] as $post_quem) {if($post_quem != ''){ $text = $text.$post_quem."/"; }}
                                            $text = substr($text, 0, -1);
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Title</td>
                                            <td<?php $name = "Artifact - Structure Title"; $text = $subjects[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Geolocation</td>
                                            <td<?php $name = "Artifact - Structure Geolocation"; $text = $subjects[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Excavation Unit</td>
                                            <td<?php $name = "Artifact - Structure Excavation Unit"; $text = ''; foreach( $subjects['Artifact - Structure Excavation Unit'] as $excavation_unit) { $text = $text.$excavation_unit."<br>";}
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Description</td>
                                            <td<?php $name = "Artifact - Structure Description"; $text = $subjects[$name];
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Artifact - Structure Location</td>
                                            <td<?php $name = "Artifact - Structure Description"; $text = ''; foreach($subjects['Artifact - Structure Location'] as $structure_location) { $text = $text.$structure_location."<br>";}
                                            $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'">'.$text.'</div>';
                                            foreach($metadataEdits as $value) {
                                                if( $value['metadata_kid'] == $subjects['kid'] && $value['field_name'] == $name){
                                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>'; break;
                                                }} echo $string; ?>
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
                        Keywords
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
            <img src="../img/Arrow-White.svg" height="220px" width="10px" />
        </a>
    </div>
    <div id="other-resources-container">
        <div id="other-resources" style="min-width: <?php $length = 220*count($pages); echo " $length
        ";?>px">
        <?php foreach($pages as $r): ?>
        <a href="#">
            <img class="other-resource" src="<?php echo $r['thumbnail'] ?>" height="200px" width="200px"/>
        </a>
        <?php endforeach ?>
    </div>
</div>
<div id="button-right">
    <a href="#" id="right-button">
        <img src="../img/Arrow-White.svg" height="220px" width="10px" />
    </a>
</div>
</div>

<!-- Give the resource array to the client-side code -->
<script>
    $(function () {
        $("#tabs").tabs();
    });

    $(function () {
        $(".accordion").accordion({
            heightStyle: "fill"
        });
    });

    $('.metadata-accordion').height($('#viewer-window').height() + 40);

    $(window).resize(function () {
        $('.metadata-accordion').height($('#viewer-window').height());
    });

    $(function () {
        $("#soo").tabs();
    });
    $(function () {
        $(".survey-accordion").accordion({
            heightStyle: "content"
        });
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
        setTimeout(function () {
        }, 10000);
        return $.ajax({
            url: "<?php echo Router::url('/', true); ?>resources/loadNewResource/" + id,
            type: 'GET',
            success: function (res) {
                //document.getElementById('PageImage').src = res;
                res = JSON.parse(res);
                kid = res['kid'];
                document.getElementById('PageImage').src = "<?php echo $kora_url; ?>" + res['Image Upload']['localName'];
            }
        });
    }
</script>

<script>
    // flag
    $(function () {
        $("#flag").click(function () {
            $(".modalBackground").show();
        });

        $(".modalClose").click(function () {
            $(".modalBackground").hide();
            $(".flagSuccess").hide();
            $("#flagTarget").hide();
            $("#flagReason").val('');
            $("#flagExplanation").val('');
            $("#flagTarget").val('');
            $("#flagAnnotation_id").val('');
        });

        $("#flagForm").submit(function (event) {

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

            if ($("#flagTarget").val() == '' && $("#flagTarget").is(":visible")) {
                $(".targetError").show();
            } else {
                $(".targetError").hide();
            }

            if ($("#flagReason").val() != '' && $("#flagExplanation").val() != '' && (($("#flagTarget").val() != '' && $("#flagTarget").is(":visible")) || !$("#flagTarget").is(":visible"))) {
                var formdata = {
                    page_kid: kid,
                    resource_kid: "<?php echo $resource['kid']; ?>",
                    resource_name: "<?php echo $resource['Resource Identifier']; ?>",
                    reason: $("#flagReason").val(),
                    annotation_target: $("#flagTarget").val(),
                    annotation_id: $("#flagAnnotation_id").val(),
                    explanation: $("#flagExplanation").val(),
                    status: "pending"
                };

                $.ajax({
                    url: "<?php echo Router::url('/', true); ?>resources/flags/add",
                    type: "POST",
                    data: formdata,
                    statusCode: {
                        201: function () {
                            $("#flagReason").val('');
                            $("#flagExplanation").val('');
                            $("#flagTarget").val('');
                            $(".flagSuccess").show();
                            $("#flagAnnotation_id").val('');
                        }
                    }

                });
            }
        });
    });
</script>

<script>
    // collection
    $("#collection-modal-btn").click(function () {
        console.log("hello-testing-click");
        $(".collectionModalBackground").show();
    });

    $(".modalClose").click(function () {
        $(".collectionModalBackground").hide();
        $("#collectionModal").show();
        $("#addedCollectionModal").hide();
        var retunselect = unselect(null);
        collectionList();
    });
    var collectionArray = [];
    function collectionList() {
        collectionArray = [];
        $.ajax({
            url: arcs.baseURL + "collections/titlesAndIds",
            type: "get",
            //data: "",
            success: function (data) {
                //console.log("ajax success");
                //console.log(data);
                var arr = Object.keys(data).map(function (k) {
                    return data[k]
                });
                //console.log('array below here');
                //console.log(arr);
                data.forEach(function (tempdata) {
                    var arr = Object.keys(tempdata).map(function (k) {
                        return tempdata[k]
                    });
                    //console.log(tempdata);
                    //console.log("array below");
                    //console.log(arr);
                    arr.forEach(function (temparrdata) {
                        var arr2 = Object.keys(temparrdata).map(function (k) {
                            return temparrdata[k]
                        });
                        //console.log(arr2);
                        if (arr2.length > 0)
                            collectionArray.push(arr2);
                    })


                })
                collectionsSearch();
                //console.log("finished the ajax");
                //console.log(collectionArray);
            }
        });
    }

    var unselect = function(trigger){
        console.log("unselect");
        if(trigger==null){
            trigger=true
        }
        this.$(".result").removeClass("selected");
        this.$(".select-button").removeClass("de-select");
        this.$(".select-button, #toggle-select").html("SELECT");
        this.$("#deselect-all").attr({id:"select-all"});
        this.$(".checkedboxes").prop("checked", false);
        this.$("#collectionTitle").val('');
        this.$(".collectionTabSearch").trigger("click");
        collectionList();
        checkSearchSubmitBtn();
        //collectionsSearch();
        //if(trigger){
          //  return arcs.bus.trigger("selection")
        //}
    }

    var isAnyChecked = 0;
    var lastCheckedId = '';
    function checkSearchSubmitBtn() {
        // Hide add to collection button in collection modal when no collections are selected
        var checkboxes = $("#collectionSearchObjects > input");
        var submitButt = $(".collectionSearchSubmit");
        //console.log(checkboxes);
        //console.log("here");
        //console.log(this);

        if(checkboxes.is(":checked")) {
            submitButt.show();
            isAnyChecked = 1;
        }
        else {
            submitButt.hide();
            isAnyChecked = 0;
        }
    }

    function collectionsSearch() {
        var query = $(".collectionSearchBar").val();

        // only put collections in between the div if they include the query.
        // I.E. "" is in every collection title and user_name
        var populateCheckboxes = "<hr>";
        //console.log("new search here");
        //console.log(collections);
        var populateCheckboxes = "<hr>";
        for (var i = 0; i < collectionArray.length; i++) {
            if ((collectionArray[i][0].toLowerCase()).indexOf(query.toLowerCase()) != -1 ||
                    (collectionArray[i][2].toLowerCase()).indexOf(query.toLowerCase()) != -1) {

                populateCheckboxes += "<input type='checkbox' class='checkedboxes' name='item-" + i + "' id='item-" + i + "' value='" + collectionArray[i][1] + "' />"
                        + "<label for='item-" + i + "'><div style='float:left'>" + collectionArray[i][0] + " </div><div style='float:right'>" + collectionArray[i][2]+ "</div></label><br />";
            }
        }
        $("#collectionSearchObjects").html(populateCheckboxes);

        var checkboxes = $("#collectionSearchObjects > input");
        checkboxes.click(function() {
            //console.log('clicked check here');
            //console.log(this);
            if(isAnyChecked == 1){
               $('#'+lastCheckedId).prop("checked", false);
            }
            lastCheckedId = $(this).attr('id');
            checkSearchSubmitBtn();
        });
        $('#collectionTitle').bind('input propertychange', function() {
              if(this.value != ""){
                $(".collectionNewSubmit").show();
                //console.log('text value not null');
              }else{
                $(".collectionNewSubmit").hide();
              }
        });
    }



    $(".viewCollection").click(function () {
        console.log("lastcheckedid");
        console.log(lastCheckedId);
        window.location.href = "<?php echo Router::url('/', true); ?>collections?"+lastCheckedId.substr(5);
    });
    $(".backToSearch").click(function () {
        $(".modalClose").trigger("click");
    });

    $(".collectionNewSubmit").click(function () {
        // creates a single, new collection entry based on the resource it is viewing
        console.log("collectionNewSubmit");
        var formdata = {
            title: $('#collectionTitle').val(),
            resource_kid: "<?php echo $resource['kid']; ?>",
            description: "",
            public: 1
        };

        $.ajax({
            url: "<?php echo Router::url('/', true); ?>collections/add",
            type: "POST",
            data: formdata,
            statusCode: {
                201: function () {
                    console.log("Add to Collection Success");
                    //window.location.reload();
                    //var text = $("label[for="+lastCheckedId+"]").children(":first").text();
                    $("#collectionName").text($('#collectionTitle').val());
                    $("#collectionModal").hide();
                    $("#addedCollectionModal").show();
                    getCollections();
                },
                400: function () {
                    console.log("Bad Request");
                    $(".collectionModalBackground").hide();
                },
                405: function () {
                    console.log("Method Not Allowed");
                    $(".collectionModalBackground").hide();
                }
            }
        });

    });

    $(".collectionSearchSubmit").click(function () {
        // creates 1+ collection entries based on the resource (IE adds the resource to old collections)

        var resource_kid = "<?php echo $resource['kid']; ?>";

        $('#collectionSearchObjects input:checked').each(function () {
            var formdata = {
                collection: $(this).val(),
                resource_kid: resource_kid
            }

            // TODO: sometimes returns an error but it will always upload to the sql database
            $.ajax({
                url: "<?php echo Router::url('/', true); ?>collections/addToExisting",
                type: "POST",
                data: formdata,
                statusCode: {
                    201: function (data) {
                        //console.log("Success");
                        //console.log(data);
                        var text = $("label[for="+lastCheckedId+"]").children(":first").text();
                        $("#collectionName").text(text);
                        $("#collectionModal").hide();
                        $("#addedCollectionModal").show();
                        getCollections();
                    },
                    400: function () {
                        console.log("Bad Request");
                    },
                    405: function () {
                        console.log("Method Not Allowed");
                    }
                }
            });
        });
        //$(".collectionModalBackground").hide();
    });

    // collection tabs
    $(".collectionTabSearch").click(function () {
        $(".collectionSearchContainer").show();
        $(".collectionNewContainer").hide();
        $(".collectionTabSearch").addClass("activeTab");
        $(".collectionTabNew").removeClass("activeTab");
    });

    $(".collectionTabNew").click(function () {
        $(".collectionNewContainer").show();
        $(".collectionSearchContainer").hide();
        $(".collectionTabNew").addClass("activeTab");
        $(".collectionTabSearch").removeClass("activeTab");
    });

    // run on page load
    $(".collectionNewContainer").hide();

    //<?php echo "var collectionArray = ".$collections.";";?>
    //console.log("collections-here");
    //console.log(collectionArray);

    //var collection_members = [];
    //var collections = [];
    //collectionArray.forEach(function (element) {
      //  collections.push(element['Collection']);
    //});
    collectionList();
    collectionsSearch();
</script>

<script>
    var isAdmin = "<?php echo $admin; ?>";

    // Annotations
    var showAnnotations = true;
    var mouseOn = false;

    $(".resources-annotate-icon").click(function () {
        if (showAnnotations) {
            $(".canvas").hide();
            showAnnotations = false;
        }
        else {
            $(".canvas").show();
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

    function waitForElement() {
        if ($("#PageImage").height() !== 0) {
            $(".canvas").height($("#PageImage").height());
            $(".canvas").width($("#PageImage").width());
            $(".canvas").css({bottom: $("#PageImage").height()});
            DrawBoxes(kid);
        }
        else {
            setTimeout(function () {
                waitForElement();
            }, 250);
        }
    }
    waitForElement();

    $(".annotationClose").click(function () {
        $(".annotateModalBackground").hide();
        ResetAnnotationModal();
        $('.gen_box').remove();
        DrawBoxes(kid);
    });

    var gen_box = null;
    var disabled = true;
    function Draw(showForm = true, id = null) {
        $(".annotate").addClass("annotateActive");
        $(".canvas").show();
        $(".annotateHelp").show();
        $(".canvas").addClass("select");
        //Draw box
        var i = 0;
        disabled = false;
        $(".canvas").selectable({
            disabled: false,
            start: function (e) {
                if (!disabled) {
                    //get the mouse position on start
                    x_begin = e.pageX;
                    y_begin = e.pageY;
                }
            },
            stop: function (e) {
                if (!disabled) {
                    //get the mouse position on stop
                    x_end = e.pageX,
                            y_end = e.pageY;

                    /***  if dragging mouse to the right direction, calcuate width/height  ***/
                    if (x_end - x_begin >= 1) {
                        width = x_end - x_begin;

                        /***  if dragging mouse to the left direction, calcuate width/height (only change is x) ***/
                    } else {

                        width = x_begin - x_end;
                        var drag_left = true;
                    }

                    /***  if dragging mouse to the down direction, calcuate width/height  ***/
                    if (y_end - y_begin >= 1) {
                        height = y_end - y_begin;

                        /***  if dragging mouse to the up direction, calcuate width/height (only change is x) ***/
                    } else {

                        height = y_begin - y_end;
                        var drag_up = true;
                    }

                    //append a new div and increment the class and turn it into jquery selector
                    $(this).append('<div class="gen_box gen_box_' + i + '"></div>');
                    gen_box = $('.gen_box_' + i);

                    //add css to generated div and make it resizable & draggable
                    $(gen_box).css({
                        'width': width,
                        'height': height,
                        'left': x_begin,
                        'top': y_begin - 120
                    });

                    //if the mouse was dragged left, offset the gen_box position
                    drag_left ? $(gen_box).offset({left: x_end}) : $(gen_box).offset({left: x_begin});
                    drag_up ? $(gen_box).offset({top: y_end}) : $(gen_box).offset({top: y_begin});

                    //Add coordinates to annotation to save
                    annotateData.x1 = parseFloat($(gen_box).css('left'), 10) / $(".canvas").width();
                    annotateData.x2 = (parseFloat($(gen_box).css('left')) + width) / $(".canvas").width();
                    annotateData.y1 = (parseFloat($(gen_box).css('top'))) / $(".canvas").height();
                    annotateData.y2 = (parseFloat($(gen_box).css('top')) + height) / $(".canvas").height();

                    // Show annotation modal or update incoming annotation coordinates
                    if (showForm) $(".annotateModalBackground").show();
                    else {
                        $.ajax({
                            url: "<?php echo Router::url('/', true); ?>api/annotations/"+id+".json",
                            type: "POST",
                            data: {
                                x1: annotateData.x1,
                                x2: annotateData.x2,
                                y1: annotateData.y1,
                                y2: annotateData.y2
                            },
                            success: function() {
                                ResetAnnotationModal();
                                GetDetails();
                                DrawBoxes(kid);
                            }
                        });
                    }

                    i++;
                }
            }
        });
    }

    $(".annotate").click(function(){Draw()});

    //Load boxes
    function DrawBoxes(pageKid) {
        $(gen_box).remove();
        $(".gen_box").remove();
        $.ajax({
            url: "<?php echo Router::url('/', true); ?>api/annotations/findall.json",
            type: "POST",
            data: {
                id: pageKid
            },
            success: function (data) {
                $.each(data, function (k, v) {
                    if (v.x1) {
                        $(".canvas").append('<div class="gen_box" id="' + v.id + '"></div>');
                        gen_box = $('#' + v.id);

                        //add css to generated div and make it resizable & draggable
                        $(gen_box).css({
                            'width': $(".canvas").width() * v.x2 - $(".canvas").width() * v.x1,
                            'height': $(".canvas").height() * v.y2 - $(".canvas").height() * v.y1,
                            'left': $(".canvas").width() * v.x1,
                            'top': $(".canvas").height() * v.y1
                        });

                        if (isAdmin == 1) {
                            $(gen_box).append("<div class='deleteAnnotation' id='deleteAnnotation_" + v.id + "'><img src='../app/webroot/assets/img/Trash-White.svg'/></div>");
                            $(gen_box).append("<div class='flagAnnotation'><img src='../app/webroot/assets/img/FlagTooltip.svg'/></div>");
                        }
                        else {
                            $(gen_box).append("<div class='flagAnnotation notAdmin'><img src='../app/webroot/assets/img/FlagTooltip.svg'/></div>");
                        }

                        $("#deleteAnnotation_" + v.id).click(function () {
                            var box = $(this).parent();
                            $.ajax({
                                url: "<?php echo Router::url('/', true); ?>api/annotations/" + $(this).parent().attr("id") + ".json",
                                type: "DELETE",
                                statusCode: {
                                    204: function () {
                                        box.remove();
                                        GetDetails();
                                    },
                                    // Make modal for this
                                    403: function () {
                                        alert("You don't have permission to delete this annotation");
                                    }
                                }
                            })
                        });
                    }
                });

                $(".flagAnnotation").click(function () {
                    $(".modalBackground").show();
                    $("#flagTarget").show();
                    $('#flagAnnotation_id').val($(this).parent().attr("id"));
                });

                //Mouse over annotation
                $(".gen_box").mouseenter(function () {
                    mouseOn = true;
                    ShowAnnotation($(this).attr('id'));
                });

                $(".gen_box").mouseleave(function () {
                    mouseOn = false;
                    $(".annotationPopup").remove();
                });
            }
        });
    }

    // Annotation popup on the canvas
    function ShowAnnotation(id) {
        $.ajax({
            url: "<?php echo Router::url('/', true); ?>api/annotations/" + id + ".json",
            type: "GET",
            success: function (data) {
                $(".annotationPopup").remove();
                if (mouseOn) {
                    $("#" + id).append("<div class='annotationPopup'><img class='annotationImage'/><div class='annotationData'></div></div>");
                    $(".annotationPopup").css("left", $("#" + id).width() + 10);
                    if (data.relation_page_kid != "") {
                        var paramKid = (data.relation_resource_kid == data.relation_page_kid) ? data.relation_resource_kid : data.relation_page_kid;
                        var paramSid = (data.relation_resource_kid == data.relation_page_kid) ? "<?php echo RESOURCE_SID;?>" : "<?php echo PAGES_SID;?>";
                        $.ajax({
                            url: "<?php echo Router::url('/', true); ?>resources/search?q=" + encodeURIComponent(
                                    "kid,=," + paramKid) + "&sid=" + paramSid,
                            type: "POST",
                            success: function (page) {
                                $(".annotationImage").attr('src', page.results[0].thumb);
                                $(".annotationData").append("<p>Relation</p>");
                                $(".annotationData").append("<p>Name: " + data.relation_resource_name + "</p>");
                                $(".annotationData").append("<p>Type: " + page.results[0].Type + "</p>");
                                $(".annotationData").append("<p>Scan #: " + page.results[0]["Scan Number"] + "</p>");
                            }
                        });
                    }

                    if (data.transcript != "") {
                        $(".annotationData").append("<p>Transcript: " + data.transcript + "</p>");
                    }

                    if (data.url != "") {
                        $(".annotationData").append("<p>URL: " + data.url + "</p>");
                    }
                }
            }
        });
    }

    // Annotation popup in details tab
    function ShowDetailsAnnotation(t) {
        var id  = t.parent().attr('id');
        $.ajax({
            url: "<?php echo Router::url('/', true); ?>api/annotations/" + id + ".json",
            type: "GET",
            success: function (data) {
                $(".annotationPopup").remove();
                if (mouseOn) {
                    t.append("<div class='annotationPopup detailsPopup'><img class='annotationImage'/><div class='annotationData'></div></div>");
                    $(".annotationPopup").css("left", t.width() + 30);
                    if (data.relation_page_kid != "") {
                        var paramKid = (data.relation_resource_kid == data.relation_page_kid) ? data.relation_resource_kid : data.relation_page_kid;
                        var paramSid = (data.relation_resource_kid == data.relation_page_kid) ? "<?php echo RESOURCE_SID;?>" : "<?php echo PAGES_SID;?>";
                        $.ajax({
                            url: "<?php echo Router::url('/', true); ?>resources/search?q=" + encodeURIComponent(
                                    "kid,=," + paramKid) + "&sid=" + paramSid,
                            type: "POST",
                            success: function (page) {
                                $(".annotationImage").attr('src', page.results[0].thumb);
                                $(".annotationData").append("<p>Relation</p>");
                                $(".annotationData").append("<p>Name: " + data.relation_resource_name + "</p>");
                                $(".annotationData").append("<p>Type: " + page.results[0].Type + "</p>");
                                $(".annotationData").append("<p>Scan #: " + page.results[0]["Scan Number"] + "</p>");
                            }
                        });
                    }

                    if (data.transcript != "") {
                        $(".annotationData").append("<p>Transcript: " + data.transcript + "</p>");
                    }

                    if (data.url != "") {
                        $(".annotationData").append("<p>URL: " + data.url + "</p>");
                    }
                }
            }
        });
    }

    //Annotation search
    $(".annotateSearchForm").submit(function (event) {
        $(".resultsContainer").empty();
        $.ajax({
            url: "<?php echo Router::url('/', true); ?>resources/search?q=" + encodeURIComponent(
                    "(Type,like," + $(".annotateSearch").val()
                    + "),or,(Title,like," + $(".annotateSearch").val()
                    + "),or,(Resource Identifier,like," + $(".annotateSearch").val()
                    + "),or,(Description,like," + $(".annotateSearch").val()
                    + "),or,(Accession Number,like," + $(".annotateSearch").val()
                    + "),or,(Earliest Date,like," + $(".annotateSearch").val()
                    + "),or,(Latest Date,like," + $(".annotateSearch").val()
                    + ")") + "&sid=<?php echo RESOURCE_SID;?>",
            type: "POST",
            success: function (data) {
                BuildResults(data);
            }
        });

        event.preventDefault();
    });

    function BuildResults(data) {
        if (data.total > 0) {
            //Iterate search results
            $.each(data.results, function (key, value) {
                $(".resultsContainer").append("<div class='annotateSearchResult' id='" + value.kid + "'></div>");
//                if (value.thumb == "img/DefaultResourceImage.svg") {
//                    $("#" + value.kid).append("<div class='imageWrap'><img class='resultImage' src='<?php echo Router::url('/', true); ?>app/webroot/" + value.thumb + "'/></div>");
//                }
//                else {
//                    $("#" + value.kid).append("<div class='imageWrap'><img class='resultImage' src='" + value.thumb + "'/></div>");
//                }
//
//                $("#" + value.kid).append(
//                        "<div class='resultInfo'>" +
//                        "<p>" + value['Accession Number'] + "</p>" +
//                        "<p>" + value['Type'] + "</p>" +
//                        "</div>"
//                );
                //$("#" + value.kid).append("<hr class='resultDivider'>");

                //Get related pages
                $.ajax({
                    url: "<?php echo Router::url('/', true); ?>resources/search?q=" + encodeURIComponent("(Resource Associator,like," + value.kid + "),or,(Resource Identifier,like," + value['Resource Identifier'] + ")") + "&sid=<?php echo PAGES_SID;?>",
                    type: "POST",
                    success: function (pages) {
                        $.each(pages.results, function (k, v) {
                            $("#" + value.kid).after("<div class='annotateSearchResult resultPage' id='" + v.kid + "'></div>");
                            if (v.thumb == "img/DefaultResourceImage.svg") {
                                $("#" + v.kid).append("<div class='imageWrap'><img class='resultImage' src='<?php echo Router::url('/', true); ?>app/webroot/" + v.thumb + "'/></div>");
                            }
                            else {
                                $("#" + v.kid).append("<div class='imageWrap'><img class='resultImage' src='" + v.thumb + "'/></div>");
                            }

                            $("#" + v.kid).append(
                                    "<div class='pageInfo'>" +
                                    "<p>" + v['Page Identifier'] + "</p>" +
                                    "</div>"
                            );

                            $("#" + v.kid).append("<hr class='resultDivider'>");

                            //Clicked a page
                            $("#" + v.kid).click(function () {
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
            });
        }
    }

    //Set transcript and url
    var lastValue = '';
    $(".annotateTranscript, .annotateUrl").on('change keyup paste mouseup', function () {
        if ($(this).val() != lastValue) {
            lastValue = $(this).val();
            //annotateData.transcript = $(".annotateTranscript").val();
            annotateData.url = $(".annotateUrl").val();
            if (selected || annotateData.url.length > 0) {
                $(".annotateSubmit").show();
            }
            else {
                $(".annotateSubmit").hide();
            }
        }
    });

    $(".annotateSubmit").click(function () {
        annotateData.page_kid = kid;
        annotateData.resource_kid = "<?php echo $resource['kid']; ?>";
        annotateData.resource_name = "<?php echo $resource['Resource Identifier']; ?>";

        //First relation
        $.ajax({
            url: "<?php echo Router::url('/', true); ?>api/annotations.json",
            type: "POST",
            data: annotateData,
            success: function (data) {
                $(gen_box).attr("id", data.id);
                gen_box = null;
                DrawBoxes(kid);
                if (annotateData.relation_resource_kid == "") {
                    GetDetails();
                }
            }
        });

        if (annotateData.relation_resource_kid != "") {
            //Backwards relation
            $.ajax({
                url: "<?php echo Router::url('/', true); ?>api/annotations.json",
                type: "POST",
                data: {
                    incoming: 'true',
                    resource_kid: annotateData.relation_resource_kid,
                    page_kid: annotateData.relation_page_kid,
                    resource_name: annotateData.relation_resource_name,
                    relation_resource_kid: annotateData.resource_kid,
                    relation_page_kid: annotateData.page_kid,
                    relation_resource_name: annotateData.resource_name,
                    transcript: annotateData.transcript,
                    url: annotateData.url
                },
                success: function (data) {
                    GetDetails();
                }
            });
        }
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

        $(".annotateModalBackground").hide();
        $(".annotateHelp").hide();
        $(".annotateSearch").val("");
        $(".annotateTranscript").val("");
        $(".annotateUrl").val("");
        $(".resultsContainer").empty();
        $(".canvas").selectable({disabled: true});
        //$( ".canvas" ).removeClass("select ui-selectable ui-selectable-disabled");
        $(".annotate").removeClass("annotateActive");
        $(".annotateSubmit").hide();
    }

    //Tabs
    $(".annotateTabRelation").click(function () {
        $(".annotateRelationContainer").show();
        $(".annotateTranscriptContainer").hide();
        $(".annotateUrlContainer").hide();
        $(".annotateTabRelation").addClass("activeTab");
        $(".annotateTabTranscript").removeClass("activeTab");
        $(".annotateTabUrl").removeClass("activeTab");
    });

    $(".annotateTabTranscript").click(function () {
        $(".annotateTranscriptContainer").show();
        $(".annotateRelationContainer").hide();
        $(".annotateUrlContainer").hide();
        $(".annotateTabTranscript").addClass("activeTab");
        $(".annotateTabRelation").removeClass("activeTab");
        $(".annotateTabUrl").removeClass("activeTab");
    });

    $(".annotateTabUrl").click(function () {
        $(".annotateUrlContainer").show();
        $(".annotateTranscriptContainer").hide();
        $(".annotateRelationContainer").hide();
        $(".annotateTabUrl").addClass("activeTab");
        $(".annotateTabTranscript").removeClass("activeTab");
        $(".annotateTabRelation").removeClass("activeTab");
    });

    $(".annotationHelpOk").click(function () {
        $(".annotateHelp").hide();
    });


    function GetDetails() {
        $(".transcript_display").remove();
        $(".annotation_display").remove();
        $.ajax({
            url: "<?php echo Router::url('/', true); ?>api/annotations/findall.json",
            type: "POST",
            data: {
                id: kid
            },
            success: function (data) {
                data.sort(function (a, b) {
                    if (a.order_transcript < b.order_transcript) return -1;
                    if (a.order_transcript > b.order_transcript) return 1;
                });

                $.each(data, function (key, value) {
                    var trashButton = isAdmin == 1 ? "<img src='../app/webroot/assets/img/Trash-Dark.svg' class='deleteTranscript'/>" : "";
                    if (value.page_kid == kid && value.transcript != "") {
                        $(".content_transcripts").append("<div class='transcript_display' id='" + value.id + "'>"+ value.transcript +"<div class='thumbResource'> <img src='../app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/><img src='../app/webroot/assets/img/Trash-Dark.svg' class='trashTranscript'/>"+trashButton+"</div></div>");
                    }
                    else {
                        if (value.relation_page_kid != "" && (value.incoming == "false" || !value.incoming)) {
                            $(".outgoing_relations").append("<div class='annotation_display' id='" + value.id + "'><div class='relationName'>"+ value.relation_resource_name +"</div><img src='../app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/>"+trashButton+"</div>");
                        }
                        else if (value.relation_page_kid != "" && value.incoming == "true") {
                            var text = value.x1 ? "Revert to whole resource" : "Define space";
                            $(".incoming_relations").append("<div class='annotation_display "+value.id+"' id='" + value.id + "'><div class='relationName'>"+ value.relation_resource_name +"</div><img src='../app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/>"+trashButton+"<img src='../app/webroot/assets/img/AnnotationsTooltip.svg' class='annotateRelation'/><div class='annotateLabel'>"+text+"</div></div>");
                        }
                    }
                    if (value.url != "") {
                        $(".urls").append("<div class='annotation_display' id='" + value.id + "'>"+ value.url + "<img src='../app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/>"+trashButton+"</div>");
                    }

                    // Set incoming coordinates or reset incoming annotation coordinates to null
                    $("."+value.id).click(function() {
                        if (!value.x1) {
                            Draw(false, value.id);
                        }
                        else {
                            $.ajax({
                                url: "<?php echo Router::url('/', true); ?>api/annotations/" + value.id + ".json",
                                type: "POST",
                                data: {
                                    x1: null,
                                    x2: null,
                                    y1: null,
                                    y2: null
                                },
                                success: function() {
                                    DrawBoxes(kid);
                                    GetDetails();
                                }
                            });
                        }
                    });
                });

                $(".flagTranscript").click(function () {
                    $(".modalBackground").show();
                    $("#flagTarget").val("Transcript");
                    $('#flagAnnotation_id').val($(this).parent().attr("id"));
                });

                $(".trashTranscript").click(function () {
					console.log("Delete clicked")
                    $.ajax({
                        url: "<?php echo Router::url('/', true); ?>api/annotations/" + $(this).parent().attr("id") + ".json",
                        type: "DELETE",
                        statusCode: {
                            204: function () {
								console.log("In the 204 status")
                                GetDetails();
                                DrawBoxes(kid);
                            },
                            403: function () {
                                alert("You don't have permission to delete this annotation");
                            }
                        }
                    })
                });

                //Mouse over annotation
                $(".relationName").mouseenter(function () {
                    mouseOn = true;
                    ShowDetailsAnnotation($(this));
                })
                .mouseleave(function () {
                    mouseOn = false;
                    $(".annotationPopup").remove();
                });
            }
        })

    }

    getCollections();
    var numCollections = 0;

    function getCollections() {
        $.ajax({
            url: arcs.baseURL + "collections/memberships",
            type: "get",
            data: {
                id: "<?php echo $resource['kid']; ?>"
            },
            success: function (data) {
                console.log("memberships here");
                console.log(data);
                //console.log(data.collections);
                //console.log(data.collections.length);
                numCollections = data.collections.length;
                if (data.collections.length > 0){
                    //document.getElementById("ui-id-50").style.color = "blue";
                    var ctab = document.getElementById("collections_tab");
                    ctab.innerHTML = "COLLECTIONS (" + numCollections + ")";
                    var populateCollections = "<table><tbody>"+
                        "<tr><td colspan='2'>This resource is a part of the following "+numCollections+" collections...</td></tr>";
                    for (var i = numCollections-1; i >= 0; i--) {
                        //console.log("got-here1");
                        var collection = data.collections[i];
                        populateCollections += "<tr><td style='width:50%'>"+ collection.title +"</td><td>"+ collection.user_name +"</td></tr>";
                    }
                    populateCollections += "</tbody></table>";
                    //console.log(populateCollections);
                    $("#collections_table").html(populateCollections);
                }
            }
        })

    }
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
                //meta_resource_kid = "<?php echo $surveys[0]['kid']; ?>";
                break;
            case "Archival_Object":
                meta_scheme_id = "<?php echo RESOURCE_SID; ?>";
                meta_resource_kid = "<?php echo $resource['kid']; ?>";
                break;
            case "Subject_Of_Observation":
                meta_scheme_id = "<?php echo SUBJECT_SID; ?>";
                //meta_resource_kid = meta_resource_kid.substring(4);
                //meta_resource_kid = parseInt(meta_resource_kid) - 1;
                //tempint = 0;
                //java_subjects = "<?php echo array_values($subject)[".tempint."]['kid']; ?>";
                //console.log("java here");
                //console.log(typeof java_subjects);
                //meta_resource_kid = "<?php echo array_values($subject)[meta_resource_kid]['kid']; ?>";
                //meta_resource_kid = "<?php echo array_values($subject)[meta_resource_kid]['kid']; ?>";
                break;
        }
        $.ajax({
            url: arcs.baseURL + "metadataedits/add",
            type: "post",
            data: {
                resource_kid: "<?php echo $resource['kid']; ?>",
                resource_name: "<?php echo $resource['Title']; ?>",
                scheme_id: meta_scheme_id,
                scheme_name: meta_scheme_name,
                field_name: meta_field_name,
                user_id: "idk",
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
    var metadataIsSelected = 0;
    var editBtnClick = 0;
    var meta_field_name = '';
    var meta_value_before = '';
    var meta_new_value = '';
    var meta_scheme_name = '';
    var meta_resource_kid = '';
    var meta_scheme_id = 0;

    $(".metadataEdit").click(function() {
        console.log("metadataEdit click");
        $(this).each(
            function(){
                // if the td elements contain any input tag
                if ($(this).find('textarea').length || metadataIsSelected == 1 || editBtnClick == 0){
                    // sets the text content of the tag equal to the value of the input
                    //$(this).text($(this).find('input').val());
                }
                else {
                    // removes the text, appends an input and sets the value to the text-value
                    meta_field_name = $(this).children('div').eq(1).attr('id');
                    meta_scheme_name = $(this).parent().parent().parent().attr('id');
                    meta_resource_kid = $(this).parent().parent().parent().parent().attr('data-kid');
                    var t = $(this).children('div').eq(1).text();
                    meta_value_before = t;
                    $(this).children('div').eq(1).html($('<textarea />',{'value' : t, 'id' : 'meta_textarea'}).val(t));
                    metadataIsSelected = 1;
                }
            });
    });

    $(document).on("click", ".edit-btn", function() {
        //console.log("edit-btn clicked");
        if (editBtnClick != 1) {
            $(this).text("SAVE");
            $(this).css({'color':'#0093be'});
            $(this).addClass("save-btn").removeClass("edit-btn");
        }
        editBtnClick = 1;
    });

    // Details tab
    $(".details").click(function () {
        GetDetails();

    });

    $(".level-tab span .save-btn").click(function() {
        console.log("level tab save btn click");
    });

    $(".soo-click").click(function() {
        //console.log("sso click change");
        $(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
        var id = $("#meta_textarea").parent().children("div").eq(0).text();
        var text = $("#meta_textarea").text();
        var fill = '<div id="'+meta_field_name+'">'+meta_value_before+"</div>";
        $("#meta_textarea").parent().replaceWith(fill);
        metadataIsSelected = 0;
        editBtnClick = 0;
    });

    $(".level-tab").click(function(e) {
        //console.log("clicked thingy");
        //console.log(e);
        if( e.toElement.getAttribute("class") == 'save-btn' ){
            //console.log("level tab save btn click");
             e.stopPropagation();
            if (metadataIsSelected == 1) {
                $(".save-btn").removeClass("save-btn");
                console.log("save is selected and save click");
                console.log(e);
                meta_new_value = $("#meta_textarea").val();
                addMetadataEdits();
            }
            return;
        }
        if( e.toElement.getAttribute("aria-expanded") == 'true' ){
            //console.log("already expanded");
            return;
        }
        $(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
        var id = $("#meta_textarea").parent().children("div").eq(0).text();
        var text = $("#meta_textarea").text();
        var fill = '<div id="'+meta_field_name+'">'+meta_value_before+"</div>";
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
                url: "<?php echo Router::url('/', true); ?>api/annotations/"+ v +".json",
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
        annotateData.resource_kid = "<?php echo $resource['kid']; ?>";
        annotateData.resource_name = "<?php echo $resource['Resource Identifier']; ?>";
        annotateData.transcript = $(".transcriptionTextarea").val();
        annotateData.order_transcript = 1000000;

        if (annotateData.transcript.length > 0)
            $.ajax({
                url: "<?php echo Router::url('/', true); ?>api/annotations.json",
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

<script>
    // other resources
    $(document).ready(function () {
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
        endIndex =
        <?php $length = count($pages); echo "$length";?> / visible -1;

        for(var i=0; i
        <$pics.length; i++){
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
                    //$('#button-left').css('display', 'block');
                    //$('#other-resources-container').css('width', '90%');
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
                    //$('#button-left').css('display', 'none');
                    //$('#other-resources-container').css('width', '95%');
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
        image.style.left = "0px";
        image.style.top = "0px";
        }

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
            
        });
        
        $('#zoom-range').click(function(event){
            event.preventDefault();
            var zoomrange = document.getElementById("zoom-range");
            var canvas = $('.canvas');
            var image = document.getElementById("PageImage");
            var zoom;
            
            zoom = zoomrange.value;
            
            if(oldzoom > zoom){
                image.style.left = "0px";
                image.style.top = "0px";
            }
            
            oldzoom = zoom;
            zoomratio = 10/(11-zoom);
            canvas.css("transform" , "scale(" + zoomratio + ")");
            image.style.transform = "scale(" + zoomratio + ")";
            
        });
        
        var jq = document.createElement('script');
        jq.src = "//code.jquery.com/ui/1.11.4/jquery-ui.js";
        document.querySelector('head').appendChild(jq);
        
        jq.onload = drag;
        
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
        image = document.getElementById('PageImage')
        image.src = '../img/arcs-preloader.gif';
        image.style.height = '100%';
        image.style.width = '100%';
        setTimeout(function () {
        }, 10000);
        return $.ajax({
            url: "<?php echo Router::url('/', true); ?>resources/loadNewResource/" + id,
            type: 'GET',
            success: function (res) {
                //document.getElementById('PageImage').src = res;
                res = JSON.parse(res);
                kid = res['kid'];
                document.getElementById('PageImage').src = "<?php echo $kora_url; ?>" + res['Image Upload']['localName'];
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

                $.each(data, function (index, comment) {
                    if (!comment.parent_id) {
                        $(".commentContainer").append(
                                "<div class='discussionComment' id='" + comment.id + "'>" +
                                "<span class='commentName'>" + comment.name + "</span>" +
                                "<span class='commentDate'>" +
                                formatDate(comment.created) +
                                "</span><br><span class='commentBody'>" +
                                comment.content +
                                "</span><div class='reply'>Reply</div>" +
                                "</div>"
                        );
                    }
                });

                $.each(data, function (index, comment) {
                    if (comment.parent_id) {
                        $("#" + comment.parent_id).append(
                                "<div class='discussionReply' id='" + comment.id + "'><span class='replyTo'>" +
                                "In reply to " + $("#" + comment.parent_id + " > .commentName").html() +
                                "</span><br><span class='commentName'>" +
                                comment.name +
                                "</span><span class='commentDate'>" +
                                formatDate(comment.created) +
                                "</span><br><span class='commentBody'>" +
                                comment.content +
                                "</span></div>");
                    }
                });

                $(".reply").click(function () {
                    $("#tabs-3").append($(".newReplyForm"));
                    $(".replyTextArea").val("");
                    // $(this).parent().append($(".newReplyForm"));
                    $(".newReplyForm").show();
                    $(".newReplyForm").removeAttr('style');
                    $(".newReplyForm").css("display", "inline");
                    $(".newComment").show();
                    parent = $(this).parent().attr("id");
                    $('html, body').animate({
                        scrollTop: $(".newReplyForm").offset().top - 600
                    }, 1000);
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

    $(".closeComment").click(function () {
        $(".commentTextArea,.replyTextArea").val("");
        $(".newCommentForm,.newReplyForm").hide();
        $(".newComment").show();
    });

    $(".newCommentForm,.newReplyForm").submit(function (e) {
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
                    $("#tabs-3").append($(".newCommentForm,.newReplyForm"));
                    $(".newCommentForm,.newReplyForm").hide();
                    $(".newComment").show();
                    getComments();
                }
            });
        }
        else if ($(".replyTextArea").val() != "") {
            $.ajax({
                url: "<?php echo Router::url('/', true); ?>api/comments.json",
                type: "POST",
                data: {
                    resource_kid: "<?php echo $resource['kid']; ?>",
                    content: $(".replyTextArea").val(),
                    parent_id: parent
                },
                success: function (data) {
                    $(".replyTextArea").val("");
                    $("#tabs-3").append($(".newCommentForm,.newReplyForm"));
                    $(".newCommentForm,.newReplyForm").hide();
                    $(".newComment").show();
                    getComments();
                }
            });
        }
    });
</script>