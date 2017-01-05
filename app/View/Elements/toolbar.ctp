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
	<div id='log' >
		<?php if (isset($user['loggedIn']) && $user['loggedIn'] != '' ): ?>
			<div id="menu" class="btn btn-grey toolbar-btn">
				<div id="cage">
				<?php echo $user['name'] ?>
				<div id="dropBox">
					<span id='logDrop' class="pointerDown pointerTool"></span>
				</div>
				</div>
				<div id="droppedMenu" class="dropped-menu">
					<?php echo $this->Html->link('Profile',
						'/user/' . $user['username'] . '/') ?>
					<?php if ($user['role'] == "Admin"): ?>
					<?php echo $this->Html->link('Admin',
						'/admin') ?>
					<?php endif ?>
					<div id='signOut'> <?php echo $this->Html->link('Sign Out',
						'/logout') ?></div>
				</div>


			</div>
		<?php else: ?>

			<a id='menu' class="btn btn-grey toolbar-btn"
				href="#loginModal">Login / Register</a>

		<?php endif ?>
	</div>
	<?php else: ?>
		<!--Display search bar for index page. Placeholder, require backend programming.-->
		<div class="search-bar">
			<input data-project-kid="all" type="text" id="searchBar" class="search-bar indexSearchBox search-bar-js" placeholder="|&nbsp;&nbsp;Search">
			<div class="indexSearchIcon"></div>
		</div>
	<?php endif ?>
	<?php echo $this->Html->script('searchBox.js');?>

	<?php if (!isset($index_toolbar) || !$index_toolbar) :?>
	<!--Display regular buttons for other pages-->


	<div class="btn-group toolbar-btn">
		 <!-- Arrow won't work-->
		 <div  id= "projects" class="btn btn-grey">
			 <div id='projCage'>
			 <i class="icon-white icon-folder-open"></i>
			 <div id="toolbarHead" >
				 	<div id="dropArrow" class='pointerDown pointerTool'>

				    </div>

				 </div>

			 </div>
			<div id="projectsMenu" class="projects-menu">
			    <?php foreach($projects as $p): ?>
				<a href="<?php echo$this->Html->url('/projects/single_project/' . $p['Persistent Name'])?>"><?php echo $p['Persistent Name'] ?></a>
			    <?php endforeach ?>
			</div>

		</div>
		<div id= 'belowProjects'>
		    <?php
		        //skip links if in profile or all project search
                if( ($this->request->params['controller'] != 'user' &&
                    $this->request->params['action'] != 'profile') &&
                    ($this->request->params['action'] != 'search' &&
                    $this->request->params['action'] != 'search' &&
                    $this->request->params['pass'][0] != 'all')
                    ){
		                $pKid = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        $pKid = explode('/', $pKid);
                        $pKid = '/'.array_pop($pKid);
            ?>
			 <a id="resources" class="btn btn-grey"
				href="<?php echo $this->Html->url('/resources').$pKid ?>">
				<i class="icon-white icon-folder-open"></i> Resources

			</a>
			<a id="collections" class="btn btn-grey"
				href="<?php echo $this->Html->url('/collections').$pKid ?>">
				<i class="icon-white icon-folder-open"></i> Collections
			</a>
			<a id="search" class="btn btn-grey"
				href="<?php echo $this->Html->url('/search').$pKid ?>">
				<i class="icon-white icon-search"></i> Search
			</a>

			<?php //add the search link back into the all project search

			    }if( $this->request->params['action'] == 'search' &&
                       $this->request->params['action'] == 'search' &&
                       $this->request->params['pass'][0] == 'all' ){?>
                <a id="search" class="btn btn-grey"
                    href="<?php echo $this->Html->url('/search').'/all/'
                            .$this->request->params['pass'][1] ?>">
                    <i class="icon-white icon-search"></i> Search
                </a>

            <?php } ?>

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
			<div id='projCageHome'>
			 <i class="icon-white icon-folder-open"></i>
			 <div id="toolbarHead" > Projects
				 	<div id="dropArrow" class='pointerDown pointerTool'>

				    </div>

				 </div>

			 </div>
			<div id="projectsMenu" class="projects-menu homeProject">
				<?php foreach($projects as $p): ?>
                <a href="<?php echo$this->Html->url('/projects/single_project/' . $p['Persistent Name'])?>"><?php echo $p['Persistent Name'] ?></a>
                <?php endforeach ?>
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
  <?= $this->element("Login/login");?>
  <?= $this->element("Login/register");?>
