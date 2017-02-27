<?php
/**
 * Keyword Search is used in the search controller and the api for searching
 * on a particular keyword or a set of keywords
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  library
 * @package   Lib\Kora
 * @author    Austin Rix <austin.rix@matrix.msu.edu>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://svn.matrix.msu.edu/svn/arcs/
 */

namespace Lib\Kora;

require_once "Kora.php";
require_once "Resource.php";

require_once "../../app/Controller/SearchController.php";

use Lib\Kora;
use Lib\Resource;
use Lib\KORA_Clause;
use \SearchController;
use arcs_e\ArcsException;
use \App;
use \Exception;
/**
 * Keyword search performs searches by keyword on the kora database
 *
 * @category  library
 * @package   Lib\Kora
 * @author    Austin Rix <austin.rix@matrix.msu.edu>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   SVN: $Id$
 * @link      http://svn.matrix.msu.edu/svn/arcs/
 */
class Keyword_Search extends Kora
{
    protected $formulatedResult;
    protected $project_list = array();
    protected $season_list = array();
    protected $excavation_list = array();
    protected $total = 0;

    protected $months = [
    "January","February","March","April","May","June","July","August",
    "September","October","November","December"
    ];
    protected $filters = [
    "a","about","above","above","across","after","afterwards","again","against",
    "all","almost","alone","along","already","also","although","always","am",
    "among","amongst","amoungst","amount","an","and","another","any","anyhow",
    "anyone","anything","anyway","anywhere","are","around","as","at","back",
    "be","became","because","become","becomes","becoming","been","before",
    "beforehand","behind","being","below","beside","besides","between","beyond",
    "bill","both","bottom","but","by","call","can","cannot","cant","co","con",
    "could","couldn't","cry","de","describe","detail","do","done","down","due",
    "during","each","eg","eight","either","eleven","else","elsewhere","empty",
    "enough","etc","even","ever","every","everyone","everything","everywhere",
    "except","few","fifteen","fifty","fill","find","fire","first","five","for",
    "former","formerly","forty","found","four","from","front","full","further",
    "get","give","go","had","has","hasn't","have","he","hence","her","here",
    "hereafter","hereby","herein","hereupon","hers","herself","him","himself",
    "his","how","however","hundred","ie","if","in","inc","indeed","interest",
    "into","is","it","its","itself","keep","last","latter","latterly","least",
    "less","ltd","made","many","may","me","meanwhile","might","mill","mine",
    "more","moreover","most","mostly","move","much","must","my","myself","name",
    "namely","neither","never","nevertheless","next","nine","no","nobody",
    "none","no one","nor","not","nothing","now","nowhere","of","off","often",
    "on","once","one","only","onto","or","other","others","otherwise","our",
    "ours","ourselves","out","over","own","part","per","perhaps","please","put",
    "rather","re","same","see","seem","seemed","seeming","seems","serious",
    "several","she","should","show","side","since","sincere","six","sixty","so",
    "some","somehow","someone","something","sometime","sometimes","somewhere",
    "still","such","system","take","ten","than","that","the","their","them",
    "themselves","then","thence","there","thereafter","thereby","therefore",
    "therein","thereupon","these","they","","thin","third","this","those",
    "though","three","through","throughout","thru","thus","to","together",
    "too","top","toward","towards","twelve","twenty","two","un","under",
    "until","up","upon","us","very","via","was","we","well","were","what",
    "whatever","when","whence","whenever","where","whereafter","whereas",
    "whereby","wherein","whereupon","wherever","whether","which","while",
    "whither","who","whoever","whole","whom","whose","why","will","with",
    "within","without","would","yet","you","your","yours","yourself",
    "yourselves","the"
    ];

    /**
    * Constructor
    */
    function __construct()
    {
        //call parent constructor 'kora'
        parent::__construct();
    }
    /**
    * executes a search on a query in a set project
    *
    * @param string $query   | the query to search
    * @param string $project | the project name
    * @param int    $start   | the starting index of results
    * @param int    $end     | the end index of results
    * @return void
    */
    public function execute($query,$project=null,$start=1,$end=10000)
    {

        $time_start = microtime(true);
        $mem_start =  memory_get_usage();

        $terms = explode(" ", trim($query));
        $terms = self::queryFilter($terms);
        $terms = self::dateFilter($terms);

        $resourcesFromSOO = $this->_searchSOO($terms, $project);

        $clause = $this->_clauseGen(
            "OR", "LIKE",
            array(
            "Resource Identifier","Type","Earliest Date","Latest Date",
            "Accession Number"
            ), $terms
        );
        //set up the kora search parameters for keyword search on RESOURCE
        $pid = parent::getPIDFromProjectName($project);
        $rid = parent::getResourceSIDFromProjectName($project);
        $token = parent::getTokenFromProjectName($project);
        $this->set_search_parameters($query, $pid, $rid, $token, $clause);

        //do the keyword search
        $resourcesFromResource = parent::search();

        $this->formulatedResult = array_merge($resourcesFromResource, $resourcesFromSOO);

        $extra_data = array(
        "Return_Count_SOO"=>count($resourcesFromSOO),
        "Return_Count_Resource"=>count($resourcesFromResource),
        );

        // traverse the database to include excavation,
        // season and project associations;
        $this->traverse_insert($project);

        // get resource filters
        $filters = Resource::filter_analysis($this->formulatedResult);
        //get indicators
        $indicators = Resource::flag_analysis($this->formulatedResult);

        //adjust the results to the requested section
        $this->adjust_requested_limits($start, $end);

        $time_end = microtime(true);
        $mem_end = memory_get_usage();

        $time = $time_end - $time_start;
        $total_mem = ($mem_end - $mem_start) / pow(10, 9);

        //format and prepare for a json response
        $this->format_results($time, $total_mem, $filters, $indicators, $extra_data);

    }
    /**
    * executes a search on a query in a Subject of observation
    *
    * @param string $query   | the query to search
    * @param string $project | the project name
    * @return results as array
    */
    private function _searchSOO($query, $project)
    {

        //set up the kora search parameters for keyword search on SOO
        $pid = parent::getPIDFromProjectName($project);
        $token = parent::getTokenFromProjectName($project);

        $clause = $this->_clauseGen(
            "OR",
            "LIKE",
            array(
            "Artifact - Structure Classification","Artifact - Structure Type",
            "Artifact - Structure Material","Artifact - Structure Technique",
            "Artifact - Structure Period","Artifact - Structure Terminus Ante Quem",
            "Artifact - Structure Terminus Post Quem"
            ), $query
        );

        $subject = parent::getSubjectSIDFromProjectName($project);
        $this->set_search_parameters($query, $pid, $subject, $token, $clause, array("Pages Associator"));

        //search on soo level
        $soo = parent::search();

        if (empty($soo)) {
            return array();
        }

        $pages = $this->mergeIntoArray($soo, "Pages Associator");

        $clause = new KORA_Clause("kid", "IN", $pages);
        $pageSID = parent::getPageSIDFromProjectName($project);
        $this->set_search_parameters($query, $pid, $pageSID, $token, $clause, array("Resource Associator"));

        $page = parent::search();

        if (empty($page)) {
            return array();
        }

        $resources = $this->mergeIntoArray($page, "Resource Associator");

        $clause = new KORA_Clause("kid", "IN", $resources);
        $rid = parent::getResourceSIDFromProjectName($project);
        $this->set_search_parameters($query, $pid, $rid, $token, $clause, null);
        $resourcesWithFields = parent::search();

        return $resourcesWithFields;
    }
    /**
    * generates a kora clause from a array of fields
    *
    * @param string $join      | the join condition AND / OR
    * @param string $condition | the field operator
    * @param int    $array     | the array of fields
    * @param int    $query     | the query
    * @return void
    */
    private function _clauseGen($join,$condition,$array,$query)
    {
        if (empty($array)) {
            return array();
        }

        if (is_array($query)) {
            $clauses = array();
            foreach ($array as $term) {
                $innerClause = array();
                foreach ($query as $q) {
                    $clause = new KORA_Clause($term, $condition, "%$q%");
                    array_push($innerClause, $clause);
                }
                $joins = $innerClause[0];
                for ($i = 1; $i < count($innerClause); $i++) {
                    $joins = new KORA_Clause($joins, "AND", $innerClause[$i]);
                }
                $clause = $joins;
                array_push($clauses, $clause);
            }
            $joins = $clauses[0];
            for ($i = 1; $i < count($clauses); $i++) {
                $joins = new KORA_Clause($joins, $join, $clauses[$i]);
            }

        } else {
            $clauses = array();
            foreach ($array as $term) {
                $clause = new KORA_Clause($term, $condition, "%$query%");
                array_push($clauses, $clause);
            }
            $joins = $clauses[0];
            for ($i = 1; $i < count($clauses); $i++) {
                $joins = new KORA_Clause($joins, $join, $clauses[$i]);
            }
        }

        return $joins;
    }
    /**
    * combines all results into one array.
    * only the attribute (Kora return field) is merged
    * removes all duplicates
    *
    * @param string $input_array  | input array to merge
    * @param string $attribute    | the array key

    * @return a unique array
    */
    private function mergeIntoArray($input_array, $attribute)
    {
        $return_array = array();
        //combine all results pages into an array
        foreach ($input_array as $kid) {
            if (isset($kid[$attribute]) && is_array($kid[$attribute])) {

                $associator = $kid[$attribute];
                $difference = array_diff($associator, $return_array);

                foreach ($difference as $one) {
                    array_push($return_array, $one);
                }

            }

        }
        //ensure array has no duplicates
        return  array_unique($return_array);
    }
    /**
    * formats a return array with stats and performace data
    *
    * @param array $time        | the total time of exectution
    * @param array $total_mem   | the total memeory used
    * @param array $filters     | the filter array
    * @param array $indicators  | the indicator array
    * @param array $indicators  | the extra data array
    * @return void
    */
    protected function format_results($time,$total_mem,$filters,$indicators,$data=array())
    {

        $this->formulatedResult = array(

        "total"=>$this->total,
        "time"=>$time,
        "Memory"=>$total_mem . " GB",
        "filters" => $filters,
        "indicators"=> $indicators,
        "data" => $data,
        "results"=>$this->formulatedResult

        );
        $this->comprehensive_results = $this->formulatedResult;

    }

    /**
    * trim results array by limits
    *
    * @param string $time        | the total time of exectution
    * @param string $total_mem   | the total memeory used
    * @return void
    */
    protected function adjust_requested_limits($start,$end)
    {

        $this->total = count($this->formulatedResult);
        if ($this->total > $end) {
            $this->formulatedResult = array_slice($this->formulatedResult, $start, $end);
        }

    }
    /**
    * set the kora search paramaters
    *
    * @param string $query     | n/a
    * @param string $project   | n/a
    * @param string $scheme    | n/a
    * @param string $token     | n/a
    * @param string $clause    | n/a
    * @param string $fields    | n/a
    * @return void
    */
    private function set_search_parameters($query,$project,$scheme,$token,$clause=null,$fields=null)
    {

        $this->token = $token;
        $this->projectMapping = $project;
        $this->schemeMapping = $scheme;

        if ($clause != null) {
            $this->The_Clause = $clause;
        } else {
            $clause1 = new KORA_Clause("ANY", "LIKE", "%".$query."%");
            $this->The_Clause = $clause1;
        }

        if (empty($fields)) { //default fields
             $this->fields = array(
            "Excavation - Survey Associator",
            "Title",
            "Type",
            "Resource Identifier",
            "Accession Number",
            "Creator",
            "Creator2",
            "systimestamp"
            );
        } else {
            $this->fields = $fields;
        }
    }

    /**
    * set the kora search paramaters
    *
    * @param string $project     | n/a
    * @return void
    */
    protected function traverse_insert($project)
    {

        if (!empty($this->formulatedResult)) {

            $page = parent::getPageSIDFromProjectName($project);
            $this->insertPages($page);

            $survey = parent::getSurveySIDProjectName($project);
            $this->insertExcavations($survey);

            $season = parent::getSeasonSIDFromProjectName($project);
            $this->insertSeasons($season);

            //$this->insertProjects();
        }

    }

    /**
    * returns project List as a key value array
    *
    *key 7B-2DF-0 would look like:
    *
    *[7B-2DF-0] = "1972"
    *
    * @return void
    */
    protected function getProjectList()
    {

        $projects = array();
        $this->projectMapping = PID;
        $this->schemeMapping = PROJECT_SID;
        $this->fields =  array("Persistent Name");
        $this->The_Clause = new KORA_Clause("kid", "!=", "");

        self::search();

        foreach ($this->comprehensive_results as $key => $value) {
            $projects[$key] = $value['Persistent Name'];
        }
        return $projects;

    }
    /**
    *returns season List as a key value array

     *key 7B-2DF-0 would look like:

    *[7B-2DF-0] = [
    *    Title => "1972",
    *    Project Associator => "7B-2DE-0"
    *]
    * @return void
    */
    protected function getSeasonList($sid)
    {
        $season = array();
        $this->schemeMapping = $sid;
        $this->fields = array("Title", "Project Associator");
        $this->The_Clause = new KORA_Clause("kid", "!=", "");

        self::search();

        foreach ($this->comprehensive_results as $key => $value) {
            $projAssoc = isset($value["Project Associator"][0])?$value["Project Associator"][0]:"";
            $season[$key] = array(
            "Name" => $value['Title'],
            "Project Associator" => $projAssoc
            );
        }
        return $season;

    }

    /**
    *returns excavation List as a key value array

     *key 7B-2DF-0 would look like:

    *[7B-2DF-0] = [
    *    Name => "1972",
    *    Season Associator => "7B-2DE-0"
    *]

    * @return void
    */
    protected function getExcavationList($survey)
    {
        $excavation = array();
        $this->schemeMapping = $survey;
        $this->fields = array("Name", "Season Associator","Type");
        $this->The_Clause = new KORA_Clause("kid", "!=", "");

        self::search();

        foreach ($this->comprehensive_results as $key => $value) {
            $seasonAssoc = isset($value["Season Associator"][0])?$value["Season Associator"][0]:"";
            $excavation[$key] = array(
            "Name" => $value['Name'],
            "Type" => $value['Type'],
            "Season Associator" => $seasonAssoc

            );
        }
        return $excavation;

    }

    public function insertPages($page)
    {

        $pageArray = array();
        $this->schemeMapping = $page;
        $this->fields = array("Image Upload", "Resource Associator");
        $this->The_Clause = new KORA_Clause("kid", "!=", "");

        $images = self::search();

        foreach ($images as $img) {
            $pKid = $img['kid'];
            if (isset($img["Resource Associator"]) && is_array($img["Resource Associator"])) {
                foreach ($img["Resource Associator"] as $rKid) {
                    if (!isset($pageArray[$rKid])) {
                        $pageArray[$rKid] = isset($img["Image Upload"]['localName'])?
                        $img["Image Upload"]['localName'] : "none" ;
                    }
                }
            }
        }
        foreach ($this->formulatedResult as $obj) {
            if (isset($pageArray[$obj['kid']])) {
                $this->formulatedResult[$obj['kid']]["thumb"] = $this->smallThumb($pageArray[$obj['kid']]);
            } else {
                $this->formulatedResult[$obj['kid']]["thumb"] = DEFAULT_THUMB;
            }
        }
    }

    private function insertExcavations($survey)
    {

        $this->excavation_list = self::getExcavationList($survey);

        foreach ($this->formulatedResult as $key => $value) {

            $newkey = isset($value["Excavation - Survey Associator"][0])?
            $value["Excavation - Survey Associator"][0]: "";

            if (array_key_exists($newkey, $this->excavation_list)) {

                $this->formulatedResult[$key]["Excavation Name"] = $this->excavation_list[$newkey]["Name"];
                $this->formulatedResult[$key]["Excavation Type"] = $this->excavation_list[$newkey]["Type"];
                $this->formulatedResult[$key]["Season Associator"] = $this->excavation_list[$newkey]["Season Associator"];
            } else {
                $this->formulatedResult[$key]["Excavation Name"] = "";
                $this->formulatedResult[$key]["Season Associator"] = "";
            }
        }

    }
    private function insertSeasons($season)
    {
        $this->season_list = self::getSeasonList($season);
        foreach ($this->formulatedResult as $key => $value) {

            $newkey = isset($value["Season Associator"])?
            $value["Season Associator"]: "";

            if (array_key_exists($newkey, $this->season_list)) {

                $this->formulatedResult[$key]["Season Name"] = $this->season_list[$newkey]["Name"];
                $this->formulatedResult[$key]["Project Associator"] = $this->season_list[$newkey]["Project Associator"];
            } else {
                $this->formulatedResult[$key]["Season Name"] = "";
                $this->formulatedResult[$key]["Project Associator"] = "";
            }
        }

    }
    public function queryFilter($query)
    {
        for ($i = 0; $i < count($query); $i++) {
            if (in_array($query[$i], $this->filters)) {
                unset($query[$i]);
            }
        }
        return array_values($query);
    }
    /**
  * extract and format the any dates in the forms of either
  * YYYY/YY/YY or <Month name> <day>
  *
  * @param  Array $query contains the space sperated array split
  * @return Array query with the new formated strings
  */
    public function dateFilter($query)
    {
        // Look for YYYY/YY/YY format
        for ($i = 0; $i < count($query); $i++) {
            $date = array();
            preg_match("/(....)-(..)-(..)/", $query[$i], $date);

            if (!empty($date)) {
                $query[$i] = preg_replace(
                    "/(....)-(..)-(..)/",
                    "<month>".(int)$date[3]."</month><day>".(int)$date[2]."</day><year>".
                    (int)$date[1]."</year>", $date[0]
                );
            }
        }
        // Look for  <Month name> <day> format
        if (count($query) == 2) {
            $monthTerm = $query[0];
            $yearTerm = (int)$query[1];
            $extract = array();
            for ($i = 0; $i < count($this->months); $i++) {
                if (strtolower($this->months[$i]) === strtolower($monthTerm)) {
                    // using the index as a inderict month to number conversion
                    $monthTerm = $i + 1;
                    $formated = "<month>$monthTerm</month><day>%</day><year>$yearTerm</year>";
                    array_push($extract, $formated);
                    $query = $extract;
                    break;
                }
            }
        }
        return $query;
    }
}
