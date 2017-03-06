<style media="screen">
  .advanced-search-container {
    width: 70%;
    margin: auto;
  }
  #backToSearch {
    font-size: 12px;
    color: #0094BC;
    margin-bottom: 16px;
  }
  #search-box{
    margin-bottom: 140px;
  }
  #page-title {
    color: #3F3F3F;
    font-size: 24px;
  }
  #page-description {
    color: #686868;
    font-size: 12px;
    line-height: 24px;
    margin-top: 16px;
  }
  #page-help{
    font-family: Montserrat;
    font-size: 14px;
    text-align: center;
    color: #686868;
    width: 25px;
    height: 25px;
    background-color: #FFFFFF;
    border: 1px solid #686868;
    border-radius: 50%;
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto;
    margin-left: 18px;
    line-height: 24px;
  }
  .search-btn {
    width: 70%;
    height: 44px;
    background: #0094BC;
    border: 1px solid #0094BC;
    color: white;
    position: fixed;
    bottom: 60px;
    margin: auto;
  }
  .page-info header {
    position: relative;
  }
  .search-info {
    margin-bottom: 80px;
  }
  .search-options {
    margin-top: 48px;
  }
  .search-options header {
    color: #3F3F3F;
    font-size: 20px;
    line-height: 24px;
  }
  .search-options header p{
    margin-bottom: 22px;
  }
  .section-search-box option {

  }
  .section-search-box input, .section-search-box select {
    width: 100%;
    height: 44px;
    border: 1px solid #E2E2E2;
    background: white;
    font-size: 14px;
    padding-left: 20px;
    color: #3F3F3F;
  }
  .section-search-box {
    margin-bottom: 20px;
  }
  .section-search-box p {
    font-size: 12px;
    line-height: 14px;
    color: #3F3F3F;
  }
  .date-select {
    font-size: 0;
  }
  .date-select select{
    width: 33.33333%;
    margin-left: -1px;
  }

</style>
<main class="advanced-search-container" data-project="<?=$project?>">
  <article class="search-info">
    <section id="backToSearch">
      <a href="#">GO TO REGULAR SEARCH</a>
    </section>
    <section class="page-info">
      <header>
        <span id="page-title">Advanced Search</span>
        <a id="page-help" href="#pageHelpModal">?</a>
      </header>

      <p id="page-description">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
        veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
        commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
        vlit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
        occaecat cupidatat non proident, sunt in culpa qui officia deserunt
        mollit anim id est laborum
      </p>
    </section>
  </article>

  <article id="search-box">

    <section id="season-search" class="search-options" data-prefix="season-">

      <header>
        <p>Season Advanced Search</p>
      </header>

      <div class="section-search-box">
        <p>Title</p>
        <input type="text" name="title" placeholder="Enter Title">
      </div>

      <div class="section-search-box">
        <p>Type</p>
        <select name="type">
          <option placeholder="">Select Type</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Director(s)</p>
        <select name="director">
          <option placeholder="">Select Director(s)</option>
        </select>
      </div>

    </section>

    <section id="excavation-search" class="search-options" data-prefix="excavation-">

      <header>
        <p>Excavation - Survey Advanced Search</p>
      </header>

      <div class="section-search-box">
        <p>Name</p>
        <input type="text" name="name" placeholder="Enter Name">
      </div>

      <div class="section-search-box">
        <p>Type</p>
        <select name="type">
          <option value="">Select Type</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Supervisor(s)</p>
        <select name="supervisors">
          <option value="">Select Supervisor(s)</option>
        </select>
      </div>

    </section>

    <section id="resource-search" class="search-options" data-prefix="resource-">

      <header>
        <p>Resource Advanced Search</p>
      </header>

      <div class="section-search-box">
        <p>Resource Identifier</p>
        <input type="text" name="identifier" placeholder="Enter Resource Identifier">
      </div>

      <div class="section-search-box">
        <p>Type</p>
        <select name="type">
          <option value="">Select Type</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Title</p>
        <input type="text" name="title" placeholder="Enter Title">
      </div>

      <div class="section-search-box">
        <p>Creator(s)</p>
        <select name="creators">
          <option value="">Select Creator(s)</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Creator Role</p>
        <select name="role">
          <option value="">Select Creator Role</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Earilest Date</p>
        <div class="date-select">
          <select name="earliest_date">
            <option value="">Select Year</option>
          </select>
          <select name="type">
            <option value="">Select Month</option>
          </select>
          <select name="type">
            <option value="">Select Day</option>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <p>Latest Date</p>
        <div class="date-select">
          <select name="latest_date--year">
            <option value="">Select Year</option>
          </select>
          <select name="latest_date--month">
            <option value="">Select Month</option>
          </select>
          <select name="latest_date--day">
            <option value="">Select Day</option>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <p>Select Language(s)</p>
        <select name="languages">
          <option value="">Select Language(s)</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Transcription</p>
        <input type="text" name="transcription" placeholder="Enter Transcription">
      </div>

    </section>

    <section id="pages-search" class="search-options" data-prefix="page-">

      <header>
        <p>Pages Advanced Search</p>
      </header>

      <div class="section-search-box">
        <p>Scan Date</p>
        <div class="date-select">
          <select name="scan_date--year">
            <option value="">Select Year</option>
          </select>
          <select name="scan_date--month">
            <option value="">Select Month</option>
          </select>
          <select name="scan_date--day">
            <option value="">Select Day</option>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <p>Scan Creator</p>
        <input type="text" name="scan_creator" placeholder="Enter Scan Creator">
      </div>

    </section>

    <section id="subject-general-search" class="search-options" data-prefix="subject-general-">

      <header>
        <p>Subject of Observation General Advanced Search</p>
      </header>

      <div class="section-search-box">
        <p>Classification</p>
        <select name="classification">
          <option value="">Select Classification</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Type(s)</p>
        <select name="type">
          <option value="">Select Type(s)</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Material(s)</p>
        <select name="materials">
          <option value="">Select Material(s)</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Technique(s)</p>
        <select name="techniques">
          <option value="">Select Technique(s)</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Period</p>
        <select name="period">
          <option value="">Select Period</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Terminus Ante Quem</p>
        <div class="date-select">
          <select name="terminus_ante_quem--year">
            <option value="">Select Year</option>
          </select>
          <select name="terminus_ante_quem--month">
            <option value="">Select Month</option>
          </select>
          <select name="terminus_ante_quem--day">
            <option value="">Select Day</option>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <p>Terminus Post Quem</p>
        <div class="date-select">
          <select name="terminus_post_quem--year">
            <option value="">Select Year</option>
          </select>
          <select name="terminus_post_quem--month">
            <option value="">Select Month</option>
          </select>
          <select name="terminus_post_quem--day">
            <option value="">Select Day</option>
          </select>
        </div>
      </div>


    </section>

    <section id="subject-detailed-search" class="search-options" data-prefix="subject-detailed-">

      <header>
        <p>Subject of Observation Detailed Advanced Search</p>
      </header>

      <div class="section-search-box">
        <p>Location</p>
        <select name="location">
          <option value="">Select Location</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Excavation Unit(s)</p>
        <select name="excavation_units">
          <option value="">Excavation Unit(s)</option>
        </select>
      </div>

      <div class="section-search-box">
        <p>Inscription</p>
        <input type="text" name="inscription" placeholder="Enter Inscription">
      </div>

    </section>
  </article>

  <button class="search-btn" type="button" name="button">Search</button>
</main>
<form class="searchRedirect" method="POST">

</form>
<!---TODO move to js file-->
<script type="text/javascript">
(function(){
  var AdvancedSearch = AdvancedSearch || {}
  AdvancedSearch.display = {

    getQuery : function (inputs, selects) {
      var query = "";
      inputs.each(function() {
        var val = $(this).val()
        var placeholder = $(this).attr("placeholder")
        var prefix = $(this).parent().parent().data("prefix")
        var name = $(this).attr("name")
        if (val.length && val != placeholder) {
            query += prefix + name + "=" + val + "&"
        }
      })
      return query;
    },
    search : function (baseURL, query, project) {
      window.location.href = baseURL + "/search/advanced/view/" + project + "?" + query

    }

  }

  $(document).ready(function() {
    var baseURL = window.location.href.split("/search/")[0];
    var project = $("main").data("project")
    $(".search-btn").click(function() {

      var sections = $(".section-search-box")
      var inputs = sections.find("input")
      var selects = sections.find("select")

      var query = AdvancedSearch.display.getQuery(inputs,selects)
      AdvancedSearch.display.search(baseURL, query, project)

    })

    $("#backToSearch").find("a").click(function() {
      window.location.href =
      window.location.origin + arcs.baseURL + "search/" + project
    })

  })
})()
</script>
