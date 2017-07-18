<?php

require_once(KORA_LIB . "General_Search.php");


/**
 * Users Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class UsersController extends AppController
{
    public $name = 'Users';
    public $uses = array('User', 'Mapping');
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(
          'crop', 'signup', 'special_login', 'register', 'confirm_user',
          'register_no_invite', 'reset_password', 'display', 'getEmail',
          'getUsername', 'ajaxAdd', 'ajaxInvite', 'registerByInvite', 'ajaxUpdate',
          'profile', 'getAllUsers', 'findById', 'ajaxDelete'
          );
        $this->User->flatten = true;
        $this->User->recursive = -1;
    }
    /**
      * Takes a parameter which can be either (KID, PID, project name)
      * and resolves a project.
      *
      * @param $param either (KID, PID, project name)
      *
      * @return a map with project name and a bool value for $param type
      */
    public static function resolveProject($param) {
      $project = NULL;
      $isResource = false;
      // test for project name
      try {
        parent::getPIDFromProjectName($param);
        $project = $param;

      } catch (Exception $e) {
        // test for a KID
        if ($tmp = parent::convertKIDtoProjectName($param)) {
          $project = $tmp;
          $isResource = true;

        } else {
          // test for a pid
            try {
              $projects = parent::getPIDArray();
              if ($tmp = array_search($param, $projects)) {
                  $project = $tmp;
              }
            } catch (Exception $e){}
        }
      }
      return array(
        "project" => $project,
        "isResource" => $isResource
      );
    }
    /**
      * Takes a project name and finds the corresponding admins
      *
      * @param $project is the project name
      *
      * @return array of admin emails
      */
    public function getAdmins($project) {
      $pid;
      $ids = array();
      $mapping = array();

      try {
        $pid = parent::getPIDFromProjectName($project);
      } catch (Exception $e) {
        // indicate no admins
        return array();
      }

      // sql query on admins on the project
      $res = $this->Mapping->find('all', array(
        'fields' => array('Mapping.id_user'),
        'conditions' => array(
          'Mapping.role' => 'Admin',
          'Mapping.pid'  => $pid
        )
      ));

      // push the ID's to an array
      foreach ($res as $key => $value) {
        array_push($ids, $value['Mapping']['id_user']);
      }

      // Find the ID's in the user table
      $res = $this->User->findAllById($ids);

      // push the emails to an array
      foreach ($res as $key => $value) {
        array_push($mapping, $value['email']);
      }
      // return the admin emails
      return $mapping;
    }
    /**
      * Takes a parameter which can be either (KID, PID, project name)
      * sends a permission request to the admins
      *
      * @param $project is the project name
      *
      * @return array of admin emails
      */
    public function requestPermission($param) {
      $template; $viewVars; $admins;

      $resolve = static::resolveProject($param);
      $admins = $this->getAdmins($resolve["project"]);
      // don't render a view
      $this->autoRender = false;

      // assert email dependencies
      if (($user = $this->getUser($this->Auth)) && !is_null($resolve["project"]) && !empty($admins)) {
        // Set the template and view vars based on type
        if ($resolve["isResource"]) {
          $template = 'requestAccessResource';
          $viewVars = array('user' => $user, 'project' => $resolve["project"], 'resource' => $param);
          // else is project permissions
        } else {
          $template = 'requestAccessProject';
          $viewVars = array('user' => $user, 'project' => $resolve["project"]);
        }
        // Send emails to admins
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->viewVars($viewVars)
              ->template($template, 'default')
              ->emailFormat('html')
              ->subject('User Access Request')
              ->to($admins)
              ->from(array('arcs@arcs.matrix.msu.edu' => 'ARCS'));
        $Email->send();

        // return the flash message for frontend
        return "Success, the request has been sent.";
      }
      // return the flash message for frontend
      return "Error, Request was not set";
    }

    public function getUser(&$auth){
        if ($auth->loggedIn()){
            $user = $this->User->find('first', array(
                'conditions' => array("User.id" => $auth->user("id"))
            ));
            if (!empty($user))
                return $user;
        }
        return false;
    }

    /**
     * Add a new user.
     */
    public function add()
    {
        if (!($this->request->is('post') && $this->request->data))
            return $this->json(400);
        if ($this->Access->isAdmin())
            $this->User->permit('isAdmin');
        if (!$this->User->add($this->request->data))
            return $this->json(400);
        $this->json(201, $this->User->findById($this->User->id));
    }

    public function ajaxDelete(){
        $this->autoRender = false;
        if (!($this->request->is('post') && $this->request->data))
            return $this->json(400);
        $results = $this->Mapping->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'id_user' => $this->request->data['id'],
                    'status'=>'confirmed'
                )
            )
        ));
        $projects = array();
        foreach($results as $map){
            array_push($projects, array('project'=>array('pid'=>$map['Mapping']['pid'])));
        }
        //make sure the admin has permissions for every project the delete is a part of
        $authenticated = $this->pluginAuthentication(
            $this->request->data['user'],
            $this->request->data['pass'],
            $projects
        );
        $response["message"] = '';
        if( !$authenticated ){
            $response['message'] = 'You need to be an admin for every project the user is a part of to be able to delete.';
            echo json_encode($response); die;
        }
        $conditionArray = array( 'id_user' => $this->request->data['id'] );
        if( !$this->Mapping->deleteAll($conditionArray, false) ){
            $response['message'] = 'There was an error deleting the user project permissions.';
            echo json_encode($response); die;
        }
        $conditionArray = array( 'id' => $this->request->data['id'] );
        if( !$this->User->deleteAll($conditionArray, false) ){
            $response['message'] = 'There was an error deleting the user.';
            echo json_encode($response); die;
        }
        $response['message'] = 'success';
        $this->json(201, $response);
    }

    /**
     * Add a new user through ajax.
     */
    public function ajaxAdd(){
        $this->autoRender = false;
        if (!$this->request->is('post') || !isset($this->request->data['form']['projects']) )
            return $this->json(400);
        $mappingProjects = array();
        foreach( $this->request->data['form']['projects'] as $p ){
            array_push($mappingProjects, array('project'=>$p['project'], 'role'=>array('name'=>$p['role'], 'value'=>$p['role'])));
        }
        $authenticated = $this->pluginAuthentication(
            $this->request->data['user'],
            $this->request->data['pass'],
            $this->request->data['form']['projects']
        );
        $this->request->data = $this->request->data['form'];
        unset($this->request->data['projects']);
        $response["message"] = [];
        $response['auth'] = $authenticated;
        if( !$authenticated ){
            $response["status"]["credentials"] = "Invalid Arcs Credentials";
            return $this->json(400, ($response));
        }
        $response["status"] = $this->User->add($this->request->data);
        if ($response["status"] == false) {
            $response["message"] = $this->User->invalidFields();
            return $this->json(400, ($response));
        }
        $this->editMappings($mappingProjects, array(), $response["status"]['User']['id']);
        $this->json(201, $response);
    }

    /**
     * update user through ajax.
     */
    public function ajaxUpdate(){
        $this->autoRender = false;
        if (!($this->request->is('post') && $this->request->data))
            return $this->json(400);

        $id = $this->request->data['form']['id'];
        $user = $this->User->read(null, $id);
        $current = $this->request->data['form']['projects'];
        $add = array();
        if( isset($this->request->data['addProjects']) ) {
            $add = $this->request->data['addProjects'];
        }
        $delete = array();
        if( isset($this->request->data['deleteProjects']) ) {
            $delete = $this->request->data['deleteProjects'];
        }
        $all = $current;
        foreach($add as $a){
            array_push($all, array('project'=>array('pid'=>$a['project']['pid'])));
        }foreach($delete as $d){
            array_push($all, array('project'=>array('pid'=>$d['project']['pid'])));
        }
        $authenticated = $this->pluginAuthentication(
            $this->request->data['user'],
            $this->request->data['pass'],
            $all
        );
        $this->request->data = $this->request->data['form'];
        if( !$authenticated ){
            echo 'notValid';
            die;
        }
        if (!$user){
            return $this->json(404);
        }
        $this->editMappings($add, $delete, $id);
        if( $this->request->data['password'] == '' ){
            unset( $this->request->data['password'] );
        }
        if (!$this->User->save($this->request->data)) {
            $response["status"] = null;
            return $this->json(400, ($response));
        }
        $this->json(200, $this->User->findById($id));
    }

    //Update the mappings table for the plugin edit user
    public function editMappings($add, $delete, $userId){
        foreach($delete as $d){
            $conditionArray = array( 'AND' => array(
                'id_user' => $userId,
                'role' => $d['role'],
                'pid'=> $d['pid'],
                'status'=>'confirmed'
            ));
            if( !$this->Mapping->deleteAll($conditionArray, false) ){
                return $this->json(404);
            }
        }
        foreach($add as $a){
            $map = array(
                'id_user' => $userId,
                'role' => $a['role']['name'],
                'pid'=> $a['project']['pid'],
                'status'=>'confirmed'
            );
            if( !$this->Mapping->save($map) ){
                return $this->json(404);
            }
        }
    }

    /**
     * Edit a user.
     *
     * @param string $id user id
     */
    public function edit($id = null)
    {
        $this->Session->setFlash($this->data['User']['id']);
        // Change to return json error! Otherwise it is nearly impossible to diagnois why ajax isn't working.
        if (!($this->request->is('put') || $this->request->is('post')))
            // throw new MethodNotAllowedException();
            return $this->json(405);
        if (!$this->request->data || !$id)
            // throw new BadRequestException();
            return $this->json(400);
        $user = $this->User->read(null, $id);
        if (!$user)
            // throw new NotFoundException();
            return $this->json(404);
        # Must be editing own account, or an admin.
       if (!($this->User->id == $this->Auth->user('id') || $this->Access->isAdmin()))
            // throw new ForbiddenException();
            return $this->json(403);
        # Only admins can change user roles.
       if ($this->Access->isAdmin())
            $this->User->permit('isAdmin');
        // returns internal error when it shouldn't <<<<<<<<<<<<<<<<
        if (!$this->User->save($this->request->data)) {
            // throw new InternalErrorException();
            return $this->json(500);
        }
        # Update the Auth Session var, if necessary.
       if ($id == $this->Auth->user('id'))
            $this->Session->write('Auth.User', $this->User->findById($id));
        $this->json(200, $this->User->findById($id));
    }

    /**
     * Delete a user by id.
     *
     * Only an admin can delete users.
     *
     * @param string $id user id
     */
    public function delete($id = null)
    {
        if (!$this->request->is('delete')) return $this->json(405);
        if (!$this->Access->isAdmin()) return $this->json(403);
        if (!$this->User->findById($id)) return $this->json(404);
        if (!$this->User->delete($id)) return $this->json(500);
        $this->json(204);
    }

    /**
     * Authenticates login and forgot password POST form sent from the login modal.
     * Note: called "special_login" because there might be calls to "login" not removed.
     * @param string $id user id
     */
    public function special_login()
    {
        $this->User->flatten = false;
          if ($this->request->is('post')) {
            if ($this->request->data['User']['forgot_password']) {
                /* Reset user's password */
                $email = $this->request->data['User']['username']; // actually is email because the reset form overrides the login form
                $user = $this->User->findByEmail($this->request->data['User']['username']);
                if (!$user) {
                    $this->Session->setFlash("Sorry, we couldn't find an account with that email address.", 'flash_error');
                    $this->redirect('/');
                } else if ($user['User']['reset'] != null) {
                    $this->Session->setFlash("Your password is already in the process of being reset.  We have sent you another email with instruction to reset your password.", 'flash_error');
                    $this->sendEmailResetPassword($email, $user['User']['reset']);
                    $this->redirect('/');
                } else {
                    $token = $this->User->getToken();
                    $this->User->permit('reset');
                    $this->User->saveById($user['User']['id'], array(
                        'reset' => $token
                    ));

                    $this->sendEmailResetPassword($email, $token);
                    $this->Session->setFlash("We've sent an email to $email. It contains a special " .
                        "link to reset your password.", 'flash_success');
                    $this->redirect('/');
                }
            } else {
                /* Logs user in */
                $user = $this->User->findByRef($this->request->data['User']['username']);
                if($user['User']['status'] == 'active'){
                        if ($this->Auth->login()) {
                                $this->User->id = $user['User']['id'];
                                $this->User->saveField('last_login', date("Y-m-d H:i:s"));
                                return $this->redirect($this->referer());
                                // return $this->redirect($this->Auth->redirect());
                        } else {
                                $this->Session->setFlash("Wrong username or password.  Please try again.", 'flash_error');
                                $this->redirect($this->referer());
                        }
                }
                else if($user['User']['status'] == 'pending') {
                        $this->Session->setFlash("You cannot log in until an administrator approves your account.", 'flash_error');
                        return $this->redirect('/');
                }
                else if($user['User']['status'] == 'unconfirmed') {

                    // change status of user
                    $this->User->id = $user['User']['id'];
                    $this->User->saveField('status', "pending");

                    // notify admins of the new user
                    $admins = $this->User->find('all', array('conditions' => array('User.isAdmin' => 1)));
                    foreach ($admins as $admin) {
                        $this->pendingUserEmail($admin, $user);
                    }
                    $this->Session->setFlash("Thank you for confirming your registration.  Your account is waiting for administrator approval.", 'flash_success');
                    $this->redirect('/');
                }
                //Invited users will not be found by findByRef until activated
                else if(!$user) {
                        $this->Session->setFlash("Username not found.", 'flash_error');
                        $this->redirect('/');
                }
            }
        }
    }


    /**
     * Change the password.
     *
     * @param string $token a valid password reset token
     */
    public function reset_password($token = null)
    {
        if (!$token) throw new BadRequestException();
        $this->set(array('toolbar' => false, 'footer' => false));
        $user = $this->User->findByReset($token);
        if (!$user || is_null($token)) {
            $this->Session->setFlash("Invalid token.", 'flash_error');
            return $this->redirect('/');
        }
        if (($this->request->is('put') || $this->request->is('post')) && isset($this->data['User']['password'])) {
            $this->User->id = $user['id'];
            $this->User->permit('password');
            $this->User->permit('reset');
            if ($this->User->save(array(
                'password' => $this->data['User']['password'],
                'reset' => null
            ))
            ) {
                $this->Session->setFlash("Your password has been changed. You may now login.", 'flash_success');
                $this->redirect('/');
            } else {
                $this->Session->setFlash("There was an error.  Please try again.", 'flash_error');
            }
        }
    }

    /**
     * Change the password.
     *
     * @param string $username a valid user whose status is unconfirmed
     */
    public function confirm_user($username = null)
    {
        $user = $this->User->findByRef($username);

        if($user['status'] == 'pending' ){  //user clicked the confirm link a second time.
            $this->Session->setFlash("Your account is confirmed, the admins will be notified of your request.", 'flash_success');
            //TODO - this session message won't work on the main page.
            $this->redirect('/');
            return;
        }

        if ($username == null || !$user || $user['status'] != 'unconfirmed') throw new BadRequestException();

        // change status of user
        $this->User->id = $user['id'];
        $this->User->saveField('status', "pending");

        // notify admins of the new user
        $admins = $this->User->find('all', array('conditions' => array('User.isAdmin' => 1)));
        foreach ($admins as $admin) {
            $this->pendingUserEmail($admin, $user);
        }

        $this->Session->setFlash("Thank you for confirming your registration.  Your account is waiting for administrator approval.", 'flash_success');
        $this->redirect('/');
    }

    /**
     * Logout the user.
     */
    public function logout()
    {
        $this->Auth->logout();
        $this->redirect('/');
    }

    /**
     * Send an invite email and set up a skeleton account.
     */
    public function invite()
    {
        if (!$this->Access->isAdmin()) throw new ForbiddenException();
        if (!$this->request->is('post')) throw new MethodNotAllowedException();
        $data = $this->request->data;

        if (!($data && $data['email']))
            throw new BadRequestException();
        $token = $this->User->getToken();
        $this->User->permit('activation');
        $this->User->add(array(
            'email' => $data['email'],
            'isAdmin' => $data['isAdmin'],
            'activation' => $token
        ));
        $this->sendInviteEmail($data, $token);
        $this->json(202);

    }

    /**
     * Send an invite email and set up a skeleton account.
     */
    public function ajaxInvite()
    {
        if (!$this->request->is('post')) throw new MethodNotAllowedException();
        $data = $this->request->data;
        if (!($data && $data['email']))
            throw new BadRequestException();
        $token = $this->User->getToken();
        $this->User->permit('activation');
        $this->User->permit('isAdmin');
        $name = $data['firstName'] . " " . $data['lastName'];
        $response["message"] = [];
        $response["status"] = $this->User->add(array('name' => $name, 'isAdmin' => $data['isAdmin'], 'email' => $data['email'], 'activation' => $token, 'status' => "invited"));
        if ($response["status"] == false) {
            $response["message"] = $this->User->invalidFields();
            return $this->json(400, ($response));
        } else {
            $this->ajaxSendInviteEmail($data, $token);
            $this->json(202, ($response));
        }
    }


    /**
     * Register a user FROM NO INVITE
     */
    public function register()
    {
        $this->loadModel('Mapping');
        if ($this->request->is('post')) {
            if ($this->request->data('g-recaptcha-response')) {
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdFHQ0TAAAAADQYAB3dz72MPq293ggfKl5GOQsm&response=" . $this->request->data('g-recaptcha-response'));
                $response = json_decode($response, true);
                if ($response['success'] === true) {
                    $this->User->permit('isAdmin', 'last_login');
                    if ($this->User->add(array(
                        'name' => $this->request->data['User']['name'],
                        'username' => $this->request->data['User']['usernameReg'],
                        'email' => $this->request->data['User']['email'],
                        'password' => $this->request->data['User']['passwd'],
                        'isAdmin' => 0,
                        'last_login' => null,
                        'status' => 'unconfirmed'
                    ))) {
                        $allDat = $this->User->findByRef($this->request->data['User']['usernameReg']);
                        $id = $allDat['id'];
                        $projects = explode(", ", $this->request->data['User']['project']);
                        $mappingArray = [];
                        foreach ($projects as $project) {
                            $mappingArray[] = array(
                                'id_user' => $id,
                                'role' => 'Researcher',
                                'pid' => $this->getPIDFromProjectName(strtolower(str_replace(" ","_",$project))),
                                'status' => 'unconfirmed',
                                'activation' => $this->Mapping->getToken()
                            );
                        }
                        $this->Mapping->saveAll($mappingArray);
                        $user = $this->User->findByRef($this->request->data['User']['usernameReg']);
                        $this->confirmUserEmail($user);
                        $this->Session->setFlash("Thank you for registering.  You will recieve a confirmation email shortly.  After your account is confirmed, the admins will be notified of your request.", 'flash_success');

                        $this->redirect($this->referer());
                    } else {
                        $error_message = "";
                        foreach (array_keys($this->User->validationErrors) as $key) {
                            $error_message .= "Error with " . strtolower(ucfirst($key)) . ': ';
                            for ($x = 0; $x < count($this->User->validationErrors[$key]); $x++)
                                $error_message .= $this->User->validationErrors[$key][$x] . '.  ';
                            $error_message .= "<br>";
                        }
                        $this->Session->setFlash($error_message, 'flash_error');
                        $this->redirect($this->referer());
                    }
                } elseif ($response['success'] === false) {
                    $this->Session->setFlash("There was an error with the reCaptcha.", 'flash_error');
                    $this->redirect($this->referer());
                }
            } else {
                $this->Session->setFlash("Please complete the reCaptcha.", 'flash_error');
                $this->redirect($this->referer());
            }
        } else {
            $this->redirect($this->referer());
        }
    }

    /**
     * Register an invited user
     */
    public function registerByInvite($token)
    {
        $this->set('activation', $token);
        $this->set('error', false);

        $conditions = array('User.activation' => $token);
        $user = $this->User->find('first', array('conditions' => $conditions));

        if ($user['activation'] == null) {
            $this->set('error', true);
        }

        $this->set('email', $user['email']);
        $this->set('name', $user['name']);

                if (isset($this->data['User'])) {
                        //Check if passwords match
                        if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                                $this->Session->setFlash('Passwords do not match', 'flash_error');
                        } else {
                                //Find user
                                $conditions = array('User.activation' => $this->data['User']['activation']);
                                $user = $this->User->find('first', array('conditions' => $conditions));
                                $this->User->id = $user['id'];

                                //Check if user was found
                                if ($this->User->id) {
                                        //Try to save data
                                        $newUser = $this->data['User'];
                                        $newUser['status'] = "active";
                                        //$this->data['User']['status'] = "active";
                                        // var_dump($newUser);
                                        if (!$this->User->save($newUser)) {
                                                //Print error messages
                                                $error_message = "";
                                                foreach (array_keys($this->User->validationErrors) as $key) {
                                                   $error_message .= ucfirst($key) . ': ';
                                                   for ($x = 0; $x < count($this->User->validationErrors[$key]); $x++)
                                                           $error_message .= $this->User->validationErrors[$key][$x] . '.  ';
                                                   $error_message .= "<br>";
                                                }
                                                $this->Session->setFlash($error_message, 'flash_error');
                                        } else {
                                                //Remove activation token from user
                                                $this->User->saveField('activation', null);

                                                //Login and redirect
                                                $user = $this->User->findById($user['id']);
                                                $this->Auth->login($user);
                                                $this->Session->setFlash("Your account has been created successfully!", 'flash_success');
                                                $this->redirect('/');
                                        }
                                } else {
                                        //Error getting user
                                        $this->Session->setFlash('Account count not be created.', 'flash_error');
                                }
                        }
                }
    }

    /**
     * Checks if email exists
     */
    public function getEmail()
    {
        $this->autoRender = false;
        $email = $_POST['email'];
        $emailReturn = $this->User->find(
            'first',
            array(
                'conditions' => array(
                    'User.email' => $email
                )
            )
        );
        if (empty($emailReturn)) {
            echo 0;
        } else {
            echo true;
        }
    }

    /**
     * Checks if username exists
     */
    public function getUsername()
    {
        $this->autoRender = false;
        $username = $_POST['username'];
        $usernameReturn = $this->User->find(
            'first',
            array(
                'conditions' => array(
                    'User.username' => $username
                )
            )
        );
        if (empty($usernameReturn)) {
            echo 0;
        } else {
            echo true;
        }
    }

    /**
     * Display the user's profile.
     *
     * @param string $ref username or id of an existing user
     */
    public function profile($ref){
        $this->User->flatten = false;
        $this->User->recursive = 1;

        $signedIn = $this->getUser($this->Auth);

        /*** Begin Getting User Information ***/
        $user = $this->User->find('first', array(
            'conditions' => array(
                'OR' => array('User.username' => $ref, 'User.id' => $ref),
            ),
            'order' => array('id' => 'DESC'),
        ))['User'];

        if ($ref == "" || !$user)
            throw new NotFoundException();

        $mappings = $this->Mapping->find('all', array(
            'fields' => array('Mapping.role', 'Mapping.pid'),
            'conditions' => array(
                'AND' => array('Mapping.id_user' => $user['id'], 'Mapping.status' => 'confirmed'),
            )
        ));

        $thumbnails = '';
        $user['mappings'] = array();
        foreach($mappings as $mapping) {
            $project = parent::getProjectNameFromPID($mapping["Mapping"]['pid']);
            $role = $mapping["Mapping"]['role'];
            $user['mappings'][] = array("project" => $project,
                                        "role" => $role);
            if( $role == 'Admin' ) {
                $thumbnails .= "<dd><input class=\"createThumbnails\" data-project=\"$project\" " .
                    "type=\"submit\" value=\"Create All $project Thumbnails\"></dd>";
            }
        }
        if( $signedIn == FALSE ){
            $user['thumbnails'] = '';
        }else {
            $user['thumbnails'] = $thumbnails;
        }

        $this->loadModel('Comment');
        $user['commentsCount'] = $this->Comment->find('count', array(
            'conditions' => array('Comment.user_id' => $user['id']),
            'recursive' => -1
        ));

        $this->loadModel('Annotation');
        $user['annotationsCount'] = $this->Annotation->find('count', array(
            'conditions' => array('Annotation.user_username' => $user['username'])
        ));

        $this->loadModel('MetadataEdit');
        $user['metadataCount'] = $this->MetadataEdit->find('count', array(
            'conditions' => array(
                'AND' => array('MetadataEdit.user_id' => $user['id'], 'MetadataEdit.approved' => '1'),
            )
        ));
        $now = new Datetime();
        $created = new Datetime($user['created']);
        $user['monthsCount'] = $created->diff($now)->m + ($created->diff($now)->y * 12);
        $user['totalCount'] = $user['annotationsCount'] + $user['commentsCount'] + $user['metadataCount'] + $user['monthsCount'];
        $user['activeSince'] = $created->format('F Y');
        /*** End Getting User Information ***/

        /*** Begin Profile Picture ***/
        $uploads_path = Configure::read('uploads.path') . "/profileImages/";
        $uploads_url  = Configure::read('uploads.url')  . "/profileImages/";

        //authenticate---
        if( isset($signedIn['User']['username']) ){
            $signedIn = $signedIn['User']['username'];
        }
        //upload the profile picture function
        if ($this->request->is("post") && $user['username'] == $signedIn ) {
            if (isset($_FILES['user_image'])) {
                $vaildExtensions = array('jpg', 'jpeg', 'gif', 'png');
                $nameEnd = explode('.',$_FILES['user_image']['name']);
                $file_ext = strtolower(end($nameEnd));
                if ($_FILES['user_image']['error'] > 0 ) {
                    $error    = $_FILES['user_image']['error'];
                    $errorOut = "Unknown upload error.";
                    if     ($error == 1) $errorOut = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                    elseif ($error == 2) $errorOut = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                    elseif ($error == 3) $errorOut = "The uploaded file was only partially uploaded";
                    elseif ($error == 4) $errorOut = "No file was uploaded";
                    elseif ($error == 6) $errorOut = "Missing a temporary folder";
                    elseif ($error == 7) $errorOut = "Failed to write file to disk";
                    elseif ($error == 8) $errorOut = "File upload stopped by extension";
                    $this->Session->setFlash("Error: " . $errorOut, 'flash_error');
                } elseif (!getimagesize($_FILES['user_image']['tmp_name'])) {
                    // check if image file exists
                    $this->Session->setFlash("Failed to upload the image.  Cannot find the temporary file.", 'flash_error');
                } elseif ($_FILES['user_image']['size'] > 500000) {
                    // check if file size is extremely large
                    $this->Session->setFlash("Failed to upload the image.  The file size is too large.", 'flash_error');
                } elseif (!in_array($file_ext, $vaildExtensions)) {
                    // check if file extension is valid
                    $this->Session->setFlash("Failed to upload the image.  The file extension is not supported.", 'flash_error');
                } else {
                    // try to upload the image.
                    $uploadFile = $uploads_path . $user['username'] . ".";

                    // each user is allowed one profile picture
                    if (count(glob($uploadFile."*")) > 0) {
                        foreach (glob($uploadFile."*") as $file) {
                            unlink($file);
                        }
                    }
                    if (move_uploaded_file($_FILES['user_image']['tmp_name'], $uploadFile.$file_ext)) {
                        $this->Session->setFlash("Profile picture has been uploaded successfully.", 'flash_success');
                        $actual_link = 'http://'.$_SERVER['HTTP_HOST'].'/'.BASE_URL.'user/'.$user["username"];
                        $this->redirect($actual_link);
                    } else {
                        $this->Session->setFlash("Failed to move the image to the approiate location.", 'flash_error');
                        $actual_link = 'http://'.$_SERVER['HTTP_HOST'].'/'.BASE_URL.'user/'.$user["username"];
                        $this->redirect($actual_link);
                    }
                }
            }
            die;
        }

        //get the user profile picture
        $user['profileImage'] = NULL;
        $profileImage = glob($uploads_path . $user['username'] . '.*');
        if (count($profileImage) == 1) {
            $filename = explode('/', $profileImage[0]);
            $filename = array_pop($filename);
            $user['profileImage'] = $uploads_url . $filename;
        }else{
            $gravatar = 'http://gravatar.com/avatar/'.md5(strtolower($user['email'])).'?d=404';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$gravatar);
            // don't download content
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch)!==FALSE){
                $user['profileImage'] = $gravatar;
            }
        }
        if ($user['profileImage'] == NULL) {
            $user['profileImage'] = $this->webroot."app/webroot/img/DefaultProfilePic.svg";
        }

        // set user and admin status
        $this->set('isAdmin', $this->Access->isAdmin());
        $this->set('user_info', $user);
    }

    /**
     * Give users the options to crop profile image.
     *
     * @param string $ref username or id of an existing user
     */
    public function crop($ref)
    {

        $uploads_path = Configure::read('uploads.path') . "/profileImages/";
        $uploads_url  = Configure::read('uploads.url')  . "/profileImages/";

        // For reference:
        // $uploads_path = '/matrix/dev/public_html/arcs/app/webroot/uploads/profileImages/'
        // $uploads_url = 'http://dev2.matrix.msu.edu/arcs/uploads/profileImages/'

        // change picture with cropped version
        if ($this->request->is('post') && $this->request->data('id')) {
            $user = $this->User->findById($this->request->data('id'));
            if ($user) {
                $imageData = $this->request->data('canvasData');
                $filteredData = substr($imageData, strpos($imageData, ",")+1);
                $unencodedData = base64_decode($filteredData);

                $uploadFile = $uploads_path . $user['username'] . ".";
                if (count(glob($uploadFile."*")) > 0) {
                    foreach (glob($uploadFile."*") as $file) {
                        unlink($file);
                    }
                }

                $imageFile = fopen($uploadFile . "png", 'wb');
                fwrite($imageFile, $unencodedData);
                fclose($imageFile);

                $this->Session->setFlash("Profile picture has successfully been cropped.", 'flash_success');
            }
            return;
        }

        $user = $this->User->findByRef($ref);

        if ($ref == "" || !$user)
            throw new NotFoundException();
        if (!($user['id'] == $this->Auth->user('id') || $this->Access->isAdmin()))
            throw new ForbiddenException();

        // get current profile picture
        $user["profileImage"] = NULL;
        $profileImage = glob($uploads_path . $user['username'] . ".*");

        // only grab the first image; there could be multiple images with same name and different extensions
        if (count($profileImage) > 0) {
            $user["profileImage"] = $uploads_url . explode('/', $profileImage[0])[9];
            // explode seperates the url on '/', we want the 'username.ext' part
        }

        $this->set('isAdmin', $this->Access->isAdmin());
        $this->set('user_info', $user);

        $baseURL = $this->baseURL() . "/user/" . $user['username'] . "/";
        $this->set("baseURL", $baseURL);
    }


    /**
     * Return an array containing values from the users.name column, for
     * autocompletion purposes. Responds only to ajax requests.
     */
    public function complete()
    {
        if (!$this->request->is('get')) throw new MethodNotAllowedException();
        return $this->json(200, $this->User->complete('User.name'));
    }

    /**
     * Send invitiational email
     * @param array data
     * @param token   a valid activation token
     */
    public function sendInviteEmail($data, $token)
    {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->viewVars(array(
            'activation' => $this->baseURL() . '/register/' . $token
        ))
            ->template('welcome', 'default')
            ->emailFormat('html')
            ->subject('Welcome to ARCS')
            ->to($data['email'])
            ->from(array('arcs@arcs.matrix.msu.edu' => 'ARCS'));
        $Email->send();
    }

    /**
     * Send invitiational email
     * @param array data
     * @param token   a valid activation token
     */
    public function ajaxSendInviteEmail($data, $token)
    {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->viewVars(array('activation' => $this->baseURL() . '/invitation/register/' . $token))
              ->emailFormat('html')
              ->template('welcome', 'default')
              ->subject('Welcome to ARCS')
              ->to($data['email'])
              ->from(array('arcs@arcs.matrix.msu.edu' => 'ARCS'));
        $Email->send();
    }

    /**
     * Send pending user email
     * @param array data
     * @param array user
     */
    public function pendingUserEmail($data, $user)
    {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->viewVars(array('user' => $user['name'], 'link' => KORA_PLUGIN_USERS ))
              ->emailFormat('html')
              ->template('pending_user', 'default')
              ->subject('ARCS New User Has Registered')
              ->to($data['email'])
              ->from(array('arcs@arcs.matrix.msu.edu' => 'ARCS'));
        $Email->send();
    }

        /**
     * Send pending user email
     * @param array data
     */
    public function confirmUserEmail($data)
    {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->viewVars(array('link' => $this->baseURL() . '/users/confirm_user/' . $data['username']))
              ->emailFormat('html')
              ->template('confirm_user', 'default')
              ->subject('ARCS Registration')
              ->to($data['email'])
              ->from(array('arcs@arcs.matrix.msu.edu' => 'ARCS'));
        /* Here is where the problem is.*/
        $Email->send();
    }

    /**
     * Send email to reset password.
     * @param string email
     * @param string token   a valid password reset token
     * @return void
     */
    public function sendEmailResetPassword($email, $token)
    {
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->viewVars(array('reset' => $this->baseURL() . '/users/reset_password/' . $token))
              ->emailFormat('html')
              ->template('reset_password', 'default')
              ->subject('Reset Password')
              ->to($email)
              ->from(array('arcs@arcs.matrix.msu.edu' => 'ARCS'));
        $Email->send();
    }

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
    public function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        if ($title_for_layout == 'About') {
            $this->set('toolbar', false);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        $this->render(implode('/', $path));
    }

    /**
     * Find user information by id - collections uses this to find collections in the model.
     */
    public function findById()
    {
        $model = $this->modelClass;
        $results = $this->$model->find('first', array(
            'conditions' => array('id' => $this->request->data['id'])
        ));
        $this->json(200, $results);
    }

    /**
     * Return all user names for the collections permissions on user profile page.
     */
    public function getAllUsers()
    {
        $model = $this->modelClass;
        $results = $this->$model->find('all', array(
            'conditions' => array('not' => array('name' => null)),
            'fields' => array('name', 'id', 'username'),
            'order' => 'name'
        ));
        $this->json(200, $results);
    }

    //create all thumbnails for a project in kora
    public function createThumbnails($projectName){
        set_time_limit(0);
        $signedIn = $this->getUser($this->Auth);

        if( $signedIn == FALSE ){
            echo 'You must be signed-in to do this.';
            die;
        }
        $mappings = $this->Mapping->find('all', array(
            'fields' => array('Mapping.role', 'Mapping.pid'),
            'conditions' => array(
                'AND' => array(
                    'Mapping.id_user' => $signedIn['id'],
                    'Mapping.status' => 'confirmed',
                    'Mapping.role' => 'Admin'
                ),
            )
        ));
        $pid = parent::getPIDFromProjectName($projectName);
        $pageSid = parent::getPageSIDFromProjectName($projectName);

        $permissions = false;
        foreach($mappings as $mapping) {
            if( $pid == $mapping["Mapping"]['pid'] ){
                $permissions = true;
            }
        }
        if( $permissions == false ){
            echo "You don't have the project permissions necessary to do this.";
            die;
        }
        $search = new General_Search($pid, $pageSid, 'kid', '!=', '0',['Image Upload']);
        $results = $search->return_array();
        foreach( $results as $page ){
            $localName = @$page['Image Upload']['localName'];
            $this->smallThumb($localName,$pid,$pageSid);
        }
        print_r('All thumbnails have been successfully created!');
        die;
    }

    //authenticate a plugin user
    public function pluginAuthentication($username, $password, $projects){
        $model = $this->modelClass;
        $results = $this->$model->find('first', array(
            'conditions' => array(
                'and' => array(
                    'username' => $username,
                    'password' => $password
                )
            )
        ));
        if( $results ){
            $mappings = $this->Mapping->find('all', array(
                'conditions' => array(
                    'Mapping.status' => 'confirmed',
                    'Mapping.id_user' => $results['id']
                )
            ));
            if( count($mappings) <= 0 ){
                return false;
            }
            foreach($projects as $project){
                $projectAuth = false;
                foreach( $mappings as $mapping ){
                    if($mapping['Mapping']['pid'] == $project['project']['pid']){
                        $projectAuth = true;
                    }
                }
                if($projectAuth == false){
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}
?>
