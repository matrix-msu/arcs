<?php
namespace Lib\Kora;

require_once("Kora.php");
require_once("Resource.php");



use Lib\Kora;
use Lib\Resource;
use Lib\KORA_Clause;

class Project extends Kora{
    private $project;
    protected $info;
    protected $is_valid;
    public $components = array('Session');

    function __construct($project_name){
      parent::__construct();

      //set name
      $this->project = $project_name;

      //set search for project
      $this->set_search_params();

      // retrieve the project by name
      $this->get_project($project_name);

    }
    public function get_project($project){
      $this->The_Clause = new KORA_Clause("Persistent Name", "=", $project);
      parent::search();

      if(!empty($this->comprehensive_results)){
        $this->is_valid = true;
        $this->info = array_values($this->comprehensive_results)[0];
      }
      else
        $this->is_valid = false;

    }

    private function set_search_params(){
      $this->schemeMapping = PROJECT_SID;
      $this->fields = "ALL";
      $this->results_per_page = 100;
    }
    public function get_description(){
      if($this->is_valid){
        return $this->info["Description"];
      }
      return "";
    }
    public function get_kid(){
      if($this->is_valid){
        return $this->info["kid"];
      }
      return "";
    }

    //Get recent resources associated with a single project, for single-project page
    //takes an array of (8) kids and returns the info
    public function getRecent($recent){
        $this->schemeMapping = RESOURCE_SID;
        $this->fields = array("Title","Type","Resource Identifier");
        $this->The_Clause = new KORA_Clause("kid", "IN", $recent);
        $results = parent::search();
        usort($results, function($a, $b){
            if ($a == $b) {
                return 0;
            }
            $atest = explode('-', $a['kid']);
            $atest = array_pop($atest);
            $atest = hexdec($atest);
            $btest = explode('-', $b['kid']);
            $btest = array_pop($btest);
            $btest = hexdec($btest);
            return ($atest > $btest) ? -1 : 1;
        });
        return $results;
    }
    
    public function getProjectResources(){
        if($this->is_valid){
            $projectKid = $this->get_kid(); //get project kid

            //get all seasons based on project kid
            $this->schemeMapping = SEASON_SID;
            $this->fields = array("Project Associator");
            $this->The_Clause = new KORA_Clause("Project Associator", "=", $projectKid);
            $seasons = parent::search();

            //get an array of the seasons
            $seasonArray = array_keys($seasons);
            //get a season clause for excavations
            $this->The_Clause = new KORA_Clause("Season Associator", "IN", $seasonArray);

            //get all excavations based on the seasons.
            $this->schemeMapping = SURVEY_SID;
            $this->fields = array("Season Associator");
            $surveys = parent::search();

            //get an excavation array.
            $surveyArray = array_keys($surveys);
            //make clauses for the 2 ways resources can be linked.
            $tempClause1 = new KORA_Clause("Excavation - Survey Associator", "IN", $surveyArray);
            $tempClause2 = new KORA_Clause("Season Associator", "IN", $seasonArray);

            //get 8 newest resources based on the excavations and seasons.
            $this->schemeMapping = RESOURCE_SID;
            //$this->fields = array("Title","Type","Resource Identifier", 'systimestamp');
            $this->fields = array("Title");
            $this->The_Clause = new KORA_Clause($tempClause1, 'OR', $tempClause2);
            //$this->sortFields= array(array( 'field' => 'systimestamp', 'direction' => SORT_DESC));
            $this->sortFields= array();
            $this->start = 0;
            $this->end = 0;
            $results = array_keys(parent::search_limited());

            usort($results, function($a, $b){
                if ($a == $b) {
                    return 0;
                }
                $atest = explode('-', $a);
                $atest = array_pop($atest);
                $atest = hexdec($atest);
                $btest = explode('-', $b);
                $btest = array_pop($btest);
                $btest = hexdec($btest);
                return ($atest < $btest) ? -1 : 1;
            });
            return $results;
        }
    return "";

    }


    //project controller to get individual pages.
    public function get_page($resource, $type){
      if($this->is_valid){
        $this->schemeMapping = PAGES_SID;
        $this->fields = array("Image Upload");
        if($type == 'Field journal'){
            $clause1 = new KORA_Clause("Resource Associator", "=", $resource);
            $clause2 = new KORA_Clause("Scan Number", "=", '1');
            $this->The_Clause = new KORA_Clause($clause1, "AND", $clause2);
            $temp = parent::search();
            if( empty($temp) ){
                $this->The_Clause = new KORA_Clause("Resource Associator", "=", $resource);
                $temp = parent::search();
            }
            return $temp;
        }else{
            $this->The_Clause = new KORA_Clause("Resource Associator", "=", $resource);
            return parent::search();
        }
      }
      return "";

    }
    public function get_name(){
      if($this->is_valid){
        return $this->info["Name"];
      }
      return "";
    }
}


/////////////////////////////////////////
