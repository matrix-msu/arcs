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
        
        <form action="./create" method="post" >
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
                    
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Country (Countries)</p>
                                <input name="Country" type="text" placeholder="countries"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Region(s)</p>
                                <input name="Region" type="text" placeholder="Corinthia"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Modern Name(s)</p>
                                <input name="Modern Name" type="text" placeholder="Kyras Vrisi"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Period(s)</p>
                                <input name="Period" type="text" placeholder="Bronze Age"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Archaeological Culture(s)</p>
                                <input name="Archaeological Culture" type="text" placeholder="Culture"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Permiting Heritage Culture(s)</p>
                                <input name="Permitting Heritage Culture" type="text" placeholder="Greek Ministry of Culture"/>
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
                    
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Director(s)</p>
                                <input name="Director" type="text" placeholder="Ethan Watrall, Catherine Foley"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Registrar(s)</p>
                                <input name="Registrar" type="text" placeholder="Corinthia"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Sponsor(s)</p>
                                <input name="Sponsor" type="text" placeholder="Kyras Vrisi"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Contributor(s)</p>
                                <input name="Contributor" type="text" placeholder="Bronze Age"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Contributor Role(s)</p>
                                <input name="Contributor Role" type="text" placeholder="Culture"/>
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
                    
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Supervisor(s)</p>
                                <input name="Supervisor" type="text" placeholder="Firstname Lastname"/>
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
                    
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Type(s)</p>
                                <input name="Type" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Creator(s)</p>
                                <input name="Creator" type="text" placeholder="Enter the list options for creator(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Creator Role(s)</p>
                                <input name="Creator Role" type="text" placeholder="Enter the list options for creator role(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Language(s)</p>
                                <input name="Language" type="text" placeholder="Enter the list options for language(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Right Holder(s)</p>
                                <input name="Rights Holder" type="text" placeholder="Enter the list options for rights holder(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Repository(s)</p>
                                <input name="Repository" type="text" placeholder="Enter the list options for repository(s)"/>
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
                    
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Artifact - Structure Classification(s)</p>
                                <input name="Artifact - Structure Classification" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Artifact - Structure Type(s)</p>
                                <input name="Artifact - Structure Type" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Artifact - Structure Material(s)</p>
                                <input name="Artifact - Structure Material" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Artifact - Structure Technique(s)</p>
                                <input name="Artifact - Structure Technique" type="text" placeholder="Enter the list options for language(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Artifact - Structure Archaeological Culture(s)</p>
                                <input name="Artifact - Structure Archaeological Culture" type="text" placeholder="Enter the list options for rights holder(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Artifact - Structure Current Location(s)</p>
                                <input name="Artifact - Structure Current Location" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Artifact - Structure Repository(s)</p>
                                <input name="Artifact - Structure Repository" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Artifact - Structure Creator(s)</p>
                                <input name="Artifact - Structure Creator" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Artifact - Structure Unit(s)</p>
                                <input name="Artifact - Structure Unit" type="text" placeholder="Enter the list options for language(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <span class="dot"></span>
                                <p>Artifact - Structure Location(s)</p>
                                <input name="Artifact - Structure Location" type="text" placeholder="Enter the list options for language(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Artifact - Structure Condition(s)</p>
                                <input name="Artifact - Structure Condition" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Artifact - Structure Subject(s)</p>
                                <input name="Artifact - Structure Subject" type="text" placeholder="Enter the list options for type(s)"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-full inputDiv">
                                <p>Artifact - Structure Origin(s)</p>
                                <input name="Artifact - Structure Origin" type="text" placeholder="Enter the list options for type(s)"/>
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
                                    <p>Continue to Project Record Creation</p>
                                </button>
                            </div>
                        </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>
