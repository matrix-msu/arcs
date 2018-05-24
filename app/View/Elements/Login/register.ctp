<div id="registerModal" class="register">
    <div class="register-content">


        <?php echo $this->Form->create('User', array('controller' => 'users', 'id' => 'desktopform', 'url' => '/register')); ?>
        <div class="left">
            <div class="registerContainer">

                <h1>Register</h1> <span class="requiredfield">* Required Field</span>

                <?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Full Name *')); ?>

                <?php echo $this->Form->input('usernameReg', array('label' => false, 'placeholder' => 'Username *')); ?>
                <?php echo "<p id='getUsername' hidden>".$this->Html->url(array('controller' => 'users', 'action' => 'getUsername'))."</p>";?>

                <?php echo $this->Form->input('email', array('label' => false, 'placeholder' => 'Email *')); ?>
                <?php echo "<p id='getEmail' hidden>".$this->Html->url(array('controller' => 'users', 'action' => 'getEmail'))."</p>";?>

                <?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'Password *'));?>
                <input type="hidden" id="UserProject" name="data[User][project]">
                <div class="selectDiv selectDiv1">
                    Select Project(s) to Register In *
                </div>
                <div id="projectDropdown" style="display: none;">
                    <?php foreach($projects as $p) { ?>
                        <p id="<?php echo $p['Persistent_Name'] ?>"><?php echo ucwords($p['Persistent_Name']) ?></p>
                    <?php } ?>
                </div>


            </div>
        </div>

        <div class="right">
            <div class="registerContainer2">
                <a id="#close" class="reverse-filter" href="#" style="float:right;">
                    <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
                </a>

                <p>In order to register for an account, please provide us with your name, a username and password, as well as an email address. You also must select the project(s) in which you would like to participate. Once you have selected "register," you will receive a confirmation email. The project administrator(s) will contact you once they have confirmed your request. Your patience in this process is appreciated.</p>

                <!-- g-recaptcha has to be inside the <form method="post"></form> (also form method has to be  post) -->
                <div class="g-recaptcha" data-sitekey="6LfP5hcTAAAAADZ4Je8NJ0LOoP2lE4JgYet3BOx1"></div>

                <?php echo $this->Form->submit('Register', array('class' => 'btn btn-success', 'id' => 'registerSubmit')); ?>
                <?php echo $this->Form->end() ?>
            </div>
        </div>

    </div>
    <div class = "register-content-mobile">
        <?php echo $this->Form->create('User', array('controller' => 'users', 'id' => 'mobileform', 'url' => '/register')); ?>
        <div class="mobile">
            <a id="#close" class="reverse-filter" href="#" style="float:right;">
                <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
            </a>
            <div class="registerContainer3">

                <h1 id="reg">Register</h1> <span class="requiredfield">* Required Field</span>

                <h1>&nbsp;</h1>

                <input type="hidden" name="data[isMobile]" value="true">

                <p>In order to register for an account, please provide us with your name, a username and password, as well as an email address. You also must select the project(s) in which you would like to participate. Once you have selected "register," you will receive a confirmation email. The project administrator(s) will contact you once they have confirmed your request. Your patience in this process is appreciated.</p>

                <?php echo $this->Form->input('name2', array('label' => false, 'placeholder' => 'Full Name *')); ?>

                <?php echo $this->Form->input('usernameReg2', array('label' => false, 'placeholder' => 'Username *')); ?>
                <?php echo "<p id='getUsername' hidden>".$this->Html->url(array('controller' => 'users', 'action' => 'getUsername'))."</p>";?>

                <?php echo $this->Form->input('email2', array('label' => false, 'placeholder' => 'Email *')); ?>
                <?php echo "<p id='getEmail' hidden>".$this->Html->url(array('controller' => 'users', 'action' => 'getEmail'))."</p>";?>

                <?php echo $this->Form->input('password2', array('label' => false, 'placeholder' => 'Password2 *'));?>
                <input type="hidden" id="UserProject2" name="data[User][project]">
                <div class="selectDiv selectDiv2">
                    Select Project(s) to Register In *
                </div>
                <div id="projectDropdown2" style="display: none;">
                    <?php foreach($projects as $p) { ?>
                        <p id="<?php echo $p['Persistent_Name'] ?>"><?php echo ucwords($p['Persistent_Name']) ?></p>
                    <?php } ?>
                </div>
            </div>




            <!-- g-recaptcha has to be inside the <form method="post"></form> (also form method has to be  post) -->
            <center>
                <div class="g-recaptcha" data-sitekey="6LfP5hcTAAAAADZ4Je8NJ0LOoP2lE4JgYet3BOx1"></div>
            </center>
            <?php echo $this->Form->submit('Register', array('class' => 'btn btn-success', 'id' => 'registerMobile')); ?>
            <?php echo $this->Form->end() ?>

        </div>


    </div>

</div>
