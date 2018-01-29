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
            'Modern Name' => 'list',
            'Persistent Name' => 'text',
            'Location Identifier' => 'text',
            'Location Identifier Scheme' => 'text',
            'Geolocation' => 'multi_input',
            'Elevation' => 'text',
            'Records Archive' => 'multi_select',
            'Complex Title' => 'text',
            'Earliest Date' => 'date',
            'Latest Date' => 'date',
            'Terminus Ante Quem' => 'terminus',
            'Terminus Post Quem' => 'terminus',
            'Period' => 'multi_select',
            'Archaeological Culture' => 'multi_select',
            'Description' => 'text',
            //'Brief Description' => 'text',
            'Permitting Heritage Body' => 'multi_select'
        ),
        'Seasons' => array(
            //'Project Associator' => 'associator',
            'Title' => 'text',
            'Type' => 'multi_select',
            'Sponsor' => 'multi_select',
            'Director' => 'multi_select',
            'Registrar' => 'multi_select',
            'Contributor' => 'list',
            'Contributor Role' => 'multi_select',
            'Contributor 2' => 'list',
            'Contributor Role 2' => 'multi_select',
            'Contributor 3' => 'list',
            'Contributor Role 3' => 'multi_select',
            'Contributor 4' => 'list',
            'Contributor Role 4' => 'multi_select',
            'Contributor 5' => 'list',
            'Contributor Role 5' => 'multi_select',
            'Contributor 6' => 'list',
            'Contributor Role 6' => 'multi_select',
            'Contributor 7' => 'list',
            'Contributor Role 7' => 'multi_select',
            'Contributor 8' => 'list',
            'Contributor Role 8' => 'multi_select',
            'Contributor 9' => 'list',
            'Contributor Role 9' => 'multi_select',
            'Earliest Date' => 'date',
            'Latest Date' => 'date',
            'Terminus Ante Quem' => 'terminus',
            'Terminus Post Quem' => 'terminus',
            'Description' => 'text'
        ),
        'excavations' => array(
            'Season Associator' => 'associator',
            'Name' => 'text',
            'Type' => 'list',
            'Supervisor' => 'multi_select',
            'Earliest Date' => 'date',
            'Latest Date' => 'date',
            'Terminus Ante Quem' => 'terminus',
            'Terminus Post Quem' => 'terminus',
            'Excavation Stratigraphy' => 'text',
            'Survey Conditions' => 'text',
            'Post Dispositional Transformation' => 'text'
        ),
        'archival objects' => array(
            'URL' => 'url',
            'Excavation - Survey Associator' => 'associator',
            'Season Associator' => 'associator',
            'Resource Identifier' => 'text',
            'Type' => 'list',
            'Title' => 'text',
            'Sub-title' => 'text',
            'Repository' => 'list',
            'Accession Number' => 'text',
            'Creator' => 'multi_select',
            'Creator Role' => 'multi_select',
            'Earliest Date' => 'date',
            'Latest Date' => 'date',
            //'Date Range' => 'text',
            'Dimensions' => 'multi_input',
            'Language' => 'multi_select',
            'Description' => 'text',
            'Pages' => 'text',
            'Rights' => 'text',
            'Rights Holder' => 'multi_select',
        ),
        'subjects' => array(
            'Pages Associator' => 'associator',
            //'Resource Identifier' => 'text',
            'Subject of Observation Associator' => 'associator',
            'Artifact - Structure Classification' => 'list',
            'Artifact - Structure Type' => 'multi_select',
            'Artifact - Structure Type Qualifier' => 'text',
            'Artifact - Structure Material' => 'multi_select',
            'Artifact - Structure Technique' => 'multi_select',
            'Artifact - Structure Terminus Ante Quem' => 'terminus',
            'Artifact - Structure Terminus Post Quem' => 'terminus',
            'Artifact - Structure Period' => 'multi_select',
            'Artifact - Structure Archaeological Culture' => 'multi_select',

            'Artifact - Structure Title' => 'text',
            'Artifact - Structure Creator' => 'multi_select',
            'Artifact - Structure Creator Role' => 'multi_select',
            'Artifact - Structure Dimensions' => 'multi_input',
            'Artifact - Structure Excavation Unit' => 'multi_select',
            'Artifact - Structure Location' => 'multi_select',
            'Artifact - Structure Geolocation' => 'multi_input',
            'Artifact - Structure Current Location' => 'list',
            'Artifact - Structure Repository' => 'list',
            'Artifact - Structure Repository Accession Number' => 'text',
            'Artifact - Structure Description' => 'text',
            'Artifact - Structure Condition' => 'multi_select',
            'Artifact - Structure Inscription' => 'text',
            'Artifact - Structure Munsell Number' => 'text',
            'Artifact - Structure Date' => 'date',
            'Artifact - Structure Subject' => 'multi_select',
            'Artifact - Structure Origin' => 'list',
            'Artifact - Structure Comparanda' => 'text',
            'Artifact - Structure Archaeological Context' => 'text',
            'Artifact - Structure Shelving Location' => 'text'
        )
    );
    $controlDisplayNames = array(
        'project' => array(
            'Name' => 'Name',
            'Country' => 'Country',
            'Region' => 'Geographic Region',
            'Modern Name' => 'Modern Placename',
            'Location Identifier' => 'Location',
            'Location Identifier Scheme' => 'Location Source',
            'Geolocation' => 'Coordinates',
            'Elevation' => 'Elevation',
            'Earliest Date' => 'Earliest Research Activity',
            'Latest Date' => 'Latest Research Activity',
            'Records Archive' => 'Archive / Repository',
            'Persistent Name' => 'Common Name',
            'Complex Title' => 'Associated Institution(s)',
            'Terminus Ante Quem' => 'Earliest Cultural Activity',
            'Terminus Post Quem' => 'Latest Cultural Activity',
            'Period' => 'Period(s) of Cultural Activity',
            'Archaeological Culture' => 'Archaeological Culture',
            'Description' => 'Full Description',
            //'Brief Description' => 'text',
            'Permitting Heritage Body' => 'Permitting Heritage Body'
        ),
        'Seasons' => array(
            //'Project Associator' => 'associator',
            'Title' => 'Title',
            'Type' => 'Research Activity',
            'Director' => 'Director(s)',
            'Registrar' => 'Registrar(s)',
            'Sponsor' => 'Sponsor(s)',
            'Contributor' => 'Contributor(s)',
            'Contributor Role' => 'Contributor Role(s)',
            'Contributor 2' => 'Contributor(s)',
            'Contributor Role 2' => 'Contributor Role(s)',
            'Contributor 3' => 'Contributor(s)',
            'Contributor Role 3' => 'Contributor Role(s)',
            'Contributor 4' => 'Contributor(s)',
            'Contributor Role 4' => 'Contributor Role(s)',
            'Contributor 5' => 'Contributor(s)',
            'Contributor Role 5' => 'Contributor Role(s)',
            'Contributor 6' => 'Contributor(s)',
            'Contributor Role 6' => 'Contributor Role(s)',
            'Contributor 7' => 'Contributor(s)',
            'Contributor Role 7' => 'Contributor Role(s)',
            'Contributor 8' => 'Contributor(s)',
            'Contributor Role 8' => 'Contributor Role(s)',
            'Contributor 9' => 'Contributor(s)',
            'Contributor Role 9' => 'Contributor Role(s)',
            'Earliest Date' => 'Beginning of Season',
            'Latest Date' => 'End of Season',
            'Terminus Ante Quem' => 'Earliest Cultural Activity for Season',
            'Terminus Post Quem' => 'Latest Cultural Activity for Season',
            'Description' => 'Description of Season Activity'
        ),
        'excavations' => array(
            'Season Associator' => 'Season(s) when Study took place',
            'Name' => 'Unit of Study',
            'Type' => 'Type of Study',
            'Supervisor' => 'Supervisor(s)',
            'Earliest Date' => 'Beginning of Study',
            'Latest Date' => 'End of Study',
            'Terminus Ante Quem' => 'Earliest Cultural Activity for Study Unit',
            'Terminus Post Quem' => 'Latest Cultural Activity for Study Unit',
            'Excavation Stratigraphy' => 'Description of Stratigraphy',
            'Survey Conditions' => 'Description of Survey',
            'Post Dispositional Transformation' => 'Post-Depositional Activity'
        ),
        'archival objects' => array(
            'URL' => 'Stable URL',
            'Excavation - Survey Associator' => 'Study(s) when Resource was created',
            'Season Associator' => 'Season(s) when Resource was created',
            'Resource Identifier' => 'Resource Identifier',
            'Type' => 'Resource Type',
            'Title' => 'Title',
            'Sub-title' => 'Sub-title',
            'Creator' => 'Author/Creator',
            'Creator Role' => 'Author/Creator Role',
            'Earliest Date' => 'Earliest Date of Resource',
            'Latest Date' => 'Latest Date of Resource',
            'Dimensions' => 'Dimensions',
            'Language' => 'Language(s)',
            'Description' => 'Description of Resource',
            'Pages' => 'Number of Pages',
            'Rights' => 'Rights',
            'Rights Holder' => 'Rights Holder',
            'Repository' => 'Archive / Repository',
            'Accession Number' => 'Accession/Catalogue Number(s)',
        ),
        'subjects' => array(
            'Pages Associator' => 'Page ID with Topic Info',
            //'Resource Identifier' => 'text',
            'Subject of Observation Associator' => 'Other Records with Topic Info',
            'Artifact - Structure Classification' => 'Artifact / Structure Classification',
            'Artifact - Structure Type' => 'Artifact / Structure Type',
            'Artifact - Structure Type Qualifier' => 'Type Qualifier',
            'Artifact - Structure Material' => 'Artifact / Structure Material',
            'Artifact - Structure Technique' => 'Manufacturing technique',
            'Artifact - Structure Archaeological Culture' => 'Associated Archaeological Culture',
            'Artifact - Structure Period' => 'Artifact / Structure Period',
            'Artifact - Structure Terminus Ante Quem' => 'Earliest Possible Date of Artifact / Structure',
            'Artifact - Structure Terminus Post Quem' => 'Latest Possible Date of Artifact / Structure',

            'Artifact - Structure Title' => 'Title of Artifact / Structure',
            'Artifact - Structure Location' => 'Project-specific Location',
            'Artifact - Structure Current Location' => 'Current Location of Artifact / Structure',
            'Artifact - Structure Repository' => 'Storage / Repository',
            'Artifact - Structure Repository Accession Number' => 'Accession Number',
            'Artifact - Structure Creator' => 'Artifact / Structure Creator',
            'Artifact - Structure Creator Role' => 'Creator Role',
            'Artifact - Structure Dimensions' => 'Artifact / Structure Dimensions',
            'Artifact - Structure Geolocation' => 'Artifact / Structure Coordinates',
            'Artifact - Structure Excavation Unit' => 'Artifact / Structure Survey / Excavation Unit',
            'Artifact - Structure Location' => 'Project-specific Location',
            'Artifact - Structure Description' => 'Artifact / Structure Description',
            'Artifact - Structure Condition' => 'Artifact / Structure Condition',
            'Artifact - Structure Inscription' => 'Inscribed text',
            'Artifact - Structure Munsell Number' => 'Artifact / Structure Color(s)',
            'Artifact - Structure Date' => 'Precise Date of Artifact / Structure',
            'Artifact - Structure Subject' => 'Subject of Artifact / Structure',
            'Artifact - Structure Origin' => 'Point of Origin',
            'Artifact - Structure Comparanda' => 'Comparative examples',
            'Artifact - Structure Archaeological Context' => 'Archaeological context',
            'Artifact - Structure Shelving Location' => 'Location in repository'
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
                            //build how the text value of the control should be displayed.
                            $text = '';
                            if( $type=='text'||$type=='list' ) {
                                $text = $array[$control];
                            }elseif($type=='url'){
                                $host_url = "http://$_SERVER[HTTP_HOST]";//$_SERVER[REQUEST_URI]";
                                $kid = $array['kid'];
                                $url = BASE_URL.'resource/'.$kid;
                                $url = $host_url.'/'.$url;
                                $link = "<a class='stable-url' href=".$url.">".$url."</a>";
//                                $link .= '<button class="js-textareacopybtn" style="vertical-align:top;">Copy Url</button>
//                                            <textarea style="visibility:hidden;" class="js-copytextarea">'.$url.'</textarea>';
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
                                            if ($control == 'Excavation - Survey Associator') {
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
                                $tmpControl = "Contributor Role";
                                $matchContributor = false;
                            }elseif( fnmatch("Contributor *",$tmpControl) && $tmpControl != 'Contributor Role' ){
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
                            if( $control == 'Persistent Name' || $type == "url" ){
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
