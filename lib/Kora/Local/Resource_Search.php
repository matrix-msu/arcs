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
    $time_start = microtime(true);
    $mem_start =  memory_get_usage();

    //print_r($array);
//    $this->token = parent::getTokenFromProjectName($projectName);
    $this->projectMapping = parent::getPIDFromProjectName($projectName);
    $this->schemeMapping = parent::getResourceSIDFromProjectName($projectName);
//    $this->The_Clause = new KORA_Clause("kid","IN",$array);
//	$this->fields = array('kid','Title','Type','Excavation_-_Survey_Associator','Season_Associator','Permissions','Special_User','Resource_Identifier');
//	$this->fields = array('ALL');


    $fields = array('Title','Type','Excavation_-_Survey_Associator','Season_Associator','Permissions','Special_User','Resource_Identifier','linkers');
    //$fields = array('Title');
    $pid = parent::getPIDFromProjectName($projectName);
    $sid = parent::getResourceSIDFromProjectName($projectName);
    $tempFields = array();
    $fieldExt = '_'.$pid.'_'.$sid.'_';
    foreach( $fields as $index => $field ) {
        $tempFields[$index] = $fields[$index] . $fieldExt;
    }
    $query = array(
      'forms'=>json_encode(array(
          array(
              'form'=>parent::getResourceSIDFromProjectName($projectName),
              'token'=>parent::getTokenFromProjectName($projectName),
              'fields'=>$tempFields,
              //'format'=>'KORA_OLD',
              'query'=>array(
                  array(
                      'search'=>'kid',
                      'kids'=>$array,
                  )
              )
          )
      ))
    );

    $url = KORA_RESTFUL_URL.'search';
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $resource = curl_exec($ch);
    curl_close($ch);

//    echo 'hi';
//      var_dump($query);
//      die;
//    print_r(json_decode($resource, true)['records'][0]);
//die;
    $this->formulatedResult = array();
    foreach( json_decode($resource, true)['records'][0] as $kid => $value ){
        $template = array(
//            'kid' => '',
//            'pid' => '',
            'Title' => '',
            'Type' => '',
            'Excavation_-_Survey_Associator' => '',
            'Season_Associator' => '',
            'Permissions' => '',
            'Special_User' => '',
            'Resource_Identifier' => ''
        );
        foreach( $fields as $field ){
            if( isset($value[$field.$fieldExt]) ){
                $template[$field] = $value[$field.$fieldExt]['value'];
            }else{
                unset($template[$field]);
            }
        }
        $template['kid'] = $kid;
//        $template['pid'] = $kid;
        $this->formulatedResult[$kid] = $template;
    }
    unset($resource);
//    print_r($this->formulatedResult);
//    die;


    //$this->formulatedResult = parent::search();

    //var_dump($this->formulatedResult);die;

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
