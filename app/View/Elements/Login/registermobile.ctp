<div id="registerModal" class="register">
    <div class="register-content">
        <a id="#close" class="reverse-filter" href="#">
          <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
        </a>

        <?php echo $this->Form->create('User', array('controller' => 'users', 'url' => '/register')); ?>

        <div class="left">
            <div class="registerContainer">

                <h1>Register</h1> <span class="requiredfield">* Required Field</span>

                <h1>&nbsp;</h1>
                <p>In order to register for an account, please provide us with your name, a username and password, as well as an email address. You also must select the project(s) in which you would like to participate. Once you have selected "register," you will receive a confirmation email. The project administrator(s) will contact you once they have confirmed your request. Your patience in this process is appreciated.</p>

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

                <!-- g-recaptcha has to be inside the <form method="post"></form> (also form method has to be  post) -->
            <div class="g-recaptcha" data-sitekey="6LfP5hcTAAAAADZ4Je8NJ0LOoP2lE4JgYet3BOx1"></div>

				<?php echo $this->Form->submit('Register', array('class' => 'btn btn-success', 'id' => 'register')); ?>


        <?php echo $this->Form->end() ?>

    </div>
</div>
