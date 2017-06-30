<div class="collection-list-wrapper">
    <h1 class="rsc-title">Resources</h1>
    {% if not user.loggedIn %}
    <p class="login_msg">Some resources require you to
        <a href=#loginModal>log in</a>, or have specific permissions to view.
    </p>
    {% endif %}

    <div class="collection-list" id="all-collections">
        <details class="back-color"  data-type="Field Journal" >
            <summary class="rsc-sum">
                <p class="rsc-name">NOTEBOOKS</p>
            </summary>
            <div></div>
        </details>

        <details class="back-color" data-type="Photograph">
            <summary class="rsc-sum">
                <p class="rsc-name">PHOTOGRAPHS</p>
            </summary>
            <div></div>
        </details>

        <details class="back-color" data-type="Photographic Negative">
            <summary class="rsc-sum">
                <p class="rsc-name">PHOTOGRAPHIC NEGATIVE</p>
            </summary>
            <div></div>
        </details>

        <details class="back-color" data-type="Report">
            <summary class="rsc-sum">
                <p class="rsc-name">REPORTS</p>
            </summary>
            <div></div>
        </details>

        <details class="back-color" data-type="Drawing">
            <summary class="rsc-sum">
                <p class="rsc-name">DRAWINGS</p>
            </summary>
            <div></div>
        </details>

        <details class="back-color" data-type="Plan or Elevation">
            <summary class="rsc-sum">
                <p class="rsc-name">MAPS</p>
            </summary>
            <div></div>
        </details>

        <details class="back-color" data-type="Inventory Card">
            <summary class="rsc-sum">
                <p class="rsc-name">INVENTORY CARDS</p>
            </summary>
            <div></div>
        </details>

        <details class="back-color" data-type="Orphaned">
            <summary class="rsc-sum">
                <p class="rsc-name">ORPHANED (Digitized Resources Without Metadata)</p>
            </summary>
            <div></div>
        </details>
    </div>
    <script>arcs.homeView = new arcs.views.Home({el: $('.page')});</script>
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
        <input data-searchlink="true" type="text" class="searchBoxInput" placeholder="SEARCH FOR ARCHAEOLOGICAL DATA">
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
<script>
</script>
