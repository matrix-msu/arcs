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
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
        if($_POST){
            $_SESSION['ProjectConfig'] = $_POST;
        }
        $path = APP . "Config/bootstrap.php";
        $contents = file_get_contents($path);
        $pName = trim(strtolower(str_replace(" ", "_", $_SESSION['ProjectConfig']['Persistent_Name'])));

        $installerInput = file_get_contents("../../installerInput.txt");
        $installerInput = explode("\n", $installerInput);

        $arcsBaseUrl = "https://".$installerInput[0]."/";

        $contents = str_replace(
            'define("BASE_BOTH", "");',
            'define("BASE_BOTH", "' . $arcsBaseUrl . '");',
            $contents
        );

        if (isset($GLOBALS['PID_ARRAY']) && isset($GLOBALS['PID_ARRAY']['arcs'])) {
            $pid = $GLOBALS['PID_ARRAY']['arcs'];
            $contents = str_replace(
                "'arcs' =>",
                "'" . $pName . "' =>",
                $contents
            );

            //make api call to kora with pid and get sids back
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => KORA_RESTFUL_URL . 'projects/'.$pid.'/forms'
            ));

            $formsResult = json_decode(curl_exec($curl), true);
            curl_close($curl);

            // get the info on each field so we know their types
            $fieldsInfo = array();
            $sidToFieldsData = array(); // map the sids to their field data to update
            foreach ($formsResult as $formSid => $value) {
                if ( isset($value['name']) && $value['name'] == "Project"){
                    $projectSid = $formSid;
                }

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => KORA_RESTFUL_URL . 'projects/'.$pid.'/forms/'.$formSid.'/fields'
                ));

                $result = json_decode(curl_exec($curl), true);
                curl_close($curl);
                if ( isset($value['name']) ){
                    $fieldsInfo[$value['name']] = $result;
                    $fieldsInfo[$value['name']]['sid'] = $formSid;
                }
                $sidToFieldsData[$formSid] = [];
            }

            $fieldsArray = $_SESSION['FieldConfig'];    // all user inputted data
            foreach ($fieldsArray as $fieldKey => $fieldValue) {
                // search field info to find the types and sid
                $cleanedKey = str_replace('- ' , '', str_replace("_", " ", $fieldKey));
                $type = '';
                $sid = '';
                $found = false;
                foreach ($fieldsInfo as $form => $formValues) {
                    foreach($formValues as $field){
                        if (isset($field['name']) && $field['name'] == $cleanedKey){
                            $found = true;
                            $type = $field['type'];
                            $sid = $formValues['sid'];
                            break;
                        }
                    }
                    if ($found){
                        break;
                    }
                }

                // turn the data into the correct form for the api
                if ($type == "List" || $type == "Multi-Select List") {
                    $options = array('Options' => []);
                    foreach ($fieldValue as $listOption) {
                        $options['Options'][] = trim($listOption);
                    }
                    $sidToFieldsData[$sid][$cleanedKey] = $options;
                }
            }

            // edit field options api for each form
            foreach ($sidToFieldsData as $sid => $fieldData){
                $apiUrl = KORA_RESTFUL_URL . 'projects/'.$pid.'/forms/'.$sid.'/fields';

                $data = [
                    '_method' => 'PUT',
                    'bearer_token' => $GLOBALS['TOKEN_ARRAY']['arcs'],
                    'fields' => json_encode($fieldData)
                ];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_URL =>  $apiUrl
                ));

                $result = json_decode(curl_exec($curl), true);
                curl_close($curl);
            }


            $usersC = new UsersController();
            $mappingProjects = array();
            array_push($mappingProjects, array(
                'project' => array('name' => $pName, 'pid' => $pid),
                'role' => array('name' => 'Admin', 'value' => 'Admin')
            ));
            $addUserData = array(
                'name' => 'Admin',
                'username' => 'Admin',
                'email' => $installerInput[1],
                'password' => $installerInput[2],
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
             var_dump($installerInput);
             die;

            if( isset($GLOBALS['PROJECT_SID_ARRAY']['arcs']) && isset($GLOBALS['TOKEN_ARRAY']['arcs']) ){
            $projectSid = $GLOBALS['PROJECT_SID_ARRAY']['arcs'];

            // echo $projectSid;die;
            $pidSid = '';
            // var_dump($_SESSION['ProjectConfig']);die;

            $query['Name' . $pidSid] = $_SESSION['ProjectConfig']["Name"];
            $query['Location_Identifier' . $pidSid] = $_SESSION['ProjectConfig']["Location_Identifier"];
            $query['Location_Identifier_Scheme' . $pidSid] = $_SESSION['ProjectConfig']["Location_Identifier_Scheme"];
            $query['Elevation' . $pidSid] = $_SESSION['ProjectConfig']["Elevation"];
            $query['Persistent_Name' . $pidSid] = $_SESSION['ProjectConfig']["Persistent_Name"];
            $query['Complex_Title' . $pidSid] = $_SESSION['ProjectConfig']["Complex_Title"];
            $query['Description' . $pidSid] = $_SESSION['ProjectConfig']["Description"];
            $query['Brief_Description' . $pidSid] = $_SESSION['ProjectConfig']["Brief_Description"];
            if (isset($_SESSION['ProjectConfig']["Region"])) {
                $query['Country' . $pidSid] = $_SESSION['ProjectConfig']["Region"];
            }
            if (isset($_SESSION['ProjectConfig']["Country"])) {
                $query['Country' . $pidSid] = $_SESSION['ProjectConfig']["Country"];
            }
            if (isset($_SESSION['ProjectConfig']["Modern_Name"])) {
                $query['Modern_Name' . $pidSid] = $_SESSION['ProjectConfig']["Modern_Name"];
            }
            if (isset($_SESSION['ProjectConfig']["Records_Archive"])) {
                $query['Records_Archive' . $pidSid] = [$_SESSION['ProjectConfig']["Records_Archive"]];
            }
            if (isset($_SESSION['ProjectConfig']["Period"])) {
                $query['Period' . $pidSid] = [$_SESSION['ProjectConfig']["Period"]];
            }
            if (isset($_SESSION['ProjectConfig']["Archaeological_Culture"])) {
                $query['Archaeological_Culture' . $pidSid] = [$_SESSION['ProjectConfig']["Archaeological_Culture"]];
            }
            if (isset($_SESSION['ProjectConfig']["Permitting_Heritage_Body"])) {
                $query['Permitting_Heritage_Body' . $pidSid] = [$_SESSION['ProjectConfig']["Permitting_Heritage_Body"]];
            }
            if (isset($_SESSION['ProjectConfig']["Geolocation"])) {
                $query['Geolocation' . $pidSid] = $_SESSION['ProjectConfig']["Geolocation"];
            }
            if (
                isset($_SESSION['ProjectConfig']["Earliest_Date_Month"])||
                isset($_SESSION['ProjectConfig']["Earliest_Date_Day"])||
                isset($_SESSION['ProjectConfig']["Earliest_Date_Year"])
            ) {
                $query['Earliest_Date' . $pidSid] = array(
                    'circa' => "0",
                    'era' => "CE"
                );
                if( isset($_SESSION['ProjectConfig']["Earliest_Date_Month"]) ) {
                    $query['Earliest_Date' . $pidSid]['month'] = $_SESSION['ProjectConfig']["Earliest_Date_Month"];
                }
                if( isset($_SESSION['ProjectConfig']["Earliest_Date_Day"]) ) {
                    $query['Earliest_Date' . $pidSid]['day'] = $_SESSION['ProjectConfig']["Earliest_Date_Day"];
                }
                if( isset($_SESSION['ProjectConfig']["Earliest_Date_Year"]) ) {
                    $query['Earliest_Date' . $pidSid]['year'] = $_SESSION['ProjectConfig']["Earliest_Date_Year"];
                }
            }
            if (
                isset($_SESSION['ProjectConfig']["Latest_Date_Month"])||
                isset($_SESSION['ProjectConfig']["Latest_Date_Day"])||
                isset($_SESSION['ProjectConfig']["Latest_Date_Year"])
            ) {
                $query['Latest_Date' . $pidSid] = array(
                    'circa' => "0",
                    'era' => "CE"
                );
                if( isset($_SESSION['ProjectConfig']["Latest_Date_Month"]) ) {
                    $query['Latest_Date' . $pidSid]['month'] = $_SESSION['ProjectConfig']["Latest_Date_Month"];
                }
                if( isset($_SESSION['ProjectConfig']["Latest_Date_Day"]) ) {
                    $query['Latest_Date' . $pidSid]['day'] = $_SESSION['ProjectConfig']["Latest_Date_Day"];
                }
                if( isset($_SESSION['ProjectConfig']["Latest_Date_Year"]) ) {
                    $query['Latest_Date' . $pidSid]['year'] = $_SESSION['ProjectConfig']["Latest_Date_Year"];
                }
            }
            if (
                isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Month"])||
                isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Day"])||
                isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Year"])||
                isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Period"])
            ) {
                $query['Terminus_Ante_Quem' . $pidSid] = array(
                    'circa' => "0"
                );
                if( isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Month"]) ) {
                    $query['Terminus_Ante_Quem'.$pidSid]['month'] = $_SESSION['ProjectConfig']["Terminus_Ante_Quem_Month"];
                }
                if( isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Day"]) ) {
                    $query['Terminus_Ante_Quem'.$pidSid]['day'] = $_SESSION['ProjectConfig']["Terminus_Ante_Quem_Day"];
                }
                if( isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Year"]) ) {
                    $query['Terminus_Ante_Quem'.$pidSid]['year'] = $_SESSION['ProjectConfig']["Terminus_Ante_Quem_Year"];
                }
                if( isset($_SESSION['ProjectConfig']["Terminus_Ante_Quem_Period"]) ) {
                    $query['Terminus_Ante_Quem'.$pidSid]['era'] = $_SESSION['ProjectConfig']["Terminus_Ante_Quem_Period"];
                }
            }
            if (
                isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Month"])||
                isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Day"])||
                isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Year"])||
                isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Period"])
            ) {
                $query['Terminus_Post_Quem' . $pidSid] = array(
                    'circa' => "0"
                );
                if( isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Month"]) ) {
                    $query['Terminus_Post_Quem'.$pidSid]['month'] = $_SESSION['ProjectConfig']["Terminus_Post_Quem_Month"];
                }
                if( isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Day"]) ) {
                    $query['Terminus_Post_Quem'.$pidSid]['day'] = $_SESSION['ProjectConfig']["Terminus_Post_Quem_Day"];
                }
                if( isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Year"]) ) {
                    $query['Terminus_Post_Quem'.$pidSid]['year'] = $_SESSION['ProjectConfig']["Terminus_Post_Quem_Year"];
                }
                if( isset($_SESSION['ProjectConfig']["Terminus_Post_Quem_Period"]) ) {
                    $query['Terminus_Post_Quem'.$pidSid]['era'] = $_SESSION['ProjectConfig']["Terminus_Post_Quem_Period"];
                }
            }

            $query = json_encode($query);
            $data = ['form' => $projectSid,
            'bearer_token' => $GLOBALS['TOKEN_ARRAY']['arcs'],
            'fields' => $query];

            $ch = curl_init(KORA_RECORD_CREATE_URL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        $contents = str_replace(
            "define('CONFIGURED', 'false');",
            "define('CONFIGURED', 'true');",
            $contents
        );
        file_put_contents($path, $contents);
        $this->redirect('/');
    }
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
