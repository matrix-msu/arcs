<?php
/**
 * Add Projects Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */


class AddProjectsController extends AppController
{
    public $name = 'AddProjects';

    public function beforeFilter()
    {
        parent::beforeFilter();

        if (!$this->Access->isAdmin()) {
            $this->Session->setFlash('You must be an Admin to add projects ', 'flash_error');
            $this->redirect('/');
        } else {
            echo "<script>var JS_IS_ADD_PROJECT_PAGE = true;</script>";
        }

    }

    /**
     * Displays the start installation page
     */
    public function display()
    {
        $this->set(array(
            'title_for_layout' => 'Add a Project'
        ));
        $this->render("index");
    }

    /**
     * Download the kora project files to use with the kora importer
     */
    public function download()
    {
//        $koraProjectFiles = "arcs-icon.png";
//
//        header("Content-Disposition: attachment; filename=$koraProjectFiles");
//        header("Content-Length: " . filesize($koraProjectFiles));
//
        $this->set(array(
            'title_for_layout' => 'Download'
        ));
        $this->render("download");

//        header("Content-Disposition: attachment; filename=\"" . basename($koraProjectFiles) . "\"");
//        header("Content-Type: application/force-download");
//        header("Content-Length: " . filesize($koraProjectFiles));
//        header("Connection: close");
    }


    /**
     * Filling in the pid and token from kora
     */
    public function projectConfig()
    {
        $this->set(array(
            'title_for_layout' => 'Configure Project'
        ));
        $this->render("config");

    }

    /**
     * Filling in the field options for the create page
     */
    public function fieldConfig()
    {
        if (isset($_POST) && isset($_POST['add-pid']) && isset($_POST['add-token'])){
            $_SESSION['addProjectConfig'] = $_POST;
        }

        $this->set(array(
            'title_for_layout' => 'Configure Fields'
        ));
        $this->render("field_config");

    }

    /**
     * Create the project using the installation page
     */
    public function createProject()
    {
        if ($_POST) {
            $_SESSION['FieldConfig'] = $_POST;
        }

        $this->set(array(
            'title_for_layout' => 'Create Project'
        ));
        $this->render("create_project");

    }


    /**
     * Do the stuff to add it
     */
    public function finalize()
    {
        if ($_POST) {
            $_SESSION['ProjectConfig'] = $_POST;
        }
//        $this->set(array(
//            'title_for_layout' => 'Create Project'
//        ));
//        $this->render("finalize");
//
//        echo json_encode($_SESSION);
//        die;

        $pid = $_SESSION['addProjectConfig']['add-pid'];
        $pName = trim(strtolower(str_replace(" ", "_", $_SESSION['ProjectConfig']['Persistent_Name'])));

        $path = APP . "Config/bootstrap.php";
        $contents = file_get_contents($path);


        //make api call to kora with pid and get sids back
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => KORA_RESTFUL_URL . 'projects/'.$pid.'/forms'
        ));

        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);

//        var_dump($result);
//        die;

        // add the pid to the bootstrap
        $contents = str_replace(
            '$GLOBALS[\'PID_ARRAY\'] = array(',
            '$GLOBALS[\'PID_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$pid.',',
            $contents
        );

        // add the token to the bootstrap
        $contents = str_replace(
            '$GLOBALS[\'TOKEN_ARRAY\'] = array(',
            '$GLOBALS[\'TOKEN_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$_SESSION['addProjectConfig']['add-token'].',',
            $contents
        );

        // add the sids to the bootstrap
        foreach ($result as $formSid => $value) {
            switch ($value['name']) {
                case 'Project':
                    $projectSid = $formSid;

                    $contents = str_replace(
                        '$GLOBALS[\'PROJECT_SID_ARRAY\'] = array(',
                        '$GLOBALS[\'PROJECT_SID_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$formSid.',',
                        $contents
                   );
                    break;
                case 'Season':
                    $contents = str_replace(
                        '$GLOBALS[\'SEASON_SID_ARRAY\'] = array(',
                        '$GLOBALS[\'SEASON_SID_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$formSid.',',
                        $contents
                    );
                    break;
                case 'Resource':
                    $contents = str_replace(
                        '$GLOBALS[\'RESOURCE_SID_ARRAY\'] = array(',
                        '$GLOBALS[\'RESOURCE_SID_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$formSid.',',
                        $contents
                    );
                    break;
                case 'Pages':
                    $contents = str_replace(
                        '$GLOBALS[\'PAGES_SID_ARRAY\'] = array(',
                        '$GLOBALS[\'PAGES_SID_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$formSid.',',
                        $contents
                    );
                    break;
                case 'Subject of Observation':
                    $contents = str_replace(
                        '$GLOBALS[\'SUBJECT_SID_ARRAY\'] = array(',
                        '$GLOBALS[\'SUBJECT_SID_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$formSid.',',
                        $contents
                    );
                    break;
                case 'Excavation - Survey':
                    $contents = str_replace(
                        '$GLOBALS[\'SURVEY_SID_ARRAY\'] = array(',
                        '$GLOBALS[\'SURVEY_SID_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$formSid.',',
                        $contents
                    );
                    break;
            }
        }


        if (isset($_SESSION['addProjectConfig']) && isset($_SESSION['addProjectConfig']['add-pid'])) {
            //todo make sure this works on projects.arcs
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
//                    $sql->execute();
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
//            $addUserData = array(
//                'name' => $_SESSION['ArcsConfig']['ArcsAdminName'],
//                'username' => $_SESSION['ArcsConfig']['ArcsAdminUsername'],
//                'email' => $_SESSION['ArcsConfig']['ArcsAdminEmail'],
//                'password' => $_SESSION['ArcsConfig']['ArcsAdminPassword'],
//                'isAdmin' => 1,
//                'last_login' => null,
//                'status' => 'confirmed'
//            );
//            $response["status"] = $this->User->add($addUserData);
//            if ($response["status"] == false) {
//                $response["message"] = $this->User->invalidFields();
//                return $this->json(400, ($response));
//            }

            $user_id =  $this->Session->read('Auth.User.id');

            $usersC->editMappings($mappingProjects, array(), $user_id);

            if( isset($GLOBALS['PROJECT_SID_ARRAY']['arcs']) && isset($GLOBALS['TOKEN_ARRAY']['arcs']) ){
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
                    'token' => $_SESSION['addProjectConfig']['add-token'],
                    'fields' => $query];

                $ch = curl_init(KORA_RESTFUL_URL.'create');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);
//                echo $result;
//                die;
            }
        }

        file_put_contents($path, $contents);
        $this->redirect('/');
    }

}
