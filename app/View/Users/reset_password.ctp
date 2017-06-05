<div class="resetpw-title">
    <h1> Enter Your New Password </h1>
</div>
<br><br>
<div class="new-passwd-box">
        <?php echo $this->Form->create('User'); ?>
        <?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'Your New Password')); ?>
        <?php echo $this->Form->submit('Change password', array('class' => 'change-passwd-btn')); ?>
        <?php echo $this->Form->end() ?>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        // Focus the username field on load.
        $('#UserPassword').focus();
    });
</script>
