<?php

include_once(KORA_LIB . "Advanced_Field_Search.php");
require_once(KORA_LIB . "../Class/AdvancedFieldDataStructure.php");
require_once(KORA_LIB . "Resource_Search.php");
require_once(KORA_LIB . "Kora.php");

use Lib\Kora;
use kora\local\Advanced_Field_Search;
use kora\classes\AdvancedFieldDataStructure as AdvancedDS;
use kora\classes\AFDSFactory;

App::import('Controller', 'Users');
App::import('Controller', 'Resources');

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
		ini_set("memory_limit", "-1");
		set_time_limit(0);
        $title = 'Advanced Search';
        // check bootstrap configuration

        $username = NULL;
        $usersC = new UsersController();

        if ($user = $usersC->getUser($this->Auth)) {
            $username = $user['User']['username'];
        }

        try {
          parent::getPIDFromProjectName($project);
        } catch (Exception $e) {
            throw new NotFoundException("Project \"$project\" was not found!");
        }

        echo "<script>var globalproject = \"$project\" </script>";
		
		try {
          parent::verifyGlobals($project);
        } catch (Exception $e) {
          // return configuration error code
          return json_encode(array(
            "Error" => $e->getMessage()
          ));
        }

		$times = array();
		$time_start = microtime(true);
		 
        if (is_null($this->request->query)) {
          $query = $this->request->query;
        }
        $dataStructure = AFDSFactory::create($this->request->query);
        $adv = new Advanced_Field_Search($project, $dataStructure);
        $resources = $adv->executeSearch();
		
		$time_end = microtime(true);
        $times['search'] = $time_end - $time_start;
		
		//echo $json;die;
		$time_start = microtime(true);

        if (empty($resources) || is_null($resources)) {
          $resources = array("empty");
        }

        $search = new Resource_Search($resources, $project);
        $results = $search->getResultsAsArray();
		
		$time_end = microtime(true);
        $times['resource search'] = $time_end - $time_start;

		
		$time_start = microtime(true);
        ResourcesController::filterByPermission($username, $results['results']);
		$time_end = microtime(true);
        $times['filter by perm'] = $time_end - $time_start;
		
		//var_dump($times);die;

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
        $names = array( 'Type',
                        'Director');
        $sCid = $this->getControls($pid, $sid, $names, 'Season');

        $sid = parent::getSurveySIDProjectName($project);
        $names = array( 'Type',
                        'Supervisor');
        $eCid = $this->getControls($pid, $sid, $names, 'Excavation_-_Survey');
//        var_dump($eCid);
//        die;

        $sid = parent::getResourceSIDFromProjectName($project);
        $names = array( 'Type',
                        'Creator',
                        'Creator Role',
                        'Language');
        $rCid = $this->getControls($pid, $sid, $names, 'Resource');
//        var_dump($rCid);
//        die;

        $sid = parent::getSubjectSIDFromProjectName($project);
        $names = array( 'Artifact - Structure Classification',
                        'Artifact - Structure Type',
                        'Artifact - Structure Material',
                        'Artifact - Structure Technique',
                        'Artifact - Structure Period');
        $sgCid = $this->getControls($pid, $sid, $names,'Subject_of_Observation');
//        var_dump($sgCid);
//        die;
        $sid = parent::getSubjectSIDFromProjectName($project);
        $names = array( 'Artifact - Structure Current Location',
                        'Artifact - Structure Excavation Unit');
        $sdCid = $this->getControls($pid, $sid, $names, 'Subject_of_Observation');

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
          ));
        }

        if (is_null($query)) {
          $query = $this->request->query;
        }
        $dataStructure = AFDSFactory::create($query);
        $adv = new Advanced_Field_Search($project, $dataStructure);
        $resources = $adv->executeSearch();
        return json_encode($resources);
    }
    private function getControls($pid,$sid,$names,$form_name) {

        $controls = parent::getK3Controls($pid,$sid,$names,$form_name);
        return $controls;

    }
    private static function getControlArray($controlList, $controlName) {
      if (isset($controlList[$controlName]) && is_array($controlList[$controlName])) {
        return $controlList[$controlName];
      }
      return array();
    }
}
