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
require_once("KoraSearch.php");
// use function \App\FieldHelpers\KORA_Search;

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
    protected $kidsNoData = false;

    function __construct(){

        if(!is_link(LIB . "Kora/search")){
            //Create Symbolic link to local kora_search
            symlink(KORA_SEARCH,LIB . "Kora/search");
        }
//        $version = phpversion();
//        $first_num = (int)$version[0];
//        if ($first_num <= 5){
//            require_once(LIB . "Kora/search");
//        }

        // $this->token = TOKEN;
        //$this->token = $GLOBALS['TOKEN_ARRAY'];
        //$this->projectMapping = PID;
        //$this->schemeMapping = PROJECT_SID;
        $this->fields = "ALL";
        $this->results_per_page = 100;
    }
    public function search(){

        $this->token = $this->getTOKENFromPid($this->projectMapping);


        $this->comprehensive_results = KORA_Search(

            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields,
            array(),
            null,
            null,
            array(),
            true,
			$this->kidsNoData

        );
        if( $this->comprehensive_results == null ){
            $this->comprehensive_results = array();
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
        $this->token = $this->getTOKENFromPid($this->projectMapping);

        $this->comprehensive_results = KORA_Search(
            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields,
            $this->sortFields,
            $this->start,
            $this->end,
            array(),
            true,
			$this->kidsNoData
        );
        if( $this->comprehensive_results == null ){
            $this->comprehensive_results = array();
        }
        return $this->comprehensive_results;
    }
    protected function MPF(){

        $this->token = $this->getTOKENFromPid($this->projectMapping);

        $this->comprehensive_results = MPF_Search(
            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields,
            $this->sortFields,
            null,
            null,
            array(),
            true,
			$this->kidsNoData
        );
        if( $this->comprehensive_results == null ){
            $this->comprehensive_results = array();
        }
        return $this->comprehensive_results;
    }
    // public setter functions to change
    // search parameters.
    public function setToken($string){
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

    public static function getTOKENFromPid($pid){
        if (isset($GLOBALS['PID_ARRAY'])) {
            if ( array_search($pid, $GLOBALS['PID_ARRAY']) ) {
                $name = array_search($pid, $GLOBALS['PID_ARRAY']);
                if (isset($GLOBALS['TOKEN_ARRAY'])) {
                    if (isset($GLOBALS['TOKEN_ARRAY'][$name])) {
                        return $GLOBALS['TOKEN_ARRAY'][$name];
                    } else {
                        throw new Exception('Token not set');
                    }
                } else {
                    throw new Exception('Token array set');
                }
            } else {
                throw new Exception('Pid not set');
            }
        } else {
            throw new Exception('Pid array set');
        }
    }
}
