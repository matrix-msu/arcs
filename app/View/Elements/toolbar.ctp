<div id="toolbar" class="row">
    <?php if (!isset($logo) || $logo): ?>
        <a id="logo-wrapper" href="<?php echo $this->Html->url('/') ?>">
            <h1 id="logo">
                <?php echo isset($logo) && is_string($logo) ? $logo : "ARCS" ?>
            </h1>
        </a>
    <?php endif ?>
    <?php if ($user['loggedIn']): ?>
    <div id="menu" class="btn-group toolbar-btn">
        <button id="menuButton" class="btn btn-dark">
            <?php echo $user['name'] ?> 
            <span class="pointerDown"></span>
        </button>
        <div id="droppedMenu" class="dropped-menu">
            <?php echo $this->Html->link('Profile', 
                '/user/' . $user['username']) ?>
            <?php if ($user['role'] === 0): ?>
            <?php echo $this->Html->link('Admin', 
                '/admin') ?>
            <?php endif ?>
            <?php echo $this->Html->link('Sign Out', 
                '/logout') ?>
        </div>
    </div>
    <?php else: ?>

    <a class="btn btn-dark toolbar-btn" 
        href="#loginModal">Login / Register</a>
    <?php endif ?>

    <div class="btn-group toolbar-btn">
        <a id="about" class="btn btn-grey"
            href="<?php echo $this->Html->url('/about')?>">
            <i class="icon-white icon-folder-open"></i> About
        </a>
         <a id="resources" class="btn btn-grey"
            href="<?php echo $this->Html->url('/resources')?>">
            <i class="icon-white icon-folder-open"></i> Resources
        </a>
        <a id="collections" class="btn btn-grey"
            href="<?php echo $this->Html->url('/collections')?>">
            <i class="icon-white icon-folder-open"></i> Collections
        </a>
        <a id="search" class="btn btn-grey"
            href="<?php echo $this->Html->url('/search')?>">
            <i class="icon-white icon-search"></i> Search
        </a>
        <a id="help" class="btn btn-grey"
            href="<?php echo $this->Html->url('/help/')?>">
            <i class="icon-white icon-book"></i> Help
        </a>
    </div>
</div>

<div id="loginModal" class="login">
    <div class="login-content">

        <a id="#close" href="#"><img class="exit" src="http://cdn.flaticon.com/png/256/59254.png" alt="Exit"></a>

        <div class="loginSect">
            <div class="loginContainer">

                <h1 id="loginHeader">Login</h1>

                <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'login')); ?>
				
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

<div id="registerModal" class="register">
    <div class="register-content">

        <a id="#close" href="#"><img class="exit" src="http://cdn.flaticon.com/png/256/59254.png" alt="Exit"></a>

        <div class="left">
            <div class="registerContainer">

                <h1>Register</h1>

                <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register')); ?>

                <?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Name *')); echo "<p id='name-error' class='error'>&nbsp;</p>"; ?>

				<?php 
					if($this->Session->read('username-error') == true) {
						$usernameError = "Username already registered";
					} else {
						$usernameError = "";
					}
					$this->Session->delete('username-error');
				?>
                <?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Username *')); echo "<p id='username-error' class='error'>&nbsp;".$usernameError."</p>"; ?>

				<?php 
					if($this->Session->read('email-error') == true) {
						$emailError = "Email already registered";
					} else {
						$emailError = "";
					}
					$this->Session->delete('email-error');
				?>
                <?php echo $this->Form->input('email', array('label' => false, 'placeholder' => 'Email *')); echo "<p id='email-error' class='error'>&nbsp;".$emailError."</p>"; ?>

                <?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'Password *')); echo "<p id='password-error' class='error'>&nbsp;</p>"; ?>

                <span class="requiredfield">* Required Field</span>

                
            </div>
        </div>

        <div class="right">
            <div class="registerContainer2">
                <h1>&nbsp;</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex.</p>

				<?php echo $this->Form->submit('Register', array('class' => 'btn btn-success', 'id' => 'register')); ?>
				<?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>