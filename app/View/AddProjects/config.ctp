<?=  $this->Html->script("views/installation/keyword.js")  ?>
<?php  echo $this->Html->script("views/add_project/add_project.js"); ?>
<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
<div class="index-body-content">
    <div class="install-welcome-text">
        <h1>Configure ARCs with your KORA project:</h1>
    </div>
</div>
<div class="importer-directions" style="text-align:center;">
    <p>You can find the Project ID from you new project's main page url. It is the number at the end of the url. </p>
    <p></p>
    <p>Example: a project with the url https://kora3/projects/1 would have the Project ID of 1.</p>
    <br>
    <p>You will then need to add a new or existing token to your new project.</p>
    <p>You can do this from Kora's token management page.</p>
</div>
<br>
<div class="config-form-wrapper">
    <form action="./field" class="config-form" method="POST">
        <p>New Project ID</p>
        <input type="text" name="add-pid" required><br>
        <p>New Project Token</p>
        <input type="text" name="add-token" required>
        <br><br>
        <button class="continue-to-create-btn" type="submit">
            <p>Continue</p>
        </button>
        <br><br>
    </form>
</div>


