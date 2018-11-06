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



# Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));
App::uses('IniReader', 'Configure', 'Security');
App::uses('CakeLog', 'Log');
Configure::config('default', new IniReader(APP . 'Config' . DS));
# Load additional config files.
Configure::load('arcs');
Configure::load('assets');

# Basic Kora Information
define("DEFAULT_THUMB", "img/DefaultResourceImage.svg");
define("KORA_LIB", CORE_PATH . "Kora/Local/");
define("BASE_BOTH", "");
define("BASE_URL",  BASE_BOTH . "arcs/" );

define("KORA_FILES_URI",  BASE_BOTH . "kora3/app/files/");
define ("KORA_SEARCH", BASE_URL . "lib/Kora/Local/KoraSearch.php");
define ("KORA_RESTFUL_URL", BASE_BOTH . "kora3/api/");

define("KORA_HOST", "localhost");
define("KORA_USER", "kora3");
define("KORA_PASS", "kora3");
define("KORA_DB", "kora3");

//flag for if arcs has been configured for user
define('CONFIGURED', 'false');

$GLOBALS['PID_ARRAY'] = array(
    'arcs' => 1
);
$GLOBALS['PROJECT_SID_ARRAY'] = array(
    'arcs' => 1
);
$GLOBALS['SEASON_SID_ARRAY'] = array(
    'arcs' => 2
);
$GLOBALS['SURVEY_SID_ARRAY'] = array(
    'arcs' => 6
);
$GLOBALS['RESOURCE_SID_ARRAY'] = array(
    'arcs' => 3
);
$GLOBALS['PAGES_SID_ARRAY'] = array(
    'arcs' => 4
);
$GLOBALS['SUBJECT_SID_ARRAY'] = array(
    'arcs' => 5
);
$GLOBALS['TOKEN_ARRAY'] = array(
    'arcs' => "WTI4VtJabtjOcpt4ke0OgPvU"
);

define ("TOKEN", "WTI4VtJabtjOcpt4ke0OgPvU");


define("TWIG_VIEW_CACHE", APP . 'tmp');
define("LIB", CORE_PATH);
CakePlugin::load('TwigView');

define("ARCS_LOADER_HTML",
    "<div class='sk-cube-container'>".
    "<div class='sk-folding-cube'>".
    "<div class='sk-cube1 sk-cube'></div>".
    "<div class='sk-cube2 sk-cube'></div>".
    "<div class='sk-cube4 sk-cube'></div>".
    "<div class='sk-cube3 sk-cube'></div>".
    "</div>".
    "</div>"
);

define("globaljsvars",
    "<script type='text/javascript'>" .
    "var BASE_URL ='".BASE_URL."';" .
    "var PID_ARRAY ='".json_encode($GLOBALS['PID_ARRAY'])."';" .
    "var PROJECT_SID_ARRAY ='".json_encode($GLOBALS['PROJECT_SID_ARRAY'])."';" .
    "var SEASON_SID_ARRAY ='".json_encode($GLOBALS['SEASON_SID_ARRAY'])."';" .
    "var RESOURCE_SID_ARRAY ='".json_encode($GLOBALS['RESOURCE_SID_ARRAY'])."';" .
    "var SUBJECT_SID_ARRAY ='".json_encode($GLOBALS['SUBJECT_SID_ARRAY'])."';" .
    "var SURVEY_SID_ARRAY ='".json_encode($GLOBALS['SURVEY_SID_ARRAY'])."';" .
    "var PAGES_SID_ARRAY ='".json_encode($GLOBALS['PAGES_SID_ARRAY'])."';" .
    "var KORA_FILES_URI ='".KORA_FILES_URI."';".
    "function getSidFromKid(kid){return kid.split('-')[1];}".
    "function getPidFromKid(kid){return kid.split('-')[0];}".
    "var ARCS_LOADER_HTML = \" ".ARCS_LOADER_HTML." \";" .
    "</script>");
