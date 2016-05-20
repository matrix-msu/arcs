<?php
/**
 * User model
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class User extends AppModel {

    public $name = 'User';
	
	public $validate = array(
		'name' => array(
			 'rule' => array('custom', '/^[a-z ]*$/i'),
            'allowEmpty' => false,
            'message' => 'Letter and spaces only'
		),
		'username' => array(
            'custom' => array(
			    'rule' => array('custom', '/^[a-z0-9 .-_~]*$/i'),
                'allowEmpty' => false,
                'message' => 'Letters, numbers, and some symbols (.-_~) only'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => "Username must be unique"
            )
		),
		'password' => array(
			'rule' => array('minLength', '6'),
            'allowEmpty' => false,
            'message' => 'Password must be at least 6 characters long'
		),
		'email' => array(
            'email' => array(
			    'rule' => 'email',
                'allowEmpty' => false,
			    'message' => 'Invalid email'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => "Email must be unique"
            )
		),
	);

    public $hasMany = array(
        'Resource', 
        'Keyword', 
        'Comment',
        'Bookmark',
        'Annotation',
        'Collection'
    );

    public $whitelist = array(
        'name', 'email', 'username', 'password', 'status'
    );

    public $actsAs = array('Containable');

    /**
     * Don't give out the user's hashed password to non-primary finds. 
     */
    function afterFind($results, $primary) {
        $results = parent::afterFind($results, $primary);
        if (!$primary) {
            $results = $this->resultsMap($results, function($r) {
                $r['password'] = '****';
                return $r;
            });
        }
        $results = $this->resultsMap($results, function($r) {
            if (isset($r['email']))
                $r['gravatar'] = md5(strtolower($r['email']));

            //Josh- Find and return collections data also
            /////////////////////////////////////////////
            $catchcollections = 1;
            if ( $catchcollections == 1 ){

                //// Start SQL Area
                ///////////////////
                $mysqli = new mysqli('rush.matrix.msu.edu', 'arcs_dev', 'uohE4n032x', 'arcs_dev');

                if ($mysqli->connect_error) {
                    die('Connect Error (' . $mysqli->connect_errno . ') '
                        . $mysqli->connect_error);
                }
                //Get a collection_id from the id
                $sql = "SELECT DISTINCT collection_id, title FROM arcs_dev.collections WHERE collections.user_id ='".$r['id']."';";
                //WHERE title = '".$file_name."'";
                $result = $mysqli->query($sql);
                while($row = mysqli_fetch_assoc($result)) {
                    //$row['temporary'] = 1;
                    $temp_array = array('id' => $row['collection_id'],
                                        'title' => $row['title']);
                    $test[] = $temp_array;
                }
                    //$response['collection_table_id'] = $collection_table_id;
                //$response['sql'] = $sql;
                //$collections = mysqli_fetch_assoc($result);
                //$collection_id = $collection_id['collection_id'];
                //$r['query'] = $sql;
                $r['Collection'] = $test;
                $temp_array = array();
                foreach ($test as $collection) {
                    $test2 = array();
                    //Get the kid's from the collection_id
                    $sql = "SELECT resource_kid FROM arcs_dev.collections WHERE collections.collection_id ='".$collection['id']."' LIMIT 12;";
                    $result = $mysqli->query($sql);
                    while($row = mysqli_fetch_assoc($result))
                        $test2[] = $row;
                    //$response['col_id'] = $collection_id;
                    //$response['query'] = $sql;
                    //$response['col_result'] = $test;
                    //$collection['col_result'] = $test2;
                    $temp_array2 = array();
                    $temp_array2['id'] = $collection['id'];
                    $temp_array2['title'] = $collection['title'];
                    $temp_array2['kids'] = $test2;
                    $temp_array[] = $temp_array2;
                }
                //$r['col_test'] = $temp_array;
                $r['Collection'] = $temp_array;
                //return $r;
                //$r['Resources'] = array();
                //$r['r_query'] = array();
                //$r['r_kids'] = array();
                $temp_collection_array = array();
                foreach( $r['Collection'] as $collection) {
                    $temp_resource_array = array();
                    foreach ($collection['kids'] as $kid) {
                        $temp_array = array();
                        //Get the Resources from Kora
                        $query = "kid,=," . $kid['resource_kid'];
                        //$r['r_kids'][] = $kid['resource_kid'];
                        //$temp_array['resource_query'] = $query;
                        $user = "";
                        $pass = "";
                        $display = "json";
                        $url = KORA_RESTFUL_URL . "?request=GET&pid=" . PID . "&sid=" . RESOURCE_SID . "&token=" . TOKEN . "&display=" . $display . "&query=" . urlencode($query);
                        //$r['r_query'][] = $url;
                        //$temp_array['resource_url'] = $url;
                        ///initialize post request to KORA API using curl
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_USERPWD, $user . ':' . $pass);
                        //capture results and map to array
                        $resource = json_decode(curl_exec($ch), true);
                        $temp_resource = array_values($resource)[0];
                        //$r['Resources'][] = $temp_resource;
                        //$r = $page[$kid];

                        $temp_array['col_title'] = $collection['title'];
                        unset($collection['title']);

                        //Handle resource title
                        $resource_title = $temp_resource['Title'];
                        if (!empty($resource_title)) {
                            $temp_array['title'] = $resource_title;
                        } else {
                            $temp_array['title'] = 'Unknown Title';
                        }

                        //Handle resource type
                        $resource_type = $temp_resource['Type'];
                        if (!empty($resource_type)) {
                            $temp_array['type'] = $resource_type;
                        } else {
                            $temp_array['type'] = 'Unknown Type';
                        }

                        $resource_identifier = $temp_resource['Resource Identifier'];
                        $temp_array['Resource_identifier'] = $resource_identifier;

                        //Get the Pages from Kora
                        //$new_temp = array('7B-2E0-1');
                        $query = "Resource Identifier,=," . $resource_identifier;
                        //$response['query'] = $query;
                        $user = "";
                        $pass = "";
                        $display = "json";
                        //no query
                        //$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display;
                        //query
                        //$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display."&query=".$query;
                        $url = KORA_RESTFUL_URL . "?request=GET&pid=" . PID . "&sid=" . PAGES_SID . "&token=" . TOKEN . "&display=" . $display . "&query=" . urlencode($query) . "&count=1";

                        ///initialize post request to KORA API using curl
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_USERPWD, $user . ':' . $pass);
                        //capture results and map to array
                        $page2 = json_decode(curl_exec($ch), true);

                        //Get the picture URL from the page results
                        $temp_array['page_search'] = $page2;
                        $picture_url = array_values($page2)[0]['Image Upload']['localName'];
                        $kid = array_values($page2)[0]['Resource Associator'][0];
                        $temp_array['id'] = $kid;

                        //Decide if there is a picture..
                        if (!empty($picture_url)) {
                            //$temp_array['pic_url'] = $picture_url;
                            $kora_pic_url = "http://kora.matrix.msu.edu/files/123/738/";
                            $temp_array['thumb'] = $kora_pic_url . $picture_url;
                        } else {
                            $temp_array['thumb'] = "img/DefaultResourceImage.svg";
                        }
                        //array_push($response['results'], $temp_array); 
                        //array_push($temp_collection_array, $temp_resource_array);
                        array_push($temp_resource_array, $temp_array);
                    }
                    //$temp_resource_array['title'] = $collection['title'];
                    array_push($temp_collection_array, $temp_resource_array);
                }
                $r['Collection'] = $temp_collection_array;
            }
            //End of collections
            ///////////////////////////////////////
            return $r;
        });
        return $results;
    }

    /**
     * (Try to) find a user given a reference, which may be the
     * id or username.
     *
     * @param string ref   id or username
     * @return array       user array
     */
    function findByRef($ref) {
        $user = $this->findById($ref);
        if (!$user) $user = $this->findByUsername($ref);
        return $user;
    }

    /**
     * finds user by Id
     * returns false if user not in database
     */
    function findById($ref){
        /* Initialize variables to use for database communication */
        $servername = "rush.matrix.msu.edu";
        $username = "arcs_dev";
        $password = "uohE4n032x";
        $myDB ="arcs_dev";

        /* try to connect to the database */
        try{
            $con = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
            /* Catch error if we can't connect */
        catch(PDOException $e){
            echo "CONNECTION TO DATABASE FAILED. " . $e->getMessage(). "<br>";
        }

        // gets the info for the current image needed
        $sql = <<<SQL
        select *
        from users
        where id=?
SQL;
        $stmnt = $con->prepare($sql);
        $stmnt->execute(array($ref));
        $user = $stmnt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    /**
     * finds user by username
     * returns false if cannot find username
     */
    function findByUsername($ref){
        /* Initialize variables to use for database communication */
        $servername = "rush.matrix.msu.edu";
        $username = "arcs_dev";
        $password = "uohE4n032x";
        $myDB ="arcs_dev";

        /* try to connect to the database */
        try{
            $con = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } /* Catch error if we can't connect */
        catch(PDOException $e){
            echo "CONNECTION TO DATABASE FAILED. " . $e->getMessage(). "<br>";
        }

        // gets the info for the current image needed
        $sql = <<<SQL
        select *
        from users
        where username=?
SQL;
        $stmnt = $con->prepare($sql);
        $stmnt->execute(array($ref));
        $user = $stmnt->fetch(PDO::FETCH_ASSOC);
        //var_dump($user);
        return $user;
    }

    /**
     * Return a UUID suitable for account activation and reset tokens.
     */
    function getToken() {
        App::uses('String', 'Utility');
        return String::uuid();
    }

    /**
     * On create, we need to hash the user's password.
     */
    function beforeSave($created) {
        App::uses('AuthComponent', 'Controller/Component');
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password(
                $this->data['User']['password']
            );
        }
    }
}
