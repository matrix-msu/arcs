<?php
App::uses('ConnectionManager', 'Model');
App::import('Controller', 'Users');

require_once(KORA_LIB . "General_Search.php");
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
        $pid = parent::getPIDFromProjectName($_SESSION['currentProjectName']);

        $project_users = $this->Mapping->find('list', array(
            'fields' => array(


                'Mapping.status',
                'Mapping.role',
                'Mapping.id_user',
            ),
            'conditions' => array(
                    'Mapping.pid' => $pid
                ),
            )
        );
        foreach( $project_users as $id => $info ){
            $status = key($info);
            $role = $info[$status];
            $project_users[$id] = array( 'role'=> $role, 'status' => $status );
        }

        $mappingUserIds = array_keys($project_users);
        $userReturn = $this->User->find('all', array(
            'order' => 'User.created',
            'conditions' => array(
                    'User.id' => $mappingUserIds
                    ),
        ));

        foreach ($userReturn as $key => $user) {
            $userReturn[$key]['User']['role'] = $project_users[$user['User']['id']]['role'];
            $userReturn[$key]['User']['status'] = $project_users[$user['User']['id']]['status'];
        }


        $cleanedReturn = array();//getting rid of the 'User'
        $i = 0;
        foreach ($userReturn as $user) {
            array_push($cleanedReturn, $user['User']);
            $cleanedReturn[$i]['profilePic'] = parent::checkForProfilePicture($cleanedReturn[$i]['username'], $cleanedReturn[$i]['email']);
            $i++;
        }
        $this->set('users', $cleanedReturn);
    }


    public function accept($map_id) {
        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $con=mysqli_connect($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);
        $mappings = mysqli_query($con, "SELECT * FROM mappings WHERE id_user = '$map_id'");
        $map = mysqli_fetch_array($mappings);
        $users = mysqli_query($con, "SELECT * FROM users WHERE id = '$map_id'");
        $user = mysqli_fetch_array($users);
        $project = "";


        foreach ($GLOBALS['PID_ARRAY'] as $name => $pid) {
            if ($map["pid"] == $pid) {
                $project = $name;
            }
        }

        self::acceptanceEmail($user, $project, $map['role']);

        mysqli_query($con, "UPDATE users SET status = 'active' WHERE id = '" . $user['id'] . "'");
        mysqli_query($con, "UPDATE mappings SET status = 'confirmed', activation = '' WHERE id_user = '" . $user['id'] . "'");
        die;
    }

    public function acceptanceEmail($user, $project, $role) {
        $Users = new UsersController;
        $adminEmails = $Users->getAdmins($project);

        $to = $user['email'];
        $subject = "ARCS Account Approval";
        $login_url = 'http://'.$_SERVER['HTTP_HOST'].'/'.BASE_URL.'#loginModal/';

        $txt = '';
        $txt .= "<p>Hi there,</p>";
        $txt .= "<p>An ARCS administrator approved your account.</p>";
        $txt .= "<p>You should be good to go!</p>";
        $txt .= "<p>If you have any questions at all, please contact us:</p>";
        foreach ($adminEmails as $email) {
            $txt .= $email."<br>";
        }
        $txt .= '<br>';
        $txt .= "<p>ARCS was developed by Michigan State University's MATRIX: ";
        $txt .= "The Center for Digital Humanities & Social Sciences with support ";
        $txt .= "from the National Endowment for the Humanities<p>";

        $headers = '';
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html\r\n";
        $headers .= "From: \"ARCS\" <arcs@arcs.matrix.msu.edu>\r\n";
        $headers .= "To: " . $user['email'] . "\r\n";

        $success = mail($to, $subject, $txt, $headers);
    }






    /**
     * View resource and collection flags.
     */
    public function flags() {

        $pName = $this->request->params['pass'][0];
        $pid = parent::getPIDFromProjectName($pName);

        $pid = explode('-', $pid)[0];
//        $hex = dechex($pid);
        //echo $hex;die;
        $this->set('flags', $this->Flag->find('all', array(
            'order' => 'Flag.created DESC',
            'conditions' => array(
                'Flag.resource_kid LIKE' => "$pid-%"
            )
        )));
    }


    public function editFlags() {
        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $response['db_info'] = $db_array['host'];
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
          $user = $conn->prepare("UPDATE flags SET status = ? WHERE id = ?");
          $user->bindParam(1, $_POST['updateTo'], PDO::PARAM_STR);
          $user->bindParam(2, $_POST['flagID'], PDO::PARAM_STR);
          $user->execute();
        }
        die;
    }




    public function metadata_edits(){
        echo "<script>console.log('test');</script>";
        $metadata = $this->MetadataEdit->find('all', array());
        $resultsArray = array();
        $count = 0;
        foreach($metadata as $row) {
            $count++;
            if ($row['MetadataEdit']["user_id"]) {
                //$row["target"] = $row["annotation_target"];
                $id = $row['MetadataEdit']['user_id'];
                $user = $this->User->find('first', array('conditions'=>array('id'=>$id)));
                $row['MetadataEdit']['user_name'] = $user['User']['username'];
                $row['MetadataEdit']['email'] = $user['User']['email'];
            }
            array_push($resultsArray, $row);
        }

        $this->set('metadata', $resultsArray);
    }

        /**
         * View and re-run jobs.
         */
        public function activity() {
            include_once("../Config/database.php");
            $db = new DATABASE_CONFIG();

            $_POST['task'] = "all";
            $_POST['username'] = "";

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
                    "SELECT user_name as name,modified as date,user_username as username,resource_name,resource_kid,user_email as email ".
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
                $users = self::getTable("SELECT id,username,email FROM users WHERE id IN ($mappingsArray)", $conn);
                $userMappings = array();
                foreach( $users as $user ){
                    $userMappings[$user['id']] = array('username'=>$user['username'],'email'=>$user['email']);
                    //$userMappings[$user['id']] = $user['username'];
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
                    $username = $userMappings[$value['user_id']]['username'];
                    $email = $userMappings[$value['user_id']]['email'];
                    $table[$key]['username'] = $username;
                    $table[$key]['email'] = $email;
                }
                $resultsArray = array_merge($resultsArray, $table);
            }
            if( $_POST['task'] == 'all' || $_POST['task'] == 'flags' ){
                $table = self::getTable(
                    "SELECT user_name as name,created as date,user_username as username,resource_name,resource_kid,user_email as email ".
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

            //get the profile pic and formatted date
            foreach( $resultsArray as $key => $value ){
                if( isset($value['username']) ) {
                    if( !isset($value['email']) ){
                        $value['email'] = '';
                    }
                    $resultsArray[$key]['profilePic'] = parent::checkForProfilePicture($value['username'], $value['email']);
                }
                if( isset($value['date']) ) {
                    $resultsArray[$key]['date'] = parent::time_elapsed_string($value['date']);
                }
            }
            $this->set('activity', $resultsArray);
        }




    public function editMetadata(){
        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $con=mysqli_connect($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);
        $user = "";
        $pass = "";
        $display = "json";
        $result = Array();

        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        } else {
            if ($_POST['task'] == 'reject' && $_POST['reason'] != NULL ) {
                $flags = mysqli_query($con, "UPDATE metadata_edits SET rejected = '".decbin(1)."', reason_rejected='".$_POST['reason']."', approved = '".decbin(0)."' WHERE id = '" . $_POST['id'] . "'");

                $metadata_info = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM metadata_edits WHERE id='".$_POST['id']."'"),MYSQL_ASSOC);


                // the message
                $msg = '<h3>The metadata edit you submitted was rejected for the following reason:</h3>'
                    . '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $metadata_info['reason_rejected'] . "</p>"
                    . '<h4>Other information about this metadata edit:</h4>';
                unset( $metadata_info['reason_rejected'] );

                foreach( $metadata_info as $key => $value ){
                    $msg .= '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $key . ' : ' . $value . "</p>";
                }

                // send email
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: Noreply <noreply@matrix.msu.edu>' . "\r\n";
                $email_subject = "Your ARCS Metadata Edit was Rejected";

                mail($_POST['email'], $email_subject, $msg, $headers);

                echo json_encode($metadata_info);
            }
            elseif ($_POST['task'] == 'approve') {
                $approve = mysqli_query($con, "UPDATE metadata_edits SET approved = '".decbin(1)."' WHERE id = '" . $_POST['id'] . "'");
                $metadata_row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM metadata_edits WHERE id='".$_POST['id']."'"));
                $metadata_kid = $metadata_row['metadata_kid'];
                $scheme_id = $metadata_row['scheme_id'];
                $field_name = $metadata_row['field_name'];
                $new_value = $metadata_row['new_value'];
                $control_type = $metadata_row['control_type'];

                //Get the resource from kora

                $pName = parent::convertKIDtoProjectName($metadata_kid);
                $sid = parent::getResourceSIDFromProjectName($pName);
                $pid = parent::getPIDFromProjectName($pName);
                $fields = array('ALL');
                $kora = new General_Search($pid, $sid, 'kid', '=', $metadata_kid, $fields);
                $resource = json_decode($kora->return_json(), true);

                //$resource = koraSearchKidWrapper($metadata_kid);

                $resource = $resource[$metadata_kid];
                $result['resource'] = $resource;
                $result['new_value:'] = $new_value;
                if( $resource['kid']) {
                    unset($resource['kid']);
                }

                //change the edit to an array or object if needed
                if( $control_type == 'multi_input' || $control_type == 'multi_select' || $control_type == 'associator' ){
                    $temp = array();
                    $temp = preg_split("/\\r\\n|\\r|\\n/", $new_value );
                    $new_value = $temp;
                }elseif( $control_type == 'date' || $control_type == 'terminus' ){
                    $month = '';
                    $day = '';
                    $year = '';
                    $prefix = '';
                    $era = '';

                    $valueArray = array();
                    $valueArray = explode(" ", $new_value);
                    $dateString = '';
                    if( strpos($valueArray[0], '/') === false ){     // '/' does not exist in array value, it is the prefix
                        $prefix = $valueArray[0];
                        $dateString = $valueArray[1];
                        if( array_key_exists(2,$valueArray) ) { //does exist
                            $era = $valueArray[2];
                        }

                    }else{      // '/' does exit it is the date
                        $dateString = $valueArray[0];
                        if( array_key_exists(1,$valueArray) ) { //does exist
                            $era = $valueArray[1];
                        }
                    }
                    $dateArray = array();
                    $dateArray = explode('/', $dateString);
                    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December');
                    $month = strval( array_search($dateArray[0], $months) + 1 ); //+1 because in kora, january = 1
                    $day = $dateArray[1];
                    $year = $dateArray[2];
                    $dateObject = new stdClass;
                    $dateObject->month = $month;
                    $dateObject->day = $day;
                    $dateObject->year = $year;
                    $dateObject->era = $era;
                    $dateObject->prefix = $prefix;
                    $dateArray2 = array();
                    $dateArray2['month'] = $month;
                    $dateArray2['day'] = $day;
                    $dateArray2['year'] = $year;
                    $dateArray2['era'] = $era;
                    $dateArray2['prefix'] = $prefix;

                    $new_value = $dateArray2;
                }

                //*** Do the actual edit here! then wrap in Record tag.
                $resource[$field_name] = $new_value;
                $result['new_value:'] = $new_value;
                $result['resources after new value:'] = $resource;
                $record_array = array();
                $record_array['Record'] = $resource;
                array_push($result, $record_array);
                $json = json_encode($resource);
                array_push($result, $json );
                $json2 = json_decode($json);
                array_push($result, $json2 );

                //Build the XML
                $xml =<<<XML
<?xml version="1.0" encoding="ISO-8859-1"?><Data><ConsistentData/></Data>
XML;

                $xml_data = new SimpleXMLElement($xml);
                self::array_to_xml($record_array, $xml_data, $result);
                $xml = $xml_data->asXML();
                $xml = str_replace("\n", '', $xml);

                array_push($result, $xml);

                //Update the resource in kora
                $token = parent::getTokenFromProjectName($pName);
                $url = KORA_RESTFUL_URL."?request=UPDATE&pid=".$pid."&sid=".$scheme_id."&token=".$token."&rid=".$metadata_kid."&xml=".urlencode($xml);
                array_push($result, $url);
                //initialize post request to KORA API using curl
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
                //capture results and display
                $update = json_decode(curl_exec($ch), true);
                //array_push($result, $update);

                echo json_encode($result);
            }
            elseif($_POST['task'] == 'updateEdit') {
                $result = array();
                $result[] = 'updateEdit';
                $result['text'] = $_POST['text'];
                $flags = mysqli_query($con, "UPDATE metadata_edits SET new_value = '".$_POST['text']."' WHERE id = '" . $_POST['id'] . "'");

                echo json_encode($result);

            }elseif ($_POST['task'] == 'deleteRow') {
                $flags = mysqli_query($con, "DELETE FROM metadata_edits WHERE id = '" . $_POST['id'] . "'");
                echo json_encode('Delete Metadata Sucess');
            }
        }
        die;
    }
    //build the xml to send to kora
    public function array_to_xml( $data, $xml_data, $result ) {
        foreach( $data as $key => $value ) {
            if($key == 'Record') {  //treat record tag specially
                $subnode = $xml_data->addChild($key);
                self::array_to_xml($value, $subnode, $result);
            }elseif( is_array($value) ) {
                if ( is_numeric(key($value)) ) {  //multi-select, multi-input, and associator controls here
                    foreach ($value as $list_key => $list_value) {
                        $xml_data->addChild(str_replace(' ', '_', $key), htmlspecialchars("$list_value"));
                    }
                } else { //dates and terminus controls here
                    $string = "";
                    $was_there_prefix = 0;
                    $prefix = '';
                    foreach ($value as $list_key => $list_value) {
                        if (strcmp($list_key, 'prefix') === 0 && strcmp($list_value, '') !== 0) {
                            $prefix = $list_value;
                            $was_there_prefix = 1;

                        }elseif( strcmp($list_key, 'month') === 0 || strcmp($list_key, 'day') === 0 ) {
                            $string = $string . $list_value . '/';

                        }elseif( strcmp($list_key, 'year') === 0 ) {
                            $string = $string . $list_value;

                        }elseif( strcmp($list_key, 'era') === 0 && strcmp($list_value, '') !== 0 ) {
                            $string = $string . ' ' . $list_value;
                        }
                    }
                    if ($was_there_prefix == 1) {
                        $has_prefix = $xml_data->addChild(str_replace(' ', '_', $key), htmlspecialchars("$string"));
                        $has_prefix->addAttribute('prefix', $prefix);
                    } else {
                        $xml_data->addChild(str_replace(' ', '_', $key), htmlspecialchars("$string"));
                    }
                }
            }elseif($value != "") { //text controls
                $xml_data->addChild(str_replace(' ', '_', $key),htmlspecialchars("$value"));
            }
        }
    }


    public function getTable($query, $conn, $type=''){
        $results = $conn->prepare($query);
        $results->execute();
        $resultsArray = Array();
        while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
            if ($type == 'logins' && !isset($row['date'])) {
                continue;
            }
//            if (isset($row['username']) && isset($row['email'])) {
//                //$row['profilePic'] = checkProfilePicture($row['username'], $row['email']);
//                $row['profilePic'] = "testing";
//            } elseif (isset($row['username'])) {
//                //$row['profilePic'] = checkProfilePicture($row['username']);
//                $row['profilePic'] = "testing";
//            }
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
