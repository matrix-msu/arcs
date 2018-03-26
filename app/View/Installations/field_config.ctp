<?php  $this->Html->script("views/installation/installation.js"); ?>
<div class="field-body-content">
    <div class="install-progress-bar">
        <ul>
            <li>Kora Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li class="current-step">Field Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>Create Project</li>
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
            <li>Subject of Observation</li>
        </ul>
    </div>
    <div class="form-container">
        <div class="project field">
            <hr>
            <div class="form-prompt-wrapper">
                <p class="prompt1">
                    Enter information about your Project form below
                </p>
                <p class="prompt2">
                    For each field, type an option and then hit enter. Then add more options as needed.
                </p>
            </div>
            <div class="form-wrapper">
                <form>
                    <div class="row">
                        <div class="input-full">
                            <p>Country (Countries)</p>
                            <input type="text" placeholder="countries"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Region(s)</p>
                            <input type="text" placeholder="Corinthia"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Modern Name(s)</p>
                            <input type="text" placeholder="Kyras Vrisi"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Period(s)</p>
                            <input type="text" placeholder="Bronze Age"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Archeaological Culture(s)</p>
                            <input type="text" placeholder="Culture"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Permiting Heritage Culture(s)</p>
                            <input type="text" placeholder="Greek Ministry of Culture"/>
                        </div>
                    </div>
                    <hr class="divider">
<!--
                    <div class="cont-btn-container" id="ctn-create">
                        <button onclick="window.location.href= window.location.href.replace('field', 'create')" class="cont-install-btn" type="button" name="button">
                            <p>Continue to Create Project</p>
                        </button>
                    </div>
-->
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
            <div class="form-prompt-wrapper">
                <p class="prompt1">
                    Enter information about your Season form below
                </p>
                <p class="prompt2">
                    For each field, type an option and then hit enter. Then add more options as needed.
                </p>
            </div>
            <div class="form-wrapper">
                <form>
                    <div class="row">
                        <div class="input-full">
                            <span class="dot"></span>
                            <p>Director(s)</p>
                            <input type="text" placeholder="Ethan Watrall, Catherine Foley"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Registrar(s)</p>
                            <input type="text" placeholder="Corinthia"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Sponsor(s)</p>
                            <input type="text" placeholder="Kyras Vrisi"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
                            <p>Contributor(s)</p>
                            <input type="text" placeholder="Bronze Age"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-full">
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
                                <p>Continue to Excavation Confiuration</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="excavation field">
            <hr>
            <div class="form-prompt-wrapper">
                <p class="prompt1">
                    Enter information about your Excavation form below
                </p>
                <p class="prompt2">
                    For each field, type an option and then hit enter. Then add more options as needed.
                </p>
            </div>
            <div class="form-wrapper">
                <form>
                    <div class="row">
                        <div class="input-full">
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
                                <p>Continue to Resource Confiuration</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
