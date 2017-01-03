<?php

namespace Lib\Kora;

require_once("Kora.php");
require_once("Resource.php");

require_once("../../app/Controller/SearchController.php");

use Lib\Kora;
use Lib\Resource;
use Lib\KORA_Clause;
use \SearchController;

class Keyword_Search extends Kora{

  protected $formulatedResult;
  protected $project_list = array();
  protected $season_list = array();
  protected $excavation_list = array();
  protected $total = 0;

  /**
  * Constructor
  */
  function __construct($query,$project=null,$start=1,$end=10000){

      $time_start = microtime(true);
      $mem_start =  memory_get_usage();

      //call parent constructor 'kora'
      parent::__construct();

      //set up the kora search parameters for keyword search
      $this->set_search_parameters($query,$project);

      //do the keyword search
      $this->formulatedResult = parent::search();

      // traverse the database to include excavation,
      // season and project associations;
      $this->traverse_insert();

      // get resource filters
      $filters = Resource::filter_analysis($this->formulatedResult);

      //adjust the results to the requested section
      $this->adjust_requested_limits($start,$end);


      $time_end = microtime(true);
      $mem_end = memory_get_usage();

      $time = $time_end - $time_start;
      $total_mem = ($mem_end - $mem_start) / pow(10,9);

      //format and prepare for a json response
      $this->format_results($time,$total_mem,$filters);

  }

  private function format_results($time,$total_mem,$filters){

    $this->formulatedResult = array(

      "total"=>$this->total,
      "time"=>$time,
      "Memory"=>$total_mem . " GB",
      "filters" => $filters,
      "results"=>$this->formulatedResult

    );
    $this->comprehensive_results = $this->formulatedResult;

  }

  /*
    @function adjust_requested_limits
    @return VOID
    set up the kora search parameters for keyword search
  */
  private function adjust_requested_limits($start,$end){

    $this->total = count($this->formulatedResult);
    if($this->total > $end){
      $this->formulatedResult = array_slice($this->formulatedResult, $start, $end);
    }

  }
  /*
    @function set_search_parameters
    @return VOID
    set up the kora search parameters for keyword search
  */
  private function set_search_parameters($query,$project){

    $this->token = TOKEN;
    $this->projectMapping = PID;
    $this->schemeMapping = RESOURCE_SID;

    $clause1 = new KORA_Clause("ANY", "LIKE", "%".$query."%");
    $this->The_Clause = $clause1;

    if($project !== "all"){
    
    	$projectResources = SearchController::getProjectResourceKids($project);

    	if(empty($projectResources))
    		$projectResources = array("none");

   	$clause = new KORA_Clause("kid","IN", $projectResources);
    	  
    	$this->The_Clause =new KORA_Clause($clause1,"AND",$clause);
    }
 
    $this->fields = array(
      "Excavation - Survey Associator",
      "Title",
      "Type",
      "Resource Identifier",
      "Accession Number",
      "Creator",
      "Creator2",
      "systimestamp"
    );

  }

  /*
    @function traverse_data
    @return VOID
    sequence to traverse the data associated with the search
  */
  private function traverse_insert(){

    if(!empty($this->formulatedResult)){
        $this->insertPages();
        $this->insertExcavations();
        $this->insertSeasons();
        $this->insertProjects();
    }

  }

  /*
    returns project List as a key value array

     key 7B-2DF-0 would look like:

    [7B-2DF-0] = "1972"

    ...

  */
  protected function getProjectList(){

    $projects = array();
    $this->projectMapping = PID;
    $this->schemeMapping = PROJECT_SID;
    $this->fields =  array("Persistent Name");
    $this->The_Clause = new KORA_Clause("kid", "!=", "");

    self::search();

    foreach ($this->comprehensive_results as $key => $value) {
      $projects[$key] = $value['Persistent Name'];
    }
    return $projects;

  }
  /*
    returns season List as a key value array

     key 7B-2DF-0 would look like:

    [7B-2DF-0] = [
        Title => "1972",
        Project Associator => "7B-2DE-0"
    ]

    ...

  */
  protected function getSeasonList(){

    $season = array();
    $this->projectMapping = PID;
    $this->schemeMapping = SEASON_SID;
    $this->fields = array("Title", "Project Associator");
    $this->The_Clause = new KORA_Clause("kid", "!=", "");

    self::search();

    foreach ($this->comprehensive_results as $key => $value) {
      $projAssoc = isset($value["Project Associator"][0])?$value["Project Associator"][0]:"";
      $season[$key] = array(
        "Name" => $value['Title'],
        "Project Associator" => $projAssoc
      );
    }
    return $season;

  }

  /*
    returns excavation List as a key value array

     key 7B-2DF-0 would look like:

    [7B-2DF-0] = [
        Name => "1972",
        Season Associator => "7B-2DE-0"
    ]

    ...

  */
  protected function getExcavationList(){

    $excavation = array();
    $this->projectMapping = PID;
    $this->schemeMapping = SURVEY_SID;
    $this->fields = array("Name", "Season Associator","Type");
    $this->The_Clause = new KORA_Clause("kid", "!=", "");

    self::search();

    foreach ($this->comprehensive_results as $key => $value) {
      $seasonAssoc = isset($value["Season Associator"][0])?$value["Season Associator"][0]:"";
      $excavation[$key] = array(
        "Name" => $value['Name'],
        "Type" => $value['Type'],
        "Season Associator" => $seasonAssoc

      );
    }
    return $excavation;

  }

  public function insertPages(){

      $pageArray = array();
      $this->schemeMapping = PAGES_SID;
      $this->fields = array("Image Upload", "Resource Associator");
      $this->The_Clause = new KORA_Clause("kid", "!=" , "");

      // //debug
      // $time_start = microtime(true);
      // $mem_start =  memory_get_usage();
       $images = self::search();

      foreach($images as $img){
        $pKid = $img['kid'];
        if(isset($img["Resource Associator"]) && is_array($img["Resource Associator"])){
          foreach($img["Resource Associator"] as $rKid){
            if(!isset($pageArray[$rKid]))
             $pageArray[$rKid] = isset($img["Image Upload"]['localName'])?
             $img["Image Upload"]['localName'] : "none" ;
          }
        }
      }
      // $time_e = microtime(true);
      // $mem_e =  memory_get_usage();
      //
      // echo "<p>time: </p>" . ($time_e - $time_start);
      // echo "<p>mem: " . ($mem_e - $mem_start);
      // echo "</p><br>";
      // echo "count: " . count($image);
      // exit();



      foreach($this->formulatedResult as $obj){
        if(isset($pageArray[$obj['kid']])){
          $this->formulatedResult[$obj['kid']]["thumb"] = $this->smallThumb($pageArray[$obj['kid']]);
        }
        else{
          $this->formulatedResult[$obj['kid']]["thumb"] = DEFAULT_THUMB;
        }
      }
  }

  private function insertExcavations(){

    $this->excavation_list = self::getExcavationList();

    foreach ($this->formulatedResult as $key => $value) {

      $newkey = isset($value["Excavation - Survey Associator"][0])?
      $value["Excavation - Survey Associator"][0]: "";

      if(array_key_exists($newkey,$this->excavation_list)){

        $this->formulatedResult[$key]["Excavation Name"] = $this->excavation_list[$newkey]["Name"];
        $this->formulatedResult[$key]["Excavation Type"] = $this->excavation_list[$newkey]["Type"];
        $this->formulatedResult[$key]["Season Associator"] = $this->excavation_list[$newkey]["Season Associator"];
      }
      else{
          $this->formulatedResult[$key]["Excavation Name"] = "";
          $this->formulatedResult[$key]["Season Associator"] = "";
      }
    }

  }
  private function insertSeasons(){

    $this->season_list = self::getSeasonList();
    foreach ($this->formulatedResult as $key => $value) {

      $newkey = isset($value["Season Associator"])?
      $value["Season Associator"]: "";

      if(array_key_exists($newkey,$this->season_list)){

        $this->formulatedResult[$key]["Season Name"] = $this->season_list[$newkey]["Name"];
        $this->formulatedResult[$key]["Project Associator"] = $this->season_list[$newkey]["Project Associator"];
      }
      else{
          $this->formulatedResult[$key]["Season Name"] = "";
          $this->formulatedResult[$key]["Project Associator"] = "";
      }
    }

  }
  private function insertProjects(){

    $this->project_list = self::getProjectList();
    foreach ($this->formulatedResult as $key => $value) {

      $newkey = isset($value["Project Associator"])?
      $value["Project Associator"]: "";

      if(array_key_exists($newkey,$this->project_list)){

        $this->formulatedResult[$key]["Project Name"] = $this->project_list[$newkey];
      }
      else{
          $this->formulatedResult[$key]["Project Name"] = "";
      }
    }

  }



}
