<?php


  if(sizeof($argv) == 1)
    command_prompt();
  else if(sizeof($argv) == 2){

  }


  function command_prompt(){
      echo "Run Boostrap Configure (Y/N)? ";
      $stdin = fopen('php://stdin', 'r');
      $response = strtoupper(fgetc($stdin));
      if($response == "Y"){
          run_boot_config();
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

  /*
  define ("PID", "123");
  define ("PROJECT_SID", "734");
  define ("SEASON_SID", "735");
  define ("RESOURCE_SID", "736");
  define ("PAGES_SID", "738");
  define ("SUBJECT_SID", "739");
  define ("SURVEY_SID", "740");
  define ("TOKEN", "8b88eecedaa2d3708ebec77a");
  */
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
  function run_boot_config(){
    try{
      $bootstrap = copy_bootstrap();
      $json = replace_sequence();
      loop_replace($bootstrap, $json);
      write_to_file($bootstrap);
    }
    catch(Exception $e){
      echo $e->getMessage() . "\n";
      exit();
    }
  }


 ?>
