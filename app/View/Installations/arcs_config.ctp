<?php  echo $this->Html->script("views/installation/installation.js"); ?>
<div class="config-body-content">
    <div class="install-progress-bar">
        <ul>
            <li>Kora Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>Field Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li>Create Project</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="/<?php echo BASE_URL; ?>img/ArrowRight.svg"></li>
            <li class="current-step">ARCS Configuration</li>
        </ul>
    </div>
    <div class="form-container">
        <hr>
        <div class="form-prompt-wrapper">
            <p>
                Enter information about your ARCS Installation below. Maybe some brief info on how to find this information will go here.
            </p>
        </div>
        <div class="form-wrapper">
            <form action="./finalize" method="post">
                <div class="row">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>ARCS Database Host</p>
                        <input name="ArcsDBHost" type="text" placeholder="Enter the ARCS host name here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>ARCS Database Name</p>
                        <input name="ArcsDBName" type="text" placeholder="Enter the ARCS database name here"/>
                    </div>
                </div>
                <div class="row">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>ARCS Database Username</p>
                        <input name="ArcsDBUsername" type="text" placeholder="Enter the ARCS database username here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>ARCS Database Password</p>
                        <input name="ArcsDBPassword" type="text" placeholder="Enter the ARCS database Password here"/>
                    </div>
                </div>
                <div class="row">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>ARCS Base URL</p>
                        <input name="ArcsBaseURL" type="text" placeholder="Enter the ARCS base URL here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>ARCS Base Path</p>
                        <input name="ArcsBasePath" type="text" placeholder="Enter the ARCS base path here"/>
                    </div>
                </div>
                <div class="row" id="arcs-name">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>Create Admin Username</p>
                        <input name="ArcsAdminUsername" type="text" placeholder="Enter the admin username here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>Create Admin Password</p>
                        <input name="ArcsAdminPassword" type="text" placeholder="Enter the admin password here"/>
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
                            <p>Submit Configuration</p>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
