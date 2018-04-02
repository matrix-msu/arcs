<div id="registerModal" class="register">
    <div class="register-content">
        <a id="#close" class="reverse-filter" href="#">
          <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
        </a>

        <?php echo $this->Form->create('User', array('controller' => 'users', 'url' => '/register')); ?>

        <div class="left">
            <div class="registerContainer">

                <h1>Register</h1> <span class="requiredfield">* Required Field</span>

                <?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Full Name *')); ?>

                <?php echo $this->Form->input('usernameReg', array('label' => false, 'placeholder' => 'Username *')); ?>
				<?php echo "<p id='getUsername' hidden>".$this->Html->url(array('controller' => 'users', 'action' => 'getUsername'))."</p>";?>

                <?php echo $this->Form->input('email', array('label' => false, 'placeholder' => 'Email *')); ?>
                <?php echo "<p id='getEmail' hidden>".$this->Html->url(array('controller' => 'users', 'action' => 'getEmail'))."</p>";?>

                <?php echo $this->Form->input('passwd', array('label' => false, 'placeholder' => 'Password *'));?>
                <input type="hidden" id="UserProject" name="data[User][project]">
                <div class="selectDiv">
                    Select Project(s) to Register In *
                </div>
                <div id="projectDropdown" style="display: none;">
                    <?php foreach($projects as $p) { ?>
                        <p id="<?php echo $p['Persistent_Name'] ?>"><?php echo ucwords($p['Persistent_Name']) ?></p>
                    <?php } ?>
                </div>

                <?php echo $this->Form->submit('Register', array('class' => 'btn btn-success mobile-only', 'id' => 'registerMobile')); ?>
                <a class="login-link mobile-only" id="login-mobile" href="#loginModal">Login</a>

            </div>
        </div>

        <div class="right">
	    <div class="registerContainer2">
		<div class='login-link-back desktop-only'>
	  	  <a href='#loginModal'>Back To Login</a>
		</div>
                <h1>&nbsp;</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex.</p>

                <!-- g-recaptcha has to be inside the <form method="post"></form> (also form method has to be  post) -->
            <div class="g-recaptcha" data-sitekey="6LfP5hcTAAAAADZ4Je8NJ0LOoP2lE4JgYet3BOx1"></div>

				<?php echo $this->Form->submit('Register', array('class' => 'btn btn-success', 'id' => 'register')); ?>

            </div>
        </div>

        <?php echo $this->Form->end() ?>

    </div>
</div>
