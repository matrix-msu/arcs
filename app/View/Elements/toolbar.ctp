<!-- <script>console.log(checkMobile());</script> -->
<meta id="viewport" name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"/>

<div id="toolbar" class="row">
    <?php if (!isset($logo) || $logo): ?>
        <a id="logo-wrapper" href="<?php echo $this->Html->url('/') ?>">
            <h1 id="logo">
                <?php echo isset($logo) && is_string($logo) ? $logo : "ARCS" ?>
            </h1>
        </a>
	
	
	<h1 id= "hamburger" class='hamburger'></h1>
	
    <?php endif ?>
		
	
	<!--Check if it is index page or not, display accordingly-->
	<?php if (!isset($index_toolbar) || !$index_toolbar) :?>
		<!--Display login button for other pages-->
	<div id='log'>
		<?php if ($user['loggedIn']): ?>
			<div id="menu" class="btn btn-grey toolbar-btn"> 
				<?php echo $user['name'] ?> 
				<span class="pointerDown"></span>
				<div id="droppedMenu" class="dropped-menu">
					<?php echo $this->Html->link('Profile', 
						'/user/' . $user['username'] . '/') ?>
					<?php if ($user['role'] == "Admin"): ?>
					<?php echo $this->Html->link('Admin', 
						'/admin') ?>
					<?php endif ?>
					<?php echo $this->Html->link('Sign Out', 
						'/logout') ?>
				</div>
			</div>
		<?php else: ?>
		
			<a class="btn btn-grey toolbar-btn" 
				href="#loginModal">Login / Register</a>
		
		<?php endif ?>
	</div>
	<?php else: ?>
		<!--Display search bar for index page. Placeholder, require backend programming.-->
		<div class="search-bar">
			<input type="text" class="search-bar indexSearchBox" placeholder="|&nbsp;&nbsp;Search">
			<div class="indexSearchIcon"></div>
		</div>
	<?php endif ?>

	<?php if (!isset($index_toolbar) || !$index_toolbar) :?>
	<!--Display regular buttons for other pages-->

   
	<div class="btn-group toolbar-btn">
		 <!-- Arrow won't work-->
		 <div id="projects" class="btn btn-grey">
			 <i class="icon-white icon-folder-open"></i> 
			 <div id="toolbarHead" > <div id="dropArrow" class=dropArrowFull> </div> </div> 
			<div id="projectsMenu" class="projects-menu">
				<a href="<?php echo$this->Html->url('/projects/single_project/Isthmia')?>">Isthmia</a>
				<a href="<?php echo$this->Html->url('/projects/single_project/Polis')?>">Polis</a>
				<a href="<?php echo$this->Html->url('/projects/single_project/Chersonesos')?>">Chersonesos</a>
			</div>
			
		</div>
		<div id= 'belowProjects'>
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
         <?php echo $this->Html->script('toolbarAssist.js');?>
	</div>
	<?php else: ?>
	<!--Display three buttons for index page with search bar-->
	<div class="btn-group toolbar-btn">
		<a id="about" class="btn btn-grey"
			href="<?php echo $this->Html->url('/about')?>">
			<i class="icon-white icon-folder-open"></i> About ARCS
		</a>
		 
		 <!-- Arrow won't work-->
        
		 <div id="projectsHeader" class="btn btn-grey">
			<i class="icon-white icon-folder-open"></i> Projects 
			 <div id="dropArrowHome" class=dropArrowHome> </div> 
			<div id="projectsMenu" class="projects-menu">
				<a href="<?php echo$this->Html->url('/projects/single_project/Isthmia')?>">Isthmia</a>
				<a href="<?php echo$this->Html->url('/projects/single_project/Polis')?>">Polis</a>
				<a href="<?php echo$this->Html->url('/projects/single_project/Chersonesos')?>">Chersonesos</a>
			</div>
		</div>
		<div id='helpSearch'>
		<a id="help" class="btn btn-grey"
			href="<?php echo $this->Html->url('/help/')?>">
			<i class="icon-white icon-book"></i> Help
		</a>
		<a id="searchHeader" class="btn btn-grey"
				href="<?php echo $this->Html->url('/search')?>">
				<i class="icon-white icon-search"></i> Search
			</a>
		</div>
		</div>
				
	<?php endif ?>

</div>

<div id="loginModal" class="login">
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

<div id="registerModal" class="register">
    <div class="register-content">

        <a id="#close" href="#"><img class="exit" src="http://cdn.flaticon.com/png/256/59254.png" alt="Exit"></a>

        <?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register')); ?>

        <div class="left">
            <div class="registerContainer">

                <h1>Register</h1>

                <?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'Name *')); ?>

                <?php echo $this->Form->input('usernameReg', array('label' => false, 'placeholder' => 'Username *')); ?>
				<?php echo "<p id='getUsername' hidden>".$this->Html->url(array('controller' => 'users', 'action' => 'getUsername'))."</p>";?>

                <?php echo $this->Form->input('email', array('label' => false, 'placeholder' => 'Email *')); ?>
                <?php echo "<p id='getEmail' hidden>".$this->Html->url(array('controller' => 'users', 'action' => 'getEmail'))."</p>";?>

                <?php echo $this->Form->input('passwd', array('label' => false, 'placeholder' => 'Password *'));?>

                <span class="requiredfield">* Required Field</span>
                
            </div>
        </div>

        <div class="right">
            <div class="registerContainer2">
                <h1>&nbsp;</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam elit eu tincidunt dignissim. Proin tincidunt orci sed commodo scelerisque. Praesent ex ante, feugiat vitae augue nec, tempor tempor ex.</p>

                <!-- g-recaptcha has to be inside the <form method="post"></form> (also form method has to be  post) -->
                <div class="g-recaptcha" data-sitekey="6LdFHQ0TAAAAAFZ2cLF1oq7X1zoUJapbhYgpYVh2"></div>

				<?php echo $this->Form->submit('Register', array('class' => 'btn btn-success', 'id' => 'register')); ?>

            </div>
        </div>

        <?php echo $this->Form->end() ?>

    </div>
</div>

