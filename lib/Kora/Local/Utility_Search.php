<?php
namespace lib\kora\local;

require_once("Kora.php");
require_once("Advanced_Field_Search.php");

use Lib\Kora;
//use Lib\KORA_Clause;
// use \App\FieldHelpers\KORA_Clause;
use kora\local\Advanced_Field_Search;

class Utility_Search extends Kora{

  function __construct(){
      //call parent constructor 'kora'
      parent::__construct();
  }
  public function getResourcesFromPages($pageAray, $project) {
    $this->token          = parent::getTokenFromProjectName($project);
    $this->projectMapping = parent::getPIDFromProjectName($project);
    $this->schemeMapping  = parent::getPageSIDFromProjectName($project);
    $this->fields         = array("Resource Associator");
    $this->The_Clause     = new KORA_Clause("kid", "IN", $pageAray);

    $pages = parent::search();

    if (!empty($pages)) {
        $associators = Advanced_Field_Search::getAssociatorLinks(
          $pages, "Resource Associator"
        );

        $this->schemeMapping = parent::getResourceSIDFromProjectName($project);
        $this->The_Clause    = new KORA_Clause("kid", "IN", $associators);
        $this->fields        = array("Title");
        $resources = parent::search();

        return array_keys($resources);

    }

    return array("empty");
  }

}
