
<article id="pageHelpModal">
  <div>

    <p class="modal-title">Advanced Search</p>
    This Search Text has yet to be supplied. Basic Search conducts a keyword
    search over words included in the Title, Creator, Description, Subject, and
    Transcript fields of materials in the repository.
    <p>
      Basic Search works best for whole words. It is not case sensitive, so the search
      terms can be entered in upper or lower case.
    </p>
    <p>
      Multi-word Basic Searches
      Entering more than one word in the Basic Search box results in a search where
      ALL words in the query are present in ANY of the Basic Search fields. A search
      for Wesley Fishel will return records where both "Wesley" AND "Fishel" appear
      in the Title OR Creator OR Description OR Subject OR Transcript field.
    </p>
    <p>
      To speed up searches, punctuation and common short function words have been
      removed from the search. These stop words include:
    </p>
    <p>
      a, about, above, above, across, after, afterwards, again, against, all,
      almost, alone, along, already, also, although, always, am, among, amongst,
      amoungst, amount, an, and, another, any, anyhow, anyone, anything, anyway,
      anywhere, are, around, as, at, back, be, became, because, become, becomes,
      becoming, been, before, beforehand, behind, being, below, beside, besides,
      between, beyond, bill, both, bottom, but, by, call, can, cannot, cant, co,
      con, could, couldn't, cry, de, describe, detail, do, done, down, due,
      during, each, eg, eight, either, eleven, else, elsewhere, empty, enough,
      etc, even, ever, every, everyone, everything, everywhere, except, few,
      fifteen, fifty, fill, find, fire, first, five, for, former, formerly,
      forty, found, four, from, front, full, further, get, give, go, had, has,
      hasn't, have, he, hence, her, here, hereafter, hereby, herein, hereupon, hers,
      herself, him, himself, his, how, however, hundred, ie, if, in, inc, indeed,
      interest, into, is, it, its, itself, keep, last, latter, latterly, least,
      less, ltd, made, many, may, me, meanwhile, might, mill, mine, more, moreover,
      most, mostly, move, much, must, my, myself, name, namely, neither, never, nevertheless,
      next, nine, no, nobody, none, no one, nor, not, nothing, now, nowhere, of, off, often,
      on, once, one, only, onto, or, other, others, otherwise, our, ours, ourselves, out, over,
      own, part, per, perhaps, please, put, rather, re, same, see, seem, seemed, seeming,
      seems, serious, several, she, should, show, side, since, sincere, six, sixty, so,
      some, somehow, someone, something, sometime, sometimes, somewhere, still, such,
    </p>
    <p>
      a, about, above, above, across, after, afterwards, again, against, all,
      almost, alone, along, already, also, although, always, am, among, amongst,
      amoungst, amount, an, and, another, any, anyhow, anyone, anything, anyway,
      anywhere, are, around, as, at, back, be, became, because, become, becomes,
      becoming, been, before, beforehand, behind, being, below, beside, besides,
      between, beyond, bill, both, bottom, but, by, call, can, cannot, cant, co,
      con, could, couldn't, cry, de, describe, detail, do, done, down, due,
      during, each, eg, eight, either, eleven, else, elsewhere, empty, enough,
      etc, even, ever, every, everyone, everything, everywhere, except, few,
      fifteen, fifty, fill, find, fire, first, five, for, former, formerly,
      forty, found, four, from, front, full, further, get, give, go, had, has,
      hasn't, have, he, hence, her, here, hereafter, hereby, herein, hereupon, hers,
      herself, him, himself, his, how, however, hundred, ie, if, in, inc, indeed,
      interest, into, is, it, its, itself, keep, last, latter, latterly, least,
      less, ltd, made, many, may, me, meanwhile, might, mill, mine, more, moreover,
      most, mostly, move, much, must, my, myself, name, namely, neither, never, nevertheless,
      next, nine, no, nobody, none, no one, nor, not, nothing, now, nowhere, of, off, often,
      on, once, one, only, onto, or, other, others, otherwise, our, ours, ourselves, out, over,
      own, part, per, perhaps, please, put, rather, re, same, see, seem, seemed, seeming,
      seems, serious, several, she, should, show, side, since, sincere, six, sixty, so,
      some, somehow, someone, something, sometime, sometimes, somewhere, still, such,
    </p>
  </div>
</article>

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
          <option value="default">Select Type</option>
          <?php $this->Search->printControlList($seasonTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Director(s)</p>
        <select name="director">
          <option value="default">Select Director(s)</option>
          <?php $this->Search->printControlList($seasonDirectorList)?>
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
          <option value="default">Select Type</option>
          <?php $this->Search->printControlList($surveyTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Supervisor(s)</p>
        <select name="supervisors">
          <option value="default">Select Supervisor(s)</option>
          <?php $this->Search->printControlList($surveySupervisorList)?>
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
          <option value="default">Select Type</option>
          <?php $this->Search->printControlList($resourceTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Title</p>
        <input type="text" name="title" placeholder="Enter Title">
      </div>

      <div class="section-search-box">
        <p>Creator(s)</p>
        <select name="creators">
          <option value="default">Select Creator(s)</option>
          <?php $this->Search->printControlList($resourceCreatorList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Creator Role</p>
        <select name="role">
          <option value="default">Select Creator Role</option>
          <?php $this->Search->printControlList($resourceCreatorRoleList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Earilest Date</p>
        <div class="date-select" data-name="earliest_date">
          <select name="year">
            <option value="default">Select Year</option>
            <?php $this->Search->printYearOptions($min,$max,$step); ?>
          </select>
          <select name="month">
            <option value="default">Select Month</option>
            <?php $this->Search->printMonthOptions() ?>
          </select>
          <select name="day">
            <option value="default">Select Day</option>
            <?php $this->Search->printDayOptions() ?>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <p>Latest Date</p>
        <div class="date-select" data-name="latest_date">
          <select name="year">
            <option value="default">Select Year</option>
            <?php $this->Search->printYearOptions($min,$max,$step); ?>
          </select>
          <select name="month">
            <option value="default">Select Month</option>
            <?php $this->Search->printMonthOptions() ?>
          </select>
          <select name="day">
            <option value="default">Select Day</option>
            <?php $this->Search->printDayOptions() ?>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <p>Select Language(s)</p>
        <select name="languages">
          <option value="default">Select Language(s)</option>
          <?php $this->Search->printControlList($resourceLanguageList)?>
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
        <div class="date-select" data-name="scan_date">
          <select name="year">
            <option value="default">Select Year</option>
            <?php $this->Search->printYearOptions(2000, $max, $step); ?>
          </select>
          <select name="month">
            <option value="default">Select Month</option>
            <?php $this->Search->printMonthOptions() ?>
          </select>
          <select name="day">
            <option value="default">Select Day</option>
            <?php $this->Search->printDayOptions() ?>
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
          <option value="default">Select Classification</option>
          <?php $this->Search->printControlList($subjectGClassificationList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Type(s)</p>
        <select name="type">
          <option value="default">Select Type(s)</option>
          <?php $this->Search->printControlList($subjectGTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Material(s)</p>
        <select name="materials">
          <option value="default">Select Material(s)</option>
          <?php $this->Search->printControlList($subjectGMaterialList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Technique(s)</p>
        <select name="techniques">
          <option value="default">Select Technique(s)</option>
          <?php $this->Search->printControlList($subjectGTechniqueList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Period</p>
        <select name="period">
          <option value="default">Select Period</option>
          <?php $this->Search->printControlList($subjectGPeriodList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Terminus Ante Quem</p>
        <div class="double-select" data-name="terminus_ante_quem">
          <input type="text" name="title" placeholder="Enter Date">
          <select name="period">
            <option value="default">Select Period</option>
            <option value="BCE">BC</option>
            <option value="CE">AC</option>
            <option value="BP">BP</option>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <p>Terminus Post Quem</p>
        <div class="double-select" data-name="terminus_post_quem">
          <input type="text" name="title" placeholder="Enter Date">
          <select name="period">
            <option value="default">Select Period</option>
            <option value="BCE">BC</option>
            <option value="CE">AC</option>
            <option value="BP">BP</option>
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
          <option value="default">Select Location</option>
          <?php $this->Search->printControlList($subjectDLocationList)?>
        </select>
      </div>

      <div class="section-search-box">
        <p>Excavation Unit(s)</p>
        <select name="excavation_units">
          <option value="default">Excavation Unit(s)</option>
          <?php $this->Search->printControlList($subjectDUnitTypeList)?>
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
<a id="removeModal" href="#"></a>
<!---TODO move to js file-->
<script type="text/javascript">
(function(){


  var AdvancedSearch = AdvancedSearch || {}
  AdvancedSearch.months = [
    "January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"
  ];
  AdvancedSearch.display = {

    getQuery : function (inputs, selects, dates, eras) {
      var query = "";
      inputs.each(function() {
        var parentClass = $(this).parent().attr("class")
        if ( parentClass !== "date-select" && parentClass !== "double-select") {
            var val = $(this).val()
            var placeholder = $(this).attr("placeholder")
            var prefix = $(this).parent().parent().data("prefix")
            var name = $(this).attr("name")
            if (val.length && val != placeholder) {
                query += prefix + name + "=" + val + "&"
            }
        }
      })
      selects.each(function() {
        var parentClass = $(this).parent().attr("class")
        if ( parentClass !== "date-select" && parentClass !== "double-select") {
          var val = $(this).val()
          var prefix = $(this).parent().parent().data("prefix");
          var name = $(this).attr("name")
          if (val != "default" && val.length) {
            query += prefix + name + "=" + val + "&"
          }
        }
      })

      dates.each(function() {
        var comps = $(this)
        var prefix = $(this).parent().parent().data("prefix");
        var name = $(this).data("name");
        var year = comps.find("select[name='year']")
        var month = comps.find("select[name='month']")
        var day = comps.find("select[name='day']")


        year  = parseInt(year.val())  || "00";
        day   = parseInt(day.val())   || "00";
        month = parseInt(AdvancedSearch.months.indexOf(month.val()))+1;
        if (month === 0)
          month = "00"

        var val = year + "-" + month + "-" + day

        if (val !== "00-00-00")
          query += prefix + name + "=" + val + "&"

      })
      eras.each(function() {
          var elem = $(this)
          var date = elem.find("input")
          var era  = elem.find("select")
          var prefix = elem.parent().parent().data("prefix");
          var name = elem.data("name")
          if (
              date.length && era.length && 
              date.attr("placeholder") !== date.val() && 
              era.val() !== "default"
             )
          {
             var year = parseInt(date.val()) || false
             if (era.val() === "BP" && year){
                 query += prefix + name + "=" + (year + 1950) + "-00-00" + "&"    
             }
             else if (year) {
                 query += prefix + name + "=" + year + "-00-00-" + era.val() + "&"    
             }
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
      var dateSelects = sections.find(".date-select")
      var doubleSelects = sections.find(".double-select")

      var query = AdvancedSearch.display.getQuery(inputs, selects, dateSelects, doubleSelects)
      AdvancedSearch.display.search(baseURL, query, project)

    })

    $("#backToSearch").find("a").click(function() {
      window.location.href =
      window.location.origin + arcs.baseURL + "search/" + project
    })

    $("#pageHelpModal").click(function(e) {
      if (e.target.nodeName === "ARTICLE") {
        $("#removeModal")[0].click()
      }
    })

  })
})()
</script>
