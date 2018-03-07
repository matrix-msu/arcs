<?php
/*
Author: Austin Rix
*/
/*
 @class Kora
*/
/*
                    (project)
                    /     \
                  /        \
              (season)    ('')
              /     \
            /        \
  (excavation)   (excavation)
      |              |
      |              |
      |              |
(Resources ...) (Resources ...)

*/

namespace Lib;
use \AppController;
require_once(KORA_SEARCH);
use function \App\FieldHelpers\KORA_Search;

require_once(KORA_LIB . "Kora3_Util.php");
use Lib\Kora3\Kora3_Util;



class Kora extends AppController{

    protected $token;
    protected $projectMapping;
    protected $schemeMapping;
    protected $The_Clause;
    protected $sortFields;
    protected $results_per_page;
    protected $comprehensive_results;
    protected $fields;
    protected $start;
    protected $end;

    function __construct(){

      $this->token = TOKEN;
      //$this->projectMapping = PID;
      //$this->schemeMapping = PROJECT_SID;
      $this->fields = "ALL";
      $this->results_per_page = 100;
    }
    public function search(){

        $this->comprehensive_results = KORA_Search(

            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields
        );
        if( $this->comprehensive_results == null ){
            $this->comprehensive_results = array();
        }
        foreach($this->comprehensive_results as $kid => $record_values){
            if( is_string($record_values) ){continue;}
            foreach( $record_values as $key => $value ){
                if (strpos($key, ' ') !== false) {
                    $this->comprehensive_results[$kid][str_replace(' ','_',$key)] = $value;
                    unset($this->comprehensive_results[$kid][$key]);
                }
            }
        }
        return $this->comprehensive_results;
    }

    protected function search_limited(){
        if( $this->start == 0 ){
            $this->start = null;
        }
        if( $this->end == 0 ){
            $this->end = null;
        }
        $this->comprehensive_results = KORA_Search(
            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields,
            $this->sortFields,
            $this->start,
            $this->end
        );
        if( $this->comprehensive_results == null ){
            $this->comprehensive_results = array();
        }
        foreach($this->comprehensive_results as $kid => $record_values){
            if( is_string($record_values) ){continue;}
            foreach( $record_values as $key => $value ){
                if (strpos($key, ' ') !== false) {
                    $this->comprehensive_results[$kid][str_replace(' ','_',$key)] = $value;
                    unset($this->comprehensive_results[$kid][$key]);
                }
            }
        }
        return $this->comprehensive_results;
    }
    protected function MPF(){

        $this->comprehensive_results = MPF_Search(
            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields,
            $this->sortFields
        );
        if( $this->comprehensive_results == null ){
            $this->comprehensive_results = array();
        }
        foreach($this->comprehensive_results as $kid => $record_values){
            if( is_string($record_values) ){continue;}
            foreach( $record_values as $key => $value ){
                if (strpos($key, ' ') !== false) {
                    $this->comprehensive_results[$kid][str_replace(' ','_',$key)] = $value;
                    unset($this->comprehensive_results[$kid][$key]);
                }
            }
        }
        return $this->comprehensive_results;
    }
    // public setter functions to change
    // search parameters.
    public function setToken($string){
        $this->token = $string;
    }
    public function setProject($int){
        $this->projectMapping = $int;
    }
    public function setScheme($int){
        $this->schemeMapping = $int;
    }
    public function setFields($array){
        $this->fields = $array;
    }
    public function setClause($array){
        $this->The_Clause = $array;
    }
    public function setSortFields($array){
        $this->sortFields = $array;
    }

    public function print_json(){

        //start compression handler
        ob_start('ob_gzhandler');

        if(!empty($this->comprehensive_results)){
            echo json_encode($this->comprehensive_results);
        }
        else{
            echo json_encode(array("empty"));
        }

        //end compression
        ob_end_flush();
    }
    public static function to_json($array){
        return json_encode($array);
    }
  public function getResultsAsArray(){
    return $this->comprehensive_results;
  }
  public function kora2LegacyResults() {
    $res = array();
    if (empty($this->comprehensive_results)){
        return;
    }
    $recordsK3 = $this->comprehensive_results->Records;
    foreach ($recordsK3 as $record) {
        $res[] = Kora3_Util::k3RecordToK2($record, $this->projectMapping, $this->schemeMapping);
    }
    return $res;
  }
}

