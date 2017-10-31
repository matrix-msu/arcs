<?php
namespace kora\classes;

class AdvancedFieldDataStructure {
    public $season = array(
        "title"    => "",
        "type"     => "",
        "director"=> "",
    );
    public $excavation = array(
        "name"        => "",
        "type"        => "",
        "supervisors" => "",
    );
    public $resource = array(
        "identifier"    => "",
        "type"          => "",
        "title"          => "",
        "creators"      => "",
        "role"          => "",
        "earliest_date" =>  array(
            "year"  => "",
            "month" => "",
            "day"   => "",
            "era"   => "",
        ),
        "latest_date"   =>  array(
            "year"  => "",
            "month" => "",
            "day"   => "",
            "era"   => "",
        ),
        "languages"     => "",
        "transcription" => "",
        "date_range"   =>  array(
            "start_year"  => "",
            "end_year" => "",
        ),
    );
    public $page = array(
        "scan_date"    => array(
            "year"  => "",
            "month" => "",
            "day"   => "",
            "era"   => "",
        ),
        "scan_creator" => ""
    );
    public $subjectGeneral = array(
        "classification" => "",
        "type"          => "",
        "materials"      => "",
        "techniques"     => "",
        "period"         => "",
        "terminus_ante_quem" => array(
            "year"  => "",
            "month" => "",
            "day"   => "",
            "era"   => "",
        ),
        "terminus_post_quem" => array(
            "year"  => "",
            "month" => "",
            "day"   => "",
            "era"   => "",
        )
    );
    public $subjectDetailed = array(
        "location"         => "",
        "excavation_units" => "",
        "inscription"      => ""
    );

}
class AdvancedFieldMap{
    public $season = array(
        "title"    => "Title",
        "type"     => "Type",
        "director"=> "Director",
    );
    public $excavation = array(
        "name"        => "Name",
        "type"        => "Type",
        "supervisors" => "Supervisor",
    );
    public $resource = array(
        "identifier"    => "Resource Identifier",
        "type"          => "Type",
        "title"          => "Title",
        "creators"      =>  "Creator",
        "role"          => "Creator Role",
        "earliest_date" => "Earliest Date",
        "latest_date"   => "Latest Date",
        "languages"     => "Language",
        "transcription" => "Transcription",
        'date_range' => "Date Range",
    );
    public $page = array(
        "scan_date"    => "Scan Date",
        "scan_creator" => "Scan Creator"
    );
    public $subjectGeneral = array(
        "classification" => "Artifact - Structure Classification",
        "type"          => "Artifact - Structure Type",
        "materials"      => "Artifact - Structure Material",
        "techniques"     => "Artifact - Structure Technique",
        "period"         => "Artifact - Structure Period",
        "terminus_ante_quem" => "Artifact - Structure Terminus Ante Quem",
        "terminus_post_quem" => "Artifact - Structure Terminus Post Quem"
    );
    public $subjectDetailed = array(
        "location"         => "Artifact - Structure Location",
        "excavation_units" => "Artifact - Structure Excavation Unit",
        "inscription"      => "Artifact - Structure Inscription"
    );

}
/*


*/
class AFDSFactory {

  public static function getDateFromQuery($date) {
    $comp = explode("-",$date);
    if(count($comp) === 3){
      return array(
        "year"  => $comp[0] == "00" ? "%" : (int) $comp[0],
        "month" => $comp[1] == "00" ? "%" : (int) $comp[1],
        "day"   => $comp[2] == "00" ? "%" : (int) $comp[2],
        "era"   => ""
      );
    }
    else if(count($comp) === 4){
      return array(
        "year"  => $comp[0] == "00" ? "%" : (int) $comp[0],
        "month" => $comp[1] == "00" ? "%" : (int) $comp[1],
        "day"   => $comp[2] == "00" ? "%" : (int) $comp[2],
        "era"   => $comp[3]
      );
    }else if(count($comp) === 2){ //is date range
        return array(
            "start_year" => $comp[0] == "00" ? "%" : (int) $comp[0],
            "end_year" => $comp[1] == "00" ? "%" : (int) $comp[1]
        );
    }
    return array(
      "year"  => "",
      "month" => "",
      "day"   => "",
      "era"   => ""
    );
  }
  public static function isEmptyDataStructure($ds) {
    if (get_class($ds) != "kora\classes\AdvancedFieldDataStructure") {
        throw new Exception("Expected an Advanced Field Data Structure");
    }
    foreach ($ds as $subds) {
      foreach ($subds as $data ) {
        if (is_array($data)) {
          foreach ($data as $subdate) {
            if (!empty($subdate)) {
              return false;
            }
          }
        } else {
          if (!empty($data)) {
            return false;
          }
        }
      }
    }
    return true;
  }
  public static function create($array) {

    $ds = new AdvancedFieldDataStructure();

    $prefix = "season-";
    foreach ($ds->season as $key => $value) {
      $queryKey = $prefix . $key;
      //check for matching query parameter
      if(isset($array[$queryKey])){
        if (is_array($ds->season[$key])) {
          $ds->season[$key] = self::getDateFromQuery($array[$queryKey]);
        } else {
          $ds->season[$key] = $array[$queryKey];
        }
      }
    }

    $prefix = "excavation-";
    foreach ($ds->excavation as $key => $value) {
      $queryKey = $prefix . $key;
      //check for matching query parameter
      if(isset($array[$queryKey])){
        if (is_array($ds->excavation[$key])) {
          $ds->excavation[$key] = self::getDateFromQuery($array[$queryKey]);
        } else {
          $ds->excavation[$key] = $array[$queryKey];
        }
      }
    }

    $prefix = "resource-";
    foreach ($ds->resource as $key => $value) {
      $queryKey = $prefix . $key;
      //check for matching query parameter
      if(isset($array[$queryKey])){
        if (is_array($ds->resource[$key])) {
          $ds->resource[$key] = self::getDateFromQuery($array[$queryKey]);
        } else {
          $ds->resource[$key] = $array[$queryKey];
        }
      }
    }
    $prefix = "page-";
    foreach ($ds->page as $key => $value) {
      $queryKey = $prefix . $key;
      //check for matching query parameter
      if(isset($array[$queryKey])){
        if (is_array($ds->page[$key])) {
          $ds->page[$key] = self::getDateFromQuery($array[$queryKey]);
        } else {
          $ds->page[$key] = $array[$queryKey];
        }
      }
    }
    $prefix = "subject-general-";
    foreach ($ds->subjectGeneral as $key => $value) {
      $queryKey = $prefix . $key;
      //check for matching query parameter
      if(isset($array[$queryKey])){
        if (is_array($ds->subjectGeneral[$key])) {
          $ds->subjectGeneral[$key] = self::getDateFromQuery($array[$queryKey]);
        } else {
          $ds->subjectGeneral[$key] = $array[$queryKey];
        }
      }
    }
    $prefix = "subject-detailed-";
    foreach ($ds->subjectDetailed as $key => $value) {
      $queryKey = $prefix . $key;
      //check for matching query parameter
      if(isset($array[$queryKey])){
        if (is_array($ds->subjectDetailed[$key])) {
          $ds->subjectDetailed[$key] = self::getDateFromQuery($array[$queryKey]);
        } else {
          $ds->subjectDetailed[$key] = $array[$queryKey];
        }
      }
    }
    return $ds;
  }

}
