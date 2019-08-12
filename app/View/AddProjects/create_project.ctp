<?php  echo $this->Html->script("views/add_project/add_project.js"); ?>
<head>
    <script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
</head>
<div class="create-body-content">
    <div class="install-progress-bar">
        <ul>
            <li>Field Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="../app/webroot/img/ArrowRight.svg"></li>
            <li class="current-step">Create Project Record</li>
<!--            <li class="right-arrow"><img class="arrow-right-icon" src="../app/webroot/img/ArrowRight.svg"></li>-->
<!--            <li>ARCS Configuration</li>-->
        </ul>
    </div>
    <div class="form-container">
        <div class="create-project">
            <hr>
            <div class="form-prompt">
                <div class="form-prompt-wrapper">
                    <p class="prompt1">
                        Enter information about your new ARCS project below.
                    </p>
                    <p class="prompt2">
                        For each field, type an option followed by a comma or choose from the dropdown.
                    </p>
                </div>
            </div>
            <div class="form-wrapper">
                <form action="./finalize" method="post">
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Name</p>
                            <input type="text" name="Name" placeholder="Name"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Country</p>
                            <select name="Country" class="create-project-dropdown">
                                <option value="" disabled selected>Select Country</option>
                                <?php
                                $countries = $_SESSION['FieldConfig']['Country'];
                                foreach ($countries as $country) {
                                    echo "<option>$country</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Modern Name</p>
                            <select name="Modern Name" class="create-project-dropdown">
                                <option value="" disabled selected>Select Modern Name</option>
                                <?php
                                $modern_names = $_SESSION['FieldConfig']['Modern_Name'];
                                foreach ($modern_names as $mName) {
                                    echo "<option>$mName</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Location Identifier</p>
                            <input name="Location Identifier" type="text" placeholder="Bronze Age"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Location Identifier Scheme</p>
                            <input name="Location Identifier Scheme" type="text" placeholder="Culture"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Geolocation(s)</p>
                            <!-- <input name="Geolocation" type="text" placeholder="Greek Ministry of Culture"/> -->
                            <div class="keywords-uploadForm" name="Geolocation"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Elevation</p>
                            <input name="Elevation" type="text" placeholder="Greek Ministry of Culture"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Earliest Date</p>
                            <div class="date-select">
                                <select name="Earliest Date Year" class="year-project-dropdown">
                                    <option value="" disabled selected>Select Year</option>
                                    <?php
                                    $currentYear = intval(date("Y"));
                                    for ($year = 1930; $year <= $currentYear; $year++){
                                        echo "<option>$year</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Earliest Date Month" class="month-project-dropdown">
                                    <option value="" disabled selected>Select Month</option>
                                    <?php
                                    for ($month = 1; $month <= 12; $month++){
                                        echo "<option>$month</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Earliest Date Day" class="day-project-dropdown">
                                    <option value="" disabled selected>Select Day</option>
                                    <?php
                                    for ($day = 1; $day <= 31; $day++){
                                        echo "<option>$day</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Latest Date</p>
                            <div class="date-select">
                                <select name="Latest Date Year" class="year-project-dropdown">
                                    <option value="" disabled selected>Select Year</option>
                                    <?php
                                    $currentYear = intval(date("Y"));
                                    for ($year = 1930; $year <= $currentYear; $year++){
                                        echo "<option>$year</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Latest Date Month" class="month-project-dropdown">
                                    <option value="" disabled selected>Select Month</option>
                                    <?php
                                    for ($month = 1; $month <= 12; $month++){
                                        echo "<option>$month</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Latest Date Day" class="day-project-dropdown">
                                    <option value="" disabled selected>Select Day</option>
                                    <?php
                                    for ($day = 1; $day <= 31; $day++){
                                        echo "<option>$day</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Records Archive</p>
                            <select name="Records Archive" class="create-project-dropdown">
                                <option value="" disabled selected>Select Records Archive</option>
                                <?php
                                if (isset($_SESSION['FieldConfig']['Records_Archive'])){
                                    $repos = $_SESSION['FieldConfig']['Records_Archive'];

                                    foreach ($repos as $repo){
                                        echo "<option>$repo</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Persistent Name</p>
                            <input name="Persistent Name" class="req" type="text" placeholder="Enter the Persistent Name"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Complex Title</p>
                            <input name="Complex Title" type="text" placeholder="Enter the Complex Title"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Terminus Ante Quem</p>
                            <div class="period-select">
                                <select name="Terminus Ante Quem Year" class="year-project-dropdown">
                                    <option value="" disabled selected>Select Year</option>
                                    <?php
                                    for ($year = 1; $year <= 9999; $year++){
                                        echo "<option>$year</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Terminus Ante Quem Month" class="month-project-dropdown">
                                    <option value="" disabled selected>Select Month</option>
                                    <?php
                                    for ($month = 1; $month <= 12; $month++){
                                        echo "<option>$month</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Terminus Ante Quem Day" class="day-project-dropdown">
                                    <option value="" disabled selected>Select Day</option>
                                    <?php
                                    for ($day = 1; $day <= 31; $day++){
                                        echo "<option>$day</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Terminus Ante Quem Period" class="period-project-dropdown">
                                    <option value="" disabled selected>Select Period</option>
                                    <option>BCE</option>
                                    <option>CE</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Terminus Post Quem</p>
                            <div class="period-select">
                                <select name="Terminus Post Quem Year" class="year-project-dropdown">
                                    <option value="" disabled selected>Select Year</option>
                                    <?php
                                    for ($year = 1; $year <= 9999; $year++){
                                        echo "<option>$year</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Terminus Post Quem Month" class="month-project-dropdown">
                                    <option value="" disabled selected>Select Month</option>
                                    <?php
                                    for ($month = 1; $month <= 12; $month++){
                                        echo "<option>$month</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Terminus Post Quem Day" class="day-project-dropdown">
                                    <option value="" disabled selected>Select Day</option>
                                    <?php
                                    for ($day = 1; $day <= 31; $day++){
                                        echo "<option>$day</option>";
                                    }
                                    ?>
                                </select>
                                <select name="Terminus Post Quem Period" class="period-project-dropdown">
                                    <option value="" disabled selected>Select Period</option>
                                    <option>BCE</option>
                                    <option>CE</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Period</p>
                            <select name="Period" class="create-project-dropdown">
                                <option value="" disabled selected>Select Period</option>
                                <?php
                                if (isset($_SESSION['FieldConfig']['Period'])){
                                    $periods = $_SESSION['FieldConfig']['Period'];

                                    foreach ($periods as $period){
                                        echo "<option>$period</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Archaeological Culture</p>
                            <select name="Archaeological Culture" class="create-project-dropdown">
                                <option value="" disabled selected>Select Archaeological Culture</option>
                                <?php
                                if (isset($_SESSION['FieldConfig']['Archaeological_Culture'])){
                                    $cultures = $_SESSION['FieldConfig']['Archaeological_Culture'];

                                    foreach ($cultures as $culture){
                                        echo "<option>$culture</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Description</p>
                            <input name="Description" type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Brief Description</p>
                            <input name="Brief Description" type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Permitting Heritage Body</p>
                            <select name="Permitting Heritage Body" class="create-project-dropdown">
                                <option value="" disabled selected>Select Permitting Heritage Body</option>
                                <?php
                                if (isset($_SESSION['FieldConfig']['Permitting_Heritage_Body'])){
                                    $phcs = $_SESSION['FieldConfig']['Permitting_Heritage_Body'];
                                    foreach ($phcs as $phc){
                                        echo "<option>$phc</option>";
                                    }
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="bottom">
                        <div class="required">
                            <span class="dot"></span>
                            <p>= Required Field</p>
                        </div>
                        <div class="cont-btn-container">
                            <p class="required-notice">Please fill out all required fields.</p>
                            <button class="cont-install-btn" type="submit">
                                <p>Finished</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
