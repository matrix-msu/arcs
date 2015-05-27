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
        <?php if ($user['loggedIn']): ?>
        <a id="upload" class="btn btn-grey"
            href="<?php echo $this->Html->url('/upload')?>">
            <i class="icon-white icon-upload"></i> Upload
        </a>
        <?php endif ?>
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

        <a href="#close" title="Close" class="close">X</a>

        <div class="loginSect">
            <div class="loginContainer">

                <h1>Login</h1>

                <?php echo $this->Form->create('User'); ?>

                <?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Username')); ?>

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

        <a href="#close" title="Close" class="close">X</a>

        <div class="left">
            <div class="loginContainer">

                <h1>Register</h1>

                <?php echo $this->Form->create('User'); ?>

                <?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Password')); ?>

                <?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Password')); ?>

                <?php echo $this->Form->input('email', array('label' => false, 'placeholder' => 'Password')); ?>

                <?php echo $this->Form->input('pass', array('label' => false, 'placeholder' => 'Password')); ?>

                <?php echo $this->Form->end() ?>
            </div>
        </div>

        <div class="right">
            <div class="loginContainer">
                <h1>&nbsp;</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex.</p>

                <span class='btn'>Register</span>
            </div>
        </div>
    </div>
</div>