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
            'SearchAPI',
			"advancedGetRestImages",
			"advancedGetRest"
            )
        );
    }
    public function viewer($project = null) {
		ini_set("memory_limit", "-1");
		set_time_limit(0);
        $title = 'Advanced Search';

        try {
          parent::getPIDFromProjectName($project);
        } catch (Exception $e) {
            throw new NotFoundException("Project \"$project\" was not found!");
        }

        echo "<script>var globalproject = \"$project\" </script>";
		
		try {
          parent::verifyGlobals($project);
        } catch (Exception $e) {
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

        // $search = new Resource_Search($resources, $project);
        // $results = $search->getResultsAsArray();
		
		$time_end = microtime(true);
        $times['resource search'] = $time_end - $time_start;

		
		$time_start = microtime(true);
		$time_end = microtime(true);
        $times['filter by perm'] = $time_end - $time_start;

        echo "<script>var results_to_display = false;</script>";
        echo "<script>var kids_to_get = ".json_encode($resources).";</script>";
        echo "<script>var controllerProject = ".json_encode($project).";</script>";

        $this->render("/AdvancedSearch/advancedsearch");
    }
	public function advancedGetRestImages() {
		$resourceKids = json_decode($_POST['kids'], true);
//		$linkers = array();
//		foreach( $resourceKids as $kid => $value ){
//			$linkers = array_merge($linkers, $value);
//		}
		$searchArray = array_keys($resourceKids);
		$pid = parent::getPIDFromProjectName($_POST['project']);
		$pSid = parent::getPageSIDFromProjectName($_POST['project']);
		$fields = array("Image Upload", "Resource_Associator", "Scan_Number");
		$kora = new Advanced_Search($pid, $pSid, $fields);
		$kora->add_double_clause("Resource_Associator", "IN", $searchArray,
                "Scan_Number", "=", "1");
        $images = $kora->unformatted_search();
		
		//echo json_encode($images);die;

        $pKid = $pid.'-'.$pSid.'-';
        foreach ($images as $img) {
            if (isset($img["Resource_Associator"]) && is_array($img["Resource_Associator"])) {
                foreach ($img["Resource_Associator"] as $rKid) {
                    if(
                        isset($resourceKids[$rKid]) &&
                        isset($img["Image_Upload"]) &&
                        isset($img["Image_Upload"]['localName'])
                    ){
                        if(
                            (isset($img["Scan_Number"]) && $img["Scan_Number"] == '1') ||
                            !isset($resourceKids[$rKid]["thumb"])
                        ){
                            $resourceKids[$rKid] = array( 'thumb' => $this->smallThumb($img["Image_Upload"]['localName'], $pKid) );
                        }
                    }
                }
            }
        }
        //insert default images
        $defaultImage = $this->smallThumb('', $pKid);
        foreach ($resourceKids as $kid => $resource) {
            if( !isset($resourceKids[$kid]["thumb"]) ){
                $resourceKids[$kid]["thumb"] = $defaultImage;
            }
        }
		echo json_encode($resourceKids);
		die;
	}
	public function advancedGetRest() {
		$username = NULL;
        $usersC = new UsersController();
        if ($user = $usersC->getUser($this->Auth)) {
            $username = $user['User']['username'];
        }
		$resourceKids = json_decode($_POST['kids']);
		if( $_POST['project'] === "all" ){
			$projects = array_keys(parent::getPIDArray());
			$return = array();
			foreach ($projects as $project) {
				$search = new Resource_Search($resourceKids, $project);
				$results = $search->getResultsAsArray();
				ResourcesController::filterByPermission($username, $results['results']);
				//var_dump($results);
				$return = $results;
				break;
			}
			//die;
		}else{
			$search = new Resource_Search($resourceKids, $_POST['project']);
			$results = $search->getResultsAsArray();
			ResourcesController::filterByPermission($username, $results['results']);
			$return = $results;
		}
		echo json_encode($return);
		die;
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
