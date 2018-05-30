<?php  echo $this->Html->script("views/installation/installation.js"); ?>
<div class="create-body-content">
    <div class="install-progress-bar">
        <ul>
            <li>Kora Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>Field Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li class="current-step">Create Project Record</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>ARCS Configuration</li>
        </ul>
    </div>
    <div class="form-container">
        <div class="create-project">
            <hr>
            <div class="form-prompt">
                <div class="form-prompt-wrapper">
                    <p class="prompt1">
                        Enter information about your first ARCS project below. Maybe some brief info on this process could go here.
                    </p>
                    <p class="prompt2">
                        For each field, type an option and then hit enter or choose from the dropdown.
                    </p>
                </div>
            </div>
            <div class="form-wrapper">
                <form action="./config" method="post">
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Name</p>
                            <input type="text" name="Name" placeholder="countries"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Country</p>
                            <select name="Country" class="create-project-dropdown">
                                <option value="" disabled selected>Select Country</option>
                                <option>Country 1</option>
                                <option>Country 2</option>
                                <option>Country 3</option>
                                <option>Country 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Modern Name</p>
                            <select name="Modern Name" class="create-project-dropdown">
                                <option value="" disabled selected>Select Modern Name</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
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
                            <input name="Geolocation" type="text" placeholder="Greek Ministry of Culture"/>
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
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                                <select name="Earliest Date Month" class="month-project-dropdown">
                                <option value="" disabled selected>Select Month</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                                <select name="Earliest Date Day" class="day-project-dropdown">
                                <option value="" disabled selected>Select Day</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
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
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                                <select name="Latest Date Month" class="month-project-dropdown">
                                <option value="" disabled selected>Select Month</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                                <select name="Latest Date Day" class="day-project-dropdown">
                                <option value="" disabled selected>Select Day</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Records Archive</p>
                            <select name="Records Archive" class="create-project-dropdown">
                                <option value="" disabled selected>Select Records Archive</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                          <span class="dot"></span>
                            <p>Persistent Name</p>
                            <input name="Persistent Name" type="text" placeholder="Enter the Persistent Name"/>
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
                                <input name="Terminus Ante Quem Date" class="date-input" type="text" placeholder="Enter the Date"/>
                                <select name="Terminus Ante Quem Period" class="period-project-dropdown">
                                    <option value="" disabled selected>Select Period</option>
                                    <option>Name 1</option>
                                    <option>Name 2</option>
                                    <option>Name 3</option>
                                    <option>Name 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Terminus Post Quem</p>
                            <div class="period-select">
                                <input name="Terminus Post Quem Date" class="date-input" type="text" placeholder="Enter the Date"/>
                                <select name="Terminus Post Quem Period" class="period-project-dropdown">
                                    <option value="" disabled selected>Select Period</option>
                                    <option>Name 1</option>
                                    <option>Name 2</option>
                                    <option>Name 3</option>
                                    <option>Name 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Period</p>
                            <select name="Period" class="create-project-dropdown">
                                <option value="" disabled selected>Select Period</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
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
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
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
                            <button class="cont-install-btn" type="submit">
                                <p>Continue to ARCS Confiuration</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
