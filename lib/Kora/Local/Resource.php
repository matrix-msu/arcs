<?php


class Resource {
  function __construct(){

  }
  public static function filter_analysis($array){
    $sites = array();
    $seasons = array();
    $type = array();
    $excavation = array();
    $creator = array();

    foreach($array as $key => $value){
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
    // print_r($sites);
    // echo "</br>";
    // print_r($seasons);
    // echo "</br>";
    // print_r($type);
    // echo "</br>";
    // print_r($excavation);
    // echo "</br>";
    // print_r($creator);
    // echo "</br>";

    return array(
      "sites"=> $sites,
      "seasons" => $seasons,
      "types" => $type,
      "excavations" => $excavation,
      "creators" => $creator
    );
  }

}
