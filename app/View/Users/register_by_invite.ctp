
<div class="registration well span-6">
    <?php if ($error) {?>
        <h2>This link is no longer active.</h2>
    <?php } else {
        echo $this->Form->create('User', array('action' => 'registerByInvite/'.$activation));?>
        <h2>Create your Account</h2>
        <h4>Almost done. We just need your name, a username, and a password for your new account.</h4>
        <br>
        <div class="account span-6">
            <label for="email">Email: </label>
            <?php echo $email ?><br>
            <label for="data[User][Name]">Full Name</label>
            <?php echo $this->Form->input('name', array('label' => false)); ?>
            <?php echo $this->Form->input('username'); ?>
            <?php echo $this->Form->input('password'); ?>
            <?php echo $this->Form->input('password_confirm',
                array('label' => 'Confirm your password', 'type' => 'password')); ?>
			<?php echo $this->Form->hidden('activation',
                array('value' => $activation)); ?>
            <br>
            <?php echo $this->Form->submit('Create Account', array('class' => 'btn btn-success')); ?>
        </div>
        <?php echo $this->Form->end();
    } ?>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        // Focus the name field on load.
        $('#UserName').focus();
    });
</script>
