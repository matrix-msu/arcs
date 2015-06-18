<!-- Search bar removed because of correspondence to design comps
 -->
 <!-- <div class="search-home search-wrapper"></div>
 -->
<div class="accordion-wrapper">
  <h1>Resources</h1>
  <br>

  {% if not user.loggedIn %}
  <div style="font-weight:200">
    <i class="icon-info-sign"></i>
    You're viewing publicly available resources.
    You'll need to {{ html.link('login', '#loginModal') }} to see the rest.
  </div>
  {% endif %}

  <details class="unselectable" open="open" data-type="Notebook">
    <summary class="large"><span class="summaryTitle">Notebooks <?php echo $user['id']; ?></span></summary>
    <div></div>
  </details>

  <details class="unselectable" data-type="Notebook Page">
    <summary class="large"><span class="summaryTitle">Notebooks Pages</span></summary>
    <div></div>
  </details>

  <details class="unselectable" data-type="Photograph">
    <summary class="large"><span class="summaryTitle">Photographs</span></summary>
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

  <details class="unselectable" data-type="Map">
    <summary class="large"><span class="summaryTitle">Maps</span></summary>
    <div></div>
  </details>

  <details class="unselectable" data-type="Inventory Card">
    <summary class="large"><span class="summaryTitle">Inventory Cards</span></summary>
    <div></div>
  </details>

</div>

<script>arcs.homeView = new arcs.views.Home({el: $('.page')});</script>
