<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

# Kora search include
chdir("../../");
$path = getcwd() . "/lib/";
$app = getcwd() . "/app/";
define("CORE_PATH",$path);
define("APP",$app);
chdir("vendors/TestSuite");

# Setup a 'default' cache configuration for use in the application.
# Basic Kora Information
define("DEFAULT_THUMB", "img/DefaultResourceImage.svg");
define("KORA_FILES_URI", "http://kora.matrix.msu.edu/files/");
define("KORA_SEARCH","/matrix/www/kora/public_html/includes/koraSearch.php");
define("KORA_LIB", CORE_PATH . "Kora/Local/");
define ("KORA_RESTFUL_URL", "http://kora.matrix.msu.edu/api/restful.php");
define ("KORA_BASE", "http://dev2.matrix.msu.edu/");

// EDIT
//////////////////////////////////////////////////////////////
define("BASE_URL",  "arcs/" );
define ("LOCAL_URI", "~austin.rix/arcs2/webroot/");
/////////////////////////////////////////////////////////////
// EDIT 2
define("KORA_PLUGIN_USERS", "http://dev2.matrix.msu.edu/~josh.christ/kora/plugins/arcs_plugin/#/users/pending");
//////////////////////////////////////////////////////////////

define ("PID", "123");
define ("PROJECT_SID", "734");
define ("SEASON_SID", "735");
define ("RESOURCE_SID", "736");
define ("PAGES_SID", "738");
define ("SUBJECT_SID", "739");
define ("SURVEY_SID", "740");
define ("TOKEN", "8b88eecedaa2d3708ebec77a");

# Thumbnail location
define("THUMBS_URL", "http://dev2.matrix.msu.edu/arcs/app/webroot/thumbs/");
define("THUMBS", "/matrix/dev/public_html/arcs/app/webroot/thumbs/");

define("TWIG_VIEW_CACHE", APP . 'tmp');
define("LIB", CORE_PATH);



//Edit 3
////////////////////////////////////////////////////
define("globaljsvars",
	"<script type='text/javascript'>" .
	"var BASE_URL ='".BASE_URL."';" .
	"var PROJECT_SID ='".PROJECT_SID."';" .
	"var SEASON_SID ='".SEASON_SID."';" .
	"var RESOURCE_SID ='".RESOURCE_SID."';" .
	"var SUBJECT_SID ='".SUBJECT_SID."';" .
	"var SURVEY_SID ='".SURVEY_SID."';" .
	"var PAGES_SID ='".PAGES_SID."';" .
	"var KORA_FILES_URI ='".KORA_FILES_URI."';".
	"var PID ='".PID."';".
	"</script>");
