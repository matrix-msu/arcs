<?php
include_once('AutoLoader.php');
ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// Register the directory to your include files
AutoLoader::registerDirectory('../../app');
AutoLoader::registerDirectory('../../lib');
AutoLoader::registerDirectory("./Cake");
?>
