<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>ARCS</title>
        <meta name="description" content="An interactive getting started guide for Brackets.">
        <script type="text/javascript">globalproject = "<?=$pName?>"</script>
        <script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
    </head>
    <body>
		<div class="intro">
           <h1><?php echo $name; ?></h1>
           <br>
           <p class="intro_text"><?php echo $description; ?> <br><!--br> <a href=<?php echo $locationID ?>>Location Identifier</a--></p>
            
		</div>


        <div class="greybg">
			<div class="projectIntro">
		        <h1 class="title">Recently Added Resources</h1>
		    </div>
 
		<div class="pic-display">
			<ul class="recent-resource">
			    <?php foreach($resources as $r): ?>
                    <li class="resource-pic" data-kid="<?php echo $r['kid']?>" data-resource-kid="<?php echo $r['kid']?>">
                    <div>
                      <span style="cursor:pointer">
                      <a style='position:relative;'<?php
                        if(!isset($r['Locked'])){ //not locked
                            echo 'href="'.$this->Html->url('/resource/').$r['kid'].'">';
                        }else{ //locked
                            echo '><div class="resourceLockedDarkBackgroundSP" style="height:150px;"></div>';
                            echo '<img src="/'.BASE_URL.'img/Locked.svg" class="resourceLocked">';
                        }?>

                      <img class="resource_imginfo_1" src="<?php echo $r['thumb'] ?>">

                      </a>
                      </span>
                      </div>
                      <br>
                      <h class="resource-title"><?php echo $r['Title'] ?></h><br>
                      <p class="resource-type"><?php echo $r['Type'] ?></p>
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
			            echo $url.'/resources/'.$pName;
			      ?>">EXPLORE MORE RESOURCES</a>
            </div></span>
		</div>
		<div class="proper-width" id="show-min">
			<div class="more-info"><span style="cursor:pointer"><a>EXPLORE MORE RESOURCES</a></div></span>
		</div>
		</div>



        <div class="collection-list-wrapper">

            <h1 class="title">Recent Collections</h1>
			<p class="login_msg">You're viewing publicly available collections.
			You'll need to <a href=#loginModal>log in</a> to see the rest.
			</p>
			<div class="collection-list" id="all-collections">

				<div class="back-color">
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
  						  <!--<img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">  -->
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
					  <!--<img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">  -->
						  </a>
						  </span><br>
						  <h class="resource-title">Resource Title</h><br>
						  <p class="resource-type">Resource Type</p>
						</li>
					   <li class="resource-thumb">
						  <span style="cursor:pointer">
						  <a>
						  <!--<img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">  -->
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
					</ul>
				</div>




				<div class="proper-width" id="show-min">
					<div class="more-info">
						<span style="cursor:pointer"><a>EXPLORE MORE COLLECTIONS</a></span>
					</div>
				</div>
			</div>

			<div class="more-info">
				<span style="cursor:pointer"><a href="<?php
			            //grab the current url, take off the end and add resources.
			            $url=explode('/', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			            array_pop($url);
			            array_pop($url);
			            array_pop($url);
			            $url=implode('/', $url);
			            echo $url.'/collections/'.$pName;
			      ?>">EXPLORE MORE COLLECTIONS</a></span>
			</div>

        </div>

        <div class="greybg">
            <div class = "projectIntro">
                <h1 class="title">Project User Profiles</h1>
            </div>
            <br>
                <?php
                    //echo json_encode($projectUsers);
                    $html4 = '<div id="searchBox"><form class="uploadForm single-project-chosen-choices" id="urlform" method="post" enctype="multipart/form-data" style="visibility:hidden;">
	                            <fieldset class="users-fieldset">
                                <select id ="urlAuthor"
                                    data-placeholder="SEARCH FOR USERS THAT ARE A PART OF THE PROJECT"
                                    multiple class="chosen-select" style="width:90%;"
                                >';
                    $index = 0;
                    forEach( $projectUsers as $username => $name ){
                        $html4 .= '<option class="data-project-profiles-index-'.$index.'"
                                    data-username="'.$username.'">'.
                                    $name.'  ('.$username.
                                    ')</option>';
                        $index++;
                    }
                    $html4 .= '</select>
                                </fieldset></form></div>';
                    echo $html4;
                ?>
                <br><br><br><br>
        </div>

        <div class = "projectIntro">
            <h1 class="title">Keyword Search</h1>
              <p>
                  Keyword searches are designed to provide an overview of the resources uploaded by one or more projects into ARCS.
                  Keyword Search conducts a search over words in six fields related to each <i>archival document</i>,
                  including its Title, Resource Identifier, Resource Type, Date Created, and Accession Number.
                  Keyword also searches fields that identify the <i>subject</i> focus of these archival documents,
                  including the Classification, Type, and Period of the artifact or structure described in the
                  archival document, and the Material, Technique and Dates of production for the artifact or structure.

                  <br/><br/>Because ARCS relies on user-generated content, search results may be incomplete.
              </p>
            </div>
            <br>
            <a name="searchJump"></a>
            <div id="searchBox">
            <div class="searchIcon"></div>
                  <input data-searchLink='true' data-project-Kid="<?=$kid?>" type="text" class="searchBoxInput search-bar-js" placeholder="SEARCH FOR ARCHAEOLOGICAL DATA">
            </div><br>
            <?php echo $this->Html->script('searchBox.js');?>
            <div class="proper-width">
            <div class="asearch">
                <span style="cursor:pointer">
                    <a href="<?php echo '/'.BASE_URL.'search/advanced/'.$pName; ?>">ADVANCED SEARCH</a>
                </span></div>
            </div>
            <div class="proper-width" id="show-min">
            <div class="more-info">
            <span style="cursor:pointer"><a>GO TO ADVANCED SEARCH</a></span></div>
        </div>
        <br><br>
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

$(document).ready(function(){

    //take care of the user profile chosen select
    $(".chosen-select").chosen().unbind()

    //handle chosen choices
    $('.chosen-results').on('click', 'li', function(){
        $('.search-choice').remove();
        var index = $(this).data('option-array-index');
        var username = $('.data-project-profiles-index-'+index).data('username');
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        baseUrl += '/arcs/user/'+username;

        $('.result-selected').addClass('active-result').removeClass('result-selected');
        $(".chosen-select").val('').trigger("liszt:updated");
        $(".chosen-select").trigger("chosen:updated");

        window.location = baseUrl;
    });
    //handle where chosen choices breaks.
    $('#urlAuthor option').click(function(e){
        var username = $(this).data('username');
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        baseUrl += '/arcs/user/'+username;
        window.location = baseUrl;
    });
    $('.chosen-choices').prepend('<div class="searchIcon"></div>');
    $('#urlform').css('visibility', '');}, 100);

</script>
