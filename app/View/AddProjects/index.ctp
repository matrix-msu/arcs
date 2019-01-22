<?=  $this->Html->script("views/installation/keyword.js")  ?>
<?php  echo $this->Html->script("views/add_project/add_project.js"); ?>
<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
<div class="index-body-content">
<!--    <div class="install-welcome-text">-->
<!--        <h1>Welcome to ARCS!</h1>-->
<!--        <br>-->
<!--    </div>-->
    <div class="start-btn-container">
        <button class="start-install-btn" type="button" name="button">
            <p>Add a New Project</p>
        </button>
    </div>
</div>
