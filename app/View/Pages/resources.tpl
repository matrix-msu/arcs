<!-- Search bar removed because of correspondence to design comps
 -->
 <!-- <div class="search-home search-wrapper"></div>
 -->
<!-- <div class="accordion-wrapper">
  <h1>Resources</h1>
  <br>

  {% if not user.loggedIn %}
  <div style="font-weight:200">
    <i class="icon-info-sign"></i>
    You're viewing publicly available resources.
    You'll need to {{ html.link('login', '#loginModal') }} to see the rest.
  </div>
  {% endif %}

  <details class="unselectable" open="open" data-type="Field Journal" >
    <summary class="large"><span class="summaryTitle">Notebooktest<?php echo $user['id']; ?></span></summary>
    <div></div>
  </details> -->
<!--
  <details class="unselectable" data-type="Notebook Page">
    <summary class="large"><span class="summaryTitle">Notebooks Pages</span></summary>
    <div></div>
  </details>
-->
<!--   <details class="unselectable" data-type="Photograph">
    <summary class="large"><span class="summaryTitle">Photographs</span></summary>
    <div></div>
  </details>
  
  <details class="unselectable" data-type="Photographic Negative">
    <summary class="large"><span class="summaryTitle">Photographic Negative</span></summary>
    <div></div>
  </details>

  <details class="unselectable" data-type="Report">
    <summary class="large"><span class="summaryTitle">Reports</span></summary>
    <div></div>
  </details>

  <details class="unselectable" data-type="Drawing">
    <summary class="large"><span class="summaryTitle">Drawings</span></summary>
    <div></div>
  </details>

  <details class="unselectable" data-type="Plan or Elevation">
    <summary class="large"><span class="summaryTitle">Maps</span></summary>
    <div></div>
  </details>

  <details class="unselectable" data-type="Inventory Card">
    <summary class="large"><span class="summaryTitle">Inventory Cards</span></summary>
    <div></div>
  </details>

</div>

<script>arcs.homeView = new arcs.views.Home({el: $('.page')});</script> -->



<div class="collection-list-wrapper">
  <h1 class="rsc-title">Publicly Avaliable Resources</h1>
  <p class="login_msg">You're viewing publicly available resources. 
  You'll need to <a href=#loginModal>log in</a> to see the rest.
  </p>
  <div class="collection-list" id="all-collections">
    
    <details class="back-color">
      <summary class="rsc-sum">
        <p class="rsc-name">NOTEBOOKS</p>
      </summary>
      <ul class="resource-thumbs">
        <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="lock-img-container">
            <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
            <div class="lock-icon"><img class="lock-icon-img"></div>
          </div>
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="view-all-icon"></div>
          </a>
          </span><br>
          <h class="rsc-text">SHOW ALL</h><br>
        
        </li>
       
      </ul>
    </details>
    <details class="back-color">
      <summary class="rsc-sum">
        <p class="rsc-name">NOTEBOOK PAGES</p>
      </summary>
      <ul class="resource-thumbs">
        <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="lock-img-container">
            <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
            <div class="lock-icon"><img class="lock-icon-img"></div>
          </div>
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="view-all-icon"></div>
          </a>
          </span><br>
          <h class="rsc-text">SHOW ALL</h><br>
        
        </li>
         
      </ul>
    </details>
    <details class="back-color">
      <summary class="rsc-sum">
        <p class="rsc-name">PHOTOGRAPHS</p>
      </summary>
      <ul class="resource-thumbs">
        <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="lock-img-container">
            <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
            <div class="lock-icon"><img class="lock-icon-img"></div>
          </div>
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="view-all-icon"></div>
          </a>
          </span><br>
          <h class="rsc-text">SHOW ALL</h><br>
        
        </li>
         
      </ul>
    </details>
    <details class="back-color">
      <summary class="rsc-sum">
        <p class="rsc-name">REPORTS</p>
      </summary>
      <ul class="resource-thumbs">
        <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="lock-img-container">
            <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
            <div class="lock-icon"><img class="lock-icon-img"></div>
          </div>
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="view-all-icon"></div>
          </a>
          </span><br>
          <h class="rsc-text">SHOW ALL</h><br>
        
        </li>
         
      </ul>
    </details>
    <details class="back-color">
      <summary class="rsc-sum">
        <p class="rsc-name">DRAWINGS</p>
      </summary>
      <ul class="resource-thumbs">
        <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="lock-img-container">
            <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
            <div class="lock-icon"><img class="lock-icon-img"></div>
          </div>
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="view-all-icon"></div>
          </a>
          </span><br>
          <h class="rsc-text">SHOW ALL</h><br>
        
        </li>
         
      </ul>
    </details>
    <details class="back-color">
      <summary class="rsc-sum">
        <p class="rsc-name">MAPS</p>
      </summary>
      <ul class="resource-thumbs">
        <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="lock-img-container">
            <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
            <div class="lock-icon"><img class="lock-icon-img"></div>
          </div>
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="view-all-icon"></div>
          </a>
          </span><br>
          <h class="rsc-text">SHOW ALL</h><br>
        
        </li>
         
      </ul>
    </details>
    <details class="back-color">
      <summary class="rsc-sum">
        <p class="rsc-name">INVENTORY CARDS</p>
      </summary>
      <ul class="resource-thumbs">
        <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="lock-img-container">
            <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
            <div class="lock-icon"><img class="lock-icon-img"></div>
          </div>
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="view-all-icon"></div>
          </a>
          </span><br>
          <h class="rsc-text">SHOW ALL</h><br>
        
        </li>
         
      </ul>
    </details>
    <details class="back-color">
      <summary class="rsc-sum">
        <p class="rsc-name">ORPHANED</p>
      </summary>
      <ul class="resource-thumbs">
        <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="lock-img-container">
            <img class="resource_imginfo_2" src="http://kora.matrix.msu.edu/files/123/738/7B-2E2-B-90-72-HEX-001-010.jpeg">
            <div class="lock-icon"><img class="lock-icon-img"></div>
          </div>
          </a>
          </span><br>
          <h class="rsc-text">Resource Title</h><br>
        </li>
         <li class="resource-thumb">
          <span style="cursor:pointer">
          <a>
          <div class="view-all-icon"></div>
          </a>
          </span><br>
          <h class="rsc-text">SHOW ALL</h><br>
        
        </li>
         
      </ul>
    </details> 
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
     <div class="proper-width">
  <div class="asearch"><span style="cursor:pointer"><a>ADVANCED SEARCH</a></span></div>
</div>
<div class="proper-width" id="show-min">
  <div class="more-info">
  <span style="cursor:pointer"><a>GO TO ADVANCED SEARCH</a></span></div>
</div>
<br><br>
</div>
