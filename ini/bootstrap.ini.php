<?php
/**
 * bootstrap installer.
 *
 * The boostrap installer is used to configure the app/Config/bootstrap file
 * to preserve the hooks between kora and cakephp.
 *
 * @package    ARCS
 * @link       http://svn.matrix.msu.edu/svn/arcs/
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 * @author Austin Rix
 */

  if(sizeof($argv) == 1)
    command_prompt();

  else if(sizeof($argv) == 2){

    $json = file_get_contents($argv[1]);

    if($json != false && isJson($json)){
      echo "Extracting Config from Json \n";
      $bootstrap = copy_bootstrap();
      loop_replace($bootstrap, $json);
      echo "Creating bootstrap \n";
      write_to_file($bootstrap);
    }
    else{
      echo "ERROR: could not parse JSON from file!"
    }

  }
  function isJson($string) {
   json_decode($string);
   return (json_last_error() == JSON_ERROR_NONE);
  }

  function command_prompt(){
      echo "Run Boostrap Configure (Y/N)? ";
      $stdin = fopen('php://stdin', 'r');
      $response = strtoupper(fgetc($stdin));
      if($response == "Y"){
          run_boot_config();
      }
  }
  function copy_json($json){
    $response = NULL;
    echo "Would you like to make a copy of the configuration (Y/N)? ";
    $stdin = fopen('php://stdin', 'r');
    $response = strtoupper(fgetc($stdin));

    while($response != "Y" && $response != "N" ){
      echo "Please enter 'Y' or 'N' \n";
      echo "Would you like to make a copy of the configuration (Y/N)? ";
      $stdin = fopen('php://stdin', 'r');
      $response = strtoupper(fgetc($stdin));
    }
    if($response == "Y"){
      $name = NULL;
      echo "Enter the json file name: ";
      $stdin = fopen('php://stdin', 'r');
      $name = str_replace("\n","",fgets($stdin));
      $name = str_replace(" ","_",$name);
      while($name == ""){
        echo "Please enter a file name or \"Ctrl C\" to cancel \n";
        $stdin = fopen('php://stdin', 'r');
        $name = str_replace("\n","",fgets($stdin));
        $name = str_replace(" ","_",$name);
      }
      echo "saving $name.json \n";
      $json = str_replace("{", "{\n", $json);
      $json = str_replace("}", "\n}", $json);
      $json = str_replace(",", ",\n", $json);
      file_put_contents("$name.json",$json);
    }


  }
  function run_boot_config(){
    try{
      $bootstrap = copy_bootstrap();
      $json = replace_sequence();
      loop_replace($bootstrap, $json);
      //write_to_file($bootstrap);
      copy_json($json);
    }
    catch(Exception $e){
      echo $e->getMessage() . "\n";
      exit();
    }
  }

  function copy_bootstrap($dist = "app/Config", $boot = "bootstrap.dist.template.php", $new_boot = "bootstrap.php"){

    if(!file_exists("$dist/bootstrap.dist.php")){
  		throw new Exception("Missing $dist/bootstrap.dist.php");
  	}
  	else{
      if(file_exists("$dist/$new_boot")){
        echo "Overrite current boostrap (Y/N)? ";
        $stdin = fopen('php://stdin', 'r');
        $response = strtoupper(fgetc($stdin));
        if($response != "Y"){
          exit();
        }
      }
  		copy("$dist/$boot","$dist/$new_boot");
      $bootstrap = file_get_contents("$dist/$new_boot");
      return $bootstrap;
  	}
  }
  function get_replacement($message, $rID, &$array = array()){
    global $bootstrap;
    echo "$message: ";
    $stdin = fopen('php://stdin', 'r');
    $response = str_replace("\n","",fgets($stdin));
    $response = str_replace(" ","",$response);
    if($response == "sk"){
      return;
    }
    $array[$rID] = $response;
  }

  function replace_sequence()
  {
    print("To skip a selection type \"sk\" \n");

    $array = [];

    get_replacement(
      "Enter the Base Url", "BASE_URL_REPLACE", $array
    );
    get_replacement(
      "Enter the KORA project ID", "PID_REPLACE", $array
    );
    get_replacement(
      "Enter the KORA PROJECT_SID", "PROJECT_SID_REPLACE",$array
    );
    get_replacement(
      "Enter the KORA SEASON_SID", "SEASON_SID_REPLACE", $array
    );
    get_replacement(
      "Enter the KORA RESOURCET_SID", "RESOURCE_SID_REPLACE", $array
    );
    get_replacement(
      "Enter the KORA PAGES_SID", "PAGES_SID_REPLACE", $array
    );
    get_replacement(
      "Enter the KORA SUBJECT_SID", "SUBJECT_SID_REPLACE", $array
    );
    get_replacement(
      "Enter the KORA SURVEY_SID", "SURVEY_SID_REPLACE", $array
    );
    get_replacement(
      "Enter the KORA TOKEN", "TOKEN_REPLACE", $array
    );
    return json_encode($array);

  }
  function loop_replace(&$bootstrap,$json){
    $array = (array)json_decode($json, true);
    if(is_array($array)){
      foreach ($array as $key => $val){
       $bootstrap = str_replace($key, $val,$bootstrap);
      }
    }
  }
  function write_to_file($content,$file="app/Config/bootstrap.php"){
      file_put_contents($file, $content);
  }



 ?>
