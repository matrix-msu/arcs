
<div class="registration span-6">
    <?php if ($error) {?>
        <h2>This link is no longer active.</h2>
    <?php } else {
        echo $this->Form->create('User', array('action' => 'registerByInvite/'.$activation));?>
        <h2>Create Your Account</h2>
        <div class="reg-description">Almost done. We just need your name, a username, and a password for your new account.</div>
        <br>
        <div class="account span-6">
        
            <span>Your Email: </span><?php echo $email ?><br>
			<div class="user-reg-div">
            	<?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Your Full Name')); ?>
            </div>
            <div class="user-reg-div-right">
            	<?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Your New Username')); ?>
            </div>
            <div class="user-reg-input">
            	<?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'New Password')); ?>
            </div>
            <div class="user-reg-input-right">
            	<?php echo $this->Form->input('password_confirm',
                	array('label' => false, 'placeholder' => 'Confirm Password', 'type' => 'password')); ?>
            </div>
			<?php echo $this->Form->hidden('activation',
                array('value' => $activation)); ?>
            <br>
            <?php echo $this->Form->submit('Create Account', array('class' => 'user-reg-btn btn btn-success')); ?>
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
