<?=  $this->Html->script("views/installation/keyword.js")  ?>
<?php  echo $this->Html->script("views/add_project/add_project.js"); ?>
<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
<div class="index-body-content">
    <div class="install-welcome-text">
        <h1>Add the pid!</h1>
        <br>
        <h4>Add the token!</h4>
    </div>
</div>

<div class="config-form-wrapper">
    <form action="./field" class="config-form" method="POST">
        <p>New Project PID</p>
        <input type="text" name="add-pid" required><br>
        <p>New Project Token</p>
        <input type="text" name="add-token" required>
        <br>
        <button class="continue-to-create-btn" type="submit">
            <p>Continue</p>
        </button>

    </form>
</div>

