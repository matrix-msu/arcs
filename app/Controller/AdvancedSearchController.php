<?php

include_once(KORA_LIB . "Advanced_Field_Search.php");
require_once(KORA_LIB . "../Class/AdvancedFieldDataStructure.php");
require_once(KORA_LIB . "Resource_Search.php");
require_once(KORA_LIB . "Kora.php");

use Lib\Kora;
use kora\local\Advanced_Field_Search;
use kora\classes\AdvancedFieldDataStructure as AdvancedDS;
use kora\classes\AFDSFactory;


class AdvancedSearchController extends AppController
{
    public $helpers = array("Search");
    /**
     * Before filter acts as a contructor
     * and is excuted before any controller functions
     * are called
     *
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(
            array(
            'display',
            "viewer",
            'SearchAPI'
            )
        );
    }
    public function viewer($project = null) {
        $title = 'Advanced Search';
        // check bootstrap configuration
        try {
          parent::getPIDFromProjectName($project);
        } catch (Exception $e) {
            throw new NotFoundException("Project \"$project\" was not found!");
        }

        echo "<script>var globalproject = \"$project\" </script>";

        $json = $this->SearchAPI(
          $project,
          $this->request->query
        );

        $resources = json_decode($json);

        if (empty($resources) || is_null($resources)) {
          $resources = array("empty");
        }

        $search = new Resource_Search($resources, $project);
        $results = $search->getResultsAsArray();
        echo "<script>var results_to_display = ".json_encode($results).";</script>";

        $this->render("/AdvancedSearch/advancedsearch");
    }
    /**
    * Display the advanced search page
    *
    * @param $project
    */
    public function display($project = null)
    {
        $title = 'Advanced Search';
        // check bootstrap configuration
        try {
          parent::getPIDFromProjectName($project);
        } catch (Exception $e) {
            throw new NotFoundException("Project \"$project\" was not found!");
        }

        $this->set("project",$project);
        $this->set(array(
          "min"  => 1700,
          "max"  =>  (int)date("Y"),
          "step" => 1
        ));
        $pid = parent::getPIDFromProjectName($project);

        $sid = parent::getSeasonSIDFromProjectName($project);
        $query = "name = 'Type' OR name = 'Director'";
        $sCid = $this->getControls($pid, $sid, $query);

        $sid = parent::getSurveySIDProjectName($project);
        $query = "name = 'Type' OR name = 'Supervisor'";
        $eCid = $this->getControls($pid, $sid, $query);

        $sid = parent::getResourceSIDFromProjectName($project);
        $query = "name = 'Type' OR name = 'Creator' OR name = 'Creator Role' OR name = 'Language'";
        $rCid = $this->getControls($pid, $sid, $query);

        $sid = parent::getSubjectSIDFromProjectName($project);
        $query = "name = 'Artifact - Structure Classification' OR
                  name = 'Artifact - Structure Type' OR
                  name = 'Artifact - Structure Material' OR
                  name = 'Artifact - Structure Technique' OR
                  name = 'Artifact - Structure Period'";
        $sgCid = $this->getControls($pid, $sid, $query);

        $sid = parent::getSubjectSIDFromProjectName($project);
        $query = "name = 'Artifact - Structure Current Location' OR
                  name = 'Artifact - Structure Excavation Unit'";
        $sdCid = $this->getControls($pid, $sid, $query);

        $this->set(array(
          "seasonTypeList"          => self::getControlArray($sCid, "Type"),
          "seasonDirectorList"      => self::getControlArray($sCid, "Director"),

          "surveyTypeList"          => self::getControlArray($eCid, "Type"),
          "surveySupervisorList"    => self::getControlArray($eCid, "Supervisor"),

          "resourceTypeList"        => self::getControlArray($rCid, "Type"),
          "resourceCreatorList"     => self::getControlArray($rCid, "Creator"),
          "resourceCreatorRoleList" => self::getControlArray($rCid, "Creator Role"),
          "resourceLanguageList"    => self::getControlArray($rCid, "Language"),

          "subjectGClassificationList"   => self::getControlArray(
            $sgCid, "Artifact - Structure Classification"
          ),
          "subjectGTypeList"      => self::getControlArray(
            $sgCid, "Artifact - Structure Type"
          ),
          "subjectGMaterialList"  => self::getControlArray(
            $sgCid, "Artifact - Structure Material"
          ),
          "subjectGTechniqueList" => self::getControlArray(
            $sgCid, "Artifact - Structure Technique"
          ),
          "subjectGPeriodList"    => self::getControlArray(
            $sgCid, "Artifact - Structure Period"
          ),

          "subjectDLocationList" => self::getControlArray(
            $sdCid, "Artifact - Structure Current Location"
          ),
          "subjectDUnitTypeList" => self::getControlArray(
            $sdCid, "Artifact - Structure Excavation Unit"
          ),

        ));


        $this->render('/AdvancedSearch/advancedSearch');
    }
    public function SearchAPI($project, $query=null)
    {
        $this->autoRender = false;

        try {
          parent::verifyGlobals($project);
        } catch (Exception $e) {
          // return configuration error code
          return json_encode(array(
            "Error" => $e->getMessage()
          ));;
        }

        if (is_null($query)) {
          $query = $this->request->query;
        }
        $dataStructure = AFDSFactory::create($query);
        $adv = new Advanced_Field_Search($project, $dataStructure);
        $resources = $adv->executeSearch();
        return json_encode($resources);
    }
    private function getControls($pid,$sid,$query) {
      // require symlink to the kora db
      $kora = new Kora();

      global $db;
      $controls = array();

      $object = $db->query("SELECT * FROM p$pid" .
      "Control WHERE schemeid = '$sid' " . "AND ($query)");
      if (!$object){
        return array();
      }
      while ($res = $object->fetch_assoc()) {
        $cid = $res["cid"];
        $list = new ListControl($pid, $cid);
        $settings = $list->GetControlOptions();
        $controls[$res['name']] =   (array)$settings->option;
      }
      return $controls;
    }
    private static function getControlArray($controlList, $controlName) {
      if (isset($controlList[$controlName]) && is_array($controlList[$controlName])) {
        return $controlList[$controlName];
      }
      return array();
    }
}
