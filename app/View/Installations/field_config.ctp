<?php  echo $this->Html->script("views/installation/installation.js"); ?>
<div class="field-body-content">
    <div class="install-progress-bar">
        <ul>
            <li>Kora Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li class="current-step">Field Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>Create Project Record</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>ARCS Configuration</li>
        </ul>
    </div>
    <div class="field-progress-bar">
        <ul>
            <li class="project-nav current-step">Project</li>
            <li class="dash">-</li>
            <li class="season-nav">Season</li>
            <li class="dash">-</li>
            <li class="excav-nav">Excavation</li>
            <li class="dash">-</li>
            <li class="resource-nav">Resouce</li>
            <li class="dash">-</li>
            <li class="subject-nav">Subject of Observation</li>
        </ul>
    </div>
    <div class="form-container">
        <div class="project field">
            <hr>
            <div class="form-prompt">
                <div class="form-prompt-wrapper">
                    <p class="prompt1">
                        Enter information about your Project form below
                    </p>
                    <p class="prompt2">
                        For each field, type an option and then hit enter. Then add more options as needed.
                    </p>
                </div>
            </div>
            <div class="form-wrapper">
                <form>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Country (Countries)</p>
                            <input type="text" placeholder="countries"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Region(s)</p>
                            <input type="text" placeholder="Corinthia"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Modern Name(s)</p>
                            <input type="text" placeholder="Kyras Vrisi"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Period(s)</p>
                            <input type="text" placeholder="Bronze Age"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Archeaological Culture(s)</p>
                            <input type="text" placeholder="Culture"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Permiting Heritage Culture(s)</p>
                            <input type="text" placeholder="Greek Ministry of Culture"/>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="bottom">
                        <div class="required">
                            <span class="dot"></span>
                            <p>= Required Field</p>
                        </div>
                        <div class="cont-btn-container">
                            <button class="cont-install-btn" id="season-step" type="button" name="button">
                                <p>Continue to Season Confiuration</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="season field">
            <hr>
            <div class="form-prompt">
                <div class="form-prompt-wrapper">
                    <p class="prompt1">
                        Enter information about your Season form below
                    </p>
                    <p class="prompt2">
                        For each field, type an option and then hit enter. Then add more options as needed.
                    </p>
                </div>
            </div>
            <div class="form-wrapper">
                <form>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Director(s)</p>
                            <input type="text" placeholder="Ethan Watrall, Catherine Foley"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Registrar(s)</p>
                            <input type="text" placeholder="Corinthia"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Sponsor(s)</p>
                            <input type="text" placeholder="Kyras Vrisi"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Contributor(s)</p>
                            <input type="text" placeholder="Bronze Age"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Contributor Role(s)</p>
                            <input type="text" placeholder="Culture"/>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="bottom">
                        <div class="required">
                            <span class="dot"></span>
                            <p>= Required Field</p>
                        </div>
                        <div class="cont-btn-container">
                            <button class="cont-install-btn" id="excavation-step" type="button" name="button">
                                <p>Continue to Excavation Configuration</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="excavation field">
            <hr>
            <div class="form-prompt">
                <div class="form-prompt-wrapper">
                    <p class="prompt1">
                        Enter information about your Excavation form below
                    </p>
                    <p class="prompt2">
                        For each field, type an option and then hit enter. Then add more options as needed.
                    </p>
                </div>
            </div>
            <div class="form-wrapper">
                <form>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Supervisor(s)</p>
                            <input type="text" placeholder="Firstname Lastname"/>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="bottom">
                        <div class="required">
                            <span class="dot"></span>
                            <p>= Required Field</p>
                        </div>
                        <div class="cont-btn-container">
                            <button class="cont-install-btn" id="resource-step" type="button" name="button">
                                <p>Continue to Resource Configuration</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="resource field">
            <hr>
            <div class="form-prompt">
                <div class="form-prompt-wrapper">
                    <p class="prompt1">
                        Enter information about your Resource form below
                    </p>
                    <p class="prompt2">
                        For each field, type an option and then hit enter. Then add more options as needed.
                    </p>
                </div>
            </div>
            <div class="form-wrapper">
                <form>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Type(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Creator(s)</p>
                            <input type="text" placeholder="Enter the list options for creator(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Creator Role(s)</p>
                            <input type="text" placeholder="Enter the list options for creator role(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Language(s)</p>
                            <input type="text" placeholder="Enter the list options for language(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Right Holder(s)</p>
                            <input type="text" placeholder="Enter the list options for rights holder(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Repository(s)</p>
                            <input type="text" placeholder="Enter the list options for repository(s)"/>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="bottom">
                        <div class="required">
                            <span class="dot"></span>
                            <p>= Required Field</p>
                        </div>
                        <div class="cont-btn-container">
                            <button class="cont-install-btn" id="subject-step" type="button" name="button">
                                <p>Continue to Subject of Observation Configuration</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="subject field">
            <hr>
            <div class="form-prompt">
                <div class="form-prompt-wrapper">
                    <p class="prompt1">
                        Enter information about your Subject of Observation form below
                    </p>
                    <p class="prompt2">
                        For each field, type an option and then hit enter. Then add more options as needed.
                    </p>
                </div>
            </div>
            <div class="form-wrapper">
                <form>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Artifact - Structure Classification(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Artifact - Structure Type(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Artifact - Structure Material(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Artifact - Structure Technique(s)</p>
                            <input type="text" placeholder="Enter the list options for language(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Artifact - Structure Archeological Culture(s)</p>
                            <input type="text" placeholder="Enter the list options for rights holder(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Artifact - Structure Current Location(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Artifact - Structure Repository(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Artifact - Structure Creator(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Artifact - Structure Unit(s)</p>
                            <input type="text" placeholder="Enter the list options for language(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <span class="dot"></span>
                            <p>Artifact - Structure Location(s)</p>
                            <input type="text" placeholder="Enter the list options for language(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Artifact - Structure Condition(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Artifact - Structure Subject(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full inputDiv">
                            <p>Artifact - Structure Origin(s)</p>
                            <input type="text" placeholder="Enter the list options for type(s)"/>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="bottom">
                        <div class="required">
                            <span class="dot"></span>
                            <p>= Required Field</p>
                        </div>
                        <div class="cont-btn-container">
                            <button onclick="window.location.href= window.location.href.replace('field', 'create')" class="cont-install-btn" type="button" name="button">
                                <p>Continue to Project Record Creation</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
