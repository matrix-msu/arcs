<?php 
require_once(KORA_LIB . "General_Search.php");

class Page{
  
  private $kid = "";
  private $scheme = "";
  private $exist = false;
  private $page;

  function __construct($kid,$scheme){
    $this->kid = $kid;
    $this->scheme = $scheme;
    $page = $this->getPage($this->kid,$this->scheme);
    $this->exist = !empty($page);
    $this->page = $page;
  }
  /**
   * @return if the search was successful
   */
  public function doesExist(){
    return $this->exist;
  }
  public function getPageAttribute($attr){
    return $this->value($attr);
  }
  private function value($value){
    if($this->doesExist()){
      if(isset(array_values($this->page)[0][$value]))
        return array_values($this->page)[0][$value];
      else
        return "Attribute not found";
    }
    else{
      return "Error";
    }
  }
  /**
   * Gets the page fields from kora
   * @param page kid
   * @return page object from kora
   */
  private function getPage($kid, $scheme){
    $query = "kid,=,".$kid;
    $fields = array('ALL');
    $query_array = explode(",", $query);
    $page = new General_Search($scheme, $query_array[0], $query_array[1], $query_array[2], $fields);
    return $page->return_array();
  }
  
}
