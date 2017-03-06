<?php

include_once(KORA_LIB . "Advanced_Field_Search.php");
require_once(KORA_LIB . "../Class/AdvancedFieldDataStructure.php");
require_once(KORA_LIB . "Resource_Search.php");

use kora\local\Advanced_Field_Search;
use kora\classes\AdvancedFieldDataStructure as AdvancedDS;
use kora\classes\AFDSFactory;


class AdvancedSearchController extends AppController
{
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
}
