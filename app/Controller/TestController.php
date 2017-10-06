<?php
/**
 * Test Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
//require_once(KORA_LIB . "General_Search.php");
require_once(KORA_LIB . "../Class/Benchmark.php");
require_once(KORA_LIB . "Kora.php");

use mb\Benchmark;
use Lib\Kora;


class TestController extends AppController {

    public $bench;
    protected $pidArray;
    protected $kora;
    protected $project;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->pidArray = $this->getPIDArray();
        $this->kora = new Kora();
        $this->bench = new Benchmark();
        $this->Auth->allow('test');
        if (!isset(array_keys($this->pidArray)[0])) {
            throw new Exception("Not projects to test on");
        }

        $this->project = array_keys($this->pidArray)[0];
        $pid = parent::getPIDFromProjectName($this->project);
        $token = parent::getTokenFromProjectName($this->project); 
        $this->kora->setToken($token);
        $this->kora->setProject($pid);
    
    }

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
	public function test($testNum) {
       
        $this->bench->start();
            
        switch ($testNum) {
           
            case "pull_all_resources":
                $this->pullResources();            
                break;
            case "pull_all_pages":
                $this->pullPages();
                break;
            case "pull_all_projects":
                $this->pullProjects();
                break;
            case "pull_all_seasons":
                $this->pullProjects();
                break;
            case "pull_all_excavations":
                $this->pullExcavations();
                break;
            default:
                echo "<p>select a test case</p>";
                echo "<p> pull_all_resources - pull all records and fields from the resources scheme</p>";
                exit();
        }

        $this->bench->end();
        echo $this->bench->clocked();
        exit();
    }

    public function pullResources() {
       $scheme  = parent::getResourceSIDFromProjectName($this->project); 
       $this->kora->setScheme($scheme);
       $clause = new KORA_Clause("kid","!=", "");
       $this->kora->setFields("ALL");
       $this->kora->setClause($clause); 
       $this->kora->search();        
    }
    public function pullProjects() {
       $scheme  = parent::getProjectSIDFromProjectName($this->project); 
       $this->kora->setScheme($scheme);
       $clause = new KORA_Clause("kid","!=", "");
       $this->kora->setFields("ALL");
       $this->kora->setClause($clause); 
       $this->kora->search();        
    
    }
    public function pullPages() {
       $scheme  = parent::getPageSIDFromProjectName($this->project); 
       $this->kora->setScheme($scheme);
       $clause = new KORA_Clause("kid","!=", "");
       $this->kora->setFields("ALL");
       $this->kora->setClause($clause); 
       $this->kora->search();        
    
    }
    public function pullSeasons() {
       $scheme  = parent::getSeasonSIDFromProjectName($this->project); 
       $this->kora->setScheme($scheme);
       $clause = new KORA_Clause("kid","!=", "");
       $this->kora->setFields("ALL");
       $this->kora->setClause($clause); 
       $this->kora->search();        
    
    }
    public function pullExcavations() {
       $scheme  = parent::getSurveySIDFromProjectName($this->project); 
       $this->kora->setScheme($scheme);
       $clause = new KORA_Clause("kid","!=", "");
       $this->kora->setFields("ALL");
       $this->kora->setClause($clause); 
       $this->kora->search();        
     
    }



}
