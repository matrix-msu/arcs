<?php
require_once("Kora.php");
use Lib\Kora;
// use \App\FieldHelpers\KORA_Clause;
// use \KORA_Clause;
//use App\FieldHelpers\KORA_Search;

class General_Search extends Kora{

  protected $formulatedResult;


  function __construct($pid, $sid, $query1, $query2, $query3, $fields){
      //call parent constructor 'kora'
      parent::__construct();
      /*print_r(array(
          $pid, $sid, $query1, $query2, $query3, $fields
        ));*/
        //set up the kora search parameters for keyword search
        $pName = parent::getProjectNameFromPID($pid);
        $this->token = parent::getTokenFromProjectName($pName);
        $this->projectMapping = $pid;
        $this->schemeMapping = $sid;
        
        $clause1 = new KORA_Clause($query1, $query2, $query3);
        
      $this->The_Clause = $clause1;

      $this->fields = $fields;

      //do the keyword search
      $this->formulatedResult = parent::search();

      //return $this->formulatedResult;

      //format and prepare for a json response
      //$this->format_results();
  }

    public function return_json(){
        return json_encode($this->formulatedResult);
    }
    public function return_array(){
        return $this->formulatedResult;
    }


}
