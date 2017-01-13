<?php

function command_prompt()
{
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
	print_r("Syncing all tmp files \n");
	if(file_exists("$root/app/tmp/")){
		print("Deleting tmp files \n");
		deleteDir("$root/app/tmp/");
	}
	create_mod("$root/app/tmp/");
	create_mod("$root/app/tmp/cache/");
	create_mod("$root/app/tmp/cache/persistent/");
	create_mod("$root/app/tmp/cache/models/");
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
