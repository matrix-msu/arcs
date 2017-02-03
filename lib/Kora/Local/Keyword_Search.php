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
  function __construct(){
    //call parent constructor 'kora'
    parent::__construct();
  }

  public function execute($query,$project=null,$start=1,$end=10000){

      $time_start = microtime(true);
      $mem_start =  memory_get_usage();
 
      $resourcesFromSOO = $this->search_soo($query,$project);
      
      $clause = $this->clauseGen("OR","LIKE",
        array(
          "Resource Identifier","Type","Earliest Date","Latest Date","Accession Number"
        ),$query
      
      );
      //set up the kora search parameters for keyword search on RESOURCE
      $this->set_search_parameters($query,$project,RESOURCE_SID,$clause);

      //do the keyword search
      $resourcesFromResource = parent::search();
      
      $this->formulatedResult = array_merge($resourcesFromResource,$resourcesFromSOO);
      
      $extra_data = array(
        "Return_Count_SOO"=>count($resourcesFromSOO),
        "Return_Count_Resource"=>count($resourcesFromResource), 
      );
        
      // traverse the database to include excavation,
      // season and project associations;
      $this->traverse_insert();

      // get resource filters
      $filters = Resource::filter_analysis($this->formulatedResult);
      //get indicators
      $indicators = Resource::flag_analysis($this->formulatedResult);

      //adjust the results to the requested section
      $this->adjust_requested_limits($start,$end);

      $time_end = microtime(true);
      $mem_end = memory_get_usage();

      $time = $time_end - $time_start;
      $total_mem = ($mem_end - $mem_start) / pow(10,9);

      //format and prepare for a json response
      $this->format_results($time,$total_mem,$filters,$indicators,$extra_data);

  }
  private function search_soo($query, $project){
    
      //set up the kora search parameters for keyword search on SOO
      $clause = $this->clauseGen(
        "OR",
        "LIKE",
        array(
          "Artifact - Structure Classification","Artifact - Structure Type",
          "Artifact - Structure Material","Artifact - Structure Technique",
          "Artifact - Structure Period","Artifact - Structure Terminus Ante Quem",
          "Artifact - Structure Terminus Post Quem"
        ),$query
      ); 
      $this->set_search_parameters($query,$project,SUBJECT_SID,$clause,array("Pages Associator"));

      //search on soo level
      $soo = parent::search();
      if(empty($soo))
        return array();

      $pages = $this->mergeIntoArray($soo,"Pages Associator");
      
      $clause = new KORA_Clause("kid","IN",$pages); 
      $this->set_search_parameters($query,$project,PAGES_SID,$clause,array("Resource Associator")); 
      $page = parent::search();

      if(empty($page))
        return array();
       
      $resources = $this->mergeIntoArray($page, "Resource Associator");
       
      $clause = new KORA_Clause("kid","IN",$resources); 
      $this->set_search_parameters($query,$project,RESOURCE_SID,$clause,NULL); 
      $resourcesWithFields = parent::search();

 
      return $resourcesWithFields;    
  }
  private function clauseGen($join,$condition,$array,$query){
    if(empty($array))
      return array();
    
    $clauses = array();
    foreach($array as $term){
      $clause = new KORA_Clause($term,$condition,"%$query%");
      array_push($clauses,$clause);
    }
    $joins = $clauses[0];
    for($i = 1; $i < count($clauses); $i++){
     $joins = new KORA_Clause($joins,$join,$clauses[$i]);
    }
    return $joins;
  }
  /* 
   * 
   * combines all results into one array.
   * only the attribute (Kora return field) is merged 
   * removes all duplicates
   *
   */
  private function mergeIntoArray($input_array, $attribute){
    $return_array = array();
    //combine all results pages into an array
    foreach($input_array as $kid){
      if(isset($kid[$attribute]) && is_array($kid[$attribute])){  
     
        $associator = $kid[$attribute];
        $difference = array_diff($associator,$return_array); 
     
        foreach($difference as $one){
          array_push($return_array,$one);
        }
     
      }
    
    }
    //ensure array has no duplicates
    return  array_unique($return_array);
  }

  protected function format_results($time,$total_mem,$filters,$indicators,$data=array()){

    $this->formulatedResult = array(

      "total"=>$this->total,
      "time"=>$time,
      "Memory"=>$total_mem . " GB",
      "filters" => $filters,
      "indicators"=> $indicators,
      "data" => $data,
      "results"=>$this->formulatedResult

    );
    $this->comprehensive_results = $this->formulatedResult;

  }

  /*
    @function adjust_requested_limits
    @return VOID
    set up the kora search parameters for keyword search
  */
  protected function adjust_requested_limits($start,$end){

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
  private function set_search_parameters($query,$project,$scheme,$clause=NULL,$fields=NULL){

    $this->token = TOKEN;
    $this->projectMapping = PID;
    $this->schemeMapping = $scheme;

    $clause1 = new KORA_Clause("ANY", "LIKE", "%".$query."%");
    
    $this->The_Clause = $clause1;

    if($project !== "all" && $scheme === RESOURCE_SID){
    
    	$projectResources = SearchController::getProjectResourceKids($project);

    	if(empty($projectResources))
    		$projectResources = array("none");

   	  $clause2 = new KORA_Clause("kid","IN", $projectResources);
    	  
    	$this->The_Clause =new KORA_Clause($clause1,"AND",$clause2);
    }
    if($clause != NULL){
      $this->The_Clause = $clause;
    }

    if(empty($fields)){ //default fields
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
    else{
      $this->fields = $fields;
    }
  }

  /*
    @function traverse_data
    @return VOID
    sequence to traverse the data associated with the search
  */
  protected function traverse_insert(){

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
