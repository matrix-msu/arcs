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
                <form>
                    <div class="row">
                        <div class="input-full">
                            <p>Name</p>
                            <input type="text" name="parameter[]" placeholder="countries"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Country</p>
                            <select class="create-project-dropdown">
                                <option value="" disabled selected>Select Country</option>
                                <option>Country 1</option>
                                <option>Country 2</option>
                                <option>Country 3</option>
                                <option>Country 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Modern Name</p>
                            <select class="create-project-dropdown">
                                <option value="" disabled selected>Select Modern Name</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Location Identifier</p>
                            <input type="text" placeholder="Bronze Age"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Location Identifier Scheme</p>
                            <input type="text" placeholder="Culture"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Geolocation(s)</p>
                            <input type="text" placeholder="Greek Ministry of Culture"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Elevation</p>
                            <input type="text" placeholder="Greek Ministry of Culture"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Earliest Date</p>
                            <div class="date-select">
                                <select class="year-project-dropdown">
                                <option value="" disabled selected>Select Year</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                                <select class="month-project-dropdown">
                                <option value="" disabled selected>Select Month</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                                <select class="day-project-dropdown">
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
                        <div class="input-full">
                            <p>Latest Date</p>
                            <div class="date-select">
                                <select class="year-project-dropdown">
                                <option value="" disabled selected>Select Year</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                                <select class="month-project-dropdown">
                                <option value="" disabled selected>Select Month</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                                </select>
                                <select class="day-project-dropdown">
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
                        <div class="input-full">
                            <p>Records Archive</p>
                            <select class="create-project-dropdown">
                                <option value="" disabled selected>Select Records Archive</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                          <span class="dot"></span>
                            <p>Persistent Name</p>
                            <input type="text" placeholder="Enter the Persistent Name"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Complex Title</p>
                            <input type="text" placeholder="Enter the Complex Title"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Terminus Ante Quem</p>
                            <div class="period-select">
                                <input class="date-input" type="text" placeholder="Enter the Date"/>
                                <select class="period-project-dropdown">
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
                        <div class="input-full">
                            <p>Terminus Post Quem</p>
                            <div class="period-select">
                                <input class="date-input" type="text" placeholder="Enter the Date"/>
                                <select class="period-project-dropdown">
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
                        <div class="input-full">
                            <p>Period</p>
                            <select class="create-project-dropdown">
                                <option value="" disabled selected>Select Period</option>
                                <option>Name 1</option>
                                <option>Name 2</option>
                                <option>Name 3</option>
                                <option>Name 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Description</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Brief Description</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Permitting Heritage Body</p>
                            <select class="create-project-dropdown">
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
                            <button onclick="window.location.href= window.location.href.replace('create', 'config')" class="cont-install-btn" id="season-step" type="button" name="button">
                                <p>Continue to ARCS Confiuration</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
