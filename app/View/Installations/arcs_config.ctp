<?php  echo $this->Html->script("views/installation/installation.js"); ?>
<head>
    <script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>
</head>
<div class="config-body-content">
    <div class="install-progress-bar">
        <ul>
<!--            <li>Kora Configuration</li>-->
<!--            <li class="right-arrow"><img class="arrow-right-icon" src="../app/webroot/img/ArrowRight.svg"></li>-->
            <li>Field Configuration</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="../app/webroot/img/ArrowRight.svg"></li>
            <li>Create Project</li>
            <li class="right-arrow"><img class="arrow-right-icon" src="../app/webroot/img/ArrowRight.svg"></li>
            <li class="current-step">ARCS Configuration</li>
        </ul>
    </div>
    <div class="form-container">
        <hr>
        <div class="form-prompt-wrapper">
            <p class="prompt0">
                Enter information about your ARCS Installation below.
            </p>
        </div>
        <div class="form-wrapper">
            <form action="./finalize" method="post">
                <!--<div class="row">-->
                    <!--<div class="input-left inputDiv">-->
                        <!--<span class="dot"></span>-->
                        <!--<p>ARCS Database Host</p>-->
                        <!--<input name="ArcsDBHost" class="req" type="text" placeholder="Enter the ARCS host name here"/>-->
                    <!--</div>-->
                    <!--<div class="input-right inputDiv">-->
                        <!--<span class="dot"></span>-->
                        <!--<p>ARCS Database Name</p>-->
                        <!--<input name="ArcsDBName" class="req" type="text" placeholder="Enter the ARCS database name here"/>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="row">-->
                    <!--<div class="input-left inputDiv">-->
                        <!--<span class="dot"></span>-->
                        <!--<p>ARCS Database Username</p>-->
                        <!--<input name="ArcsDBUsername" class="req" type="text" placeholder="Enter the ARCS database username here"/>-->
                    <!--</div>-->
                    <!--<div class="input-right inputDiv">-->
                        <!--<span class="dot"></span>-->
                        <!--<p>ARCS Database Password</p>-->
                        <!--<input name="ArcsDBPassword" class="req" type="text" placeholder="Enter the ARCS database Password here"/>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="row">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>Base URL -</p>
                        <br>
                        <p style="font-size:13px;">* Copy the full url from your browser ex: https://example.com/arcs/installation/config
                        <br>
                        </p>
                        <input name="ArcsBaseURL" class="req" type="text" placeholder="Enter the base URL here"/>
                    </div>
                    <!--<div class="input-right inputDiv">-->
                        <!--<span class="dot"></span>-->
                        <!--<p>ARCS Base Path</p>-->
                        <!--<input name="ArcsBasePath" class="req" type="text" placeholder="Enter the ARCS base path here"/>-->
                    <!--</div>-->
                </div>
                <div class="row" id="arcs-name">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>Create Admin Username</p>
                        <br>
                        <p style="font-size:13px;">* "Admin" is taken with password = "arcspassw0rd"</p>
                        <input name="ArcsAdminUsername" class="req" type="text" placeholder="Enter your admin username here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>Create Admin Password</p>
                        <input name="ArcsAdminPassword" class="req" type="text" placeholder="Enter your admin password here"/>
                    </div>
                </div>
                <div class="row">
                    <div class="input-left inputDiv">
                        <span class="dot"></span>
                        <p>Create Admin Name</p>
                        <input name="ArcsAdminName" class="req" type="text" placeholder="Enter your name here"/>
                    </div>
                    <div class="input-right inputDiv">
                        <span class="dot"></span>
                        <p>Create Admin Email</p>
                        <input name="ArcsAdminEmail" class="req" type="text" placeholder="Enter your email here"/>
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
                            <p>Submit Configuration</p>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
