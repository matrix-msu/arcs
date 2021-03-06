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

        $projectPicker = '<div id="projectSelectContainer" class="styled-select" style="display: block;
    float: right;
    margin-top: 108px;
    margin-right: 9%;
    margin-left: 15px;
    padding-right: 20px;
    cursor: pointer;
    -webkit-appearance: none;
    border: none;
    background: rgb(255, 255, 255);
    font-size: 16px;
    text-transform: capitalize;"><select id="projectSelect" class="styled-select" style="    color: rgb(124, 124, 124) !important;
    display: inline-block;
    cursor: pointer;
    -webkit-appearance: none;
    border: none;
    background: rgb(255, 255, 255);
    font-size: 16px;
    text-transform: capitalize;" >';

        $projectNameArray = array();

        foreach ($mappings as $map) {
            $name = parent::getProjectNameFromPID($map['Mapping']['pid']);
            $displayName = str_replace('_', ' ', $name);

            if ($name != '') {
                $projectNameArray[] = $name;
                if( $first == true ) {
                    $_SESSION['currentProjectName'] = $name;
                }
                if( $_SESSION['currentProjectName'] == $name ){
                    $first = false;
                    $projectPicker .= '<option selected="selected" disabled="" hidden="" value="" class="">' . $displayName . '</option>';
                }else{
                    $url = '/'.BASE_URL.'admintools/'.$this->request->params['action']."/".$name;
                    $projectPicker .= "<option value='" . $url . "' label='$name'>$displayName</option>";
                }
            }
        }

        $projectPicker .= "</select><span class=\"chevron\"></span></div>";

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
        $this->set('projectNames', $projectNameArray);

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


    public function ajaxGetProfilePics(){
        $namesAndEmails = $this->request->data['namesAndEmails'];
        $resultArray = array();

        foreach ($namesAndEmails as $username => $email) {
            $imageUrl = parent::checkForProfilePicture($username, $email);
            $resultArray[$username] = $imageUrl;
        }

        echo json_encode($resultArray, true);
        die;
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
            'order' => 'User.created DESC',
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
//            $cleanedReturn[$i]['profilePic'] = parent::checkForProfilePicture($cleanedReturn[$i]['username'], $cleanedReturn[$i]['email']);
            // set all profile pics to default and then load them with js
            $cleanedReturn[$i]['profilePic'] = '/' . BASE_URL . 'app/webroot/img/DefaultProfilePic.svg';
            $i++;
        }




        reset($cleanedReturn);
        $firstKey = key($cleanedReturn);
        $cleanedReturn[$firstKey]['projectNames'] = $this->viewVars['projectNames'];
        $this->set('users', $cleanedReturn);

    }


    public function accept($map_id) {
        $pName = $this->request->data['project'];
        $isAdmin = self::isAdminOfProject($pName);

        if (!$isAdmin) {
          // TODO: make an error message here
          die;
        }
        $pid = parent::getPIDFromProjectName($pName);

        // include_once("../Config/database.php");
        $db = new DATABASE_CONFIG();
        $db_object =  (object) $db;
        $db_array = $db_object->{'default'};
        $con=mysqli_connect($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);
        $mappings = mysqli_query($con, "SELECT * FROM mappings WHERE id_user = '$map_id'");
        $map = mysqli_fetch_array($mappings);
        $users = mysqli_query($con, "SELECT * FROM users WHERE id = '$map_id'");
        $user = mysqli_fetch_array($users);



        $response['db_info'] = $db_array['host'];
        $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
        }

        $sql = $mysqli->prepare("UPDATE mappings
                  SET status = 'confirmed',
                      activation = ''
                  WHERE (id_user = ? AND pid = ?)");
        $sql->bind_param("ss", $user['id'], $pid);
        $sql->execute();

        $sql = $mysqli->prepare("UPDATE users
                  SET status = 'active'
                  WHERE id = ?");
        $sql->bind_param("s", $user['id']);
        $sql->execute();

        self::acceptanceEmail($user, $pName, $map['role']);

        // mysqli_query($con, "UPDATE users SET status = 'active' WHERE id = '" . $user['id'] . "'");
        // mysqli_query($con, "UPDATE mappings SET status = 'confirmed', activation = '' WHERE id_user = '" . $user['id'] . "'");
        die;
    }

    public function isAdminOfProject($pName) {
      $Users = new UsersController;
      $signedIn = $Users->getUser($this->Auth);
      $id = $signedIn['User']['id'];
      $pid;

      try {
        $pid = parent::getPIDFromProjectName($pName);
      } catch (Exception $e) {
        return false;
      }
      // sql query on admins on the project
      $res = $this->Mapping->find('all', array(
        'fields' => array('Mapping.id_user'),
          'conditions' => array(
          'Mapping.id_user' => $id,
          'Mapping.role' => 'Admin',
          'Mapping.pid'  => $pid,
          'Mapping.status' => 'confirmed'
        )
      ));
      return !empty($res);
    }

    public function acceptanceEmail($user, $project, $role) {
        $Users = new UsersController;
        $adminEmails = $Users->getAdmins($project);

        $to = $user['email'];
        $subject = "ARCS Account Approval";
        $login_url = 'http://'.$_SERVER['HTTP_HOST'].'/'.BASE_URL.'#loginModal/';

        $txt = '';
        $txt .= "Hi there,<br /><br />
            We're happy to let you know that your account for the $project installation of the
            Archaeological Resource Cataloging System (ARCS) has been fully approved. You now have
            $role level access to this project.<br /><br />
            If you have any questions at all, please contact us at<br /><br />";
        foreach ($adminEmails as $email) {
            $txt .= $email."<br>";
        }
        $txt .= "Thanks much for your willingness to participate and collaborate on $project.<br /><br />
            Sincerely,<br /><br />
            $project Team<br /><br />";
        $txt .= "ARCS was developed by Michigan State University's MATRIX: The Center for Digital Humanities &
            Social Sciences with support from the National Endowment for the Humanities<br />";

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->emailFormat('html')
            ->subject($subject)
            ->to($user['email'])
            ->send($txt);
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
        // include_once("../Config/database.php");
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
        $pid = parent::getPIDFromProjectName($_SESSION['currentProjectName']);
        $pName = parent::getProjectNameFromPID($pid);
        $conditions = array( 'resource_kid LIKE' => "$pid-%");
        $metadata = $this->MetadataEdit->find('all', array(  'conditions' => $conditions, 'order' => 'modified DESC'));
        $resultsArray = array();
        $count = 0;
        $kidArray = array();

        foreach($metadata as $row) {
            $count++;
            if ($row['MetadataEdit']["user_id"]) {
                //$row["target"] = $row["annotation_target"];
                $id = $row['MetadataEdit']['user_id'];
                $user = $this->User->find('first', array('conditions'=>array('id'=>$id)));
                if( isset($user['User']) ) {
                    $row['MetadataEdit']['user_name'] = $user['User']['username'];
                    $row['MetadataEdit']['email'] = $user['User']['email'];
                }
            }
            array_push($resultsArray, $row);
            array_push($kidArray, $row['MetadataEdit']['resource_kid']);
        }

        //var_dump($metadata);

        $sid = parent::getResourceSIDFromProjectName(strtolower($pName));
        $fields = array('Title');
        $kidArray = array_values(array_unique($kidArray));
        //print_r($kidArray);
        //unset($kidArray[5]);
        //$kidArray = array_values($kidArray);
        //$kidArray = array("11-33-1070");

        //echo "<br><br><br>";
        //print_r( array_unique($kidArray) );
        $kora = new General_Search($pid, $sid, "KID", "IN", $kidArray, $fields);
        $resources = json_decode($kora->return_json(), true);

        foreach($resultsArray as $index => $row) {
            if( isset( $resources[$row['MetadataEdit']['resource_kid']] ) ){
                $resultsArray[$index]['MetadataEdit']['resource_name'] = $resources[$row['MetadataEdit']['resource_kid']]['Title'];
            }
        }

        //var_dump($resultsArray);die;
        $this->set('metadata', $resultsArray);
    }

        /**
         * View and re-run jobs.
         */
        public function activity() {
            // include_once("../Config/database.php");
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
            $hex = $pid;

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
                    $conn, 'Logged In'
                );
                $resultsArray = array_merge($resultsArray, $table);
            }
            if( $_POST['task'] == 'all' || $_POST['task'] == 'annotations' ){
                $table = self::getTable(
                    "SELECT user_name as name,modified as date,user_username as username,resource_name,resource_kid,user_email as email ".
                    "FROM annotations ".
                    "WHERE user_id IN ($mappingsArray) ".
                    "AND resource_kid LIKE '$hex%' ".
                    "ORDER BY modified DESC",
                    $conn, 'Created New Annotation'
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
                    $conn, 'Edited Metadata'
                );
                foreach( $table as $key => $value ){
                    $username = @$userMappings[$value['user_id']]['username'];
                    $email = @$userMappings[$value['user_id']]['email'];
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
                    $conn, 'Created New Flag'
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
//                    $resultsArray[$key]['profilePic'] = parent::checkForProfilePicture($value['username'], $value['email']);
                    $resultsArray[$key]['profilePic'] = '/' . BASE_URL . 'app/webroot/img/DefaultProfilePic.svg';
                }
                if( isset($value['date']) ) {
                    $resultsArray[$key]['date'] = parent::time_elapsed_string($value['date']);
                }
            }
            $this->set('activity', $resultsArray);
        }

    public function editMetadata(){
        // include_once("../Config/database.php");
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
                $email_subject = "Your ARCS Metadata Edit was Rejected";
                App::uses('CakeEmail', 'Network/Email');
                $Email = new CakeEmail();
                $Email->emailFormat('html')
                    ->subject($email_subject)
                    ->to($_POST['email'])
                    ->send($msg);
                echo json_encode($metadata_info);

            }
            elseif ($_POST['task'] == 'approve') {
                //add sql sanitization
                //bindparam
                $dec=decbin(1);
                $approve = $con -> prepare("UPDATE metadata_edits SET approved = ? WHERE id = ?");
                $approve->bind_param('is', $dec, $_POST['id']);
                $approve->execute();

                $mysqli = $con -> prepare("SELECT * FROM metadata_edits WHERE id=?");
                $mysqli->bind_param('s',$_POST['id']);
                $mysqli->execute();
                $mysqli_result = $mysqli->get_result();
                $metadata_row = $mysqli_result->fetch_assoc();

                $metadata_kid = $metadata_row['metadata_kid'];
                $scheme_id = $metadata_row['scheme_id'];
                $field_name = $metadata_row['field_name'];
                $new_value = $metadata_row['new_value'];
                $control_type = $metadata_row['control_type'];

                //Get the resource from kora
                //use the kora 3 api because that will be formatted for updating.
                $pName = parent::convertKIDtoProjectName($metadata_kid);
//                $sid = parent::getResourceSIDFromProjectName($pName);
                $pid = parent::getPIDFromProjectName($pName);
                $token = parent::getTokenFromProjectName($pName);
                $fields = 'ALL';
                $kora_field_name = $field_name.'_'.$pid.'_'.$scheme_id.'_';

                $query = array(
                    'forms'=>json_encode(array(
                        array(
                            'form'=>$scheme_id,
                            'token'=>$token,
                            'query'=>array(
                                array(
                                    'search'=>'kid',
//                                    'fields'=>'name',
                                    'kids'=>(array($metadata_kid)),
                                )
                            )
                        )
                    ))
                );

                $url = KORA_RESTFUL_URL.'search';
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $resource = curl_exec($ch);
                curl_close($ch);

				$controlMap = array(
					'Text' => 'text',
					'List' => 'option',
					'Multi-Select List' => 'options',
					'Associator' => 'records',
                    'Generated List' => 'options'
				);

                $resource = json_decode($resource, true)['records'][0][$metadata_kid];
                //echo json_encode($resource);die;

				foreach( $resource as $field => $value ){
					$resource[$field]['name'] = $field;
					$control_type_kora = $resource[$field]['type'];
					if( $control_type_kora == 'Date' ){
						$resource[$field] = array_merge($resource[$field], $resource[$field]['value']);
					}else{
						$resource[$field][$controlMap[$control_type_kora]] = $resource[$field]['value'];
					}
				}

				//echo 'here'; print_r($new_value);die;

                $resource[$kora_field_name]['name'] = $kora_field_name;
				//change the edit to an array or object if needed
				if(  $control_type == 'multi_select' ){
					$temp = array();
					$temp = preg_split("/\\r\\n|\\r|\\n/", $new_value );
					//$new_value = $temp;
					$resource[$kora_field_name]['options'] = $temp;
					$resource[$kora_field_name]['value'] = $temp;

				 }elseif( $control_type == 'multi_input' ){
				 	$temp = array();
				 	$temp = preg_split("/\\r\\n\\r\\n|\\r\\r|\\n\\n/", $new_value );
				 	$resource[$kora_field_name]['options'] = $temp;
				 	$resource[$kora_field_name]['value'] = $temp;

				}elseif(  $control_type == 'associator' ) {
					$temp = array();
					$temp = preg_split("/\\r\\n|\\r|\\n/", $new_value );
					$resource[$kora_field_name]['records'] = $temp;
					$resource[$kora_field_name]['value'] = $temp;

				}elseif( $control_type == 'list' ){
					$resource[$kora_field_name]['option'] = $new_value;
					$resource[$kora_field_name]['value'] = $new_value;

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
					$check = $valueArray[0];
					$era = $valueArray[1];
					$dateArray = array();
					$dateArray = explode('-', $check);
					$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
					    'September', 'October', 'November', 'December');
					$month = strval( array_search($dateArray[2], $months) + 2 ); //+1 because in kora, january = 1
					$day = $dateArray[2];
					$year = $dateArray[0];

					$resource[$kora_field_name]['year'] = $year;
					$resource[$kora_field_name]['month'] = $month;
					$resource[$kora_field_name]['day'] = $day;
					$resource[$kora_field_name]['era'] = $era;
					$resource[$kora_field_name]['circa'] = '0';
					$resource[$kora_field_name]['value'] = $resource[$kora_field_name]['value'];

				}elseif( $control_type == 'text' ){
					$resource[$kora_field_name]['text'] = $new_value;
					$resource[$kora_field_name]['value'] = $new_value;
				}
				// echo json_encode($resource);die;
                if(isset($resource['kid'])){
                    unset($resource['kid']);
                }
                if(isset($resource['legacy_kid'])){
                    unset($resource['legacy_kid']);
                }
                if(isset($resource['project_id'])){
                    unset($resource['project_id']);
                }
                if(isset($resource['form_id'])){
                    unset($resource['form_id']);
                }
                if(isset($resource['owner'])){
                    unset($resource['owner']);
                }
                if(isset($resource['created_at'])){
                    unset($resource['created_at']);
                }
                if(isset($resource['updated_at'])){
                    unset($resource['updated_at']);
                }
                if(isset($resource['reverseAssociations'])){
                    unset($resource['reverseAssociations']);
                }

                $return = $this->editK3Metadata($metadata_kid, $resource, $scheme_id);
                echo json_encode($return);
//                return $return;
            }
//            elseif($_POST['task'] == 'updateEdit') {
//                $result = array();
//                $result[] = 'updateEdit';
//                $result['text'] = $_POST['text'];
//                $flags = mysqli_query($con, "UPDATE metadata_edits SET new_value = '".$_POST['text']."' WHERE id = '" . $_POST['id'] . "'");
//
//                echo json_encode($result);
//
//            }elseif ($_POST['task'] == 'deleteRow') {
//                $flags = mysqli_query($con, "DELETE FROM metadata_edits WHERE id = '" . $_POST['id'] . "'");
//                echo json_encode('Delete Metadata Success');
//            }
        }

        die;
    }


    public function editK3Metadata($metadata_kid, $resource, $scheme_id){
        echo 'in herererere';
        echo "kid $metadata_kid";
        print_r($resource);
        print_r($scheme_id);
        $return = array();
        //format the resource variable(array) to whatever kora expects
        $return['formattedArray'] = $resource;
        //set up kora api update call
        $pName = parent::convertKIDtoProjectName($metadata_kid);
        $pid = parent::getPIDFromProjectName($pName);
        $token = parent::getTokenFromProjectName($pName);
//        $sid = parent::getResourceSIDFromProjectName($pName);


        //$resource = array($metadata_kid => $resource);

//       $resource['Title_11_33_'] = array (
//           'value' => 'TEST -- Trench on completion of excavation --test3',
//           'type' => 'Text',
//           'name' => 'Title_11_33_',
//           'text' => 'TEST -- Trench on completion of excavation --test3',
//       );

        $query = array(
            '_method'=>'put',
            'form'=>$scheme_id,
            'token'=>$token,
            'kid'=> $metadata_kid,
            'keepFields'=>"true",
            'fields'=>json_encode($resource),
        );

     //   print_r($resource);
//        print_r($query);
//        die;
//

        $return['query'] = $query;
        $url = KORA_RESTFUL_URL.'edit';
//        $url = 'http://dev2.matrix.msu.edu/k3beta/public/api/edit';
        $return['url'] = $url;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($query));
        $result = curl_exec($ch);
        curl_close($ch);


         echo ($result);
//         die;
//         $return['curlReturn'] = $result;

        return $return;
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
