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

 class InstallationsController extends AppController {
	
	public $name = 'Installations';
	public $uses = array('User', 'Mapping');

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }

	public function register() {
	          $this->set(array(
	            'title_for_layout' => 'index'
	        ));
	        $this->render("register");
	    }

    /**
     * Displays the start installation page
     */
	public function display() {
	  	$this->set(array(
	    	'title_for_layout' => 'Install ARCS'
	    ));
		$this->render("index");
	}

	/**
	 * Displays the Kora Configuration page
	 */
	public function koraConfig() {
		$this->set(array(
			'title_for_layout' => 'Install ARCS'
		));
		$this->render("kora_config");

	}

	/**
	 * Displays the Field Configuration page
	 */
	public function fieldConfig() {
		if($_POST){
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
	public function createProject() {
		if($_POST){
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
	public function arcsConfig() {
		if($_POST){
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
	public function finalize() {
		if($_POST){
			$_SESSION['ArcsConfig'] = $_POST;
		}

		//write to koradb

		$host = $_SESSION['KoraConfig']['KoraDBHost'];
		$username = $_SESSION['KoraConfig']['KoraDBUsername'];
		$password = $_SESSION['KoraConfig']['KoraDBPassword'];
		$dbName = $_SESSION['KoraConfig']['KoraDBName'];

		$pName = trim(strtolower(str_replace(" ", "_", $_SESSION['KoraConfig']['KoraProjectName'])));
		$pid = $GLOBALS['PID_ARRAY'][$pName];

		// Create connection
		$conn = new mysqli($host, $username, $password, $dbName);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		//skip config, message, and auth which are automatically in a session variable
		foreach($_SESSION as $key => $value){
			if ($key == "Config" || $key == "Message" || $key == "Auth"){			
				continue;
			}
			foreach($value as $key2 => $value2){
				$newKey = str_replace("_", " ", $key2);
				$sql = "SELECT * FROM kora3_fields WHERE NAME = '$newKey' AND pid = '$pid'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					$insert = "";
					$type = $result->fetch_assoc()['type'];
					
					if ($type == "List" || $type == "Multi-Select List") {

						$insert .= "[!Options!]";
						$items = explode(",", $value2);

						for ($i = 0; $i < sizeof($items); $i++){
							$insert .= trim($items[$i]);

							if (($i+1) != sizeof($items)) {
								$insert .= "[!]";
							}
						}
						$insert .= "[!Options!]";  
						
						$sql = $conn->prepare(
							"UPDATE kora3_fields 
							SET options = ?
							where name = '$newKey' and pid = '$pid'"
						); 
						$sql->bind_param('s', $insert);
						$sql->execute();
					}
				}
			}
		}
		$conn->close();

		//create admin user

		$usersC = new UsersController();

		$mappingProjects = array();
		array_push($mappingProjects, array(
			'project' => array('name' => $pName, 'pid' => $pid),
			'role' => array('name' => 'Admin', 'value' => 'Admin')
		));

		$addUserData = array(
			'name' => '',
            'username' => $_SESSION['ArcsConfig']['ArcsAdminUsername'],
            'email' => '',
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

		//write to bootstrap file so that configured = true

		$path = APP . "Config/bootstrap.php";
		$contents = file_get_contents($path);
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
    public function periodo()   {
        $url = 'http://n2t.net/ark:/99152/p0d.json';
        $data = file_get_contents($url);
        $out = json_decode($data, true);
        $address = $_POST["input"];
        $key = (explode('/',$address));

        multiKeyExists($out, end($key));

        function multiKeyExists($arr, $key)
        {
            // is in base array?
            if (array_key_exists($key, $arr))
            {
                return json_encode($arr[$key]['label']);
            }

            // check arrays contained in this array
            foreach ($arr as $element)
            {
                if (is_array($element))
                {
                    multiKeyExists($element, $key);
                }
            }
            return false;
        }
    }
}
