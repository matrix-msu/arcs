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
define("KORA_FILES_URI", "http://kora.matrix.msu.edu/files/");
define("KORA_SEARCH","/matrix/www/kora/public_html/includes/koraSearch.php");
define("KORA_LIB", CORE_PATH . "Kora/Local/");
define ("KORA_RESTFUL_URL", "http://kora.matrix.msu.edu/api/restful.php");
//define ("KORA_BASE", "http://dev2.matrix.msu.edu/");
//define ("LOCAL_URI", "~josh.christ/arcs/webroot/");
define("BASE_URL",  "~josh.christ/arcs/" );

define("KORA_PLUGIN_USERS", "http://dev2.matrix.msu.edu/~josh.christ/kora/plugins/arcs_plugin/#/users/pending");

//define ("PID", "123");
//define ("PROJECT_SID", "734");
//define ("SEASON_SID", "735");
//define ("RESOURCE_SID", "736");
//define ("PAGES_SID", "738");
//define ("SUBJECT_SID", "739");
//define ("SURVEY_SID", "740");

$GLOBALS['PID_ARRAY'] = array(
    'isthmia' => 123,
    'grotto_tiberri' => 168
);
$GLOBALS['PROJECT_SID_ARRAY'] = array(
    'isthmia' => 734,
    'grotto_tiberri' => 911
);
$GLOBALS['SEASON_SID_ARRAY'] = array(
    'isthmia' => 735,
    'grotto_tiberri' => 913
);
$GLOBALS['SURVEY_SID_ARRAY'] = array(
    'isthmia' => 740,
    'grotto_tiberri' => 914
);
$GLOBALS['RESOURCE_SID_ARRAY'] = array(
    'isthmia' => 736,
    'grotto_tiberri' => 915
);
$GLOBALS['PAGES_SID_ARRAY'] = array(
    'isthmia' => 738,
    'grotto_tiberri' => 916
);
$GLOBALS['SUBJECT_SID_ARRAY'] = array(
    'isthmia' => 739,
    'grotto_tiberri' => 917
);
$GLOBALS['TOKEN_ARRAY'] = array(
    'isthmia' => "8b88eecedaa2d3708ebec77a",
    'grotto_tiberri' => "8b88eecedaa2d3708ebec77a"
);

define ("TOKEN", "8b88eecedaa2d3708ebec77a");

# Thumbnail location
define("THUMBS_URL", "http://dev2.matrix.msu.edu/arcs/app/webroot/thumbs/");
define("THUMBS", "/matrix/dev/public_html/arcs/app/webroot/thumbs/");

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
    "var THUMBNAIL_URL ='".THUMBS_URL."';" .
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
