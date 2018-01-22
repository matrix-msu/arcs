<?php
App::uses('ConnectionManager', 'Model');
/**
 * Admin controller.
 *
 * This is largely a read-only group of views. Admin actions are carried out
 * through ajax requests to the proper controller actions on the client-side.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class AdminController extends AppController {
    public $name = 'Admin';
    public $uses = array(
        'User',
        'Flag',
        'Mapping',
        'Collection',
        'MetadataEdit',
        'Comment',
        'Keyword',
        'Annotation'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Access->isAdmin()) {
            $this->Session->setFlash('You must be an Admin to access the Admin ' .
                ' console.', 'flash_error');
            $this->redirect('/');
        }

        $mappings = $this->Mapping->find('all', array(
            'conditions' => array(
                'Mapping.role' => 'Admin',
                'Mapping.id_user' => $this->Auth->user('id'),
                'Mapping.status' => 'confirmed'
            )
        ));
        if( empty($mappings) ){
            $this->Session->setFlash('You must be an Admin to access the Admin ' .
                ' console.', 'flash_error');
            $this->redirect('/');
            die;
        }
        $first = true;
        $otherParams = '';

        if( isset($this->request->params['pass']) && !empty($this->request->params['pass']) ){
            $_SESSION['currentProjectName'] = $this->request->params['pass'][0];
            if( count($this->request->params['pass']) > 1 ) {
                array_shift($this->request->params['pass']);
                $otherParams = implode("/", $this->request->params['pass']);
            }
        }

        if( isset($_SESSION['currentProjectName']) ){
            $first = false;
        }

        $projectPicker = '<select id="projectSelect" class="styled-select" style="color:rgb(124, 124, 124) !important;margin-top:200px" >';

        foreach ($mappings as $map) {
            $name = parent::getProjectNameFromPID($map['Mapping']['pid']);
            if ($name != '') {
                if( $first == true ){
                    $_SESSION['currentProjectName'] = $name;
                }
                if ($_SESSION['currentProjectName'] == $name) {
                    $first = false;
                    $projectPicker .= '<option selected="selected" disabled="" hidden="" value="" class="">' . $name . '</option>';
                } else {
                    $url = '/'.BASE_URL.'admintools/'.$this->request->params['action']."/".$name;
                    $projectPicker .= "<option value='" . $url . "' label='$name'>$name</option>";
                }
            }
        }
        $projectPicker .= "</select>";

        $url = '/'.BASE_URL.'admintools/'.$this->request->params['action']."/".$_SESSION['currentProjectName']."/".$otherParams;
        if( $_SERVER['REQUEST_URI']!=$url && $_SERVER['REQUEST_URI']!=$url.'/' ){
          if (!isset($_POST['api'])){
            echo '<script>window.location.replace("'.$url.'");</script>';
          }
        }
        $script = '<script>
                    window.onload = function(){
                        $("#projectSelect").change(function(){
                            window.location.replace(this.value);
                        })
                    }
                </script>';
        if (!isset($_POST['api'])){
          echo $projectPicker;
          echo $script;
        }

    }

    /**
     * Displays information about the system configuration.
     */
    public function status() {
        $this->set('core', array(
            'debug' => Configure::read('debug'),
            'database' => @ConnectionManager::getDataSource('default')
        ));
        $uploads_path = Configure::read('uploads.path');
        $this->set('uploads', array(
            'url' => Configure::read('uploads.url'),
            'path' => $uploads_path,
            'exists' => is_dir($uploads_path),
            'writable' => is_writable($uploads_path),
            'executable' => is_executable($uploads_path)
        ));
        clearstatcache();
        $ghostscript = '/usr/bin/gs';
        $this->set('dependencies', array(

            'Ghostscript' => is_executable($ghostscript),
            'Imagemagick' => class_exists('Imagick')
        ));
    }

    /**
     * Displays the error and debug logs.
     */
    public function logs() {
        $this->set(array(
            'error'  => @file_get_contents(LOGS . 'error.log'),
            'debug'  => @file_get_contents(LOGS . 'debug.log'),
            'worker' => @file_get_contents(LOGS . 'worker.log'),
            'relic'  => @file_get_contents(LOGS . 'relic.log')
        ));
    }

    /**
     * Add, edit, and delete users.
     */
    public function users() {
        $this->User->recursive = -1;
        $this->User->flatten = true;
        $this->set('users', $this->User->find('all', array(
            'order' => 'User.created'
        )));
    }

    /**
     * View resource and collection flags.
     */
    public function flags() {
        $pName = $this->request->params['pass'][0];
        $pid = parent::getPIDFromProjectName($pName);

        $pid = explode('-', $pid)[0];
        $hex = dechex($pid);

        $this->set('flags', $this->Flag->find('all', array(
            'order' => 'Flag.created DESC',
            'conditions' => array(
                'Flag.resource_kid LIKE' => "$hex%"
            )
        )));
    }


public function editFlags() {
    include_once("../Config/database.php");
    $db = new DATABASE_CONFIG();
    $db_object =  (object) $db;
    $db_array = $db_object->{'default'};
    $response['db_info'] = $db_array['host'];
    //$conn = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);
    //$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbHost = $db_array['host'];
    $database = $db_array['database'];
    $conn = new PDO("mysql:host=$dbHost;dbname=$database", $db_array['login'], $db_array['password']);


    if ($_POST['status'] == 'delete'){
      $user = $conn->prepare("DELETE FROM flags WHERE id = ?");
      $user->bindParam(1, $_POST['flagID'], PDO::PARAM_STR);
      $user->execute();
      //$row = $user->fetch(PDO::FETCH_ASSOC);
      // $row = $row['id'];
    }
    elseif ($_POST['status'] == 'edit'){
      //print_r($_POST);die;
      $user = $conn->prepare("UPDATE flags SET status = ? WHERE id = ?");
      $user->bindParam(1, $_POST['updateTo'], PDO::PARAM_STR);
      $user->bindParam(2, $_POST['flagID'], PDO::PARAM_STR);
      $user->execute();
    }



die;
}




    public function metadata_edits(){
        $this->set('metadata', $this->MetadataEdit->find('all', array(
        )));
    }

    /**
     * View and re-run jobs.
     */
    public function activity() {

        $_POST['task'] = "all";
        $_POST['username'] = "josh.christ";

        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $response['db_info'] = $db_array['host'];
        //$conn = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);
        //$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbHost = $db_array['host'];
        $database = $db_array['database'];
        $conn = new PDO("mysql:host=$dbHost;dbname=$database", $db_array['login'], $db_array['password']);

        $pName = $this->request->params['pass'][0];
        $pid = parent::getPIDFromProjectName($pName);

        $pid = explode('-', $pid)[0];
        $hex = dechex($pid);

        //get mappings
        if( $_POST['username'] == '' ){
            $table = self::getTable("SELECT id_user FROM mappings WHERE pid = $pid AND status = 'confirmed'", $conn);
            $mappingsArray = array();
            foreach($table as $key => $object){
                $mappingsArray[] = $object['id_user'];
            }
            $mappingsArray = "'". implode("','", $mappingsArray) ."'";
        }else{
            $user = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $user->bindParam(1, $_POST['username'], PDO::PARAM_STR);
            $user->execute();
            $row = $user->fetch(PDO::FETCH_ASSOC);
            $row = $row['id'];
            $mappingsArray = "'$row'";
        }

        //get individual stuffs
        $resultsArray = Array();
        if( $_POST['task'] == 'all' || $_POST['task'] == 'logins' ){ //get logins
            $table = self::getTable(
                "SELECT name,last_login as date,username,email  ".
                "FROM users ".
                "WHERE id IN ($mappingsArray) ".
                "ORDER BY last_login DESC",
                $conn, 'logins'
            );
            $resultsArray = array_merge($resultsArray, $table);
        }
        if( $_POST['task'] == 'all' || $_POST['task'] == 'annotations' ){
            $table = self::getTable(
                "SELECT user_name as name,modified as date,user_username as username,resource_name,resource_kid ".
                "FROM annotations ".
                "WHERE user_id IN (" .$mappingsArray. ") ".
                "AND resource_kid LIKE '$hex%' ".
                "ORDER BY modified DESC",
                $conn, 'annotations'
            );
            $resultsArray = array_merge($resultsArray, $table);
        }
        if(  $_POST['task'] == 'all' || $_POST['task'] == 'metadata_edits' ){
            //get usernames because they aren't in the metadata table
            $users = self::getTable("SELECT id,username FROM users WHERE id IN ($mappingsArray)", $conn);
            $userMappings = array();
            foreach( $users as $user ){
                $userMappings[$user['id']] = $user['username'];
            }
            //get the actual metadata edits
            $table = self::getTable(
                "SELECT user_name as name,modified as date,user_id,resource_name,resource_kid ".
                "FROM metadata_edits ".
                "WHERE user_id IN (" .$mappingsArray. ") ".
                "AND resource_kid LIKE '$hex%' ".
                "ORDER BY modified DESC",
                $conn, 'metadata'
            );
            foreach( $table as $key => $value ){
                $table[$key]['username'] = $userMappings[$value['user_id']];
                //$table[$key]['profilePic'] = checkProfilePicture($table[$key]['username']);
                $table[$key]['profilePic'] = "testing";
            }
            $resultsArray = array_merge($resultsArray, $table);
        }
        if( $_POST['task'] == 'all' || $_POST['task'] == 'flags' ){
            $table = self::getTable(
                "SELECT user_name as name,created as date,user_username as username,resource_name,resource_kid ".
                "FROM flags ".
                "WHERE user_id IN (" .$mappingsArray. ") ".
                "AND resource_kid LIKE '$hex%' ".
                "ORDER BY created DESC",
                $conn, 'flags'
            );
            $resultsArray = array_merge($resultsArray, $table);
        }

        //sort all of the returns by date..
        $date = array();
        foreach ($resultsArray as $key => $row){
            $date[$key] = $row['date'];
        }
        array_multisort($date, SORT_DESC, $resultsArray);

        //return
        $count = count($resultsArray);

        //$resultsArray = array_splice($resultsArray, $_POST['low'], $_POST['limit'], []);

        //$resultsArray = array_splice($resultsArray, "0", "20", []);
        //echo json_encode(array($resultsArray, $count));

        $this->set('activity', $resultsArray);
    }



    public function getTable($query, $conn, $type=''){
        $results = $conn->prepare($query);
        $results->execute();
        $resultsArray = Array();
        while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
            if ($type == 'logins' && !isset($row['date'])) {
                continue;
            }
            if (isset($row['username']) && isset($row['email'])) {
                //$row['profilePic'] = checkProfilePicture($row['username'], $row['email']);
                $row['profilePic'] = "testing";
            } elseif (isset($row['username'])) {
                //$row['profilePic'] = checkProfilePicture($row['username']);
                $row['profilePic'] = "testing";
            }
            $row['type'] = $type;
            array_push($resultsArray, $row);
        }
        return $resultsArray;
    }

    /**
     * Stats
     */
    public function stats() {
        $this->set(array(
            'user_count' => $this->User->find('count'),
            'resource_count' => $this->Resource->find('count'),
            'collection_count' => $this->Collection->find('count'),
            'metadatum_count' => $this->Metadatum->find('count'),
            'comment_count' => $this->Comment->find('count'),
            'annotation_count' => $this->Annotation->find('count'),
            'keyword_count' => $this->Keyword->find('count'),
            'flag_count' => $this->Flag->find('count')
        ));
    }

    /**
     * Additional admin tools
     */
    public function tools() {
    }
}
