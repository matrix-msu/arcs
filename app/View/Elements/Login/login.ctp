
<div id="loginModal" class="login desktop-login">
    <div class="login-content reverse-filter-desktop">

        <div class="loginSect">
            <a id="#close" class="exit" href="#" style="float:right;">
                <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
            </a>
            <div class="loginContainer">

                <h1 id="loginHeader">Login</h1>

                <?php
                // echo $this->Form->create('User', array('controller' => 'users', 'url' => 'special_login'));
                echo $this->Form->create('User', array('url' => array('controller'=>'users', 'action'=>'special_login')));
                ?>

                <p id="loginInfo"></p>

                <?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Username')); ?>

                <?php echo $this->Form->input('password', array('label' => false, 'id'=>'loginPassword', 'placeholder' => 'Password')); ?>

                <p class="login-link" id="forgot-password">Forgot your password?</p>
                <a class="login-link" id="register-mobile" href="#registerModal">Register</a>

                <?php echo $this->Form->input('forgot_password', array('type' => 'hidden')) ?>

                <?php echo $this->Form->submit('Login', array('class' => 'btn')); ?>

                <?php echo $this->Form->end() ?>
            </div>
        </div>

        <div class="registerSect">
            <a id="#close" class="reverse-filter" href="#" style="float:right;">
                <?= $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
            </a>
            <div class="loginContainer">

                <h1>Register</h1>
                <p style="margin-top:32px;">All annotation, discussion, and metadata editing tools require an account to use. In order to create an account, please click on the Register link below.</p>

                <a class='btn' href='#registerModal'>Register</a>
            </div>
        </div>
    </div>
</div>
