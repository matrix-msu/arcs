
<div class="registration span-6">
    <?php if ($error) {?>
        <h2>This link is no longer active.</h2>
    <?php } else {
        echo $this->Form->create('User', array('action' => 'registerByInvite/'.$activation));?>
        <h2>Create Your Account</h2>
        <div class="reg-description">Almost done. We just need a username and a password for your new account.</div>
        <div class="account span-6">
        
            <h3><?php echo $name; ?></h3>
            <?php echo $email ?><br>
			<br>
            <div>
            	<?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Your New Username')); ?>
            </div>
            <div>
            	<?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'New Password')); ?>
            </div>
            <div>
            	<?php echo $this->Form->input('password_confirm',
                	array('label' => false, 'placeholder' => 'Confirm Password', 'type' => 'password')); ?>
            </div>
			<?php 
				echo $this->Form->hidden('activation',
                array('value' => $activation)); 
			?>
            <?php echo $this->Form->submit('Create Account', array('class' => 'user-reg-btn btn btn-success')); ?>
        </div>
        <?php echo $this->Form->end();
    } ?>
	<br>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        // Focus the name field on load.
        $('#UserName').focus();
    });
</script>
