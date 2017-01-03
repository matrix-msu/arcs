
<style media="screen">
.mobile-only {
  display: none;
}
.desktop-only{
  display: initial;
}
@media screen and (max-width: 1000px) {
  .mobile-only {
    display: inherit;
  }
  .desktop-only{
    display: none;
  }
}
</style>
<div id="loginModal" class="login mobile-login">
    <div class="login-content">

        <a id="#close" href="#"><img class="exit" src="http://cdn.flaticon.com/png/256/59254.png" alt="Exit"></a>

        <div class="loginSect">
            <div class="loginContainer">

                <h1 id="loginHeader">Login</h1>

                <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'special_login')); ?>

				<p id="loginInfo"></p>

                <?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Username')); ?>

                <?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'Password')); ?>

                <p class="login-link" id="forgot-password">Forgot your password?</p>

                <?php echo $this->Form->input('forgot_password', array('type' => 'hidden')) ?>

                <?php echo $this->Form->submit('Login', array('class' => 'btn')); ?>

                <?php echo $this->Form->end() ?>
            </div>
        </div>

        <div class="registerSect">
            <div class="loginContainer">

                <h1>Register</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex.</p>

                <a class='btn' href='#registerModal'>Register</a>
            </div>
        </div>
    </div>
</div>
