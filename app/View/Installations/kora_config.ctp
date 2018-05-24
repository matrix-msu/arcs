<?php  echo $this->Html->script("views/installation/installation.js"); ?>
<div class="kora-body-content">
    <div class="install-progress-bar">
        <ul>
            <li class="current-step">Kora Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>Field Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>Create Project Record</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>ARCS Configuration</li>
        </ul>
    </div>
    <div class="form-container">
        <hr>
        <div class="form-prompt-wrapper">
            <p>
                Enter information about your Kora 3 Installation below. The following information can be found within the Kora 3 .env file. The .env file is located in the root directory of the Kora 3 installation.
            </p>
        </div>
        <div class="form-wrapper">
            <form action="./field"  method="post">
                <div class="row">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>Kora Database Host</p>
                        <input name='KoraDBHost' type="text" placeholder="Enter the kora database host url here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>Kora Database Name</p>
                        <input name='KoraDBName' type="text" placeholder="Enter the kora database name here"/>
                    </div>
                </div>
                <div class="row">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>Kora Database Username</p>
                        <input name="KoraDBUsername" type="text" placeholder="Enter the kora database username here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>Kora Database Password</p>
                        <input name="KoraDBPassword" type="text" placeholder="Enter the kora database Password here"/>
                    </div>
                </div>
                <div class="row">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>Kora Base URL</p>
                        <input name='KoraBaseURL' type="text" placeholder="Enter the kora base URL here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>Kora Base Path</p>
                        <input name='KoraBasePath' type="text" placeholder="Enter the kora base path here"/>
                    </div>
                </div>
                <div class="row" id="kora-name">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>Kora Project Name</p>
                        <input name="KoraProjectName" type="text" placeholder="Enter the kora Project Name here"/>
                    </div>
                    <div class="input-right inputDiv">
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
                            <p>Continue to Field Configuration</p>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
