<meta id="viewport" name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"/>
<?php
	if( isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'index') {
		$index_toolbar = 1;
	}
	$helpBlue = '';
	if( //is a help page make help link blue
		$this->request->params['controller'] == 'help' &&
		$this->request->params['action'] == 'display'
	){$helpBlue = ' btn-blue';}
?>
<div id="toolbar" class="row"> 
        <a id="logo-wrapper" href="<?php echo $this->Html->url('/') ?>">
            <h1 id="logo"><p class="hiddenWAVEcont">HideThis</p>
            </h1>
        </a>

	<h1 id= "hamburger" class='hamburger'><p class="hiddenWAVEcont">HideThis</p></h1>

  <?php
    // Check if $nobutton is set and its value
    if (!isset($nobutton) || !$nobutton) :
  ?>
	<!--Display login button for other pages-->
	<div id='log' >
		<?php
		$profileBlue = '';
		if( //is a help page make help link blue
			$this->request->params['controller'] == 'users' &&
			$this->request->params['action'] == 'profile'
		){$profileBlue = ' btn-blue';}

		//$user['loggedIn'] = 1;
		//		print_r($user);
		//die;
		if (isset($user['loggedIn']) && $user['loggedIn'] != '' ): ?>
			<div id="menu" class="btn toolbar-btn<?php echo $profileBlue ?>">
				<div id="cage" data-userId="<?php if(isset($user['id']))echo $user['id']; ?>">
				<?php echo $user['name'] ?>
				<div id="dropBox">
					<span id='logDrop' class="pointerDown pointerTool whiteArrow"></span>
				</div>
				</div>
				<div id="droppedMenu" class="dropped-menu">
					<?php echo $this->Html->link('Profile',
						'/user/' . $user['username'] . '/') ?>
                    <?php if(
                            (isset($user['isAnyAdmin']) && $user['isAnyAdmin']) ||
                            $this->request->params['controller'] == 'admin'
                          ){ ?>
                    <div id='toolbar-activity'> <?php echo $this->Html->link('Activity',
                            '/admintools/activity') ?></div>
                    <div id='toolbar-metadataedits'> <?php echo $this->Html->link('Metadata',
                            '/admintools/metadata_edits') ?></div>
                    <div id='toolbar-flags'> <?php echo $this->Html->link('Flags',
                            '/admintools/flags') ?></div>
                    <div id='toolbar-users'> <?php echo $this->Html->link('Users',
                            '/admintools/users') ?></div>
                    <?php } ?>
					<div id='signOut'> <?php echo $this->Html->link('Sign Out',
						'/logout') ?></div>
				</div>
			</div>

		<?php else: ?>

			<a id='menu' class="btn btn-grey toolbar-btn<?php echo $profileBlue ?>"
				href="#loginModal">Login / Register</a>

		<?php endif ?>
	</div>
  <?php if (isset($index_toolbar) && $index_toolbar) :?>
    <div class="search-bar">
       <label for="searchBar" class="hiddenWAVEcont"> searchbar </label>
      <input data-project-kid="all" type="text" id="searchBar" class="search-bar indexSearchBox search-bar-js" placeholder="Search">
      <div class="indexSearchIcon"></div>
    </div>
  <?php endif ?>

	<?php echo $this->Html->script('searchBox.js');?>

	<?php if (!isset($index_toolbar) || !$index_toolbar) :?>
	<!--Display regular buttons for other pages-->


	<div class="btn-group toolbar-btn">
		 <div id= "projects" class="btn btn-grey">
			 <div id='projCage'>
                 <i class="icon-white icon-folder-open"></i>
                 <div id="toolbarHead" >
                     <?php
                     $showProjectPages = Array('single_project', 'index', 'display', 'viewtype', 'search');
                     $currentProject = '';

                     // check if this page should display the project name in the dropdown
                     if (isset($this->request->params['action']) && $this->request->params['pass']) {
                         $action = $this->request->params['action'];
                         $currentProject = '';
                         if (in_array(strtolower($action), $showProjectPages)){
                            foreach ($this->request->params['pass'] as $p) {
                                if (array_key_exists($p, $GLOBALS['PID_ARRAY'])) {
                                    $currentProject = $p;
                                }
                            }
                         } else if (strtolower($action) == 'multi_viewer'){
							 $pass = $this->request->params['pass'][0];
							 // multi resource viewer
							 if (is_numeric($pass)) {
								 $kids = $_SESSION['multi_viewer_resources'][$pass];
//								 print_r($kids);
								 $firstKid = $kids[0];
								 $currentProject = AppController::convertKIDtoProjectName($firstKid);

								 // check if all of the kids are the same project
								 foreach ($kids as $kid) {
									 if ($kid == $firstKid) {
										 continue;
									 }
									 $kidProject = AppController::convertKIDtoProjectName($kid);
									 if ($kidProject != $currentProject) {
										 $currentProject = '';
										 break;
									 }
								 }
							 }
                         } else if (strtolower($action) == 'viewcollection'){
							 $currentProject = $projectName;
                         } else if (isset($this->request->params['controller']) && $this->request->params['controller'] == 'admin') {
                             if (isset($this->request->params['pass']) && isset($this->request->params['pass'][0])) {
                                 $currentProject = $this->request->params['pass'][0];
                             }
                         }

                     }

                     if ($currentProject != ''){
                            echo strtoupper(str_replace('_', ' ', $currentProject));
                     } else {
                         echo "Projects";
                     }

                     ?>
                        <div id="dropArrow" class='pointerDown pointerTool'></div>
                 </div>
			 </div>
			<div id="projectsMenu" class="projects-menu">
			    <?php foreach($projects as $p): ?>
				<a href="<?php echo $this->Html->url('/projects/single_project/' . strtolower(str_replace(' ', '_', $p['Persistent_Name'])) )?>"><?php echo $p['Persistent_Name'] ?></a>
			    <?php endforeach ?>

				<?php if(
					(isset($user['isAnyAdmin']) && $user['isAnyAdmin']) ||
					$this->request->params['controller'] == 'admin'
				){ ?>
					<a href="<?php echo $this->Html->url('/add_project/')?>">Add a project</a>
				<?php } ?>

			</div>
		</div>
		<div id= 'belowProjects'>
		    <?php
		        if( ($this->request->params['action'] == 'search' &&
                       $this->request->params['action'] == 'search' &&
                       isset($this->request->params['pass'][0]) &&
                       $this->request->params['pass'][0] == 'all') ||
						(isset($this->request->params['pass'][0]) &&
						 $this->request->params['pass'][0] == 'index')  )
                {
                    $param1 = '';
                    if( isset($this->request->params['pass'][1]) ){
                        $param1 = $this->request->params['pass'][1];
                    }
            ?>
                    <a id="search" class="btn btn-grey"
                        href="<?php echo $this->Html->url('/search').'/all/'.$param1 ?>">
                        <i class="icon-white icon-search"></i> Search
                    </a>

            <?php }elseif(   //skip links if in profile or all project search
                        $this->request->params['controller'] != 'user' &&
                        $this->request->params['action'] != 'profile' &&
                        $this->request->params['controller'] != 'admin'
                   ){
					$resourceBlue = '';
					if( //is multi-resource, so make the link blue
						($this->request->params['controller'] == 'resources' &&
						$this->request->params['action'] == 'multi_viewer') ||
						($this->request->params['controller'] == 'orphans' &&
							$this->request->params['action'] == 'display')
					){
						$resourceBlue = ' btn-blue';
						$pKid = '/temp';
					}else{ //everything else
						// echo "im hererererere";
						// print_r($this->request->params);die;
						if( isset($this->request->params['pass'][0]) ){
	                    	$pKid = $this->request->params['pass'][0];
	                    }else {
	                    	$pKid = '';
	                    }

						if( $pKid === 'resources' ){
							$pKid = $this->request->params['pass'][1];
						}
						$pKid = '/'. $pKid;
					}
            ?>
			 <a id="resources" class="btn btn-grey<?php echo $resourceBlue ?>"
				href="<?php if (($this->request->params['controller'] == 'resources' &&
						$this->request->params['action'] == 'viewcollection')) {
                            echo $this->Html->url('/resources')."/".$projectName;
                        }
                        else {
                            echo $this->Html->url('/resources').$pKid;
                        } ?>">
				<i class="icon-white icon-folder-open"></i> Resources

			</a>
			<a id="collections" class="btn btn-grey"
				href="<?php
                        if (($this->request->params['controller'] == 'resources' &&
						$this->request->params['action'] == 'viewcollection')) {
                            echo $this->Html->url('/collections')."/".$projectName;
                        }
                        else {
                            echo $this->Html->url('/collections').$pKid;
                        } ?>">
				<i class="icon-white icon-folder-open"></i> Collections
			</a>
			<a id="search" class="btn btn-grey"
				href="
                    <?php
                        if (($this->request->params['controller'] == 'resources' &&
						$this->request->params['action'] == 'viewcollection')) {
                            echo $this->Html->url('/search')."/".$projectName;
                        }
                        else {
                            echo $this->Html->url('/search').$pKid;
                        }
                    ?>
                ">
				<i class="icon-white icon-search"></i> Search
			</a>

			<?php } ?>

			<a id="help" class="btn btn-grey<?php echo $helpBlue ?>"
               href="<?php echo ARCS_WIKI_URL;?>" target="_blank">
				<i class="icon-white icon-book"></i> Help
			</a>


        </div>
         <?php echo $this->Html->script('toolbarAssist.js');?>
	</div>
	<?php else: ?>
	<!--Display three buttons for index page with search bar-->
	<div class="btn-group toolbar-btn">
		<a id="about" class="btn btn-grey"
			href="<?php echo ARCS_PROMO_URL; ?>" target="_blank">
			<i class="icon-white icon-folder-open"></i> About ARCS
		</a>

		 <!-- Arrow won't work-->

		 <div id="projectsHeader" class="btn btn-grey">
			<div id='projCageHome'>
			 <i class="icon-white icon-folder-open"></i>
			 <div id="toolbarHead" >

                <?php

                $showProjectPages = Array('single_project', 'index', 'display', 'viewtype', 'search');
                $currentProject = '';

                // check if this page should display the project name in the dropdown
                if (isset($this->request->params['action']) && $this->request->params['pass']) {
                    $action = $this->request->params['action'];
                    $currentProject = '';
                    if (in_array(strtolower($action), $showProjectPages)){
                        foreach ($this->request->params['pass'] as $p) {
                            if (array_key_exists($p, $GLOBALS['PID_ARRAY'])) {
                                $currentProject = $p;
                            }
                        }
                    } else if (strtolower($action) == 'multi_viewer'){
                        // check if all of the kids are part of the same project
//                             $kids = end($_SESSION['multi_viewer_resources']);
////                             print_r($kids);
//                             $firstKid = $kids[0];
//                             $currentProject = AppController::convertKIDtoProjectName($firstKid);
//
//                             foreach ($kids as $kid) {
//                                 if ($kid == $firstKid) {
//                                     continue;
//                                 }
//                                 $kidProject = AppController::convertKIDtoProjectName($kid);
//                                 if ($kidProject != $currentProject) {
//                                     $currentProject = '';
//                                     break;
//                                 }
//                             }
                    } else if (strtolower($action) == 'viewcollection'){
                        // todo make this work for individual collections?
                    } else if (isset($this->request->params['controller']) && $this->request->params['controller'] == 'admin') {
                        if (isset($this->request->params['pass']) && isset($this->request->params['pass'][0])) {
                            $currentProject = $this->request->params['pass'][0];
                        }
                    }

                }

                //                     if (isset($this->request->params['action']) && $this->request->params['action'] == 'single_project'){
                if ($currentProject != ''){
//                            echo strtoupper(str_replace('_', ' ', $this->request->params['pass'][0]));
                    echo strtoupper(str_replace('_', ' ', $currentProject));
                } else {
                    echo "Projects";
                }

                ?>
				 	<div id="dropArrow" class='pointerDown pointerTool'>

				    </div>

				 </div>

			 </div>
			<div id="projectsMenu" class="projects-menu homeProject">
				<?php foreach($projects as $p): ?>

<!--                jakebaum-->
                <?php if(array_key_exists('Persistent_Name', $p)){ ?>
                	<a href="<?php echo $this->Html->url('/projects/single_project/' . strtolower(str_replace(' ', '_', $p['Persistent_Name'])) )?>">
						<?php echo $p['Persistent_Name'] ?>
					</a>
                <?php } ?>
                <?php endforeach ?>

				<?php if(
					(isset($user['isAnyAdmin']) && $user['isAnyAdmin']) ||
					$this->request->params['controller'] == 'admin'
				){ ?>
					<a href="<?php echo $this->Html->url('/add_project/')?>">Add a project</a>
				<?php } ?>

			</div>
		</div>
		<div id='helpSearch'>
		<a id="help" class="btn btn-grey<?php echo $helpBlue ?>"
			href="<?php echo ARCS_WIKI_URL;?>" target="_blank">
			<i class="icon-white icon-book"></i> Help
		</a>

		<a id="searchHeader" class="btn btn-grey" href="<?php echo $this->Html->url('/search').'/all/'?>">
				<i class="icon-white icon-search"></i> Search
			</a>

		</div>
		</div>

	<?php endif ?>

  <?php
    endif // The endif for $nobutton settings
  ?>
</div>
  <?= $this->element("Login/login");?>
  <?= $this->element("Login/register");?>

<!---->
<!--<script>-->
<!--    $(document).ready(function() {-->
<!--        console.log(PID_ARRAY);-->
<!--    })-->
<!--</script>-->
