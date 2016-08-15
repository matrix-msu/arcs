<?php
require_once("Kora.php");
require_once("Resource.php");

class Keyword_Search extends Kora{

  protected $formulatedResult;
  protected $project_list = array();
  protected $season_list = array();
  protected $excavation_list = array();
  protected $total = 0;


  function __construct($query,$start=1,$end=10000){
      $time_start = microtime(true);
      $mem_start =  memory_get_usage();
      //call parent constructor 'kora'
      parent::__construct();

      //set up the kora search parameters for keyword search
      $this->set_search_parameters($query);

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
  private function set_search_parameters($query){

    $this->token = TOKEN;
    $this->projectMapping = PID;
    $this->schemeMapping = RESOURCE_SID;

    $clause1 = new KORA_Clause("Resouce Identifier","LIKE",$query."%");
    $clause2 = new KORA_Clause("Type","LIKE","%".$query."%");
    $clause3 = new KORA_Clause("Earliest Date","LIKE","%".$query."%");
    $clause4 = new KORA_Clause("Latest Date","LIKE","%".$query."%");
    $clause5 = new KORA_Clause("Accession Number","LIKE",$query."%");
    $clause6 = new KORA_Clause("Access Level","LIKE","%".$query."%");

    $join1and2 = new KORA_Clause($clause1,"OR",$clause2);
    $join3and4 = new KORA_Clause($clause3,"OR",$clause4);
    $join5and6 = new KORA_Clause($clause5,"OR",$clause6);

    $join = new KORA_Clause($join1and2,"OR",$join3and4);

    $this->The_Clause =new KORA_Clause($join,"OR",$join5and6);

    $this->The_Clause = new KORA_Clause("ANY", "LIKE", "%".$query."%");
    $this->fields = array(
      "Excavation - Survey Associator",
      "Title",
      "Type",
      "Resource Identifier",
      "Accession Number",
      "Creator",
      "Creator2"
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

      $this->schemeMapping = PAGES_SID;
      $this->fields = array("Image Upload");

      foreach($this->formulatedResult as $obj){
        if(!empty($obj['kid'])){
          $this->The_Clause = new KORA_Clause("Resource Associator", "=" , $obj['kid']);
          $image = self::search();
          if(isset(array_values($image)[0])){
             $image = array_values($image)[0];
          }
          if(isset($image["Image Upload"])){
              $this->formulatedResult[$obj['kid']]["thumb"] = $this->smallThumb($image["Image Upload"]['localName']);
          }
          else{
            $this->formulatedResult[$obj['kid']]["thumb"] = DEFAULT_THUMB;
          }
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
