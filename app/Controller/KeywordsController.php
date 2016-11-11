<?php
App::uses('MetaResourcesController', 'Controller');
/**
 * Keywords controller.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class KeywordsController extends MetaResourcesController {
    public $name = 'Keywords';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(
            'get', 'common'
        );
    }

    /**
     * Complete keywords.
     */
    public function complete() {
        $this->json(200, $this->Keyword->complete('Keyword.keyword'));
    }

    /**
     * Add a new keyword.
     */
    public function add() {
        if (!$this->request->is('post')) {$this->json(405); throw new MethodNotAllowedException();}
        if (!$this->request->data) {$this->json(400); throw new BadRequestException();}


        //increment the count for all rows with the same project_kid and keyword
        //// Start SQL Area
        ///////////////////
        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $response['db_info'] = $db_array['host'];
        $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
        }

        //get the current count fo the keyword project_kid combo
        $sql = "SELECT keywords.count
                    FROM arcs_dev.keywords
                    WHERE keywords.project_kid ='".$this->request->data['project_kid']."'
                        AND keywords.keyword = '".$this->request->data['keyword']."'
                    LIMIT 1;";
        $result = $mysqli->query($sql);
        $row = mysqli_fetch_assoc($result);
        $count = intval( $row{count} );
        $retval['first count'] = $count;
        //set count if it is a new keyword
        if( !is_int($count) ){
            $count = 0;
        }
        $retval['count before add'] = $count;
        
        //add the new keyword
        $this->request->data['user_id'] = $this->Auth->user('id');
        $this->Keyword->permit('user_id');
        $this->request->data['count'] = $count;
        $this->Keyword->permit('count');
        $this->Keyword->add($this->request->data);

        //update the count for all the keyword, project_kid combos
        $sql = "UPDATE keywords
                    SET keywords.count = keywords.count + 1
                    WHERE keywords.project_kid ='".$this->request->data['project_kid']."'
                        AND keywords.keyword = '".$this->request->data['keyword']."';";
        $result = $mysqli->query($sql);

        $retval['keyword'] = $result;
        $this->json(201, $retval);
    }

    /**
     * Get all keywords for a page_kid
     */
    public function get() {
        if (!$this->request->is('post')) {$this->json(405); throw new MethodNotAllowedException();}
        if (!$this->request->data) {$this->json(400); throw new BadRequestException();}

        //// Start SQL Area
        ///////////////////
        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $response['db_info'] = $db_array['host'];
        $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
        }

        //get all the keywords with the page_kid
        $sql = "SELECT keywords.keyword
                    FROM arcs_dev.keywords
                    WHERE keywords.page_kid ='".$this->request->data['page_kid']."'
                    ORDER BY keywords.created;";
        $result = $mysqli->query($sql);
        $keywords = array();
        while($row = mysqli_fetch_assoc($result))
            $keywords[] = $row{'keyword'};

        $this->json(201, $keywords);
    }

    /**
     * Get common keywords for a page_kid
     */
    public function common() {
        if (!$this->request->is('post')) {$this->json(405); throw new MethodNotAllowedException();}
        if (!$this->request->data) {$this->json(400); throw new BadRequestException();}

        //// Start SQL Area
        ///////////////////
        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $response['db_info'] = $db_array['host'];
        $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
        }

        //get all the keywords with the page_kid
        $sql = "SELECT DISTINCT keywords.keyword
                    FROM arcs_dev.keywords
                    WHERE keywords.project_kid ='".$this->request->data['project_kid']."'
                    ORDER BY keywords.count DESC, keywords.created
                    LIMIT 10;";
        $result = $mysqli->query($sql);
        $keywords = array();
        while($row = mysqli_fetch_assoc($result))
            $keywords[] = $row{'keyword'};

        $this->json(201, $keywords);
    }

    /**
     * Get all keywords for a page_kid
     */
    public function deleteKeyword() {
        if (!$this->request->is('post')) {$this->json(405); throw new MethodNotAllowedException();}
        if (!$this->request->data) {$this->json(400); throw new BadRequestException();}

        //// Start SQL Area
        ///////////////////
        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $response['db_info'] = $db_array['host'];
        $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
        }

        //delete 1 keyword with the page_kid, project_kid
        $sql = "DELETE FROM arcs_dev.keywords
                    WHERE keywords.page_kid ='".$this->request->data['page_kid']."'
                        AND keywords.project_kid ='".$this->request->data['project_kid']."'
                        AND keywords.keyword ='".$this->request->data['keyword']."'
                    LIMIT 1;";
        $result = $mysqli->query($sql);
        //$row = mysqli_fetch_assoc($result);

        ////////update the count for the rest of the project_kid, keyword combos
        //get the current count for the keyword project_kid combo
        $sql = "SELECT keywords.count
                    FROM arcs_dev.keywords
                    WHERE keywords.project_kid ='".$this->request->data['project_kid']."'
                        AND keywords.keyword = '".$this->request->data['keyword']."'
                    LIMIT 1;";
        $result = $mysqli->query($sql);
        $row = mysqli_fetch_assoc($result);
        $count = intval( $row{'count'} );
        //$retval['first count'] = $count;

        //this means there are no more keywords so just return
        if( !is_int($count) ){
            return $this->json(201, "Keyword deleted.");
        }
        //$retval['count before add'] = $count;

        //update the count for all the keyword, project_kid combos
        $sql = "UPDATE keywords
                    SET keywords.count = keywords.count - 1
                    WHERE keywords.project_kid ='".$this->request->data['project_kid']."'
                        AND keywords.keyword = '".$this->request->data['keyword']."';";
        $result = $mysqli->query($sql);
        
        $this->json(201, $result);
    }
}
