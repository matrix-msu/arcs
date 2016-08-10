<?php
//include(KORA_SEARCH);
class KoraController {

    protected $token;
    protected $projectMapping;
    protected $schemeMapping;
    protected $The_Clause;
    protected $sortFields;
    protected $results_per_page;
    protected $comprehensive_results;
    protected $fields;

    function __construct(){

        $this->token = TOKEN;
        $this->projectMapping = PID;
        $this->schemeMapping = PROJECT_SID;
        $this->fields = "ALL";
        //$this->The_Clause = new KORA_Clause();
        $this->results_per_page = 100;

    }

    protected function search(){

        $this->comprehensive_results = KORA_Search(

            $this->token,
            $this->projectMapping,
            $this->schemeMapping,
            $this->The_Clause,
            $this->fields
        );
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
        return $this->comprehensive_results;
    }
    public function project_search(){

      $this->comprehensive_results = self::search();
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


}

///*\
// *
// *  Author: Austin Rix
// *
//\*/
//class Quilt{
//
//    protected $token;
//    protected $projectMapping;
//    protected $schemeMapping;
//    protected $The_Clause;
//    protected $sortFields;
//    protected $results_per_page;
//    protected $comprehensive_results;
//    protected $fields;
//
//
//    function __construct(){
//
//
//    }
//    protected function MPF(){
//
//        $this->comprehensive_results = MPF_Search(
//
//            $this->token,
//            $this->projectMapping,
//            $this->schemeMapping,
//            $this->The_Clause,
//            $this->fields,
//            $this->sortFields
//
//        );
//        return $this->comprehensive_results;
//
//    }
//    protected function search(){
//
//        $this->comprehensive_results = KORA_Search(
//
//            $this->token,
//            $this->projectMapping,
//            $this->schemeMapping,
//            $this->The_Clause,
//            $this->fields
//        );
//        return $this->comprehensive_results;
//
//    }
//    public function MPF_Limited($start, $end){
//
//        $this->comprehensive_results = MPF_Search(
//
//            $this->token,
//            $this->projectMapping,
//            $this->schemeMapping,
//            $this->The_Clause,
//            $this->fields,
//            $this->sortFields,
//            $start,
//            $end
//
//        );
//        return $this->comprehensive_results;
//
//    }
//    public function setToken($string){
//        $this->token = $string;
//    }
//    public function setProject($int){
//        $this->projectMapping = $int;
//    }
//    public function setScheme($int){
//        $this->schemeMapping = int;
//    }
//    public function setFields($array){
//        $this->fields = $array;
//    }
//    public function setClause($array){
//        $this->The_Clause = $array;
//    }
//    public function setSortFields($array){
//        $this->sortFields = $array;
//    }
//    public function getCount(){
//        if($this->comprehensive_results != "")
//            return $this->comprehensive_results['count'];
//        return "Invalid, search results not found";
//    }
//    public function varDump(){
//        print_r("token " . $this->token . " ; ");
//        print_r($this->projectMapping);
//        echo " ; ";
//        print_r($this->schemeMapping);
//        echo " ; ";
//        print_r($this->The_Clause);
//        echo " ; ";
//        print_r($this->fields);
//        echo " ; ";
//        print_r($this->sortFields);
//        echo " ; ";
//        print_r($this->comprehensive_results);
//    }
//
//    static public function format(&$string, $notFoundMessage = "Not Specified"){
//        if($string == null || $string == "" || $string == " " ||
//           $string == "<br>")
//        {
//            $string = $notFoundMessage;
//        }
//        return $string;
//    }
//}
