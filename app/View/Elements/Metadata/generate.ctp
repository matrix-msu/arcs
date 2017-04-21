<?php
function Generate_Metadata($schemename, $data, $metadataEdits, $counter = 0){
    //print_r($metadataEdits);
    //print_r('hello testing');
    //exit();
?>

    <h3 class="level-tab <?= $schemename ?>" ><?= $schemename ?>
        <span class="edit-btn">Edit</span>
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
                        //-----------------------------------------------------------------------------
                        if( $schemename == 'project' ){
                    ?>
                        <tr>
                            <td>Name</td>
                            <td<?php $name = "Name";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                }echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Country</td>
                            <td<?php $name = "Country";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $options = '<option value=&quot;Greece&quot;>Greece</option>';
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                    '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Region</td>
                            <td<?php $name = "Region";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $options = '<option value=&quot;Corinthia&quot;>Corinthia</option>';
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                    '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Geolocation</td>
                            <td<?php $name = "Geolocation";
                            if( array_key_exists( $name, $array ) ){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    foreach($array['Geolocation'] as $geolocation) {$text = $text.$geolocation."<br>";}
                                }
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_input">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_input"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Modern Name</td>
                            <td<?php $name = "Modern Name";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $options = '<option value=&quot;Kyras Vrisi&quot;>Kyras Vrisi</option>';
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                    '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Location Identifier</td>
                            <td<?php $name = "Location Identifier";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Location Identifier Scheme</td>
                            <td<?php $name = "Location Identifier Scheme";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Elevation</td>
                            <td<?php $name = "Elevation";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Earliest Date</td>
                            <td<?php $name = "Earliest Date";
                            if( array_key_exists( $name, $array ) ){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                }
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Latest Date</td>
                            <td<?php $name = "Latest Date";
                            if( array_key_exists( $name, $array ) ){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                }
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Records Archive</td>
                            <td<?php $name = "Records Archive";
                            if( array_key_exists( $name, $array ) ){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    foreach( $array[$name] as $record) { $text = $text.$record."<br>";}
                                }
                                $options = '<option value=&quot;The Ohio State University Excavations at Isthmia Archives&quot;>The Ohio State University Excavations at Isthmia Archives</option>';
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                    '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Persistent Name</td>
                            <td<?php $name = "Persistent Name";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Complex Title</td>
                            <td<?php $name = "Complex Title";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Terminus Ante Quem</td>
                            <td<?php $name = "Terminus Ante Quem";
                            if( array_key_exists( $name, $array ) ){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    if($array[$name]['prefix']){
                                        $text = $array[$name]['prefix'] . " ";
                                    }
                                    $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                }
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Terminus Post Quem</td>
                            <td<?php $name = "Terminus Post Quem";
                            if( array_key_exists( $name, $array ) ){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    if($array[$name]['prefix']){
                                        $text = $array[$name]['prefix'] . " ";
                                    }
                                    $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                }
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Period</td>
                            <td<?php $name = "Period";
                            if( array_key_exists( $name, $array ) ){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    foreach( $array[$name] as $period) { $text = $text.$period."<br>";}
                                }
                                $options = '<option value=&quot;Bronze Age&quot;>Bronze Age</option><option value=&quot;Geometric&quot;>Geometric</option><option value=&quot;Archaic&quot;>Archaic</option><option value=&quot;Classical&quot;>Classical</option><option value=&quot;Hellenistic&quot;>Hellenistic</option><option value=&quot;Roman&quot;>Roman</option><option value=&quot;Late Roman/Byzantine&quot;>Late Roman/Byzantine</option><option value=&quot;Frankish&quot;>Frankish</option><option value=&quot;Ottoman&quot;>Ottoman</option><option value=&quot;Modern&quot;>Modern</option>';
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                    '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Archaeological Culture</td>
                            <td<?php $name = "Archaeological Culture";
                            if( array_key_exists( $name, $array )){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                }
                                $options = '';
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                    '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Description</td>
                            <td<?php $name = "Description";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Brief Description</td>
                            <td<?php $name = "Brief Description";
                            if( array_key_exists( $name, $array )){
                                $text = $array[$name];
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Permitting Heritage Body</td>
                            <td<?php $name = "Permitting Heritage Body";
                            if( array_key_exists( $name, $array ) ){
                                $text = '';
                                if( !is_string($array[$name]) ){
                                    foreach( $array[$name] as $period) { $text = $text.$period."<br>";}
                                }
                                $options = '<option value=&quot;Greek Ministry of Culture&quot;>Greek Ministry of Culture</option><option value=&quot;American School of Classical Studies, Athens&quot;>American School of Classical Studies, Athens</option>';
                                $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                    '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                    $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                } echo $string;
                            }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                            ?>
                            </td>
                        </tr>


                    <?php
                        //-------------------------------------------------------------------------------------------
                        }elseif( $schemename == 'Seasons' ) {
                    ?>
                            <tr>
                                <td>Project Associator</td>
                                <td<?php $name = "Project Associator";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array[$name] as $associator) { $text = $text.$associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td<?php $name = "Title";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td<?php $name = "Type";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Excavation&quot;>Excavation</option><option value=&quot;Study&quot;>Study</option><option value=&quot;Survey&quot;>Survey</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Director</td>
                                <td<?php $name = "Director";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Broneer, Oscar&quot;>Broneer, Oscar</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Registrar</td>
                                <td<?php $name = "Registrar";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;&quot;></option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Sponsor</td>
                                <td<?php $name = "Sponsor";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;University of California, Los Angeles&quot;>University of California, Los Angeles</option><option value=&quot;Ohio State University&quot; selected=&quot;selected&quot;>Ohio State University</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Latest Date</td>
                                <td<?php $name = "Latest Date";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Ante Quem</td>
                                <td<?php $name = "Terminus Ante Quem";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        if($array[$name]['prefix']){
                                            $text = $array[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Post Quem</td>
                                <td<?php $name = "Terminus Post Quem";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        if($array[$name]['prefix']){
                                            $text = $array[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td<?php $name = "Description";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 2";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 2";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 3";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 3";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 4";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 4";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 5";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 5";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 6";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 6";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 7";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 7";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 8";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 8";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor</td>
                                <td<?php $name = "Contributor 9";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Berry, Rachel&quot;>Berry, Rachel</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M&quot;>Frey, Jon M</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Bauslaugh, R.&quot;>Bauslaugh, R.</option><option value=&quot;Bleistein, C.&quot;>Bleistein, C.</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;Gais, R.&quot;>Gais, R.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contributor Role</td>
                                <td<?php $name = "Contributor Role 9";
                                if( array_key_exists( $name, $array )){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $value) { $text = $text.$value."<br>";}
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Database Manager&quot;>Database Manager</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavation Unit Supervisor&quot;>Excavation Unit Supervisor</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Mapping Technician&quot;>Mapping Technician</option><option value=&quot;Materials Analyst&quot;>Materials Analyst</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Remote Sensing Technician&quot;>Remote Sensing Technician</option><option value=&quot;Student&quot;>Student</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Surveyor&quot;>Surveyor</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                    
                            
                            
                    <?php
                        //---------------------------------------------------------------
                        }elseif( $schemename == 'excavations' ) {
                    ?>
                            <tr>
                                <td>Season Associator</td>
                                <td<?php $name = "Season Associator";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array[$name] as $associator) { $text = $text.$associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td<?php $name = "Name";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td<?php $name = "Type";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Trench&quot;>Trench</option><option value=&quot;Survey&quot;>Survey</option><option value=&quot;Study/Lab&quot;>Study/Lab</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Supervisor</td>
                                <td<?php $name = "Supervisor";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array[$name] as $array_sup) {$text = $text.$array_sup."<br>";}
                                    }
                                    $options = '<option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Frey, Jon M.&quot;>Frey, Jon M.</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Wilson, David&quot;>Wilson, David</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Latest Date</td>
                                <td<?php $name = "Latest Date";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Ante Quem</td>
                                <td<?php $name = "Terminus Ante Quem";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        if($array[$name]['prefix']){
                                            $text = $array[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terminus Post Quem</td>
                                <td<?php $name = "Terminus Post Quem";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        if($array[$name]['prefix']){
                                            $text = $array[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Excavation Stratigraphy</td>
                                <td<?php $name = "Excavation Stratigraphy";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Survey Conditions</td>
                                <td<?php $name = "Survey Conditions";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Post Dispositional Transformation</td>
                                <td<?php $name = "Post Dispositional Transformation";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Legacy</td>
                                <td<?php $name = "Legacy";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>

                    <?php
                        //------------------------------------------------------------------------------------------
                        }elseif( $schemename == 'archival objects' ) {
                    ?>
                    
                            <tr>
                                <td>Excavation - Survey Associator</td>
                                <td<?php $name = "Excavation - Survey Associator";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array[$name] as $associator) { $text = $text.$associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Season Associator</td>
                                <td<?php $name = "Season Associator";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array[$name] as $associator) { $text = $text.$associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Resource Identifier</td>
                                <td<?php $name = "Resource Identifier";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Type</td>
                                <td<?php $name = "Type";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Drawing&quot;>Drawing</option><option value=&quot;Field journal&quot;>Field journal</option><option value=&quot;Inventory card&quot;>Inventory card</option><option value=&quot;Photograph&quot;>Photograph</option><option value=&quot;Photographic negative&quot;>Photographic negative</option><option value=&quot;Plan or elevation&quot;>Plan or elevation</option><option value=&quot;Report&quot;>Report</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Title</td>
                                <td<?php $name = "Title";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <?php if ($array['Sub-title'] != null) {?>
                            <tr>
                                <td>Sub-Title</td>
                                <td<?php $name = "Sub-title";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <?php } ?>
        
                            <tr>
                                <td>Creator</td>
                                <td<?php $name = "Creator";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array['Creator'] as $creator) {$text = $text.$creator.'<br>'; }
                                    }
                                    $options = '<option value=&quot;Anderson, Candace E.&quot;>Anderson, Candace E.</option><option value=&quot;Barletta, Barbara&quot;>Barletta, Barbara</option><option value=&quot;Batcheller, James&quot;>Batcheller, James</option><option value=&quot;Bauslaugh, Robert&quot;>Bauslaugh, Robert</option><option value=&quot;Blackmore, Judy&quot;>Blackmore, Judy</option><option value=&quot;Bleistein, Charlene&quot;>Bleistein, Charlene</option><option value=&quot;Bogle, Cynthia&quot;>Bogle, Cynthia</option><option value=&quot;Bolas, B.&quot;>Bolas, B.</option><option value=&quot;Bolas, Barbara&quot;>Bolas, Barbara</option><option value=&quot;Bowman, Michael&quot;>Bowman, Michael</option><option value=&quot;Broneer, Oscar&quot;>Broneer, Oscar</option><option value=&quot;Brunner, Judith&quot;>Brunner, Judith</option><option value=&quot;Camp II, John&quot;>Camp II, John</option><option value=&quot;Camp, Margot&quot;>Camp, Margot</option><option value=&quot;Card, Sandra&quot;>Card, Sandra</option><option value=&quot;Carpenter, J. D.&quot;>Carpenter, J. D.</option><option value=&quot;Cassimatis, Maria&quot;>Cassimatis, Maria</option><option value=&quot;Clement, Paul&quot;>Clement, Paul</option><option value=&quot;Cummer, W. Wilson&quot;>Cummer, W. Wilson</option><option value=&quot;DeForest, Dallas&quot;>DeForest, Dallas</option><option value=&quot;Dinsmoor, Jr., William Bell&quot;>Dinsmoor, Jr., William Bell</option><option value=&quot;Downs, Joanie&quot;>Downs, Joanie</option><option value=&quot;Farnsworth, Marie&quot;>Farnsworth, Marie</option><option value=&quot;Feder, Debbie&quot;>Feder, Debbie</option>'.
                                                    '<option value=&quot;Frankhauser, Sarah&quot;>Frankhauser, Sarah</option><option value=&quot;Frey, Jon M.&quot;>Frey, Jon M.</option><option value=&quot;Gais, Ruth&quot;>Gais, Ruth</option>'.
                                                    '<option value=&quot;Giesen, Myra J.&quot;>Giesen, Myra J.</option><option value=&quot;Gill, Alyson A.&quot;>Gill, Alyson A.</option><option value=&quot;Greenberg, Barbara Bolas&quot;>Greenberg, Barbara Bolas</option><option value=&quot;Gregory, Adelia E.&quot;>Gregory, Adelia E.</option><option value=&quot;Gregory, Timothy E.&quot;>Gregory, Timothy E.</option><option value=&quot;Grigoryan, Anait&quot;>Grigoryan, Anait</option><option value=&quot;Guven, Suna&quot;>Guven, Suna</option><option value=&quot;Harris, A.&quot;>Harris, A.</option><option value=&quot;Hartswick, Kim J.&quot;>Hartswick, Kim J.</option><option value=&quot;Howell, Jesse&quot;>Howell, Jesse</option><option value=&quot;Hull, Don&quot;>Hull, Don</option><option value=&quot;Hull, Susan&quot;>Hull, Susan</option><option value=&quot;Jacoby, Tom&quot;>Jacoby, Tom</option><option value=&quot;Jameson, Matthew&quot;>Jameson, Matthew</option><option value=&quot;Johnson, Matthew&quot;>Johnson, Matthew</option>'.
                                                    '<option value=&quot;Kaljakin, Tania&quot;>Kaljakin, Tania</option><option value=&quot;Kallemeyer, Susan&quot;>Kallemeyer, Susan</option><option value=&quot;Kardulias, P. Nick&quot;>Kardulias, P. Nick</option><option value=&quot;Kaye, Kenneth&quot;>Kaye, Kenneth</option><option value=&quot;Keating, Richard&quot;>Keating, Richard</option><option value=&quot;Kieit, S.&quot;>Kieit, S.</option><option value=&quot;Kouvaris, Michael S.&quot;>Kouvaris, Michael S.</option><option value=&quot;Lanham, Carol&quot;>Lanham, Carol</option><option value=&quot;Leander-Touati, Anne-Marie&quot;>Leander-Touati, Anne-Marie</option><option value=&quot;Lease, L.&quot;>Lease, L.</option><option value=&quot;Liddle, G.&quot;>Liddle, G.</option><option value=&quot;Lindros-Wohl, Birgitta&quot;>Lindros-Wohl, Birgitta</option><option value=&quot;Long, Andrea&quot;>Long, Andrea</option><option value=&quot;Luongo, C.&quot;>Luongo, C.</option><option value=&quot;Marty, Jeanne M.&quot;>Marty, Jeanne M.</option>'.
                                                    '<option value=&quot;McCaslin, Dan&quot;>McCaslin, Dan</option><option value=&quot;McClure, Robert&quot;>McClure, Robert</option><option value=&quot;McGrew, Ellen&quot;>McGrew, Ellen</option><option value=&quot;Mitchell, Maria&quot;>Mitchell, Maria</option><option value=&quot;Moore, Allen&quot;>Moore, Allen</option><option value=&quot;Moore, Debra W.&quot;>Moore, Debra W.</option><option value=&quot;Mucha, Ashley E.&quot;>Mucha, Ashley E.</option><option value=&quot;Nash, Scott&quot;>Nash, Scott</option><option value=&quot;Nicols, John&quot;>Nicols, John</option><option value=&quot;Okin, Louis&quot;>Okin, Louis</option><option value=&quot;Pallas, Demetrios&quot;>Pallas, Demetrios</option><option value=&quot;Pattengale, Jerry&quot;>Pattengale, Jerry</option><option value=&quot;Peirce, Sarah&quot;>Peirce, Sarah</option><option value=&quot;Peppers, Anne Beaton&quot;>Peppers, Anne Beaton</option><option value=&quot;Peppers, James&quot;>Peppers, James</option><option value=&quot;Peppers, Jeanne Marty&quot;>Peppers, Jeanne Marty</option><option value=&quot;Pettegrew, David&quot;>Pettegrew, David</option><option value=&quot;Pettegrew, Kate&quot;>Pettegrew, Kate</option><option value=&quot;Pierce, Charles&quot;>Pierce, Charles</option><option value=&quot;Platz, Ralph&quot;>Platz, Ralph</option><option value=&quot;Pollak, Barbara A.&quot;>Pollak, Barbara A.</option><option value=&quot;Porter, Alexander&quot;>Porter, Alexander</option><option value=&quot;Rife, Joseph L.&quot;>Rife, Joseph L.</option><option value=&quot;Rothaus, Richard M.&quot;>Rothaus, Richard M.</option>'.
                                                    '<option value=&quot;Rudrick, Anna M.&quot;>Rudrick, Anna M.</option><option value=&quot;Sarefield, Daniel&quot;>Sarefield, Daniel</option><option value=&quot;Sasel, Marjeta&quot;>Sasel, Marjeta</option><option value=&quot;Schaar, Kenneth W.&quot;>Schaar, Kenneth W.</option><option value=&quot;Scott, Ruth&quot;>Scott, Ruth</option><option value=&quot;Semeli S.&quot;>Semeli S.</option><option value=&quot;Shaw, Joseph W.&quot;>Shaw, Joseph W.</option><option value=&quot;Silberberg, Susan R.&quot;>Silberberg, Susan R.</option><option value=&quot;Snively, Carolyn&quot;>Snively, Carolyn</option><option value=&quot;Stein, Carol A.&quot;>Stein, Carol A.</option><option value=&quot;Swain, Brian&quot;>Swain, Brian</option><option value=&quot;Tache, Hannah&quot;>Tache, Hannah</option><option value=&quot;Thorne, Margaret MacVeagh&quot;>Thorne, Margaret MacVeagh</option><option value=&quot;Thorne, Stuart E.&quot;>Thorne, Stuart E.</option><option value=&quot;Tzortzoupolou-Gregory, Lita&quot;>Tzortzoupolou-Gregory, Lita</option><option value=&quot;Vernon, Catherine&quot;>Vernon, Catherine</option><option value=&quot;von Sternberg, Meri&quot;>von Sternberg, Meri</option><option value=&quot;Walker, B.&quot;>Walker, B.</option><option value=&quot;Walters, Elizabeth J.&quot;>Walters, Elizabeth J.</option><option value=&quot;Wilson, David&quot;>Wilson, David</option><option value=&quot;Wittman, Barbara&quot;>Wittman, Barbara</option><option value=&quot;Wittmann, Barbara K.&quot;>Wittmann, Barbara K.</option><option value=&quot;Wohl, Birgitta&quot;>Wohl, Birgitta</option><option value=&quot;Zidar, Charles M.&quot;>Zidar, Charles M.</option><option value=&quot;Zuckerman, T. B.&quot;>Zuckerman, T. B.</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Creator Role</td>
                                <td<?php $name = "Creator Role";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array[$name] as $role) {$text = $text.$role.'<br>'; }
                                    }
                                    $options = '<option value=&quot;Architect&quot;>Architect</option><option value=&quot;Archivist&quot;>Archivist</option><option value=&quot;Assistant Director&quot;>Assistant Director</option><option value=&quot;Conservator&quot;>Conservator</option><option value=&quot;Director&quot;>Director</option><option value=&quot;Excavator&quot;>Excavator</option><option value=&quot;Field Director&quot;>Field Director</option><option value=&quot;Photographer&quot;>Photographer</option><option value=&quot;Student Volunteer&quot;>Student Volunteer</option><option value=&quot;Trench Supervisor&quot;>Trench Supervisor</option><option value=&quot;Registrar&quot;>Registrar</option><option value=&quot;Field Coordinator&quot;>Field Coordinator</option><option value=&quot;Draftsman&quot;>Draftsman</option><option value=&quot;Volunteer&quot;>Volunteer</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Earliest Date</td>
                                <td<?php $name = "Earliest Date";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="date"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Date Range</td>
                                <td<?php $name = "Date Range";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Description</td>
                                <td<?php $name = "Description";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Pages</td>
                                <td<?php $name = "Pages";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Condition</td>
                                <td<?php $name = "Condition";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Good&quot;>Good</option><option value=&quot;Fair&quot;>Fair</option><option value=&quot;Poor&quot;>Poor</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Access Level</td>
                                <td<?php $name = "Access Level";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Closed&quot;>Closed</option><option value=&quot;Metadata&quot;>Metadata</option><option value=&quot;Metadata and digital file&quot; selected=&quot;selected&quot;>Metadata and digital file</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                                '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
        
                            <tr>
                                <td>Accession Number</td>
                                <td<?php $name = "Accession Number";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                    
                    <?php
                        //------------------------------------------------------------------------------------------
                        }elseif( $schemename == 'subjects' ) {
                    ?>
                            <tr>
                                <td>Pages Associator</td>
                                <td<?php $name = "Pages Associator";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array['Pages Associator'] as $page_associator) { $text = $text.$page_associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Resource Identifier</td>
                                <td<?php $name = "Resource Identifier";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Subject of Observation Associator</td>
                                <td<?php $name = "Subject of Observation Associator";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array[$name] as $subject_associator) {$text = $text.$subject_associator."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="associator"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Classification</td>
                                <td<?php $name = "Artifact - Structure Classification";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $options = '<option value=&quot;Arrentine&quot;>Arrentine</option><option value=&quot;Black Figure&quot;>Black Figure</option><option value=&quot;Candarli&quot;>Candarli</option><option value=&quot;Coarseware&quot;>Coarseware</option><option value=&quot;Corinthian&quot;>Corinthian</option><option value=&quot;Diamond shaped&quot;>Diamond shaped</option><option value=&quot;Doric&quot;>Doric</option><option value=&quot;Eastern Sigillata A&quot;>Eastern Sigillata A</option><option value=&quot;Eastern Sigillata B&quot;>Eastern Sigillata B</option><option value=&quot;Fineware&quot;>Fineware</option><option value=&quot;Floor tile&quot;>Floor tile</option><option value=&quot;Hydraulic&quot;>Hydraulic</option><option value=&quot;Imitation&quot;>Imitation</option><option value=&quot;Ionic&quot;>Ionic</option><option value=&quot;Kitchen ware&quot;>Kitchen ware</option><option value=&quot;Megarian&quot;>Megarian</option><option value=&quot;Micaceous&quot;>Micaceous</option><option value=&quot;Miniature&quot;>Miniature</option><option value=&quot;Non-rotary&quot;>Non-rotary</option><option value=&quot;Opus Sectile&quot;>Opus Sectile</option><option value=&quot;Plain ware&quot;>Plain ware</option><option value=&quot;Polygonal&quot;>Polygonal</option><option value=&quot;Pompeian Red&quot;>Pompeian Red</option><option value=&quot;Pontic Ware&quot;>Pontic Ware</option><option value=&quot;Red Figure&quot;>Red Figure</option><option value=&quot;Sgraffito&quot;>Sgraffito</option><option value=&quot;Slavic&quot;>Slavic</option><option value=&quot;Unknown&quot;>Unknown</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="list" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="list"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Type</td>
                                <td<?php $name = "Artifact - Structure Type";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array['Artifact - Structure Type'] as $structure_type) {$text = $text.$structure_type."<br>";}
                                    }
                                    $options = '<option value=&quot;Amphora&quot;>Amphora</option><option value=&quot;Antefix&quot;>Antefix</option><option value=&quot;Ashlar&quot;>Ashlar</option><option value=&quot;Base&quot;>Base</option><option value=&quot;Basin&quot;>Basin</option><option value=&quot;Bead&quot;>Bead</option><option value=&quot;Block&quot;>Block</option><option value=&quot;Body Sherd&quot;>Body Sherd</option><option value=&quot;Bottle&quot;>Bottle</option><option value=&quot;Bowl&quot;>Bowl</option><option value=&quot;Brick&quot;>Brick</option><option value=&quot;Buckle&quot;>Buckle</option><option value=&quot;Capital&quot;>Capital</option><option value=&quot;Casserole&quot;>Casserole</option><option value=&quot;Coin&quot;>Coin</option><option value=&quot;Column Base&quot;>Column Base</option><option value=&quot;Column shaft&quot;>Column shaft</option><option value=&quot;Cooking pot&quot;>Cooking pot</option><option value=&quot;Cornice&quot;>Cornice</option><option value=&quot;Crown moulding&quot;>Crown moulding</option><option value=&quot;Cup&quot;>Cup</option><option value=&quot;Dish&quot;>Dish</option><option value=&quot;Disk&quot;>Disk</option><option value=&quot;Drinking cup&quot;>Drinking cup</option><option value=&quot;Epistyle&quot;>Epistyle</option><option value=&quot;Epistyle/frieze&quot;>Epistyle/frieze</option><option value=&quot;Figurine&quot;>Figurine</option><option value=&quot;Flake&quot;>Flake</option><option value=&quot;Foot&quot;>Foot</option><option value=&quot;Foundation&quot;>Foundation</option><option value=&quot;Fragment&quot;>Fragment</option><option value=&quot;Frying pan&quot;>Frying pan</option><option value=&quot;Furnace ribbing&quot;>Furnace ribbing</option><option value=&quot;Grill&quot;>Grill</option><option value=&quot;Gutta&quot;>Gutta</option><option value=&quot;Hammer stone&quot;>Hammer stone</option><option value=&quot;Hand stone&quot;>Hand stone</option><option value=&quot;Handle&quot;>Handle</option><option value=&quot;Hook&quot;>Hook</option><option value=&quot;Inscription&quot;>Inscription</option><option value=&quot;Jug&quot;>Jug</option><option value=&quot;Kernos&quot;>Kernos</option><option value=&quot;Kiln Foot&quot;>Kiln Foot</option><option value=&quot;Kiln lining&quot;>Kiln lining</option><option value=&quot;Kiln support&quot;>Kiln support</option><option value=&quot;Knife blade&quot;>Knife blade</option><option value=&quot;Krater&quot;>Krater</option><option value=&quot;Lamp&quot;>Lamp</option><option value=&quot;Lekythos&quot;>Lekythos</option><option value=&quot;Lid&quot;>Lid</option><option value=&quot;Lime&quot;>Lime</option><option value=&quot;Loomweight&quot;>Loomweight</option><option value=&quot;Millstone&quot;>Millstone</option><option value=&quot;Moulding&quot;>Moulding</option><option value=&quot;Nail&quot;>Nail</option><option value=&quot;Neck&quot;>Neck</option><option value=&quot;Oinochoe&quot;>Oinochoe</option><option value=&quot;Pantile&quot;>Pantile</option><option value=&quot;Pendant&quot;>Pendant</option><option value=&quot;Pin&quot;>Pin</option><option value=&quot;Pitcher&quot;>Pitcher</option>'.
                                        '<option value=&quot;Plate&quot;>Plate</option><option value=&quot;Polishing stone&quot;>Polishing stone</option><option value=&quot;Pot&quot;>Pot</option><option value=&quot;Pyxis&quot;>Pyxis</option><option value=&quot;Rain spout&quot;>Rain spout</option><option value=&quot;Relief&quot;>Relief</option><option value=&quot;Revetment&quot;>Revetment</option><option value=&quot;Rim&quot;>Rim</option><option value=&quot;Ring&quot;>Ring</option><option value=&quot;Ring foot&quot;>Ring foot</option><option value=&quot;Rooftile&quot;>Rooftile</option><option value=&quot;Rubble&quot;>Rubble</option><option value=&quot;Sample&quot;>Sample</option><option value=&quot;Scotia&quot;>Scotia</option><option value=&quot;Sculpture&quot;>Sculpture</option><option value=&quot;Sima&quot;>Sima</option><option value=&quot;Skyphos&quot;>Skyphos</option><option value=&quot;Spindle whorl&quot;>Spindle whorl</option><option value=&quot;Stewpot&quot;>Stewpot</option><option value=&quot;Stopper&quot;>Stopper</option><option value=&quot;Strap&quot;>Strap</option><option value=&quot;Stucco&quot;>Stucco</option><option value=&quot;Tablewear&quot;>Tablewear</option><option value=&quot;Tegula mammata&quot;>Tegula mammata</option><option value=&quot;Tessera&quot;>Tessera</option><option value=&quot;Tile&quot;>Tile</option><option value=&quot;Toe&quot;>Toe</option><option value=&quot;Top&quot;>Top</option><option value=&quot;Torus&quot;>Torus</option><option value=&quot;Trefoil&quot;>Trefoil</option><option value=&quot;Tube&quot;>Tube</option><option value=&quot;Unguentarium&quot;>Unguentarium</option><option value=&quot;Vessel&quot;>Vessel</option><option value=&quot;Votive&quot;>Votive</option><option value=&quot;Wall&quot;>Wall</option><option value=&quot;Water Jar&quot;>Water Jar</option><option value=&quot;Wire&quot;>Wire</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Terminus Ante Quem</td>
                                <td<?php $name = "Artifact - Structure Terminus Ante Quem";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        if($array[$name]['prefix']){
                                            $text = $array[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Terminus Post Quem</td>
                                <td<?php $name = "Artifact - Structure Terminus Post Quem";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        if($array[$name]['prefix']){
                                            $text = $array[$name]['prefix'] . " ";
                                        }
                                        $text = $text . $array[$name]['year'] . "-" . $array[$name]['month'] . "-" . $array[$name]['day'] . " ". $array[$name]['era'];
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="terminus"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Title</td>
                                <td<?php $name = "Artifact - Structure Title";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Geolocation</td>
                                <td<?php $name = "Artifact - Structure Geolocation";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array[$name] as $geolocation) { $text = $text.$geolocation."<br>";}
                                    }
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_input">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_input"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Excavation Unit</td>
                                <td<?php $name = "Artifact - Structure Excavation Unit";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach( $array['Artifact - Structure Excavation Unit'] as $excavation_unit) { $text = $text.$excavation_unit."<br>";}
                                    }
                                    $options = '<option value=&quot;HEX-72-1&quot;>HEX-72-1</option><option value=&quot;HEX-72-2&quot;>HEX-72-2</option><option value=&quot;HEX-72-3&quot;>HEX-72-3</option><option value=&quot;HEX-72-4&quot;>HEX-72-4</option><option value=&quot;HEX-72-5&quot;>HEX-72-5</option><option value=&quot;HEX-72-6&quot;>HEX-72-6</option><option value=&quot;HEX-72-7&quot;>HEX-72-7</option><option value=&quot;HEX-72-8&quot;>HEX-72-8</option><option value=&quot;Trench 93-1&quot;>Trench 93-1</option><option value=&quot;Trench 95-6&quot;>Trench 95-6</option><option value=&quot;Trench 95-7&quot;>Trench 95-7</option><option value=&quot;Trench 2003-1&quot;>Trench 2003-1</option><option value=&quot;Trench 2003-2&quot;>Trench 2003-2</option><option value=&quot;Trench 2004-1&quot;>Trench 2004-1</option><option value=&quot;Trench 2004-2&quot;>Trench 2004-2</option><option value=&quot;Trench 2004-3&quot;>Trench 2004-3</option><option value=&quot;Trench 2004-4&quot;>Trench 2004-4</option><option value=&quot;Trench 2005-1&quot;>Trench 2005-1</option><option value=&quot;Trench 2005-2&quot;>Trench 2005-2</option><option value=&quot;Trench 2005-3&quot;>Trench 2005-3</option><option value=&quot;Trench 2005-4&quot;>Trench 2005-4</option><option value=&quot;Trench 2005-5&quot;>Trench 2005-5</option><option value=&quot;Trench 2005-6&quot;>Trench 2005-6</option><option value=&quot;Trench 2006-1&quot;>Trench 2006-1</option><option value=&quot;Trench 2006-2&quot;>Trench 2006-2</option><option value=&quot;Trench 2007-1&quot;>Trench 2007-1</option><option value=&quot;Trench 2007-2&quot;>Trench 2007-2</option><option value=&quot;Trench 2007-3&quot;>Trench 2007-3</option><option value=&quot;Trench 2008-1&quot;>Trench 2008-1</option>'.
                                        '<option value=&quot;Trench 2008-2&quot;>Trench 2008-2</option><option value=&quot;Trench 2008-3&quot;>Trench 2008-3</option><option value=&quot;Trench 2008-4&quot;>Trench 2008-4</option><option value=&quot;Trench 2009-1&quot;>Trench 2009-1</option><option value=&quot;Trench 2009-2&quot;>Trench 2009-2</option><option value=&quot;Trench 2009-3&quot;>Trench 2009-3</option><option value=&quot;Trench 2010-1&quot;>Trench 2010-1</option><option value=&quot;Trench 2010-2&quot;>Trench 2010-2</option><option value=&quot;Trench 2010-3&quot;>Trench 2010-3</option><option value=&quot;Trench 2010-4&quot;>Trench 2010-4</option><option value=&quot;Trench 2010-5&quot;>Trench 2010-5</option><option value=&quot;Trench 2011-1&quot;>Trench 2011-1</option><option value=&quot;Trench 2011-2&quot;>Trench 2011-2</option><option value=&quot;Trench 2011-3&quot;>Trench 2011-3</option><option value=&quot;Trench 2011-4&quot;>Trench 2011-4</option><option value=&quot;Trench 2011-5&quot;>Trench 2011-5</option><option value=&quot;Trench GB-70-1&quot;>Trench GB-70-1</option><option value=&quot;Trench GB-70-2&quot;>Trench GB-70-2</option><option value=&quot;Trench GB-70-3&quot;>Trench GB-70-3</option><option value=&quot;Trench GB-70-4&quot;>Trench GB-70-4</option><option value=&quot;Trench GB-70-5&quot;>Trench GB-70-5</option><option value=&quot;Trench GB-70-6&quot;>Trench GB-70-6</option><option value=&quot;Trench GB-70-7&quot;>Trench GB-70-7</option><option value=&quot;Trench GB-70-8&quot;>Trench GB-70-8</option><option value=&quot;Trench GB-70-9&quot;>Trench GB-70-9</option><option value=&quot;Trench GB-70-10&quot;>Trench GB-70-10</option><option value=&quot;Surface Find&quot;>Surface Find</option>';
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Description</td>
                                <td<?php $name = "Artifact - Structure Description";
                                if( array_key_exists( $name, $array )){
                                    $text = $array[$name];
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="text"></div>';}
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Artifact - Structure Location</td>
                                <td<?php $name = "Artifact - Structure Location";
                                if( array_key_exists( $name, $array ) ){
                                    $text = '';
                                    if( !is_string($array[$name]) ){
                                        foreach($array['Artifact - Structure Location'] as $structure_location) { $text = $text.$structure_location."<br>";}
                                    }
                                    $options = "<option value=&quot;Architecture&quot;>Architecture</option><option value=&quot;Area Northwest of Temple&quot;>Area Northwest of Temple</option><option value=&quot;Bones&quot;>Bones</option><option value=&quot;Broneer Excavation Dump&quot;>Broneer Excavation Dump</option><option value=&quot;Decauville Graves&quot;>Decauville Graves</option><option value=&quot;Dump&quot;>Dump</option><option value=&quot;Early Stadium&quot;>Early Stadium</option><option value=&quot;East Field&quot;>East Field</option><option value=&quot;Field Notes&quot;>Field Notes</option><option value=&quot;Filis Area&quot;>Filis Area</option><option value=&quot;Fortress&quot;>Fortress</option><option value=&quot;Fortress Stairways&quot;>Fortress Stairways</option><option value=&quot;Fortress Tower&quot;>Fortress Tower</option><option value=&quot;Fortress Tower 5&quot;>Fortress Tower 5</option><option value=&quot;Fortress Wall&quot;>Fortress Wall</option><option value=&quot;Gellis Wall&quot;>Gellis Wall</option><option value=&quot;Gully Bastion&quot;>Gully Bastion</option><option value=&quot;Gully Bastion Grave 2&quot;>Gully Bastion Grave 2</option><option value=&quot;Hexamilion&quot;>Hexamilion</option><option value=&quot;Hexamillion Outworks&quot;>Hexamillion Outworks</option><option value=&quot;House of Dimitrios Spanos&quot;>House of Dimitrios Spanos</option><option value=&quot;Iconic Base&quot;>Iconic Base</option><option value=&quot;IΣ Box 2&quot;>IΣ Box 2</option><option value=&quot;Lambrou Cemetery&quot;>Lambrou Cemetery</option><option value=&quot;Later Stadium&quot;>Later Stadium</option>".
                                        "<option value=&quot;Loukos&quot;>Loukos</option><option value=&quot;Loukos Dump&quot;>Loukos Dump</option><option value=&quot;Loukos Grave&quot;>Loukos Grave</option><option value=&quot;N of T1 Wall&quot;>N of T1 Wall</option><option value=&quot;National Road&quot;>National Road</option><option value=&quot;North Drain&quot;>North Drain</option><option value=&quot;Northeast Gate&quot;>Northeast Gate</option><option value=&quot;Northwest Gate&quot;>Northwest Gate</option><option value=&quot;Northwest Precinct&quot;>Northwest Precinct</option><option value=&quot;Northwest Reservoir&quot;>Northwest Reservoir</option><option value=&quot;Roman Bath&quot;>Roman Bath</option><option value=&quot;Sanctuary of Poseidon&quot;>Sanctuary of Poseidon</option><option value=&quot;South Gate&quot;>South Gate</option><option value=&quot;Stadium&quot;>Stadium</option><option value=&quot;Stray Find&quot;>Stray Find</option><option value=&quot;Surface Find&quot;>Surface Find</option><option value=&quot;Temple&quot;>Temple</option><option value=&quot;Theater&quot;>Theater</option><option value=&quot;Theater Court&quot;>Theater Court</option><option value=&quot;Theater Court 2&quot;>Theater Court 2</option><option value=&quot;Tower 2&quot;>Tower 2</option><option value=&quot;Tower 5&quot;>Tower 5</option><option value=&quot;Tower 6&quot;>Tower 6</option><option value=&quot;Tower 10&quot;>Tower 10</option><option value=&quot;Tower 14&quot;>Tower 14</option><option value=&quot;Tower 15&quot;>Tower 15</option><option value=&quot;West Cemetery&quot;>West Cemetery</option><option value=&quot;Theatre&quot;>Theatre</option><option value=&quot;Area Southwest of Stadium&quot;>Area Southwest of Stadium</option><option value=&quot;Northwest of Temple&quot;>Northwest of Temple</option><option value=&quot;Unknown&quot;>Unknown</option><option value=&quot;Tower 18&quot;>Tower 18</option><option value=&quot;Dump: 1969-72&quot;>Dump: 1969-72</option><option value=&quot;Justinian's Fortress Tower 14&quot;>Justinian's Fortress Tower 14</option><option value=&quot;Justinian's Fortress&quot;>Justinian's Fortress</option><option value=&quot;Justinian's Wall Tower 14&quot;>Justinian's Wall Tower 14</option><option value=&quot;Surface&quot;>Surface</option><option value=&quot;Ionic Base&quot;>Ionic Base</option><option value=&quot;Fortress Tower 15&quot;>Fortress Tower 15</option><option value=&quot;Fortress Tower 2&quot;>Fortress Tower 2</option><option value=&quot;Agios Vasilios&quot;>Agios Vasilios</option><option value=&quot;Site&quot;>Site</option><option value=&quot;North of Temple&quot;>North of Temple</option><option value=&quot;Area North of Temple&quot;>Area North of Temple</option><option value=&quot;Gate&quot;>Gate</option>";
                                    $string =' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div>'.
                                        '<div id="'.$name.'" data-control="multi_select" data-options="'.$options.'">'.$text.'</div>';
                                    if( array_key_exists($array['kid'], $metadataEdits) && in_array($name, $metadataEdits[$array['kid']], true) ){
                                        $string = '><div class="icon-meta-lock">&nbsp;</div><div class="metadataEditOpaque" >'.$text.'</div>';
                                    } echo $string;
                                }else{echo ' class="metadataEdit"><div class="icon-meta-flag">&nbsp;</div><div id="'.$name.'" data-control="multi_select" data-options="'.$options.'"></div>';}
                                ?>
                                </td>
                            </tr>
                    <?php
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
