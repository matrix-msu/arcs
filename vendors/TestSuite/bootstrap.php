<?php
include_once('AutoLoader.php');
include_once("functions.php");
include_once("arcs_bootstrap.php");
ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// Register the directory to your include files
 AutoLoader::registerDirectory('../../app');
AutoLoader::registerDirectory('../../lib/');
//AutoLoader::registerDirectory('../../lib/Kora/Local/');

 AutoLoader::registerDirectory("./Cake");
 define("Auth_user", "matrix.training");
 define("Auth_pass" , "Ilove2program@here!");
 //AutoLoader::registerDirectory('../../bin');
define("URL","http://dev2.matrix.msu.edu/~austin.rix/arcs");
