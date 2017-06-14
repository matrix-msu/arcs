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