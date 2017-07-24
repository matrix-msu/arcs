<?php
function Generate_Metadata($schemename, $data, $metadataEdits, $controlOptions, $flags, $counter = 0){
?>

    <h3 class="level-tab <?= $schemename ?>" ><?= $schemename ?>
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
            'Geolocation' => 'multi_input',
            'Modern Name' => 'list',
            'Location Identifier' => 'text',
            'Location Identifier Scheme' => 'text',
            'Elevation' => 'text',
            'Earliest Date' => 'date',
            'Latest Date' => 'date',
            'Records Archive' => 'multi_select',
            'Persistent Name' => 'text',
            'Complex Title' => 'text',
            'Terminus Ante Quem' => 'terminus',
            'Terminus Post Quem' => 'terminus',
            'Period' => 'multi_select',
            'Archaeological Culture' => 'multi_select',
            'Description' => 'text',
            'Brief Description' => 'text',
            'Permitting Heritage Body' => 'multi_select'
        ),
        'Seasons' => array(
            'Project Associator' => 'associator',
            'Title' => 'text',
            'Type' => 'multi_select',
            'Director' => 'multi_select',
            'Registrar' => 'multi_select',
            'Sponsor' => 'multi_select',
            'Earliest Date' => 'date',
            'Latest Date' => 'date',
            'Terminus Ante Quem' => 'terminus',
            'Terminus Post Quem' => 'terminus',
            'Description' => 'text',
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
            'Contributor Role 9' => 'multi_select'
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
            'Post Dispositional Transformation' => 'text',
            'Legacy' => 'text',
            '' => '',
        ),
        'archival objects' => array(
            'Excavation - Survey Associator' => 'associator',
            'Season Associator' => 'associator',
            'Resource Identifier' => 'text',
            'Type' => 'list',
            'Title' => 'text',
            'Creator' => 'multi_select',
            'Creator Role' => 'multi_select',
            'Earliest Date' => 'date',
            'Date Range' => 'text',
            'Description' => 'text',
            'Pages' => 'text',
            'Condition' => 'list',
            'Accession Number' => 'text',
        ),
        'subjects' => array(
            'Pages Associator' => 'associator',
            'Resource Identifier' => 'text',
            'Subject of Observation Associator' => 'associator',
            'Artifact - Structure Classification' => 'list',
            'Artifact - Structure Type' => 'multi_select',
            'Artifact - Structure Terminus Ante Quem' => 'terminus',
            'Artifact - Structure Terminus Post Quem' => 'terminus',
            'Artifact - Structure Title' => 'text',
            'Artifact - Structure Geolocation' => 'multi_select',
            'Artifact - Structure Excavation Unit' => 'multi_select',
            'Artifact - Structure Description' => 'text',
            'Artifact - Structure Location' => 'multi_select'
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
                        foreach($controlTypes[$schemename] as $control => $type){
                            //build how the text value of the control should be displayed.
                            $text = '';
                            if( $type=='text'||$type=='list' ) {
                                $text = $array[$control];
                            }elseif( $type=='multi_input'||$type=='multi_select'||$type=='associator' ){
                                if( !is_string($array[$control]) ){
                                    foreach($array[$control] as $temp) {$text .= $temp."<br>";}
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
                            if( isset($controlOptions[$schemename][$control]) ){
                                $options = ' data-options="'.$controlOptions[$schemename][$control].'"';
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
                            if( $control == 'Persistent Name' ){
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

                            echo "<tr>
                                    <td>$control</td>
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
