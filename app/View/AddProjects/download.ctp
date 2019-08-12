<?=  $this->Html->script("views/installation/keyword.js")  ?>
<?php  echo $this->Html->script("views/add_project/add_project.js"); ?>
<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
<div class="index-body-content">
    <div class="install-welcome-text">
        <h1>Kora Project Import</h1>
    </div>

    <div class="importer-directions">
        <p>A download containing files for Kora3 project files should have started downloading.</p>
        <p>If your download has not started, try refreshing this page or using a different browser.</p>
        <p>Once downloaded, drag the files into the
            <a href="<?php echo KORA_IMPORT_URI; ?>" target="_blank">Kora Project Importer</a>
            and follow the directions provided.
        </p>
        <p>This process will provide you with a PID and Token you will use on the next page.</p>
    </div>

    <button class="continue-to-projConfig-btn" type="button" name="button">
        <p>Continue</p>
    </button>



</div>
