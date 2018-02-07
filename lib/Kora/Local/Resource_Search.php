<?php
require_once("Keyword_Search.php");
require_once("Resource.php");

use Lib\Kora\Keyword_Search;
use Lib\Resource;
use App\FieldHelpers\KORA_Clause;

class Resource_Search extends Keyword_Search {


  function __construct($array, $projectName){
    //call parent constructor 'kora'
    parent::__construct();
    $time_start = microtime(true);
    $mem_start =  memory_get_usage();

    //print_r($array);
    $this->token = parent::getTokenFromProjectName($projectName);
    $this->projectMapping = parent::getPIDFromProjectName($projectName);
    $this->schemeMapping = parent::getResourceSIDFromProjectName($projectName);
    $this->The_Clause = new KORA_Clause("kid","IN",$array);
    $this->formulatedResult = parent::search();

    // traverse the database to include excavation,
    // season and project associations;
    $this->traverse_insert($projectName);

    // get resource filters
    $filters = Resource::filter_analysis($this->formulatedResult);
    //get indicators
    $indicators = Resource::flag_analysis($this->formulatedResult);

    $this->adjust_requested_limits(1,100000000);

    $time_end = microtime(true);
    $mem_end = memory_get_usage();

    $time = $time_end - $time_start;
    $total_mem = ($mem_end - $mem_start) / pow(10,9);

    //format and prepare for a json response
    $this->format_results($time,$total_mem,$filters,$indicators);

  }


}
