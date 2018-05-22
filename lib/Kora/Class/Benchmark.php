<?php

namespace mb;

class Benchmark{

  private $time_start =0;
  private $time_end = 0;
  private $mem_start =0;
  private $mem_end =0;


  public function start(){
    $this->time_start = microtime(true);
    $this->mem_start = memory_get_usage(); 
  }
  public function end(){
    $this->time_end = microtime(true);
    $this->mem_end = memory_get_usage();
  
  }
  public function clocked(){
    return json_encode(array(
      "TIME" => array(
        "VAL" => ($this->time_end - $this->time_start),
        "UNIT"=> "SECONDS"
      ),
      "MEMORY" => array(
        "VAL" => (($this->mem_end - $this->mem_start) / pow(10,9)),
        "UNIT" => "GB"
      ),
      "PEAK MEMORY" => array(
        "VAL" => (memory_get_peak_usage() / pow(10,9)),
        "UNIT"=> "GB"
      )
    ));
  }

}

?>
