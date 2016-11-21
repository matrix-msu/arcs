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
    function afterFind($results, $primary=false) {
        $results = parent::afterFind($results, $primary);
        if(empty($results))
          return;
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

            if ( isset($r['id']) ) {

                //// Start SQL Area
                ///////////////////
                $db = new DATABASE_CONFIG;
                $db_object = (object)$db;
                $db_array = $db_object->{'default'};
                $response['db_info'] = $db_array['host'];
                $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

                if ($mysqli->connect_error) {
                    die('Connect Error (' . $mysqli->connect_errno . ') '
                        . $mysqli->connect_error);
                }

                //Get a collection_id from the id
                //Get the title
                //Get the oldest created date.
                $sql = "SELECT DISTINCT collection_id, id, title, min(created) AS DATE, public, members
                        FROM arcs_dev.collections
                        WHERE collections.user_id ='" . $r['id'] . "'
                        GROUP BY title
                        ORDER BY min(created) DESC;";
                //WHERE title = '".$file_name."'";
                $result = $mysqli->query($sql);
                while ($row = mysqli_fetch_assoc($result)) {

                    //Set the collection's last modified date
                    $date = $row['DATE'];
                    $year = substr($date, 0, 4);
                    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December');
                    $month = substr($date, 5, 2);
                    $day = substr($date, 8, 2);
                    $return_date = array_values($months)[intval($month) - 1] . ' ' . $day . ', ' . $year;


                    $temp_array = array('id' => $row['id'],
                        'title' => $row['title'],
                        'date' => $return_date,
                        'public' => $row['public'],
                        'members' => $row['members']);
                    $test[] = $temp_array;
                }
                //$response['collection_table_id'] = $collection_table_id;
                //$response['sql'] = $sql;
                //$collections = mysqli_fetch_assoc($result);
                //$collection_id = $collection_id['collection_id'];
                //$r['query'] = $sql;
                if(isset($test))
                  $r['Collection'] = $test;

                return $r;
            }
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
     * Return a UUID suitable for account activation and reset tokens.
     */
    function getToken() {
        App::uses('String', 'Utility');
        return String::uuid();
    }

    /**
     * On create, we need to hash the user's password.
     */
    function beforeSave($created = array()) {
        App::uses('AuthComponent', 'Controller/Component');
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password(
                $this->data['User']['password']
            );
        }
    }
}
