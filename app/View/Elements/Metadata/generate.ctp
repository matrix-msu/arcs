<?php
function print_element($element){
    if(is_array($element)){
        $string = "";
        foreach ($element as $value) {
            if(!empty($value))
                $string .=  $value . ", ";
        }
        echo $string;

    }
    else
        echo $element;
}
function Generate_Metadata($name, $data, $metadataEdits, $counter = 0){
print_r( $metadataEdits);
exit();
?>

    <h3 class="level-tab" ><?= $name ?>
        <span class="edit-btn">Edit</span>
    </h3>
    <div class="level-content">
        <div class="accordion metadata-accordion">
    <?php

    foreach ($data as $array) {

        $counter++;


    ?>


            <h3 class="level-tab" ><?= $name . " Level " . $counter?>

                <span class="edit-btn">Edit</span>

            </h3>

            <div class="level-content smaller">

                <table id="<?=$name . $counter?>">
                    <?php
                    foreach($array as $key => $element){

                    ?>
                    <tr>

                        <td><?= $key ?></td>

                        <td><?php print_element($element) ?></td>

                    </tr>

                    <?php

                    }

                    ?>

                </table>

            </div>



<?php
    }
    ?>
    </div>
</div>
<?php
}
?>
