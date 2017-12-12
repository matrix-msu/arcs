<?php
/**
*           _____                    _____                    _____                    _____
*          /\    \                  /\    \                  /\    \                  /\    \
*         /::\    \                /::\    \                /::\    \                /::\    \
*        /::::\    \              /::::\    \              /::::\    \              /::::\    \
*       /::::::\    \            /::::::\    \            /::::::\    \            /::::::\    \
*      /:::/\:::\    \          /:::/\:::\    \          /:::/\:::\    \          /:::/\:::\    \
*     /:::/__\:::\    \        /:::/__\:::\    \        /:::/  \:::\    \        /:::/__\:::\    \
*    /::::\   \:::\    \      /::::\   \:::\    \      /:::/    \:::\    \       \:::\   \:::\    \
*   /::::::\   \:::\    \    /::::::\   \:::\    \    /:::/    / \:::\    \    ___\:::\   \:::\    \
*  /:::/\:::\   \:::\    \  /:::/\:::\   \:::\____\  /:::/    /   \:::\    \  /\   \:::\   \:::\    \
* /:::/  \:::\   \:::\____\/:::/  \:::\   \:::|    |/:::/____/     \:::\____\/::\   \:::\   \:::\____\
* \::/    \:::\  /:::/    /\::/   |::::\  /:::|____|\:::\    \      \::/    /\:::\   \:::\   \::/    /
* \/____/ \:::\/:::/    /  \/____|:::::\/:::/    /  \:::\    \      \/____/  \:::\   \:::\   \/____/
*          \::::::/    /         |:::::::::/    /    \:::\    \               \:::\   \:::\    \
*           \::::/    /          |::|\::::/    /      \:::\    \               \:::\   \:::\____\
*           /:::/    /           |::| \::/____/        \:::\    \               \:::\  /:::/    /
*          /:::/    /            |::|  ~|               \:::\    \               \:::\/:::/    /
*         /:::/    /             |::|   |                \:::\    \               \::::::/    /
*        /:::/    /              \::|   |                 \:::\____\               \::::/    /
*        \::/    /                \:|   |                  \::/    /                \::/    /
*         \/____/                  \|___|                   \/____/                  \/____/
*
*
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
*
* @author SOFTWARE LEAD: SEILA GONZALEZ
*					SOFTWARE DEVS: AUSTIN RIX, CHARLIE DENEUA, JOSH CHRIST, MATT SCHLEUSENER
*												 ARNOLD MUTAYOBA, JACOB BUCKLEY
* @design AUSTIN TRUCHAN, ALEXIS REININGER
* @documentation https://wiki.matrix.msu.edu/index.php/Arcs_Documentation
*
*/
/*///////////////////////////////////////////////////////////////////////
APPLICATION
///////////////////////////////////////////////////////////////////////*/
$base = $_SERVER['SERVER_NAME'];
$encrypted = false;
$protocol = $encrypted ? "https" : "http";
define("BASE_URL"      ,  "BASE_URL_REPLACE" );
define("DEFAULT_THUMB" ,  "img/DefaultResourceImage.svg");
/*///////////////////////////////////////////////////////////////////////
CAKE Configure
///////////////////////////////////////////////////////////////////////*/
# Setup a 'default' cache configuration for use in the application.
Cache::config('default'     ,  array('engine' => 'File'));
App::uses('IniReader'       ,  'Configure', 'Security');
App::uses('CakeLog'         ,  'Log');
Configure::config('default' ,  new IniReader(APP . 'Config' . DS));
# Load additional config files.
Configure::load('arcs');
Configure::load('assets');

define("TWIG_VIEW_CACHE", APP . 'tmp');
define("LIB", CORE_PATH);
CakePlugin::load('TwigView');

/*///////////////////////////////////////////////////////////////////////
KORA
///////////////////////////////////////////////////////////////////////*/
define("KORA_FILES_URI"     ,  "KORA_FILES_URI_REPLACE"); //unique
define("KORA_SEARCH"        ,  "KORA_SEARCH_REPLACE"); //unique
define ("KORA_RESTFUL_URL"  ,  "KORA_RESTFUL_URL_REPLACE"); //unique
define("KORA_PLUGIN_USERS"  ,  "KORA_PLUGIN_USERS_REPLACE"); //unique

#PRJOECT AND SCHEME DATA - old, not used.
//define ("PID"          ,  "PID_REPLACE");
//define ("PROJECT_SID"  ,  "PROJECT_SID_REPLACE");
//define ("SEASON_SID"   ,  "SEASON_SID_REPLACE");
//define ("RESOURCE_SID" ,  "RESOURCE_SID_REPLACE");
//define ("PAGES_SID"    ,  "PAGES_SID_REPLACE");
//define ("SUBJECT_SID"  ,  "SUBJECT_SID_REPLACE");
//define ("SURVEY_SID"   ,  "SURVEY_SID_REPLACE");

//new bootstrap setup
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

define ("TOKEN"        ,  "TOKEN_REPLACE");

define("KORA_LIB"      ,  LIB . "Kora/Local/");
# Thumbnail location
define("THUMBS_URL", "$protocol://$base/".BASE_URL."app/webroot/thumbs/");
define("THUMBS", APP."webroot/thumbs/");

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

/*///////////////////////////////////////////////////////////////////////
JAVASCRIPT
///////////////////////////////////////////////////////////////////////*/
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
    "function getSidFromKid(kid){var bootstrapSid = kid.split('-')[1];return parseInt(bootstrapSid, 16);}".
    "function getPidFromKid(kid){var bootstrapPid = kid.split('-')[0];return parseInt(bootstrapPid, 16);}".
    "var ARCS_LOADER_HTML = \" ".ARCS_LOADER_HTML." \";" .
    "</script>");
