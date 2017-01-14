<?php
/**
 * Configuration installer.
 *
 * The Config installer is used on first installation of arcs.
 * When this script is ran:
 * 	- All Temp files will be created
 *  - Chmod models and persistent data to 777
 * 	- .htaccess will be created with proper base rewrite.
 *
 * @package    ARCS
 * @link       http://svn.matrix.msu.edu/svn/arcs/
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 * @author Austin Rix
 */

function command_prompt()
{
	license();

	echo "Enter Base Url: ";

	$stdin = fopen('php://stdin', 'r');
	$base = str_replace("\n","",fgets($stdin));
	$base = trim($base, "/");
	print_r("Installing Arcs with $base/ as Base URL \n");

	print("Installer Active \n");

	$root = getcwd();

	create_access(".",$base);
	create_access("app",$base);
	create_access("app/webroot",$base);

	make_tmp($root);
	make_thumb_dir($root);

}
function license()
{
	echo  "* Configuration installer \n";
	echo  "* \n";
	echo  "* The Config installer is used on first installation of arcs. \n";
	echo  "* When this script is ran: \n";
	echo  "* 	- All Temp files will be created \n";
	echo  "* - Chmod models and persistent data to 777 \n";
	echo  "* - .htaccess will be created with proper base rewrite \n";
	echo  "* @package    ARCS \n";
	echo  "* @link       http://svn.matrix.msu.edu/svn/arcs/ \n";
	echo  "* @copyright  Copyright 2012, Michigan State University Board of Trustees \n";
	echo  "* @license    BSD License (http://www.opensource.org/licenses/bsd-license.php) \n";
}

function create_access($dir,$base){
	print("Creating access file in $dir \n");
	if(file_exists($dir)){
		$extension = array_reverse(explode("/",$dir))[0];
		$template_name = $extension == "." ? "root" : $extension;
		$templated = get_template($template_name, $base);
		file_put_contents("$dir/.htaccess", $templated);
	}
	else{
		print("$dir not found \n");
	}
}
function get_template($name, $root_path){
	$template = file_get_contents("ini/ht_templates/$name.template");
	$replaced = str_replace("ARCS_ROOT","/$root_path",$template);
	return $replaced;
}

function make_tmp($root){
	print("Syncing all tmp files \n");
	if(file_exists("$root/app/tmp/")){
		print("Deleting tmp files \n");
		deleteDir("$root/app/tmp/");
	}
	create_mod("$root/app/tmp/");
	create_mod("$root/app/tmp/cache/");
	create_mod("$root/app/tmp/cache/persistent/");
	create_mod("$root/app/tmp/cache/models/");
}
function make_thumb_dir($root){
	print("Syncing all thumbnail files \n");
	if(file_exists("$root/app/webroot/thumbs/")){
		print("Deleting thumb dir \n");
		deleteDir("$root/app/webroot/thumbs/");
	}
	create_mod("$root/app/webroot/thumbs/");
	create_mod("$root/app/webroot/thumbs/smallThumbs/");
	create_mod("$root/app/webroot/thumbs/largeThumbs/");
}
function create_mod($name){
		mkdir($name);
		chmod($name,0777);
		print("Creating $name \n");
}
function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

command_prompt();
