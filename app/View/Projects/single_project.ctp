<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>ARCS</title>
        <meta name="description" content="An interactive getting started guide for Brackets.">

    </head>
    <body>

		<div class="intro">
           <h1><?php echo $name; ?></h1>
           <br>
           <p class="intro_text"><?php echo $description; ?></p>
		</div>


        <div class="greybg">
			<div class="projectIntro">
		        <h1 class="title">Recently Added Resources</h1>
		    </div>

		<div class="pic-display">
			<ul class="recent-resource">
			    <?php foreach($resources as $r): ?>
                <li class="resource-pic">
                  <span style="cursor:pointer">
                  <a href="<?php echo $this->Html->url('/resource/').$r['kid'] ?>">
                  <img class="resource_imginfo_1" src="<?php echo $r['thumb'] ?>">
                  </a>
                  </span>
                  <br><br>
                  <h class="resource-title"><?php echo $r['title'] ?></h><br>
                  <p class="resource-type"><?php echo $r['type'] ?></p>
                </li>
			    <?php endforeach ?>
			</ul>
		</div>
		<div class="proper-width">
			<div class="more-info"><span style="cursor:pointer">
			    <a href="<?php
			            //grab the current url, take off the end and add resources.
			            $url=explode('/', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			            array_pop($url);
			            array_pop($url);
			            array_pop($url);
			            $url=implode('/', $url);
			            echo $url.'/resources';
			      ?>">EXPLORE MORE RESOURCES</a>
            </div></span>
		</div>
		<div class="proper-width" id="show-min">
			<div class="more-info"><span style="cursor:pointer"><a>EXPLORE MORE RESOURCES</a></div></span>
		</div>
		</div>



        <div class="collection-list-wrapper">

            <h1 class="title">Recent Collections</h1>
			<p class="login_msg">You're viewing publicly available resources.
			You'll need to <a href=#loginModal>log in</a> to see the rest.
			</p>
			<div class="collection-list" id="all-collections">

				<details class="back-color">
					<summary>
						<h3>Collection Title</h3>
						<h4>Author Name</h4>
						<h5>A week ago</h5>
						<a class="view-colc">VIEW COLLECTION</a>
					</summary>
					<ul class="resource-thumbs">
						<li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <div class="view-all-icon"></div>
						  </a>
						  </span><br>
						  <h class="view-title">VIEW COLLECTION</h><br>
						  <br>
						</li>
						<div class="proper-width" id="show-min">
							<div class="more-info">
							<span style="cursor:pointer"><a>VIEW COLLECTION</a></span></div>
						</div>
					</ul>
				</details>
				<details class="back-color">
					<summary>
						<h3>Collection Title</h3>
						<h4>Author Name</h4>
						<h5>A week ago</h5>
						<a class="view-colc">VIEW COLLECTION</a>
					</summary>
					<ul class="resource-thumbs">
						<li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <div class="view-all-icon"></div>
						  </a>
						  </span><br>
						  <h class="view-title">VIEW COLLECTION</h><br>
						  <br>
						</li>
						<div class="proper-width" id="show-min">
							<div class="more-info">
							<span style="cursor:pointer"><a>VIEW COLLECTION</a></span></div>
						</div>
					</ul>
				</details>
				<details class="back-color">
					<summary>
						<h3>Collection Title</h3>
						<h4>Author Name</h4>
						<h5>A week ago</h5>
						<a class="view-colc">VIEW COLLECTION</a>
					</summary>
					<ul class="resource-thumbs">
						<li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <div class="view-all-icon"></div>
						  </a>
						  </span><br>
						  <h class="view-title">VIEW COLLECTION</h><br>
						  <br>
						</li>
						<div class="proper-width" id="show-min">
							<div class="more-info">
							<span style="cursor:pointer"><a>VIEW COLLECTION</a></span></div>
						</div>
					</ul>
				</details>
				<details class="back-color">
					<summary>
						<h3>Collection Title</h3>
						<h4>Author Name</h4>
						<h5>A week ago</h5>
						<a class="view-colc">VIEW COLLECTION</a>
					</summary>
					<ul class="resource-thumbs">
						<li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <div class="view-all-icon"></div>
						  </a>
						  </span><br>
						  <h class="view-title">VIEW COLLECTION</h><br>
						  <br>
						</li>
						<div class="proper-width" id="show-min">
							<div class="more-info">
							<span style="cursor:pointer"><a>VIEW COLLECTION</a></span></div>
						</div>
					</ul>
				</details>
				<details class="back-color">
					<summary>
						<h3>Collection Title</h3>
						<h4>Author Name</h4>
						<h5>A week ago</h5>
						<a class="view-colc">VIEW COLLECTION</a>
					</summary>
					<ul class="resource-thumbs">
						<li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <div class="view-all-icon"></div>
						  </a>
						  </span><br>
						  <h class="view-title">VIEW COLLECTION</h><br>
						  <br>
						</li>
						<div class="proper-width" id="show-min">
							<div class="more-info">
							<span style="cursor:pointer"><a>VIEW COLLECTION</a></span></div>
						</div>
					</ul>
				</details>
				<details class="back-color">
					<summary>
						<h3>Collection Title</h3>
						<h4>Author Name</h4>
						<h5>A week ago</h5>
						<a class="view-colc">VIEW COLLECTION</a>
					</summary>
					<ul class="resource-thumbs">
						<li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <div class="view-all-icon"></div>
						  </a>
						  </span><br>
						  <h class="view-title">VIEW COLLECTION</h><br>
						  <br>
						</li>
						<div class="proper-width" id="show-min">
							<div class="more-info">
							<span style="cursor:pointer"><a>VIEW COLLECTION</a></span></div>
						</div>
					</ul>
				</details>
				<details class="back-color">
					<summary>
						<h3>Collection Title</h3>
						<h4>Author Name</h4>
						<h5>A week ago</h5>
						<a class="view-colc">VIEW COLLECTION</a>
					</summary>
					<ul class="resource-thumbs">
						<li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <div class="view-all-icon"></div>
						  </a>
						  </span><br>
						  <h class="view-title">VIEW COLLECTION</h><br>
						  <br>
						</li>
						<div class="proper-width" id="show-min">
							<div class="more-info">
							<span style="cursor:pointer"><a>VIEW COLLECTION</a></span></div>
						</div>
					</ul>
				</details>
				<details class="back-color">
					<summary>
						<h3>Collection Title</h3>
						<h4>Author Name</h4>
						<h5>A week ago</h5>
						<a class="view-colc">VIEW COLLECTION</a>
					</summary>
					<ul class="resource-thumbs">
						<li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <div class="view-all-icon"></div>
						  </a>
						  </span><br>
						  <h class="view-title">VIEW COLLECTION</h><br>
						  <br>
						</li>
						<div class="proper-width" id="show-min">
							<div class="more-info">
							<span style="cursor:pointer"><a>VIEW COLLECTION</a></span></div>
						</div>
					</ul>
				</details>

				<div class="more-info"><span style="cursor:pointer"><a>VIEW  ALL COLLECTIOPNS</a></span></div>
				<div class="proper-width" id="show-min">
					<div class="more-info">
					<span style="cursor:pointer"><a>VIEW ALL COLLECTION</a></span></div>
				</div>
			</div>

        </div>



        <div class="greybg">
          <div class = "projectIntro">
            <h1 class="title">Search</h1>
            <p>Vommit food and eat it again leave fur on owners clothes purr for no reason shake treat bag lounge in doorway or make meme, make cute face. Run in circles if it fits, i sits but peer out window, chatter at birds, lure them to mouth damn that dog stick butt in face leave fur on owners clothes jump off balcony, onto stranger's head.
            </p>
          </div>
		  <br>
          <a name="searchJump"></a>
          <div id="searchBox">
          	<div class="searchIcon"></div>
          	<input type="text" class="searchBoxInput" placeholder="SEARCH FOR ARCHAEOLOGICAL DATA">
          </div><br>
          <?php echo $this->Html->script('searchBox.js');?>
         <div class="proper-width">
			<div class="asearch">
			    <span style="cursor:pointer">
			        <?php echo $this->Html->link(
			            'ADVANCED SEARCH',
			            ['controller' => 'AdvancedSearch', 'action' => 'advance_search']);
			        ?>
			    </span></div>
		</div>
		<div class="proper-width" id="show-min">
			<div class="more-info">
			<span style="cursor:pointer"><a>GO TO ADVANCED SEARCH</a></span></div>
		</div>
		<br><br>
		</div>
    </body>
</html>

<script>
if( $('#menu').html() != 'Login / Register' ){  //remove the login message if logged in
    $('.login_msg').remove();
}
arcs.user_viewer = new arcs.views.SingleProject({
  model: arcs.models.Collection,
  collection: new arcs.collections.CollectionList(<?php echo json_encode($collections); ?>),
  el: $('#all-collections')
});
arcs.user_viewer.render();
</script>
