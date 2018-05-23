<?php
App::uses('Controller', 'Controller');
//App::uses('Controller', 'ProjectsController');

require_once LIB . "Arcs/ArcsException.php";

use arcs\ArcsException;
use arcs\ErrorCodes;
/**
 * Application Controller
 *
 * @package   ARCS
 * @link      http://github.com/calmsu/arcs
 * @copyright Copyright 2012, Michigan State University Board of Trustees
 * @license   BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class AppController extends Controller
{
    public $helpers = array('Html', 'Form', 'Session', 'Assets');
    public $viewClass = 'TwigView.Twig';
    public $uses = array('Job', 'Mapping');
    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'special_login'
            ),
            'authenticate' => array('Form'),
            //'authError' => "Sorry, you'll need to login to do that.",
            'authError' => "",
        ),
        'Session',
        'RequestHandler',
        'Access'
    );

    public function beforeFilter()
    {
        $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $linkParts = explode("/", $link);

        $user_id =  $this->Session->read('Auth.User.id');

        if ($GLOBALS['Configured'] == false && !in_array('installation', $linkParts) && $user_id !== null) {
            $this->redirect('/installation');
        }
        //set the project Persistent Names for the toolbar.
        $projects = array();
        foreach( $GLOBALS['PID_ARRAY'] as $name => $pid ) {
            $projects[] = array('Persistent_Name' => str_replace('_', ' ', $name) );
        }

        if (substr($this->request->url, 0, 3) == 'api') {
            $this->Auth->authenticate = array('Basic');
        }
//echo 'LOAD1';


        $this->set(
            array(
            'user' => array(
                'loggedIn' => $this->Auth->loggedIn(),
                'id' => $this->Auth->user('id'),
                'name' => $this->Auth->user('name'),
                'email' => $this->Auth->user('email'),
                'role' => $this->Auth->user('role'),
                'role' => $this->Auth->loggedIn() ?
                    $this->Auth->user('role') : "Researcher",
                'username' => $this->Auth->user('username'),
                'gravatar' => md5(strtolower($this->Auth->user('email'))),

                'isAnyAdmin' => $this->checkIfAnyAdmin($this->Auth->user('id'))
            ),
            'toolbar' => array(
                'logo' => true,
                'buttons' => array(),
            ),
            'body_class' => 'default',
            'footer' => true,
            'debug' => Configure::read('debug'),
            'projects' => $projects
            )
        );
////echo 'LOAD2';
        $this->RequestHandler->addInputType('json', array('json_decode', true));

        if( $this->Session->read('Auth.User.isAdmin') === 1 ){
            $user["role"] = 'Admin';
        } else {
            $user["role"] = 'Not';
        }

//        return $user;
//        var_dump($user);
//        echo json_encode($this);
//        die;
    }
    public function checkIfAnyAdmin($id){


        $mappings = $this->Mapping->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Mapping.id_user' => $id,
                    'Mapping.status' => 'confirmed',
                    'Mapping.role' => 'Admin'
                ),
            )
        ));
//        var_dump($mappings);
//        die;
        if( !empty($mappings) ){
            return true;
        }else{
            return false;
        }

    }


    /**
     * Converts a KID to A Project Name from the bootstrap
     *
     * @param string $kid the kid to search for
     *
     * @return the Project Name or false
     */
    public static function convertKIDtoProjectName($kid) {
        if (!empty(explode('-', $kid))) {
            $pid = explode('-', $kid)[0];
            $projects = static::getPIDArray();
            // array search returns false if not found
            return array_search($pid, $projects);
        }
        return false;
    }
    public static function getPIDArray() {
        if (!isset($GLOBALS['PID_ARRAY'])) {
            throw new ArcsException(ErrorCodes::ProjectPIDArrayNotFound);
        }
        return $GLOBALS['PID_ARRAY'];
    }
    public static function isRealProject($project) {
        if (!isset($GLOBALS['PID_ARRAY'])) {
            throw new ArcsException(ErrorCodes::ProjectPIDArrayNotFound);
        }
        return isset($GLOBALS['PID_ARRAY'][$project]);
    }
    public static function verifyGlobals($project)
    {
        self::getPIDFromProjectName($project);
        self::getProjectSIDFromProjectName($project);
        self::getSeasonSIDFromProjectName($project);
        self::getSurveySIDProjectName($project);
        self::getResourceSIDFromProjectName($project);
        self::getPageSIDFromProjectName($project);
        self::getSubjectSIDFromProjectName($project);
        self::getTokenFromProjectName($project);
    }
    public static function getPIDFromProjectName($name)
    {
        if (isset($GLOBALS['PID_ARRAY'])) {
            if (isset($GLOBALS['PID_ARRAY'][$name])) {
                return $GLOBALS['PID_ARRAY'][$name];
            } else {
                throw new ArcsException(ErrorCodes::ProjectPIDNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::ProjectPIDArrayNotFound);
        }
    }
    public static function getProjectNameFromPID($pid)
    {

        if (isset($GLOBALS['PID_ARRAY'])) {

            if ( array_search($pid, $GLOBALS['PID_ARRAY']) ) {

                return array_search($pid, $GLOBALS['PID_ARRAY']);
            } else {

                throw new ArcsException(ErrorCodes::ProjectNameNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::ProjectPIDArrayNotFound);
        }

    }
    public static function getProjectSIDFromProjectName($name)
    {
        if (isset($GLOBALS['PROJECT_SID_ARRAY'])) {
            if (isset($GLOBALS['PROJECT_SID_ARRAY'][$name])) {
                return $GLOBALS['PROJECT_SID_ARRAY'][$name];
            } else {
                throw new ArcsException(ErrorCodes::ProjectSIDNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::ProjectSIDArrayNotFound);
        }
    }

    public static function getSeasonSIDFromProjectName($name)
    {
        if (isset($GLOBALS['SEASON_SID_ARRAY'])) {
            if (isset($GLOBALS['SEASON_SID_ARRAY'][$name])) {
                return $GLOBALS['SEASON_SID_ARRAY'][$name];
            } else {
                throw new ArcsException(ErrorCodes::SeasonSIDNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::SeasonSIDArrayNotFound);
        }
    }
    public static function getSurveySIDProjectName($name)
    {
        if (isset($GLOBALS['SURVEY_SID_ARRAY'])) {
            if (isset($GLOBALS['SURVEY_SID_ARRAY'][$name])) {
                return $GLOBALS['SURVEY_SID_ARRAY'][$name];
            } else {
                throw new ArcsException(ErrorCodes::SurveySIDNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::SurveySIDArrayNotFound);
        }
    }
    public static function getResourceSIDFromProjectName($name)
    {
        if (isset($GLOBALS['RESOURCE_SID_ARRAY'])) {
            if (isset($GLOBALS['RESOURCE_SID_ARRAY'][$name])) {
                return $GLOBALS['RESOURCE_SID_ARRAY'][$name];
            } else {
                throw new ArcsException(ErrorCodes::ResourceSIDNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::ResourceSIDArrayNotFound);
        }
    }
    public static function getPageSIDFromProjectName($name)
    {
        if (isset($GLOBALS['PAGES_SID_ARRAY'])) {
            if (isset($GLOBALS['PAGES_SID_ARRAY'][$name])) {
                return $GLOBALS['PAGES_SID_ARRAY'][$name];
            } else {
                throw new ArcsException(ErrorCodes::PageSIDNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::PageSIDArrayNotFound);
        }
    }
    public static function getSubjectSIDFromProjectName($name)
    {
        if (isset($GLOBALS['SUBJECT_SID_ARRAY'])) {
            if (isset($GLOBALS['SUBJECT_SID_ARRAY'][$name])) {
                return $GLOBALS['SUBJECT_SID_ARRAY'][$name];
            } else {
                throw new ArcsException(ErrorCodes::SubjectSIDNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::SubjectSIDArrayNotFound);
        }
    }

    public static function getTokenFromProjectName($name)
    {
        if (isset($GLOBALS['TOKEN_ARRAY'])) {
            if (isset($GLOBALS['TOKEN_ARRAY'][$name])) {
                return $GLOBALS['TOKEN_ARRAY'][$name];
            } else {
                throw new ArcsException(ErrorCodes::TokenNotFound);
            }
        } else {
            throw new ArcsException(ErrorCodes::TokenArrayNotFound);
        }
    }


    /**
     * Convenience method for multiple Request->is($type) checks.
     *
     * @param  string $args One or more request types to check.
     * @return bool           True if *all* checks pass.
     */
    public function requestIs($args)
    {
        $checks = func_get_args();
        foreach($checks as $check) {
            if (!$this->request->is($check)) {
              return false;
            }
        }
        return true;
    }

    public function baseURL()
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . $this->base;
    }

    /**
     * Convenience method for wrapping up JSON response logic.
     *
     * Sets the response content header to 'application/json', sets the given
     * HTTP status code (or 200, if not given), and delivers the (possibly
     * empty) payload.
     *
     * @param  int   $status HTTP status code to set, 200 (OK) by default.
     * @param  mixed $data   Payload to deliver, is coerced to an array.
     * @return void
     */
    public function json($status=200, $data=null)
    {
        $this->autoRender = false;
        $this->response->statusCode($status);
        $this->RequestHandler->respondAs('json');
        // JSON_NUMERIC_CHECK was added in 5.3.3. It ensures numbers are encoded
        // as numbers. We use it if available.
        if (defined('JSON_NUMERIC_CHECK')) {
            $this->response->body(json_encode((array)$data, JSON_NUMERIC_CHECK));
        } else {
            $this->response->body(json_encode((array)$data));
        }
    }

    /**
     * Get a small thumb of a resource (240x200), will create thumb if it doesn't already exist
     *
     * @param string $name should be name of image file
     *
     * @return string the url to the thumb
     */
    public static function smallThumb($name, $kid='')
    {
        if ($name === "" || $kid == '') {
            return '/' . BASE_URL . DEFAULT_THUMB;
        }
        $kidSplit = explode('-', $kid);
        $pid = $kidSplit[0];
        $sid = $kidSplit[1];

        $nameStuff = explode('/', $name);
        $rPart = array_shift($nameStuff);
        $fPart = array_shift($nameStuff);
        $imageName = implode($nameStuff);

        $name = KORA_FILES_URI.'p'.$pid."/f".$sid.'/'.$rPart.'/'.$fPart."/thumbnail/".$imageName;
        return $name;
    }

    /**
     * Get a large thumb of a resource (400x400), will create thumb if it doesn't already exist
     *
     * @param string $name should be name of image file
     *
     * @return string the url to the thumb
     */
    public function largeThumb($name,  $kid='')
    {
        if ($name === "" || $kid == '') {
            return '/' . BASE_URL . DEFAULT_THUMB;
        }
        $kidSplit = explode('-', $kid);
        $pid = $kidSplit[0];
        $sid = $kidSplit[1];

        $nameStuff = explode('/', $name);
        $rPart = array_shift($nameStuff);
        $fPart = array_shift($nameStuff);
        $imageName = implode($nameStuff);

        $name = KORA_FILES_URI.'p'.$pid."/f".$sid.'/'.$rPart.'/'.$fPart."/medium/".$imageName;
        return $name;
    }


    /**
     * Used by smallThumb and largeThumb to do the resizing work - I think this should work...
     *
     * @param  $image
     * @param  $min_width
     * @param  $min_height
     * @param  string     $method
     * @return resource
     */
    private static function resize($image, $min_width, $min_height, $method = 'scale')
    {
        // get the current dimensions of the image
        $src_width = imagesx($image);
        $src_height = imagesy($image);

        // if either max_width or max_height are 0 or null then calculate it proportionally
        if (!$min_width ) {
            $min_width = $src_width / ($src_height / $min_height);
        }
        elseif (!$min_height ) {
            $min_height = $src_height / ($src_width / $min_width);
        }

        // if scaling the image calculate the dest width and height
        $dx = $src_width / $min_width;
        $dy = $src_height / $min_height;
        /*if ( $method == 'scale' ){
            $d = max($dx,$dy);
        }
        // otherwise assume cropping image
        else{
            $d = min($dx, $dy);
        }*/
        $d = min($dx, $dy);
        $new_width = $src_width / $d;
        $new_height = $src_height / $d;
        // sanity check to make sure neither is zero
        $new_width = max(1, $new_width);
        $new_height = max(1, $new_height);

        $thumb_width = max($min_width, $new_width);
        $thumb_height = max($min_height, $new_height);

        // offset into thumbination image
        $thumb_x = ($thumb_width - $new_width) / 2;
        $thumb_y = ($thumb_height - $new_height) / 2;

        // create a new image to hold the thumbnail
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

        // copy from the source to the thumbnail
        imagecopyresampled($thumb, $image, $thumb_x, $thumb_y, 0, 0, $new_width, $new_height, $src_width, $src_height);
        return $thumb;
    }

	//check if the user is an admin of the project or if they created the resource
    public function authenticateUserByKid($kid){


		$project = self::convertKIDtoProjectName($kid);
        $pid = self::getPIDFromProjectName($project);

		//if they are not signed in
		if (!isset($_SESSION['Auth']['User'])){
			return false;
		}

		$user_id = $_SESSION['Auth']['User']['id'];
		$mappings = $this->Mapping->find('all', array(
			'fields' => array('Mapping.pid'),
			'conditions' => array(
				'AND' => array(
					'Mapping.id_user' => $user_id,
					'Mapping.status' => 'confirmed',
					'Mapping.role' => 'Admin',
					'Mapping.pid' => $pid
				),
			)
		));

		if( empty($mappings) ){
			return false;
		}else{
			return true;
		}

		die;
    }

    //get a user's profile picture
    public function checkForProfilePicture($username, $email=''){
        $uploads_path = Configure::read('uploads.path') . "/profileImages/";
        $uploads_url  = Configure::read('uploads.url')  . "/profileImages/";

        $return = NULL;
        $profileImage = glob($uploads_path . $username . '.*');
        if (count($profileImage) == 1) {
            $filename = explode('/', $profileImage[0]);
            $filename = array_pop($filename);
            $return = $uploads_url . $filename;
        }elseif($email!=''){
            $gravatar = 'http://gravatar.com/avatar/'.md5(strtolower($email)).'?d=404';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$gravatar);
            // don't download content
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch)!==FALSE){
                $return = $gravatar;
            }
        }
        if ($return == NULL) {
            $return = $this->webroot."app/webroot/img/DefaultProfilePic.svg";
        }
        return $return;
    }

    public static function time_elapsed_string($createdDate, $full = false) {
        $now = new DateTime;
        // return $now;
        $ago = new DateTime($createdDate);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    //takes pid, sid, list of field names, and the internal form name in kora3
    //returns an object of key:value which are 'field name':[field options]
    public static function getK3Controls($pid, $sid, $names, $form_name) {
        $url = KORA_RESTFUL_URL.'projects/'.$pid.'/forms/'.$form_name.'/fields';
        $ch = curl_init();
        $controls = array();

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    	$result = curl_exec($ch);
        //make result an indexable array
        $result = json_decode($result, true);

        curl_close($ch);

        foreach($names as $name) {
            foreach($result as $field) {
                if ($field['name'] == $name){
                    $controls[$name] = $field['options']['Options'];
                }
            }
        }

        return $controls;
    }





}
