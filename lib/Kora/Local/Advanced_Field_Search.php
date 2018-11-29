<?php
/**
 * Advanced Field Search is used to perform multiple field searches in the Kora
 * database.
 *
 * PHP version 5
 *
 * @category  Search
 * @package   Arcs
 * @author    Austin Rix <austin.rix@matrix.msu.edu>
 * @copyright 2012 Michigan State University Board of Trustees
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: 1.0.0
 * @link      http://svn.matrix.msu.edu/svn/arcs/
 * @see       NetOther, Net_Sample::Net_Sample()
 * @since     File available since Release 1.0.0
 */

namespace kora\local;

require_once "Kora.php";
require_once "Resource.php";
require_once "Resource_Search.php";

require_once LIB . "Kora/Class/AdvancedFieldDataStructure.php";

//use Lib\Kora;
////use Lib\KORA_Clause;
//// use \App\FieldHelpers\KORA_Clause;
//use Lib\Resource;
use kora\classes\AdvancedFieldDataStructure as AdvancedDS;
use kora\classes\AdvancedFieldMap;
//use \Resource_Search;
//use Exception;

use Lib\Kora;
use Lib\Resource;
use \KORA_Clause;
// use App\FieldHelpers\KORA_Clause;
//use \SearchController;
use arcs_e\ArcsException;
use \App;
use \Exception;
use \Advanced_Search;

/**
 * Advanced Field Search performs searches by AdvancedFieldDataStructure
 * on the kora database and returns a array of reosurces
 *
 * @category  Search
 * @package   Arcs
 * @author    Austin Rix <austin.rix@matrix.msu.edu>
 * @copyright 2012 Michigan State University Board of Trustees
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: 1.0.0
 * @link      http://svn.matrix.msu.edu/svn/arcs/
 */
class Advanced_Field_Search extends Kora
{

    private $_project;
    private $_ds;
    private $_map;

    /**
     * Constructor, Initialize the Kora parent class
     *
     * @param string                     $project the project name
     * @param AdvancedFieldDataStructure $fields  the field data structure
     */
    function __construct($project,  $fields)
    {
        parent::__construct();
        if (get_class($fields) != "kora\classes\AdvancedFieldDataStructure") {
            throw new Exception("Expected an Advanced Field Data Structure, but found " . get_class($field) . " instead");
        }
        $this->_map            = new AdvancedFieldMap();
        $this->_project        = $project;
        $this->_ds             = $fields;
        $this->token           = parent::getTokenFromProjectName($project);
        $this->projectMapping  = parent::getPIDFromProjectName($project);

    }
    /**
     * Execute the kora search on the set project and fields
     * using level order searches
     *
     * @param bool $debugMode set for debuging results
     *
     * @return the intersection on all level searches
     */
    public function executeSearch($debugMode=false)
    {

        $time_start = microtime(true);
        $mem_start =  memory_get_usage();

        $resourcesFromSeasons     = $this->_seasonLevelSearch();
		
		// var_dump($resourcesFromSeasons);
		// die;
		
		// echo 'here';
		// die;

        $resourcesFromExcavations = $this->_excavationLevelSearch();

        $resourcesFromResources   = $this->_resourceLevelSearch();

        $resourcesFromPages       = $this->_pageLevelSearch();

        $resourcesFromSubGen      = $this->_subjectGeneralLevelSearch();

        $resourcesFromSubDet      = $this->_subjectDetailedLevelSearch();


        $intersect = self::getVectorIntersection(
            array(
            $resourcesFromSeasons, $resourcesFromExcavations,
            $resourcesFromResources, $resourcesFromPages,
            $resourcesFromSubGen, $resourcesFromSubDet
            )
        );

        $time_end = microtime(true);
        $mem_end = memory_get_usage();

        $time = $time_end - $time_start;
        $total_mem = ($mem_end - $mem_start) / pow(10, 6);

        if ($debugMode) {

            return array(
            "total"     => count($intersect),
            "time"      => $time,
            "memory"    => $total_mem . " KB",
            "intersect" => $intersect,
            "data" => array(
            "season hit count"      => count($resourcesFromSeasons),
            "excavation hit count"  => count($resourcesFromExcavations),
            "resource hit count"    => count($resourcesFromResources),
            "page hit count"        => count($resourcesFromPages),
            "subject gen hit count" => count($resourcesFromSubGen),
            "subject det hit count" => count($resourcesFromSubDet)

            ),
            "season resources"      => $resourcesFromSeasons,
            "excavation resources"  => $resourcesFromExcavations,
            "resource resources"    => $resourcesFromResources,
            "page resources"        => $resourcesFromPages,
            "subject gen resources" => $resourcesFromSubGen,
            "subject det resources" => $resourcesFromSubDet
            );
        }

        return $intersect;
    }
    /**
     * Preform a subject level search
     *
     * @return resources with subjects matching the fields
     */
    private function _subjectDetailedLevelSearch()
    {

        $subject  = $this->_ds->subjectDetailed;
        $map      = $this->_map->subjectDetailed;
        $clauses  = $this->generateKoraClauseFromMap($subject, $map);

        if (!empty($clauses)) {

            $this->schemeMapping = parent::getSubjectSIDFromProjectName($this->_project);
            $this->The_Clause    = self::clauseJoin($clauses, "AND");
            $this->fields        = array("Pages_Associator");
            $subjects = parent::search();
            //echo json_encode(count($subjects));exit();

            if (!empty($subjects)) {

                $associators = self::getAssociatorLinks($subjects, "Pages_Associator");
                $this->schemeMapping = parent::getPageSIDFromProjectName($this->_project);
                $this->The_Clause    = new KORA_Clause("kid", "IN", $associators);
                $this->fields        = array("Resource Associator");
                $pages = parent::search();

                if (!empty($pages)) {
                    //echo json_encode(count($pages));exit();
                    $associators = self::getAssociatorLinks($pages, "Resource_Associator");
					
					return array_unique($associators);

                    // $this->schemeMapping = parent::getResourceSIDFromProjectName($this->_project);
                    // $this->The_Clause    = new KORA_Clause("kid", "IN", $associators);
                    // $this->fields        = array("Title");
                    // $resources = parent::search();
                    // //echo json_encode(array_keys($resources);exit();
                    // return array_keys($resources);

                }

            }
            return array();
        }
        return null;

    }
    /**
     * Preform a subject level search
     *
     * @return resources with subjects matching the fields
     */
    private function _subjectGeneralLevelSearch()
    {

        $subject  = $this->_ds->subjectGeneral;
        $map      = $this->_map->subjectGeneral;
        $clauses  = $this->generateKoraClauseFromMap($subject, $map);
        if (!empty($clauses)) {

            $this->schemeMapping = parent::getSubjectSIDFromProjectName($this->_project);
            $this->The_Clause    = self::clauseJoin($clauses, "AND");
            $this->fields        = array("Pages_Associator");
            $subjects = parent::search();

            if (!empty($subjects)) {

                $associators = self::getAssociatorLinks($subjects, "Pages_Associator");
                $this->schemeMapping = parent::getPageSIDFromProjectName($this->_project);
                $this->The_Clause    = new KORA_Clause("kid", "IN", $associators);
                $this->fields        = array("Resource_Associator");
                $pages = parent::search();

                if (!empty($pages)) {
                    $associators = self::getAssociatorLinks($pages, "Resource_Associator");
					
					return array_unique($associators);

                    // $this->schemeMapping = parent::getResourceSIDFromProjectName($this->_project);
                    // $this->The_Clause    = new KORA_Clause("kid", "IN", $associators);
                    // $this->fields        = array("Title");
                    // $resources = parent::search();
                    // return array_keys($resources);

                }

            }
            return array();
        }
        return null;

    }
    /**
     * Preform a page level search
     *
     * @return resources with pages matching the fields
     */
    private function _pageLevelSearch()
    {

        $page     = $this->_ds->page;
        $map      = $this->_map->page;
        $clauses  = $this->generateKoraClauseFromMap($page, $map);

        if (!empty($clauses)) {

            $this->schemeMapping = parent::getPageSIDFromProjectName($this->_project);
            $this->The_Clause    = self::clauseJoin($clauses, "AND");
            $this->fields        = array("Resource_Associator");
            $pages = parent::search();

            if (!empty($pages)) {

                $associators = self::getAssociatorLinks($pages, "Resource_Associator");
				
				return array_unique($associators);

                // $this->schemeMapping = parent::getResourceSIDFromProjectName($this->_project);
                // $this->The_Clause    = new KORA_Clause("kid", "IN", $associators);
                // $this->fields        = array("Title");
                // $resources = parent::search();

                // return array_keys($resources);

            }
            return array();
        }
        return null;


    }
    /**
     * Preform a excavation level search
     *
     * @return resources with linkers to the matching the fields in excavations
     */
    private function _excavationLevelSearch()
    {
        $excavation  = $this->_ds->excavation;
        $map         = $this->_map->excavation;
        $clauses     = $this->generateKoraClauseFromMap($excavation, $map);
        // print_r($clauses);exit();
        if (!empty($clauses)) {

            $this->schemeMapping = parent::getSurveySIDProjectName($this->_project);
            $this->The_Clause    = self::clauseJoin($clauses, "AND");
            $this->fields        = array("Name");

            $excavations = parent::search();
            // print_r(count($excavations));exit();

            if (!empty($excavations)) {

                $linkers = $this->getLinkers($excavations);
				
				return array_unique($linkers);

            }
            return array();
        }
        return null;



    }
    /**
     * Preform a resource level search
     *
     * @return matching resources
     */
    private function _resourceLevelSearch()
    {
        $resource    = $this->_ds->resource;
        $map         = $this->_map->resource;

        $clauses = $this->generateKoraClauseFromMap($resource, $map);

        if (!empty($clauses)) {

            $this->schemeMapping = parent::getResourceSIDFromProjectName($this->_project);
            $this->The_Clause    = self::clauseJoin($clauses, "AND");
            $this->fields        = array("Title");
			$this->kidsNoData = true;
            $resources = parent::search();
//            echo 'here';
//            var_dump($resources);die;
			$this->kidsNoData = false;
            return array_keys($resources);
        }
        return null;


    }
    /**
     * Preform a season level search
     *
     * @return resources linking to matching seasons
     */
    private function _seasonLevelSearch()
    {

        $season    = $this->_ds->season;
        $map       = $this->_map->season;
        $clauses   = $this->generateKoraClauseFromMap($season, $map);
		//echo 'hdfda';
        //print_r($clauses);die;

        if (!empty($clauses)) {

            $this->schemeMapping = parent::getSeasonSIDFromProjectName($this->_project);
            $this->The_Clause    = self::clauseJoin($clauses, "AND");
            $this->fields        = array("kid");  //array("Title", "Type");

            $seasons = parent::search();
			// echo 'season results';
			// var_dump($seasons);
			// die;
//            echo 'before seasons';
//            print_r(array_keys($seasons));
//            echo 'after seasons';
            if (!empty($seasons)) {

				$linkers = $this->getLinkers($seasons);
				
				$this->schemeMapping = parent::getSurveySIDProjectName($this->_project);
				$excavations = $this->_resolveSchemeFromLinkers($linkers, $this->schemeMapping, array("Type"), false);
				
				// get the excavation linkers resource linkers
				$linkers2 = $this->getLinkers($excavations);

				// get indirect resource linkers
				return array_unique(array_merge($this->returnResourceKids($linkers,$this->_project),$linkers2));
            }
            return array();

        }
        return null;
    }
    /**
     * Resolve linkers from a specified scheme
     *
     * @param array  $linkers list of linker kids's
     * @param string $scheme  kora scheme
     * @param array  $fields  kora fields
     * @param bool   $rebase  reformat array with numerical keys
     *
     * @return KID's from the scheme
     */
    private function _resolveSchemeFromLinkers($linkers, $scheme, $fields, $rebase=true)
    {

        $this->schemeMapping = $scheme;
        $this->The_Clause    = new KORA_Clause("KID", "IN", $linkers);

        $this->fields        = array("kid");
		if($rebase){
			$this->kidsNoData = true;
		}
        $resolvedKIDS        = parent::search();
		$this->kidsNoData = false;
		
        // rebase array with keys
        if ($rebase) {
            return array_keys($resolvedKIDS);
        }
        return $resolvedKIDS;

    }
    /**
     * Get the intersection from elements in a matrix
     *
     * @param Array2D $matrix KID's matrix
     *
     * @return intersection between elements
     */
    public static function getVectorIntersection($matrix)
    {
        //removed empty search fields
        $intersection = null;
        $i = 0;
        $indicies = array();
        for ($i = 0; $i < count($matrix); $i++) {
            if (is_null($matrix[$i])) {
                array_push($indicies, $i);
            }
        }
        //unset null vecotrs
        foreach ($indicies as $index) {
            unset($matrix[$index]);
        }
        //rebase
        $matrix = array_values($matrix);
        //no valid vectors
        if (count($matrix) == 0) {
            return array();
        }
        //find instersection
        $intersection = $matrix[0];
        for ($i=0; $i < count($matrix); $i++) {
            if (!is_null($matrix[$i])) {
                $intersection = array_intersect($intersection, $matrix[$i]);
                //rebase
                $intersection = array_values($intersection);
            }
        }
        return $intersection;
    }
    /**
     * Generate a Kora Clause from a specified map
     *
     * @param array $array array of fields
     * @param array $map   contains field map (Data Structure --> Kora Fields)
     *
     * @return kora clause array
     */
    public static function generateKoraClauseFromMap($array, $map)
    {
        $clauses = array();
        $i = -1;
        // loop sub data structure
        foreach ($array as $key => $value) {
            // ignore empty fields in the data strucuture
            if (!empty($value) && !is_array($value)) {
                // get the mapped kora field
                $koraField = $map[$key];
                $clauses[++$i] = new KORA_Clause($koraField, "LIKE", "$value");

            } else if( $key == 'date_range' ){
                if( self::isEmptyDateRange($value) ){
                    continue;
                }
                $start_year = $value['start_year'];
                $end_year = $value['end_year'];
                $date_range_clause = array();
                for( $k=$start_year; $k<=$end_year; $k++ ){
                    array_push(
                        $date_range_clause,
                        new KORA_Clause('Earliest_Date', "LIKE", "<year>$k</year>"),
                        new KORA_Clause('Latest_Date', "LIKE", "<year>$k</year>")
                    );
                };
                $date_range_clause = self::clauseJoin($date_range_clause, "OR");
                $clauses[++$i] = $date_range_clause;

            }else if (is_array($value) && !self::isEmptyDate($value)) {
                $year  = $value["year"];
                $month = $value["month"];
                $day   = $value["day"];
                $query = "<month>$month</month><day>$day</day><year>$year</year>";
                $era = $value["era"];
                if (!empty($era)) {
                    $query .= "<era>$era</era>";
                }
                $clauses[++$i] = new KORA_Clause($map[$key], "LIKE", "$query");
            }
        }
        return $clauses;
    }
	public static function returnResourceKids($kids, $pName){
		$scheme = parent::getResourceSIDFromProjectName($pName);
		$return = array();
		foreach( $kids as $kid ){
			$temp = explode('-', $kid);
			if( $temp[0] == 'empty' ){
			    continue;
			}
			if( $temp[1] == $scheme ){
			    $return[] = $kid;
			}
		}
		return array_unique($return);
	}
	
    /**
     * Get linkers from a kora return
     *
     * @param array $array kora results
     *
     * @return list of linkers
     */
    public static function getLinkers($array)
    {
        $linkers = array();
        foreach ($array as $array) {
            if (isset($array["linkers"])) {
                foreach ($array["linkers"] as $link) {
                    // quick way to insure no duplicates by setting as the key
                    $linkers[$link] = "";
                }
            }
        }
        if (empty($linkers)) {
            // must return non empty Array for kora Search
            return array("empty");
        }
        // rebase array
        return array_keys($linkers);
    }
    /**
     * Check if the data structure value is a empty date
     *
     * @param array $date array of fields
     *
     * @return bool emptydate
     */
    public static function isEmptyDate($date)
    {
        $isset = true;
        if (is_array($date)) {
            foreach ($date as $subDate => $val) {
                if (!empty($val)) {
                    $isset = false;
                    break;
                }
            }
            return $isset;
        } else {
            return false;
        }
    }

    public static function isEmptyDateRange($dateRange)
    {
        $isset = false;
        if (is_array($dateRange)) {
            foreach ($dateRange as $subDate => $val) {
                if (empty($val) || $val == '%') {
                    $isset = true;
                    break;
                }
            }
            return $isset;
        } else {
            return true;
        }
    }
    /**
     * Check if the data structure value is a empty date
     *
     * @param array  $clauses   <>
     * @param string $condition join condition
     *
     * @return bool emptydate
     */
    public static function clauseJoin($clauses, $condition)
    {

        if (empty($clauses)) {
            return array();
        }

        $joins = $clauses[0];

        for ($i = 1; $i < count($clauses); $i++) {
            $joins = new KORA_Clause($joins, $condition, $clauses[$i]);
        }
        return $joins;

    }
    /**
     * Check if the data structure value is a empty date
     *
     * @param array $array      kora results
     * @param array $associator name of associator
     *
     * @return bool emptydate
     */
    public static function getAssociatorLinks($array, $associator)
    {
        $associators = array();
        foreach ($array as $key => $value) {
            if (isset($value[$associator]) && is_array($value[$associator])) {
                foreach ($value[$associator] as $val) {
                    // remove duplicates by setting key
                    $associators[$val] = "";
                }
            }
        }
        // rebase array
        return array_keys($associators);
    }

}
