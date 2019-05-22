
<article id="pageHelpModal">
  <div>
    <a class="search-help-close" href="#">X</a>

    <p class="modal-title">Advanced Search</p>
      Advanced Search allows users to search for words and phrases in numerous fields. Users can build complex searches by combining terms and phrases in multiple search boxes.
        <br /><br />
      Entering more than one word in one Advanced Search box results in a search where <b><u>ALL</u></b> <i>words</i> in the query are present in the selected field.  For example, a search for Roman Lamp in the Title field will only return records where both "Roman" <b>AND</b> "lamp" appear in the Title, regardless of their presence in other fields.
      <br /><br />
      <i>Combining Advanced Searches</i><br />
      Entering a single term or phrase in more than one search box results in a search where <b><u>ALL</u></b> <i>words</i> added to the first box are present in the first field <b>AND</b> <u>ALL</u> <i>words</i> added to the second box are present in the second field. For example, a search for Roman lamp in the Resource Title field and lamp in the Artifact/Structure Type field will only return records where "Roman lamp" is in the Resource Title <b>AND</b> "lamp" is in the Artifact/Structure Type field.
      <br /><br />
      To conduct a more basic search across a limited number of data fields, try a <a href="#" id="modalBackToSearch" style="color: #44D1FF">Keyword Search</a>.
      <br /><br />
      For a more detailed description of search fields, logic and filters, consult the <a href="#" id="help" style="color: #44D1FF">help text</a>.

      </p>
  </div>
</article>

<main class="advanced-search-container" data-project="<?=$project?>">
  <article class="search-info" style="margin-bottom:40px">
    <section id="backToSearch">
      <a href="#">GO TO KEYWORD SEARCH</a>
    </section>
    <section class="page-info">
      <header>
        <span id="page-title">Advanced Search</span>
        <a id="page-help" href="#pageHelpModal">?</a>
      </header>

      <p id="page-description">
          Advanced searches are designed to locate a specific resource or isolate resources according to
          a specific type or expression in one or more fields.  You can build combined searches with terms
          and phrases in multiple search boxes.
        <br />
          Because ARCS relies on user-generated content, search results may be incomplete.
      </p>
    </section>
  </article>

  <article id="search-box">

    <section id="season-search" class="search-options" data-prefix="season-">

      <header>
        <p>Season Advanced Search</p>
      </header>

      <div class="section-search-box">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" placeholder="Enter Title">
      </div>

      <div class="section-search-box">
        <label for="type">Type</label>
        <select name="type" id="type">
          <option value="default">Select Type</option>
          <?php $this->Search->printControlList($seasonTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="director">Director(s)</label>
        <select id="director" name="director">
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
        <label for="name3">Name</label>
        <input type="text" name="name" id="name3" placeholder="Enter Name">
      </div>

      <div class="section-search-box">
        <label for="type2">Type</label>
        <select name="type" id="type2">
          <option value="default">Select Type</option>
          <?php $this->Search->printControlList($surveyTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="supervisor">Supervisor(s)</label>
        <select name="supervisors" id="supervisor">
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
        <label for="resource-id">Resource Identifier</label>
        <input type="text" id="resource-id" name="identifier" placeholder="Enter Resource Identifier">
      </div>

      <div class="section-search-box">
        <label for="type3">Type</label>
        <select name="type" id="type3">
          <option value="default">Select Type</option>
          <?php $this->Search->printControlList($resourceTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="title2">Title</label>
        <input type="text" id="title2" name="title" placeholder="Enter Title">
      </div>

      <div class="section-search-box">
        <label for="creator">Creator(s)</label>
        <select name="creators" id="creator">
          <option value="default">Select Creator(s)</option>
          <?php $this->Search->printControlList($resourceCreatorList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="creator-role">Creator Role</label>
        <select name="role" id="creator-role">
          <option value="default">Select Creator Role</option>
          <?php $this->Search->printControlList($resourceCreatorRoleList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="earliest">Earliest Date</label>
        <div class="date-select" data-name="earliest_date">
          <select name="year" id="earliest">
            <option value="default">Select Year</option>
            <?php $this->Search->printYearOptions($min,$max,$step); ?>
          </select>
          <select name="month" id="earliest">
            <option value="default">Select Month</option>
            <?php $this->Search->printMonthOptions() ?>
          </select>
          <select name="day" id="earliest">
            <option value="default">Select Day</option>
            <?php $this->Search->printDayOptions() ?>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <label for="latest">Latest Date</label>
        <div class="date-select" data-name="latest_date">
          <select name="year" id="latest">
            <option value="default">Select Year</option>
            <?php $this->Search->printYearOptions($min,$max,$step); ?>
          </select>
          <select name="month" id="latest">
            <option value="default">Select Month</option>
            <?php $this->Search->printMonthOptions() ?>
          </select>
          <select name="day" id="latest">
            <option value="default">Select Day</option>
            <?php $this->Search->printDayOptions() ?>
          </select>
        </div>
      </div>

        <div class="section-search-box">
            <label for="date-range">Date Range</label>
            <div class="date-range" data-name="date_range" style="display:flex">
                <select name="start-year" style="width:47%" id="date-range">
                    <option value="default">Select Year</option>
                    <?php $this->Search->printYearOptions($min,$max,$step); ?>
                </select>
                <div style="display:inline-block;text-align:center;width:6%">
                    <p style="font-size:17px;margin-top:14px">&rarr;</p>
                </div>
                <select name="end-year" style="float:right;width:47%" id="date-range">
                    <option value="default">Select Year</option>
                    <?php $this->Search->printYearOptions($min,$max,$step); ?>
                </select>
            </div>
        </div>

      <div class="section-search-box">
        <label for="sel-lang">Select Language(s)</label>
        <select name="languages" id="sel-lang">
          <option value="default">Select Language(s)</option>
          <?php $this->Search->printControlList($resourceLanguageList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="trans">Transcription</label>
        <input type="text" name="transcription" id="trans" placeholder="Enter Transcription">
      </div>

    </section>

    <section id="pages-search" class="search-options" data-prefix="page-">

      <header>
        <p>Pages Advanced Search</p>
      </header>

      <div class="section-search-box">
        <label for="scan-date">Scan Date</label>
        <div class="date-select" data-name="scan_date">
          <select name="year" id="scan-date">
            <option value="default">Select Year</option>
            <?php $this->Search->printYearOptions(2000, $max, $step); ?>
          </select>
          <select name="month" id="scan-date">
            <option value="default">Select Month</option>
            <?php $this->Search->printMonthOptions() ?>
          </select>
          <select name="day" id="scan-date">
            <option value="default">Select Day</option>
            <?php $this->Search->printDayOptions() ?>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <label for="scan">Scan Creator</label>
        <input type="text" id="scan" name="scan_creator" placeholder="Enter Scan Creator">
      </div>

    </section>

    <section id="subject-general-search" class="search-options" data-prefix="subject-general-">

      <header>
        <p>Subject of Observation General Advanced Search</p>
      </header>

      <div class="section-search-box">
        <label for="class">Classification</label>
        <select name="classification" id="class">
          <option value="default">Select Classification</option>
          <?php $this->Search->printControlList($subjectGClassificationList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="types">Type(s)</label>
        <select name="type" id="types">
          <option value="default">Select Type(s)</option>
          <?php $this->Search->printControlList($subjectGTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="materials">Material(s)</label>
        <select name="materials" id="materials">
          <option value="default">Select Material(s)</option>
          <?php $this->Search->printControlList($subjectGMaterialList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="techniques">Techniques</label>
        <select name="techniques" id="techniques">
          <option value="default">Select Technique(s)</option>
          <?php $this->Search->printControlList($subjectGTechniqueList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="period">Period</label>
        <select name="period" id="period">
          <option value="default">Select Period</option>
          <?php $this->Search->printControlList($subjectGPeriodList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="term">Terminus Ante Quem</label>
        <div class="double-select" data-name="terminus_ante_quem">
          <input type="text" id="term" name="title" placeholder="Enter Date">
          <select name="period" id="term">
            <option value="default">Select Period</option>
            <option value="BCE">BC</option>
            <option value="CE">AC</option>
            <option value="BP">BP</option>
          </select>
        </div>
      </div>

      <div class="section-search-box">
        <label for="post">Terminus Post Quem</label>
        <div class="double-select" data-name="terminus_post_quem">
          <input type="text" id="post" name="title" placeholder="Enter Date">
          <select name="period" id="post">
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
        <label for="location">Location</label>
        <select name="location" id="location">
          <option value="default">Select Location</option>
          <?php $this->Search->printControlList($subjectDLocationList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="excava">Excavation Unit(s)</label>
        <select name="excavation_units" id="excava">
          <option value="default">Excavation Unit(s)</option>
          <?php $this->Search->printControlList($subjectDUnitTypeList)?>
        </select>
      </div>

      <div class="section-search-box">
        <label for="inscrip">Inscription</label>
        <input type="text" name="inscription" placeholder="Enter Inscription" id="inscrip">
      </div>

    </section>
      <button class="search-btn" type="button" name="button">Search</button>
  </article>


</main>

<!---TODO move to js file-->
<script type="text/javascript">
(function(){


    var AdvancedSearch = AdvancedSearch || {}
    AdvancedSearch.months = [
        "January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"
    ];
    AdvancedSearch.display = {

    getQuery : function (inputs, selects, dates, dateRange, eras) {
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
        if ( parentClass!=="date-select" && parentClass!=="date-range"&& parentClass!=="double-select") {
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

        dateRange.each(function() {
            var comps = $(this)
            var prefix = $(this).parent().parent().data("prefix");
            var name = $(this).data("name");
            var year1 = comps.find("select[name='start-year']")
            var year2 = comps.find("select[name='end-year']")

            year1  = parseInt(year1.val())  || "0000";
            year2   = parseInt(year2.val())   || "0000";

            var val = year1 + "-" + year2

            if (val !== "0000-0000")
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


    $.fn.followTo = function () {//make the search bar stick to bottom of the search fields
        var $this = this,
        $window = $(window);
        var heightAbove = $('.advanced-search-container').height()
            + $('.advanced-search-container').offset().top
            + $('.search-btn').height()
            + parseInt($('.search-btn').css("bottom"))
            + parseInt($('.section-search-box').css("margin-bottom"))
		 	+ 2

        $window.scroll(function (e) {
            if (heightAbove - $window.scrollTop() - $window.height() <= 0) {
                $this.css({//stuck
                    position: 'static',
                    width: '100%'
                });
            } else {
                $this.css({//dynamic
                    position: 'fixed',
                    bottom: '60px',
                    width: '70%'
                });
            }
        });
    };

    $('.search-btn').followTo()
    $(window).resize(function(){
        $('.search-btn').followTo()
    });


    $(document).ready(function() {
        var baseURL = window.location.href.split("/search/")[0];
        var project = $("main").data("project")
        $(".search-btn").click(function() {

            var sections = $(".section-search-box")
            var inputs = sections.find("input")
            var selects = sections.find("select")
            var dateSelects = sections.find(".date-select")
            var dateRangeSelects = sections.find(".date-range")
            var doubleSelects = sections.find(".double-select")

            var query = AdvancedSearch.display.getQuery(inputs, selects, dateSelects, dateRangeSelects, doubleSelects)
            AdvancedSearch.display.search(baseURL, query, project)

        })

        $("#backToSearch").find("a").click(function() {
            window.location.href =
            window.location.origin + arcs.baseURL + "search/" + project
        })

        $("#pageHelpModal").click(function(e) {
            if (e.target.nodeName === "ARTICLE") {;
                $("#removeModal")[0].click()
            }
            if (e.target.id === "modalBackToSearch") {
                window.location.href =
                window.location.origin + arcs.baseURL + "search/" + project
            }
            if (e.target.id === "help") {
                window.location.href =
                window.location.origin + arcs.baseURL + "help/searching"
            }
        })

    })
})()
</script>
