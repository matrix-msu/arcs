<?php
require_once("Keyword_Search.php");
require_once("Resource.php");

use Lib\Kora\Keyword_Search;
use Lib\Resource;
// use App\FieldHelpers\KORA_Clause;

class Resource_Search extends Keyword_Search {


  function __construct($array, $projectName){
    //call parent constructor 'kora'
    parent::__construct();
	$resourceSearchTimes = array();
    $time_start = microtime(true);
    $mem_start =  memory_get_usage();

    //print_r($array);
    $this->token = parent::getTokenFromProjectName($projectName);
    $this->projectMapping = parent::getPIDFromProjectName($projectName);
    $this->schemeMapping = parent::getResourceSIDFromProjectName($projectName);
    $this->The_Clause = new KORA_Clause("kid","IN",$array);
	//$this->fields = array('kid','Title','Type','Excavation_-_Survey_Associator','Season_Associator','Permissions','Special_User','Resource_Identifier');
	$this->fields = array('ALL');
    $this->formulatedResult = parent::search();
	
	$time_end_temp = microtime(true);
	 $resourceSearchTimes['resources kora search'] = $time_end_temp - $time_start;

    // traverse the database to include excavation,
    // season and project associations;
	$time_start_temp = microtime(true);
    $this->traverse_insert($projectName);
	
	$time_end_temp = microtime(true);
	 $resourceSearchTimes['resources traverse insert'] = $time_end_temp - $time_start_temp;

	 $time_start_temp = microtime(true);
    // get resource filters
    $filters = Resource::filter_analysis($this->formulatedResult);
    //get indicators
    $indicators = Resource::flag_analysis($this->formulatedResult);
	
	$time_end_temp = microtime(true);
	 $resourceSearchTimes['resources filter and flag'] = $time_end_temp - $time_start_temp;
	 
	 // echo 'resources.php search times';
	  // var_dump($resourceSearchTimes);


    $this->adjust_requested_limits(1,100000000);

    $time_end = microtime(true);
    $mem_end = memory_get_usage();

    $time = $time_end - $time_start;
    $total_mem = ($mem_end - $mem_start) / pow(10,9);

    //format and prepare for a json response
    $this->format_results($time,$total_mem,$filters,$indicators);

  }


}
