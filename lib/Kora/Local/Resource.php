<?php




namespace Lib;
use \DATABASE_CONFIG;
use \mysqli;

class Resource {
  function __construct(){

  }
  public static function filter_analysis($array){
    $sites = array();
    $seasons = array();
    $type = array();
    $excavation = array();
    $creator = array();
    $projects = array();
    if(!empty($array) && is_array($array)){
      foreach($array as $key => $value){
        if( !empty($value["Project Name"]) && !in_array($value["Project Name"], $projects) ){
          array_push($projects, $value["Project Name"]);
        }
        if( !empty($value["Type"]) && !in_array($value["Type"], $type) ){
          array_push($type, $value["Type"]);
        }
        if( !empty($value["Season Name"]) && !in_array($value["Season Name"], $seasons) ){
          array_push($seasons, $value["Season Name"]);
        }
        if( !empty($value["Excavation Name"]) && !in_array($value["Excavation Name"], $sites) ){
          array_push($sites, $value["Excavation Name"]);
        }
        if( !empty($value["Excavation Type"]) && !in_array($value["Excavation Type"], $excavation) ){
          array_push($excavation, $value["Excavation Type"]);
        }
        if( !empty($value["Creator"]) ){
          foreach($value["Creator"] as $person){
            if(!in_array($person, $creator))
              array_push($creator, $person);
          }
        }
      }
    }
    return array(
      "projects"=>$projects,
      "sites"=> $sites,
      "seasons" => $seasons,
      "types" => $type,
      "excavations" => $excavation,
      "creators" => $creator
    );

  }
  public static function flag_analysis($array){

    $kids = [];
    $results = [];
    if(!is_array($array) || empty($array)){
      return array();
    }
    foreach($array as $resource){
      $kid = $resource['kid'];
      array_push($kids,$kid);
      $results[$kid] = array(
        "hasFlags"=>false,
        "hasAnnotations"=>false,
        "hasCollections"=>false,
        "hasComments"=>false,
        "hasKeywords"=>false
      );
    }

    Resource::getResourcesWith($kids,$table="flags",$results);
    Resource::getResourcesWith($kids,$table="annotations",$results);
    Resource::getResourcesWith($kids,$table="comments",$results);
    Resource::getResourcesWith($kids,$table="collections",$results);
    Resource::getResourcesWith($kids,$table="keywords",$results);

    return $results;
  }
  private static function getResourcesWith($kids,$table,&$return_array){

    $mysqli = Resource::getConnection();
    $attribute = "has".ucfirst($table);
    if($mysqli){
      $kidString = join("','",$kids);
      $statement = "SELECT * FROM $table WHERE resource_kid IN ('$kidString')";
      $result = $mysqli->query($statement);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $kid = $row["resource_kid"];
          $return_array[$kid][$attribute] = true;
        }
      }
      $mysqli->close();
    }
  }

  private static function getConnection(){
    $db = new DATABASE_CONFIG;
    $db_object =  (object) $db;
    $db_array = $db_object->{'default'};
    $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);
    if ($mysqli->connect_error)
      return false;
    return $mysqli;
  }

}
