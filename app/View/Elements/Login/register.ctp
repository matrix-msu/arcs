<div id="registerModal" class="register">
    <div class="register-content">

        <?php echo $this->Form->create('User', array('id' => 'desktopform', 'url' => '/register')); ?>
        <div class="left">
            <div class="registerContainer">

                <h1>Register</h1> <span class="requiredfield">* Required Field</span>

                <label for="name" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Full Name *', 'id' => 'name')); ?>

                <label for="usernameReg" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('usernameReg', array('label' => false, 'placeholder' => 'Username *', 'id' => 'usernameReg')); ?>
                <?php echo "<p id='getUsername' hidden>" . $this->Html->url(array('controller' => 'users', 'action' => 'getUsername')) . "</p>"; ?>

                <label for="email" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('email', array('label' => false, 'placeholder' => 'Email *', 'id' => 'email')); ?>
                <?php echo "<p id='getEmail' hidden>" . $this->Html->url(array('controller' => 'users', 'action' => 'getEmail')) . "</p>"; ?>

                <label for="password" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'Password *', 'id' => 'password')); ?>
                <label for="UserProject" class="hiddenWAVEcont"> register </label>
                <input type="hidden" id="UserProject" name="data[User][project]">
                <div class="selectDiv selectDiv1">
                    Select Project(s) to Register In *
                </div>
                <div id="projectDropdown" style="display: none;">
                    <?php foreach ($projects as $p) { ?>
                        <p id="<?php echo $p['Persistent_Name'] ?>"><?php echo ucwords($p['Persistent_Name']) ?></p>
                    <?php } ?>
                </div>


            </div>
        </div>

        <div class="right">
            <div class="registerContainer2">
                <a id="#close" class="reverse-filter" href="#" style="float:right;">
                    <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit')); ?>
                </a>

                <p>In order to register for an account, please provide us with your name, a username and password, as
                    well as an email address. You also must select the project(s) in which you would like to
                    participate. Once you have selected "register," you will receive a confirmation email. The project
                    administrator(s) will contact you once they have confirmed your request. Your patience in this
                    process is appreciated.</p>

                <!-- g-recaptcha has to be inside the <form method="post"></form> (also form method has to be  post) -->
                <div class="g-recaptcha" data-sitekey="6LfP5hcTAAAAADZ4Je8NJ0LOoP2lE4JgYet3BOx1"></div>

                <label for="registerSubmit" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->submit('Register', array('class' => 'btn btn-success', 'id' => 'registerSubmit')); ?>

            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="register-content-mobile">
        <?php echo $this->Form->create('User', array('controller' => 'users', 'id' => 'mobileform', 'url' => '/register')); ?>
        <div class="mobile">
            <a id="#close" class="reverse-filter" href="#" style="float:right;">
                <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit')); ?>
            </a>
            <div class="registerContainer3">

                <h1 id="reg">Register</h1> <span class="requiredfield">* Required Field</span>

                <h1><p class="hiddenWAVEcont">HideThis</p>&nbsp;</h1>

                <label for="hidden" class="hiddenWAVEcont"> register </label>
                <input type="hidden" name="data[isMobile]" value="true">

                <p>In order to register for an account, please provide us with your name, a username and password,
                    as
                    well as an email address. You also must select the project(s) in which you would like to
                    participate. Once you have selected "register," you will receive a confirmation email. The
                    project
                    administrator(s) will contact you once they have confirmed your request. Your patience in this
                    process is appreciated.</p>

                <label for="name2" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('name2', array('label' => false, 'placeholder' => 'Full Name *', 'id'=>'name2')); ?>

                <label for="usernameReg2" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('usernameReg2', array('label' => false, 'placeholder' => 'Username *', 'id'=>'usernameReg2')); ?>
                <?php echo "<p id='getUsername' hidden>" . $this->Html->url(array('controller' => 'users', 'action' => 'getUsername')) . "</p>"; ?>

                <label for="email2" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('email2', array('label' => false, 'placeholder' => 'Email *', 'id'=>'email2')); ?>
                <?php echo "<p id='getEmail' hidden>" . $this->Html->url(array('controller' => 'users', 'action' => 'getEmail')) . "</p>"; ?>

                <label for="password2" class="hiddenWAVEcont"> register </label>
                <?php echo $this->Form->input('password2', array('label' => false, 'placeholder' => 'Password *', 'id'=>'password2')); ?>
                <label for="UserProject2" class="hiddenWAVEcont"> register </label>
                <input type="hidden" id="UserProject2" name="data[User][project]">
                <div class="selectDiv selectDiv2">
                    Select Project(s) to Register In *
                </div>
                <div id="projectDropdown2" style="display: none;">
                    <?php foreach ($projects as $p) { ?>
                        <p id="<?php echo $p['Persistent_Name'] ?>"><?php echo ucwords($p['Persistent_Name']) ?></p>
                    <?php } ?>
                </div>
            </div>


            <!-- g-recaptcha has to be inside the <form method="post"></form> (also form method has to be  post) -->
            <center>
                <div class="g-recaptcha" data-sitekey="6LfP5hcTAAAAADZ4Je8NJ0LOoP2lE4JgYet3BOx1"></div>
            </center>
            
            <label for="registerMobile" class="hiddenWAVEcont"> mobileregister </label>
            <?php echo $this->Form->submit('Register', array('class' => 'btn btn-success', 'id' => 'registerMobile')); ?>


        </div>
        <?php echo $this->Form->end() ?>

    </div>

</div>
