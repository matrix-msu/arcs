<?php
function Generate_Metadata(
                $schemename,
                $data,
                $metadataEdits,
                $controlOptions,
                $flags,
                $aboveScheme=false,
                $aboveTwoSchemes=false
    ){
    $counter = 0;
?>

    <h3 class="level-tab <?= $schemename ?>" >
        <?php
            if( $schemename == 'archival objects' ){
                echo 'Resource (archival document)';
            }else{
                echo $schemename;
            }
        ?>
        <span class="metadata-edit-btn" style="visibility:hidden;" >Edit</span>
    </h3>
    <div class="level-content" style="display:none;">
        <div class="accordion metadata-accordion excavation-div">
    <?php

    if( $schemename == 'subjects' ){
    ?>
    <div id="soo">
        <ul>
            <?php if(count($data) > 0) { ?>
            <?php $count=0; $page_associator='';?>
            <?php foreach($data as $subject) {
                $count++; ?>
                <li class="soo-li"
                    <?php if(array_key_exists('Pages Associator', $subject) && !empty($subject['Pages Associator']) ){
                        echo 'data-pageKid="'.$subject['Pages Associator'][0].'" data-sooKid="'.$subject['kid'].'"';
                    }?>
                >
                    <a href="#soo-<?php echo $count; ?>" class="soo-click<?= $count ?>  soo-click">
                        <?php
                            if( array_key_exists( 'Pages Associator', $subject ) && !empty($subject['Pages Associator'])
                                && $subject['Pages Associator'][0] != $page_associator ){
                                    $page_associator = $subject['Pages Associator'][0];
                                    $count = 1;
                            }

                            echo $count;
                        ?>
                    </a>
                </li>
            <?php }} ?>
        </ul>
        <div class="level-content soo">
    <?php
    }if( $schemename != 'excavations' && $schemename != 'subjects' && $schemename != 'Seasons' ){
    ?>
        <div class="level-content">
    <?php
    }

    $controlTypes = array(
        'project' => array(
            'Name' => 'text',
            'Country' => 'list',
            'Region' => 'list',
            'Modern_Name' => 'list',
            'Persistent_Name' => 'text',
            'Location_Identifier' => 'text',
            'Location_Identifier_Scheme' => 'text',
            'Geolocation' => 'multi_input',
            'Elevation' => 'text',
            'Records_Archive' => 'multi_select',
            'Complex_Title' => 'text',
            'Earliest_Date' => 'date',
            'Latest_Date' => 'date',
            'Terminus_Ante_Quem' => 'terminus',
            'Terminus_Post_Quem' => 'terminus',
            'Period' => 'multi_select',
            'Archaeological_Culture' => 'multi_select',
            'Description' => 'text',
            //'Brief Description' => 'text',
            'Permitting_Heritage_Body' => 'multi_select'
        ),
        'Seasons' => array(
            //'Project Associator' => 'associator',
            'Title' => 'text',
            'Type' => 'multi_select',
            'Sponsor' => 'multi_select',
            'Director' => 'multi_select',
            'Registrar' => 'multi_select',
            'Contributor' => 'list',
            'Contributor_Role' => 'multi_select',
            'Contributor_2' => 'list',
            'Contributor_Role_2' => 'multi_select',
            'Contributor_3' => 'list',
            'Contributor_Role_3' => 'multi_select',
            'Contributor_4' => 'list',
            'Contributor_Role_4' => 'multi_select',
            'Contributor_5' => 'list',
            'Contributor_Role_5' => 'multi_select',
            'Contributor_6' => 'list',
            'Contributor_Role_6' => 'multi_select',
            'Contributor_7' => 'list',
            'Contributor_Role_7' => 'multi_select',
            'Contributor_8' => 'list',
            'Contributor_Role_8' => 'multi_select',
            'Contributor_9' => 'list',
            'Contributor_Role_9' => 'multi_select',
            'Earliest_Date' => 'date',
            'Latest_Date' => 'date',
            'Terminus_Ante_Quem' => 'terminus',
            'Terminus_Post_Quem' => 'terminus',
            'Description' => 'text'
        ),
        'excavations' => array(
            'Season_Associator' => 'associator',
            'Name' => 'text',
            'Type' => 'list',
            'Supervisor' => 'multi_select',
            'Earliest_Date' => 'date',
            'Latest_Date' => 'date',
            'Terminus_Ante_Quem' => 'terminus',
            'Terminus_Post_Quem' => 'terminus',
            'Excavation_Stratigraphy' => 'text',
            'Survey_Conditions' => 'text',
            'Post_Dispositional_Transformation' => 'text'
        ),
        'archival objects' => array(
            'URL' => 'url',
            'Excavation_-_Survey_Associator' => 'associator',
            'Season_Associator' => 'associator',
            'Resource_Identifier' => 'text',
            'Type' => 'list',
            'Title' => 'text',
            'Sub-title' => 'text',
            'Repository' => 'list',
            'Accession_Number' => 'text',
            'Creator' => 'multi_select',
            'Creator_Role' => 'multi_select',
            'Earliest_Date' => 'date',
            'Latest_Date' => 'date',
            //'Date Range' => 'text',
            'Dimensions' => 'multi_input',
            'Language' => 'multi_select',
            'Description' => 'text',
            'Pages' => 'text',
            'Rights' => 'text',
            'Rights_Holder' => 'multi_select',
        ),
        'subjects' => array(
            'Pages_Associator' => 'associator',
            //'Resource Identifier' => 'text',
            'Subject_of_Observation_Associator' => 'associator',
            'Artifact_-_Structure_Classification' => 'list',
            'Artifact_-_Structure_Type' => 'multi_select',
            'Artifact_-_Structure_Type_Qualifier' => 'text',
            'Artifact_-_Structure_Material' => 'multi_select',
            'Artifact_-_Structure_Technique' => 'multi_select',
            'Artifact_-_Structure_Terminus_Ante_Quem' => 'terminus',
            'Artifact_-_Structure_Terminus_Post_Quem' => 'terminus',
            'Artifact_-_Structure_Period' => 'multi_select',
            'Artifact_-_Structure_Archaeological_Culture' => 'multi_select',

            'Artifact_-_Structure_Title' => 'text',
            'Artifact_-_Structure_Creator' => 'multi_select',
            'Artifact_-_Structure_Creator Role' => 'multi_select',
            'Artifact_-_Structure_Dimensions' => 'multi_input',
            'Artifact_-_Structure_Excavation Unit' => 'multi_select',
            'Artifact_-_Structure_Location' => 'multi_select',
            'Artifact_-_Structure_Geolocation' => 'multi_input',
            'Artifact_-_Structure_Current_Location' => 'list',
            'Artifact_-_Structure_Repository' => 'list',
            'Artifact_-_Structure_Repository_Accession_Number' => 'text',
            'Artifact_-_Structure_Description' => 'text',
            'Artifact_-_Structure_Condition' => 'multi_select',
            'Artifact_-_Structure_Inscription' => 'text',
            'Artifact_-_Structur_Munsell_Number' => 'text',
            'Artifact_-_Structure_Date' => 'date',
            'Artifact_-_Structure_Subject' => 'multi_select',
            'Artifact_-_Structure_Origin' => 'list',
            'Artifact_-_Structure_Comparanda' => 'text',
            'Artifact_-_Structure_Archaeological_Context' => 'text',
            'Artifact_-_Structure_Shelving_Location' => 'text'
        )
    );
    $controlDisplayNames = array(
        'project' => array(
            'Name' => 'Name',
            'Country' => 'Country',
            'Region' => 'Geographic Region',
            'Modern_Name' => 'Modern Placename',
            'Location_Identifier' => 'Location',
            'Location_Identifier_Scheme' => 'Location Source',
            'Geolocation' => 'Coordinates',
            'Elevation' => 'Elevation',
            'Earliest_Date' => 'Earliest Research Activity',
            'Latest_Date' => 'Latest Research Activity',
            'Records_Archive' => 'Archive / Repository',
            'Persistent_Name' => 'Common Name',
            'Complex_Title' => 'Associated Institution(s)',
            'Terminus_Ante_Quem' => 'Earliest Cultural Activity',
            'Terminus_Post_Quem' => 'Latest Cultural Activity',
            'Period' => 'Period(s) of Cultural Activity',
            'Archaeological_Culture' => 'Archaeological Culture',
            'Description' => 'Full Description',
            //'Brief Description' => 'text',
            'Permitting_Heritage_Body' => 'Permitting Heritage Body'
        ),
        'Seasons' => array(
            //'Project Associator' => 'associator',
            'Title' => 'Title',
            'Type' => 'Research Activity',
            'Director' => 'Director(s)',
            'Registrar' => 'Registrar(s)',
            'Sponsor' => 'Sponsor(s)',
            'Contributor' => 'Contributor(s)',
            'Contributor_Role' => 'Contributor Role(s)',
            'Contributor_2' => 'Contributor(s)',
            'Contributor_Role_2' => 'Contributor Role(s)',
            'Contributor_3' => 'Contributor(s)',
            'Contributor_Role_3' => 'Contributor Role(s)',
            'Contributor_4' => 'Contributor(s)',
            'Contributor_Role_4' => 'Contributor Role(s)',
            'Contributor_5' => 'Contributor(s)',
            'Contributor_Role_5' => 'Contributor Role(s)',
            'Contributor_6' => 'Contributor(s)',
            'Contributor_Role_6' => 'Contributor Role(s)',
            'Contributor_7' => 'Contributor(s)',
            'Contributor_Role_7' => 'Contributor Role(s)',
            'Contributor_8' => 'Contributor(s)',
            'Contributor_Role_8' => 'Contributor Role(s)',
            'Contributor_9' => 'Contributor(s)',
            'Contributor_Role_9' => 'Contributor Role(s)',
            'Earliest_Date' => 'Beginning of Season',
            'Latest_Date' => 'End of Season',
            'Terminus_Ante_Quem' => 'Earliest Cultural Activity for Season',
            'Terminus_Post_Quem' => 'Latest Cultural Activity for Season',
            'Description' => 'Description of Season Activity'
        ),
        'excavations' => array(
            'Season_Associator' => 'Season(s) when Study took place',
            'Name' => 'Unit of Study',
            'Type' => 'Type of Study',
            'Supervisor' => 'Supervisor(s)',
            'Earliest_Date' => 'Beginning of Study',
            'Latest_Date' => 'End of Study',
            'Terminus_Ante_Quem' => 'Earliest Cultural Activity for Study Unit',
            'Terminus_Post_Quem' => 'Latest Cultural Activity for Study Unit',
            'Excavation_Stratigraphy' => 'Description of Stratigraphy',
            'Survey_Conditions' => 'Description of Survey',
            'Post_Dispositional_Transformation' => 'Post-Depositional Activity'
        ),
        'archival objects' => array(
            'URL' => 'Stable URL',
            'Excavation_-_Survey_Associator' => 'Study(s) when Resource was created',
            'Season_Associator' => 'Season(s) when Resource was created',
            'Resource_Identifier' => 'Resource Identifier',
            'Type' => 'Resource Type',
            'Title' => 'Title',
            'Sub-title' => 'Sub-title',
            'Creator' => 'Author/Creator',
            'Creator_Role' => 'Author/Creator Role',
            'Earliest_Date' => 'Earliest Date of Resource',
            'Latest_Date' => 'Latest Date of Resource',
            'Dimensions' => 'Dimensions',
            'Language' => 'Language(s)',
            'Description' => 'Description of Resource',
            'Pages' => 'Number of Pages',
            'Rights' => 'Rights',
            'Rights_Holder' => 'Rights Holder',
            'Repository' => 'Archive / Repository',
            'Accession_Number' => 'Accession/Catalogue Number(s)',
        ),
        'subjects' => array(
            'Pages_Associator' => 'Page ID with Topic Info',
            //'Resource Identifier' => 'text',
            'Subject_of_Observation_Associator' => 'Other Records with Topic Info',
            'Artifact_-_Structure_Classification' => 'Artifact / Structure Classification',
            'Artifact_-_Structure_Type' => 'Artifact / Structure Type',
            'Artifact_-_Structure_Type_Qualifier' => 'Type Qualifier',
            'Artifact_-_Structure_Material' => 'Artifact / Structure Material',
            'Artifact_-_Structure_Technique' => 'Manufacturing technique',
            'Artifact_-_Structure_Archaeological_Culture' => 'Associated Archaeological Culture',
            'Artifact_-_Structure_Period' => 'Artifact / Structure Period',
            'Artifact_-_Structure_Terminus_Ante_Quem' => 'Earliest Possible Date of Artifact / Structure',
            'Artifact_-_Structure_Terminus_Post_Quem' => 'Latest Possible Date of Artifact / Structure',

            'Artifact_-_Structure_Title' => 'Title of Artifact / Structure',
            'Artifact_-_Structure_Location' => 'Project-specific Location',
            'Artifact_-_Structure_Current_Location' => 'Current Location of Artifact / Structure',
            'Artifact_-_Structure_Repository' => 'Storage / Repository',
            'Artifact_-_Structure_Repository_Accession_Number' => 'Accession Number',
            'Artifact_-_Structure_Creator' => 'Artifact / Structure Creator',
            'Artifact_-_Structure_Creator_Role' => 'Creator Role',
            'Artifact_-_Structure_Dimensions' => 'Artifact / Structure Dimensions',
            'Artifact_-_Structure_Geolocation' => 'Artifact / Structure Coordinates',
            'Artifact_-_Structure_Excavation_Unit' => 'Artifact / Structure Survey / Excavation Unit',
            'Artifact_-_Structure_Location' => 'Project-specific Location',
            'Artifact_-_Structure_Description' => 'Artifact / Structure Description',
            'Artifact_-_Structure_Condition' => 'Artifact / Structure Condition',
            'Artifact_-_Structure_Inscription' => 'Inscribed text',
            'Artifact_-_Structure_Munsell_Number' => 'Artifact / Structure Color(s)',
            'Artifact_-_Structure_Date' => 'Precise Date of Artifact / Structure',
            'Artifact_-_Structure_Subject' => 'Subject of Artifact / Structure',
            'Artifact_-_Structure_Origin' => 'Point of Origin',
            'Artifact_-_Structure_Comparanda' => 'Comparative examples',
            'Artifact_-_Structure_Archaeological_Context' => 'Archaeological context',
            'Artifact_-_Structure_Shelving_Location' => 'Location in repository'
        )
    );


    foreach ($data as $array) {
        $counter++;

        if($schemename == 'excavations' || $schemename == 'Seasons' ){
            $excavationClass = 'excavation-tab-head';
            $excavationSmallClass = 'excavation-tab-content';
            if($schemename == 'Seasons'){
                $excavationClass = 'season-tab-head';
                $excavationSmallClass = 'season-tab-content';
            }
    ?>
            <h3 class="level-tab <?=$excavationClass?>" data-kid="<?=$array['kid']?>"><?= $schemename . " Level " . $counter?>

                <!-- span class="edit-btn">Edit</span -->

            </h3>

            <div class="level-content smaller <?=$excavationSmallClass?>" data-kid="<?=$array['kid']?>">

        <?php } ?>

                <table id="<?=$schemename . $counter?>" class="<?=$schemename?>-table" data-scheme="<?=$schemename?>" data-kid="<?=$array['kid']?>">

                    <?php
                        $matchContributor = false;
                        $firstEmptyContributor = true;
                        foreach($controlTypes[$schemename] as $control => $type){
                            if (!isset($array[$control])){ // if there is no metadata for the control type

                                $array[$control] = "";
                            }
                            //build how the text value of the control should be displayed.
                            $text = '';
                            if( $type=='text'||$type=='list' ) {//MAKE THE URL SHOW UP
                                //echo json_encode($array);
                                $text = $array[$control];
                            }elseif($type=='url'){
                                $host_url = "http://$_SERVER[HTTP_HOST]";//$_SERVER[REQUEST_URI]";
                                $kid = $array['kid'];
                                $url = BASE_URL.'resource/'.$kid;
                                $url = $host_url.'/'.$url;
                                $link = "<a class='stable-url' href=".$url.">".$url."</a>";
//                                $link .= '<button class="js-textareacopybtn" style="vertical-align:top;">Copy Url</button>
//                                            <textarea style="visibility:hidden;" class="js-copytextarea">'.$url.'</textarea>';
                                $link .= '<input type="text" style="display:none;" value="'.$url.'" id="myInput">
                                        <div class="tooltip" style="opacity:1;">
                                            <button onclick="myFunction()" onmouseout="outFunc()">
                                                  Copy link
                                              </button>
                                        </div>';
                                $text = $link;

                            }elseif( $type=='multi_input'||$type=='multi_select' ){
                                if( !is_string($array[$control]) ){
                                    foreach($array[$control] as $temp) {$text .= $temp."<br>";}
                                }
                            }elseif( $type=='associator' ){
                                $dataAssociatedList = ''; //used for the dynamic accordion
                                if( !is_string($array[$control]) ){
                                    if( $aboveScheme || $aboveTwoSchemes ) {
                                        $preview = '';
                                        $usedAboveScheme = $aboveScheme;
                                        if ($schemename == 'excavations') {
                                            $preview = 'Title';
                                        } elseif ($schemename == 'archival objects') {
                                            if ($control == 'Excavation_-_Survey_Associator') {
                                                $preview = 'Name';
                                            } else { //season is the above scheme
                                                $usedAboveScheme = $aboveTwoSchemes;
                                                $preview = 'Title';
                                            }
                                        }
                                    }
                                    foreach($array[$control] as $temp) {
                                        if( $aboveScheme || $aboveTwoSchemes ){
                                            $text .= $temp." (".$usedAboveScheme[$temp][$preview].")<br>";
                                        }else{
                                            $text .= $temp."<br>";
                                        }
                                        $dataAssociatedList .= $temp. ' ';
                                    }
                                }
                            }elseif( $type == 'date' ){
                                if( !is_string($array[$control]) ){
                                    $text .= $array[$control]['year'] . "-" .
                                             $array[$control]['month'] . "-" .
                                             $array[$control]['day'] . " ".
                                             $array[$control]['era'];
                                }
                            }elseif( $type == 'terminus' ){
                                if( !is_string($array[$control]) ){
                                    if($array[$control]['prefix']){
                                        $text = $array[$control]['prefix'] . " ";
                                    }
                                    $text .= $array[$control]['year'] . "-" .
                                             $array[$control]['month'] . "-" .
                                             $array[$control]['day'] . " ".
                                             $array[$control]['era'];
                                }
                            }

                            $options = '';  //decide if there are options
                            $tmpControl = $control;
                            if( $matchContributor == true ){
                                $tmpControl = "Contributor_Role";
                                $matchContributor = false;
                            }elseif( fnmatch("Contributor*",$tmpControl) && $tmpControl != 'Contributor_Role' ){
                                $tmpControl = "Contributor";
                                if( $text == '' ){
                                    if( $firstEmptyContributor == true ){
                                        $firstEmptyContributor = false;
                                    }else{
                                        continue;
                                    }
                                }
                                $matchContributor = true;
                            }

                            if( isset($controlOptions[$schemename][$tmpControl]) ){
                                $options = ' data-options="'.$controlOptions[$schemename][$tmpControl].'"';
                            }

                            //check if the metadata has been flagged
                            $flagged = "<div class='icon-meta-flag'>&nbsp;</div>";
                            if(
                                array_key_exists($array['kid'], $flags) &&
                                in_array($control, $flags[$array['kid']], true)
                            ){
                                $flagged = "<div class='icon-meta-flag-red'>&nbsp;</div>";
                            }

                            $string = " class='metadataEdit'>
                                        $flagged
                                        <div id='$control' data-control='$type'$options>$text</div>";
                            if( $type == 'associator' ){
                                $string = " class='metadataEdit'>
                                        $flagged
                                        <div id='$control' data-control='$type'$options data-associations='$dataAssociatedList'>$text</div>";
                            }
                            if( $control == 'Persistent_Name' || $type == "url" ){
                                $string = " >
                                        $flagged
                                        <div id='$control' data-control='$type'$options>$text</div>";
                            }
                            //there is an edited metadata, so string is this
                            if(
                                array_key_exists($array['kid'], $metadataEdits) &&
                                in_array($control, $metadataEdits[$array['kid']], true)
                            ){
                                $string = '>
                                        <div class="icon-meta-lock">&nbsp;</div>
                                        <div>Pending Approval</div>';
                            }

                            $displayedControlName = $controlDisplayNames[$schemename][$tmpControl];

                            echo "<tr>
                                    <td>$displayedControlName</td>
                                    <td$string</td>
                                </tr>";
                        }
                    ?>

                </table>




<?php
        if($schemename == 'excavations' || $schemename == 'Seasons' ){
            ?></div><?php
        }
    }

    if($schemename != 'excavations' && $schemename != 'Seasons'   ){
            ?></div><?php
            }
    ?>
    </div>
</div>
<?php
}
?>
