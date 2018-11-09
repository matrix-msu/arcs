<?php

//require_once("UsersController.php");

/**
 * Installation Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */

App::import('Controller', 'Users');

class InstallationsController extends AppController
{

    public $name = 'Installations';
    public $uses = array('User', 'Mapping');

    public function beforeFilter()
    {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $linkParts = explode("/", $actual_link);

        if (CONFIGURED == 'true' && in_array('installation', $linkParts)) {
            $this->redirect('/');
        }

        session_start();

        parent::beforeFilter();
        $this->Auth->allow(
            'display', 'fieldConfig',
            'createProject', 'arcsConfig', 'finalize'
        );
        if ($this->request->params['action'] != 'periodo' && $this->request->params['action'] != 'finalize') {
            echo "<script>var JS_IS_INSTALTION_PAGE = true;</script>";
        }
    }

    public function register()
    {
        $this->set(array(
            'title_for_layout' => 'index'
        ));
        $this->render("register");
    }

    /**
     * Displays the start installation page
     */
    public function display()
    {
        $this->set(array(
            'title_for_layout' => 'Install ARCS'
        ));
        $this->render("index");
    }

    /**
     * Displays the Kora Configuration page
     */
    public function koraConfig()
    {
        $this->set(array(
            'title_for_layout' => 'Install ARCS'
        ));
        $this->render("kora_config");

    }

    /**
     * Displays the Field Configuration page
     */
    public function fieldConfig()
    {
        if ($_POST) {
            $_SESSION['KoraConfig'] = $_POST;
        }

        $this->set(array(
            'title_for_layout' => 'Install ARCS'
        ));
        $this->render("field_config");
    }

    /**
     * Displays the Create Project page
     */
    public function createProject()
    {
        if ($_POST) {
            $_SESSION['FieldConfig'] = $_POST;
        }

        $this->set(array(
            'title_for_layout' => 'Install ARCS'
        ));
        $this->render("create_project");
    }

    /**
     * Displays the ARCS Configuration page
     */
    public function arcsConfig()
    {
        if ($_POST) {
            $_SESSION['ProjectConfig'] = $_POST;
        }

        $this->set(array(
            'title_for_layout' => 'Install ARCS'
        ));
        $this->render("arcs_config");
    }

    /*
    * takes all user input and finalizes their kora installation by writing
    * straight to the kora DB
    */
    public function finalize()
    {
        if ($_POST) {
            $_SESSION['ArcsConfig'] = $_POST;
        }
        $path = APP . "Config/bootstrap.php";
        $contents = file_get_contents($path);
        $pName = trim(strtolower(str_replace(" ", "_", $_SESSION['ProjectConfig']['Persistent_Name'])));
        $contents = str_replace(
            'define("BASE_BOTH", "");',
            'define("BASE_BOTH", "' . $_SESSION['ArcsConfig']['ArcsBaseURL'] . '");',
            $contents
        );

        if (isset($GLOBALS['PID_ARRAY']) && isset($GLOBALS['PID_ARRAY']['arcs'])) {
            $pid = $GLOBALS['PID_ARRAY']['arcs'];
            $contents = str_replace(
                "'arcs' =>",
                "'" . $pName . "' =>",
                $contents
            );
//
            $conn = new mysqli(KORA_HOST, KORA_USER, KORA_PASS, KORA_DB);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            foreach ($_SESSION as $key => $value) {
                if ($key == "Config" || $key == "Message" || $key == "Auth" || $key == "currentProjectName" || $key == "ProjectConfig" || $key == "ArcsConfig") {
                    continue;
                }
                foreach ($value as $key2 => $value2) {

                    $newKey = str_replace("_", " ", $key2);
                    $sql = $conn->prepare(
                        "SELECT * FROM kora3_fields
                          WHERE NAME = ? AND pid = ?"
                    );
                    $sql->bind_param('ss', $newKey, $pid);
                    $sql->execute();
                    $result = $sql->get_result();
                    if ($sql->num_rows > 0) {
                        $insert = "";
                        $type = $sql->fetch_assoc()['type'];
                        if ($type == "List" || $type == "Multi-Select List") {
                            $insert .= "[!Options!]";
                            for ($i = 0; $i < sizeof($value2); $i++) {
                                $insert .= trim($value2[$i]);
                                if (($i + 1) != sizeof($value2)) {
                                    $insert .= "[!]";
                                }
                            }
                            $insert .= "[!Options!]";
                            $sql = $conn->prepare(
                                "UPDATE kora3_fields
                                   SET options = ?
                                   where name = ? and pid = ?"
                            );
                            $sql->bind_param('sss', $insert, $newKey, $pid);
                            $sql->execute();
                        }
                    }
                }
            }
            $conn->close();

            $usersC = new UsersController();
            $mappingProjects = array();
            array_push($mappingProjects, array(
                'project' => array('name' => $pName, 'pid' => $pid),
                'role' => array('name' => 'Admin', 'value' => 'Admin')
            ));
            $addUserData = array(
                'name' => $_SESSION['ArcsConfig']['ArcsAdminName'],
                'username' => $_SESSION['ArcsConfig']['ArcsAdminUsername'],
                'email' => $_SESSION['ArcsConfig']['ArcsAdminEmail'],
                'password' => $_SESSION['ArcsConfig']['ArcsAdminPassword'],
                'isAdmin' => 1,
                'last_login' => null,
                'status' => 'confirmed'
            );
            $response["status"] = $this->User->add($addUserData);
            if ($response["status"] == false) {
                $response["message"] = $this->User->invalidFields();
                return $this->json(400, ($response));
            }
            $usersC->editMappings($mappingProjects, array(), $response["status"]['User']['id']);

            if( isset($GLOBALS['PROJECT_SID_ARRAY']['arcs']) && isset($GLOBALS['TOKEN_ARRAY']['arcs']) ){
                $projectSid = $GLOBALS['PROJECT_SID_ARRAY']['arcs'];
                $pidSid = "_" . $pid . "_" . $projectSid . "_";

                $query['Name' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Name"];
                $query['Name' . $pidSid]["type"] = 'Text';
                $query['Location_Identifier' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Location_Identifier"];
                $query['Location_Identifier' . $pidSid]["type"] = 'Text';
                $query['Location_Identifier_Scheme' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Location_Identifier_Scheme"];
                $query['Location_Identifier_Scheme' . $pidSid]["type"] = 'Text';
                $query['Elevation' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Elevation"];
                $query['Elevation' . $pidSid]["type"] = 'Text';
                $query['Persistent_Name' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Persistent_Name"];
                $query['Persistent_Name' . $pidSid]["type"] = 'Text';
                $query['Complex_Title' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Complex_Title"];
                $query['Complex_Title' . $pidSid]["type"] = 'Text';
                $query['Description' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Description"];
                $query['Description' . $pidSid]["type"] = 'Text';
                $query['Brief_Description' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Brief_Description"];
                $query['Brief_Description' . $pidSid]["type"] = 'Text';
                if (isset($_SESSION['ProjectConfig']["Region"])) {
                    $query['Country' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Region"];
                    $query['Country' . $pidSid]["type"] = 'List';
                }
                if (isset($_SESSION['ProjectConfig']["Country"])) {
                    $query['Country' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Country"];
                    $query['Country' . $pidSid]["type"] = 'List';
                }
                if (isset($_SESSION['ProjectConfig']["Modern_Name"])) {
                    $query['Modern_Name' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Modern_Name"];
                    $query['Modern_Name' . $pidSid]["type"] = 'List';
                }
                if (isset($_SESSION['ProjectConfig']["Records_Archive"])) {
                    $query['Records_Archive' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Records_Archive"];
                    $query['Records_Archive' . $pidSid]["type"] = 'Multi-Select List';
                }
                if (isset($_SESSION['ProjectConfig']["Period"])) {
                    $query['Period' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Period"];
                    $query['Period' . $pidSid]["type"] = 'Multi-Select List';
                }
                if (isset($_SESSION['ProjectConfig']["Permitting_Heritage_Body"])) {
                    $query['Permitting_Heritage_Body' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Permitting_Heritage_Body"];
                    $query['Permitting_Heritage_Body' . $pidSid]["type"] = 'Multi-Select List';
                }
                if (isset($_SESSION['ProjectConfig']["Geolocation"])) {
                    $query['Geolocation' . $pidSid]["value"] = $_SESSION['ProjectConfig']["Geolocation"];
                    $query['Geolocation' . $pidSid]["type"] = 'Generated List';
                }
                if (
                    isset($_SESSION['ProjectConfig']["Earliest_Date_Month"])||
                    isset($_SESSION['ProjectConfig']["Earliest_Date_Day"])||
                    isset($_SESSION['ProjectConfig']["Earliest_Date_Year"])
                ) {
                    $query['Earliest_Date' . $pidSid]["value"] = array(
                        'circa' => "0",
                        'era' => "CE"
                    );
                    if( isset($_SESSION['ProjectConfig']["Earliest_Date_Month"]) ) {
                        $query['Earliest_Date' . $pidSid]["value"]['month'] = $_SESSION['ProjectConfig']["Earliest_Date_Month"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Earliest_Date_Day"]) ) {
                        $query['Earliest_Date' . $pidSid]["value"]['day'] = $_SESSION['ProjectConfig']["Earliest_Date_Day"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Earliest_Date_Year"]) ) {
                        $query['Earliest_Date' . $pidSid]["value"]['year'] = $_SESSION['ProjectConfig']["Earliest_Date_Year"];
                    }
                    $query['Earliest_Date' . $pidSid]["type"] = 'Date';
                }
                if (
                    isset($_SESSION['ProjectConfig']["Latest_Date_Month"])||
                    isset($_SESSION['ProjectConfig']["Latest_Date_Day"])||
                    isset($_SESSION['ProjectConfig']["Latest_Date_Year"])
                ) {
                    $query['Latest_Date' . $pidSid]["value"] = array(
                        'circa' => "0",
                        'era' => "CE"
                    );
                    if( isset($_SESSION['ProjectConfig']["Latest_Date_Month"]) ) {
                        $query['Latest_Date' . $pidSid]["value"]['month'] = $_SESSION['ProjectConfig']["Latest_Date_Month"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Latest_Date_Day"]) ) {
                        $query['Latest_Date' . $pidSid]["value"]['day'] = $_SESSION['ProjectConfig']["Latest_Date_Day"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Latest_Date_Year"]) ) {
                        $query['Latest_Date' . $pidSid]["value"]['year'] = $_SESSION['ProjectConfig']["Latest_Date_Year"];
                    }
                    $query['Latest_Date' . $pidSid]["type"] = 'Date';
                }
                if (
                    isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Month"])||
                    isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Day"])||
                    isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Year"])||
                    isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Period"])
                ) {
                    $query['Terminus_Ante_Quem' . $pidSid]["value"] = array(
                        'circa' => "0"
                    );
                    if( isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Month"]) ) {
                        $query['Terminus_Ante_Quem'.$pidSid]["value"]['month'] = $_SESSION['ProjectConfig']["Terminus_Ante_Quem_Month"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Day"]) ) {
                        $query['Terminus_Ante_Quem'.$pidSid]["value"]['day'] = $_SESSION['ProjectConfig']["Terminus_Ante_Quem_Day"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Year"]) ) {
                        $query['Terminus_Ante_Quem'.$pidSid]["value"]['year'] = $_SESSION['ProjectConfig']["Terminus_Ante_Quem_Year"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Period"]) ) {
                        $query['Terminus_Ante_Quem'.$pidSid]["value"]['era'] = $_SESSION['ProjectConfig']["Terminus_Ante_Quem_Period"];
                    }
                    $query['Terminus_Ante_Quem'.$pidSid]["type"] = 'Date';
                }
                if (
                    isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Month"])||
                    isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Day"])||
                    isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Year"])||
                    isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Period"])
                ) {
                    $query['Terminus_Post_Quem' . $pidSid]["value"] = array(
                        'circa' => "0"
                    );
                    if( isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Month"]) ) {
                        $query['Terminus_Post_Quem'.$pidSid]["value"]['month'] = $_SESSION['ProjectConfig']["Terminus_Post_Quem_Month"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Day"]) ) {
                        $query['Terminus_Post_Quem'.$pidSid]["value"]['day'] = $_SESSION['ProjectConfig']["Terminus_Post_Quem_Day"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Year"]) ) {
                        $query['Terminus_Post_Quem'.$pidSid]["value"]['year'] = $_SESSION['ProjectConfig']["Terminus_Post_Quem_Year"];
                    }
                    if( isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Year"]) ) {
                        $query['Terminus_Post_Quem'.$pidSid]["value"]['era'] = $_SESSION['ProjectConfig']["Terminus_Post_Quem_Period"];
                    }
                    $query['Terminus_Post_Quem'.$pidSid]["type"] = 'Date';
                }
                $query = json_encode($query);
                $data = ['form' => $projectSid,
                    'token' => $GLOBALS['TOKEN_ARRAY']['arcs'],
                    'fields' => $query];

                $ch = curl_init($_SESSION['ArcsConfig']['ArcsBaseURL'].'kora3/api/create');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);
                echo $result;
            }
        }
        $contents = str_replace(
            "define('CONFIGURED', 'false');",
            "define('CONFIGURED', 'true');",
            $contents
        );
        file_put_contents($path, $contents);
        $this->redirect('/');
    }

    /**
     * Returns Original Label from Permalink URL
     */
    public function periodo()
    {
        $url = 'http://n2t.net/ark:/99152/p0d.json';
        $data = file_get_contents($url);
        $out = json_decode($data, true);
        $address = $_POST["input"];
        $key = (explode('/', $address));

        multiKeyExists($out, end($key));

        function multiKeyExists($arr, $key)
        {
            // is in base array?
            if (array_key_exists($key, $arr)) {
                return json_encode($arr[$key]['label']);
            }

            // check arrays contained in this array
            foreach ($arr as $element) {
                if (is_array($element)) {
                    multiKeyExists($element, $key);
                }
            }
            return false;
        }
    }
}
