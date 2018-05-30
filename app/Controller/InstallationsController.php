<?php
/**
 * Installation Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class InstallationsController extends AppController {
	
	public $name = 'Installations';

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
		//print_r(json_encode($_SESSION));die;

		$host = $_SESSION['KoraConfig']['KoraDBHost'];
		$username = $_SESSION['KoraConfig']['KoraDBUsername'];
		$password = $_SESSION['KoraConfig']['KoraDBPassword'];
		$dbName = $_SESSION['KoraConfig']['KoraDBName'];

		$pName = strtolower(str_replace(" ", "_", $_SESSION['KoraConfig']['KoraProjectName']));
		$pid = $GLOBALS['PID_ARRAY'][$pName];
		$results = array();

		// Create connection
		$conn = new mysqli($host, $username, $password, $dbName);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

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
					
					if ($type == "List"  || $type == "Multi-Select List") {
						$insert .= "[!Options!]";
						$items = explode(",", $value2);

						for ($i = 0; $i < sizeof($items); $i++){
							$insert .= trim($items[$i]);

							if (($i+1) != sizeof($items)) {
								$insert .= "[!]";
							}
						}

						$insert .= "[!Options!]";
						array_push($results, $insert);
						$sql = "INSERT INTO kora3_fields (pid) 
						VALUES ('168')";

						if ($conn->query($sql)) {
							echo "New record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					}
				}
			}
		}
		
		$conn->close();die;
		//print_r(json_encode($results));die;
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
