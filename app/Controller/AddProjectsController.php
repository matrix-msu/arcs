<?php
/**
 * Add Projects Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
App::import('Controller', 'Users');

class AddProjectsController extends AppController
{
    public $name = 'AddProjects';

    public function beforeFilter()
    {
        parent::beforeFilter();

        if (!$this->Access->isAdmin()) {
            $this->Session->setFlash('You must be an Admin to add projects ', 'flash_error');
            $this->redirect('/');
        }else if(  @array_pop(explode('/',$_SERVER['REQUEST_URI'])) == "downloadLayoutFile"  ){
            //
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
        $this->set(array(
            'title_for_layout' => 'Download'
        ));
        $this->render("download");
    }


    //download the created export file and delete it
    public function downloadLayoutFile(){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.'ARCS_Layout.kProj'.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize("../../ARCS_Layout.kProj"));
        readfile('../../ARCS_Layout.kProj');
        die;
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

        $formsResult = json_decode(curl_exec($curl), true);
        curl_close($curl);

        // add the pid to the bootstrap
        $contents = str_replace(
            '$GLOBALS[\'PID_ARRAY\'] = array(',
            '$GLOBALS[\'PID_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => '.$pid.',',
            $contents
        );

        // add the token to the bootstrap
        $contents = str_replace(
            '$GLOBALS[\'TOKEN_ARRAY\'] = array(',
            '$GLOBALS[\'TOKEN_ARRAY\'] = array('.PHP_EOL.'    \''.$pName.'\' => "'.$_SESSION['addProjectConfig']['add-token'].'",',
            $contents
        );

        // add the sids to the bootstrap
        foreach ($formsResult as $formSid => $value) {
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

        // get the info on each field so we know their types
        $fieldsInfo = array();
        $sidToFieldsData = array(); // map the sids to their field data to update
        foreach ($formsResult as $formSid => $value) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => KORA_RESTFUL_URL . 'projects/'.$pid.'/forms/'.$formSid.'/fields'
            ));

            $result = json_decode(curl_exec($curl), true);
            curl_close($curl);

            $fieldsInfo[$value['name']] = $result;
            $fieldsInfo[$value['name']]['sid'] = $formSid;
            $sidToFieldsData[$formSid] = [];
        }

        // save form data for list and multi-select list data
        if (isset($_SESSION['addProjectConfig']) && isset($_SESSION['addProjectConfig']['add-pid'])) {
            $fieldsArray = $_SESSION['FieldConfig'];    // all user inputted data

            foreach ($fieldsArray as $fieldKey => $fieldValue) {
                // search field info to find the types and sid
                $cleanedKey = str_replace('- ' , '', str_replace("_", " ", $fieldKey));
                $type = '';
                $sid = '';
                $found = false;
                foreach ($fieldsInfo as $form => $formValues) {
                    foreach($formValues as $field){
                        if ($field['name'] == $cleanedKey){
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
                    'bearer_token' => $_SESSION['addProjectConfig']['add-token'],
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

            // save the logged in user as an admin to the new project
            $usersC = new UsersController();
            $mappingProjects = array();
            array_push($mappingProjects, array(
                'project' => array('name' => $pName, 'pid' => $pid),
                'role' => array('name' => 'Admin', 'value' => 'Admin')
            ));
            $user_id =  $this->Session->read('Auth.User.id');
            $usersC->editMappings($mappingProjects, array(), $user_id);

            // save project data
            // $pidSid = "_" . $pid . "_" . $projectSid . "_";
            $pidSid = '';

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

            // create a new project record api
            $query = json_encode($query);
            $data = ['form' => $projectSid,
            'bearer_token' => $_SESSION['addProjectConfig']['add-token'],
            'fields' => $query];
            
            $ch = curl_init(KORA_RECORD_CREATE_URL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        
        // save changes to the bootstrap
        file_put_contents($path, $contents);
        $this->redirect('/');
    }
}
