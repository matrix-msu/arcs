<?php
/**
 * Users Controller
 * 
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class UsersController extends AppController {
    public $name = 'Users';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('signup', 'special_login', 'register', 'register_no_invite', 'reset_password', 'display', 'getEmail', 'getUsername');
        $this->User->flatten = true;
        $this->User->recursive = -1;
    }

    /**
     * Display a user's bookmarks.
     *
     * @param string $ref
     */
    public function bookmarks($ref) {
        $user = $this->User->findByRef($ref);
        if (!$user) {
            $this->redirect('404');
        }
        $id = $user['User']['id'];
        $this->set('bookmarks', $this->User->Bookmark->find('all', array(
            'conditions' => array(
                'Bookmark.user_id' => $id
        ))));
    }

    /**
     * Add a new user.
     */
    public function add() {
        if (!($this->request->is('post') && $this->request->data))
            return $this->json(400);
        if ($this->Access->isAdmin())
            $this->User->permit('role');
        if (!$this->User->add($this->request->data)) 
            return $this->json(400);
        $this->json(201, $this->User->findById($this->User->id));
    }

    /**
     * Edit a user.
     *
     * @param string $id   user id
     */
    public function edit($id=null) {
        debug("editttt");
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
            $this->User->permit('role');
        // returns internal error when it shouldn't <<<<<<<<<<<<<<<<
        if (!$this->User->add($this->request->data)) {
			// throw new InternalErrorException();
            debug("in here");
            debug($this->validationErrors);
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
     * @param string $id   user id
     */
    public function delete($id=null) {
        if (!$this->request->is('delete')) return $this->json(405);
        if (!$this->Access->isAdmin()) return $this->json(403);
        if (!$this->User->findById($id)) return $this->json(404);
        if (!$this->User->delete($id)) return $this->json(500);
        $this->json(204);
    }

    /**
     * Authenticates login and forgot password POST form sent from the login modal.
     * Note: called "special_login" because there might be calls to "login" not removed.
     * @param string $id   user id
     */
    public function special_login() {
        $this->User->flatten = false;
        if ($this->request->is('post')) {
            /* reset user's password */
            if ($this->request->data['User']['forgot_password']) {
                $email = $this->request->data['User']['username'];
                $user = $this->User->findByEmail($email);
                if (!$user) { 
                    $this->Session->setFlash("Sorry, we couldn't find an account with that email address.", 'flash_error');
                    $this->redirect('/');
                } else {
                    $token = $this->User->getToken();
                    $this->User->permit('reset');
                    $this->User->saveById($user['User']['id'], array(
                        'reset' => $token
                    ));
            
                    $this->sendEmailResetPassword($email,$token);
                    $this->Job->enqueue('email', array(
                        'to' => $email,
                        'subject' => 'Reset Password',
                        'template' => 'reset_password',
                        'vars' => array(
                            'name' => array_shift(explode(' ', $user['User']['name'])),
                            'reset' => $this->baseURL() . '/users/reset_password/' . $token
                        )
                    ));
                    $this->Session->setFlash("We've sent an email to $email. It contains a special " .
                        "link to reset your password.", 'flash_success');
                    $this->redirect('/');
                }
            /* log user in */
            } else {
                $userByEmail = $this->User->findByEmail($this->request->data['User']['username']);
                if ($userByEmail)
                    $this->request->data['User']['username'] = $userByEmail['User']['username'];
                if ($this->Auth->login()) {
                    // given username get user's id
                    $this->User->id = $this->User->findByRef($this->request->data['User']['username'])['User']['id'];
                    $this->User->saveField('last_login', date("Y-m-d H:i:s"));
                    return $this->redirect($this->Auth->redirect());
                } else {
                    $this->Session->setFlash("Wrong username or password.  Please try again.", 'flash_error');
                    $this->redirect($this->referer());
                }
            }
        }
    }

    // duplicate
    /**
     * Create a reset password link and queue an email to the user.
     *
     * @param string $email
     */
    public function send_reset($email) {
        $user = $this->User->findByEmail($email);
		
        if (!$user) { 
            $this->Session->setFlash("Sorry, we couldn't find an account with that " . 
                "email address.", 'flash_error');
        } else {
            $token = $this->User->getToken();
            $this->User->permit('reset');
            $this->User->saveById($user['User']['id'], array(
                'reset' => $token
            ));
			
			$this->sendEmailResetPassword($email,$token);
            $this->Job->enqueue('email', array(
                'to' => $email,
                'subject' => 'Reset Password',
                'template' => 'reset_password',
                'vars' => array(
                    'name' => array_shift(explode(' ', $user['User']['name'])),
                    'reset' => $this->baseURL() . '/users/reset_password/' . $token
                )
            ));
            $this->Session->setFlash("We've sent an email to $email. It contains a special " .
               "link to reset your password.", 'flash_success');
        }
        $this->redirect('/#loginModal');
    }

    /**
     * Change the password.
     *
     * @param string $token   a valid password reset token
     */
    public function reset_password($token=null) {
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
            ))) {
                $this->Session->setFlash("Your password has been changed. You may now login.", 'flash_success');
                $this->redirect('/');
            } else {
                $this->Session->setFlash("There was an error.  Please try again.", 'flash_error');
            }   
        }
    }

    /**
     * Logout the user.
     */
    public function logout() {
		$this->Auth->logout();
        $this->redirect('/');
    }

    /**
     * Send an invite email and set up a skeleton account.
     */
    public function invite() {
        if (!$this->Access->isAdmin()) throw new ForbiddenException();
        if (!$this->request->is('post')) throw new MethodNotAllowedException();
        $data = $this->request->data;
		
        if (!($data && $data['email'] && !is_null($data['role'])))
            throw new BadRequestException();
        $token = $this->User->getToken();
        $this->User->permit('activation', 'role');
        $this->User->add(array(
            'email' => $data['email'],
            'role' => $data['role'],
            'activation' => $token
        ));
       /* $this->Job->enqueue('email', array(
            'to' => $data['email'],
            'subject' => 'Welcome to ARCS',
            'template' => 'welcome',
            'vars' => array(
                'activation' => $this->baseURL() . '/register/' . $token
            )
        ));*/
		$this->sendInviteEmail($data,$token);
        $this->json(202);
		
    }

    /**
     * Register a user FROM NO INVITE
     */
    public function register() {
        if ($this->request->is('post')) {
			$this->User->permit('role');
            $this->User->permit('last_login');
			if ($this->User->add(array(
                'name' => $this->request->data['User']['name'],
                'username' => $this->request->data['User']['usernameReg'],
				'email' => $this->request->data['User']['email'],
                'password' => $this->request->data['User']['passwd'],
				'role' => "Researcher",
				'activation' => null,
                'last_login' => date("Y-m-d H:i:s")
			))) {
                $user = $this->User->findByRef($this->request->data['User']['usernameReg']);
                $user = array_merge($user, $this->request->data['User']);
                $this->Auth->login($user);
                $this->redirect($this->referer());
            } else {
                $error_message = "";
                foreach(array_keys($this->User->validationErrors) as $key) {
                    $error_message .= ucfirst($key) . ': ';
                    for ($x = 0; $x < count($this->User->validationErrors[$key]); $x++)
                        $error_message .= $this->User->validationErrors[$key][$x] . '.  ';
                    $error_message .= "<br>";
                }
                $this->Session->setFlash($error_message, 'flash_error');
                $this->redirect($this->referer());
            }
        }
    }

	/** 
     * Checks if email exists
     */
	public function getEmail() {
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
		if(empty($emailReturn)) {
			echo 0;
		} else {
			echo true;
		}
	}

	/**
     * Checks if username exists
     */
	public function getUsername() {
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
		if(empty($usernameReturn)) {
			echo 0;
		} else {
			echo true;
		}
	}

    /**
     * Display the user's profile.
     *
     * @param string $ref  username or id of an existing user
     */
    public function profile($ref) {
        $this->User->flatten = false;
        $this->User->recursive = 1;
        $user = $this->User->find('first', array(
            'conditions' => array(
                'OR' => array('User.username' => $ref, 'User.id' => $ref),
            ),
            'order' => array('id' => 'DESC'),
            'contain' => array(
                'Resource'   => array('limit' => 30),
                'Annotation' => array('limit' => 30),
                'Collection' => array('limit' => 30),
                'Comment'    => array('limit' => 30)
            )
        ));
        $this->loadModel('Annotation');
        $user['User']['annotationsCount'] = $this->Annotation->find('count', array(
            'conditions' => array('Annotation.user_username' => $user['User']['username'])
        ));
        $this->loadModel('Comment');
        $user['User']['commentsCount'] = $this->Comment->find('count', array(
            'conditions' => array('Comment.user_id' => $user['User']['id'])
        ));
        $this->loadModel('Metadatum');
        $user['User']['metadataCount'] = $this->Metadatum->find('count', array(
            'conditions' => array('Metadatum.user_username' => $user['User']['username'])
        ));
        $now = new Datetime();
        $created = new Datetime($user['User']['created']);
        $user['User']['monthsCount'] = $created->diff($now)->m + ($created->diff($now)->y*12);
        $user['User']['totalCount'] = $user['User']['annotationsCount'] + $user['User']['commentsCount'] + $user['User']['metadataCount'] + $user['User']['months'];
        $user['User']['activeSince'] = $created->format('F Y');

        if (!$user) {
            throw new NotFoundException();
        }
        $this->set('isAdmin', $this->Access->isAdmin());
        $this->set('user_info', $user);
    }

    /**
     * Return an array containing values from the users.name column, for
     * autocompletion purposes. Responds only to ajax requests.
     */
    public function complete() {
        if (!$this->request->is('get')) throw new MethodNotAllowedException();
        return $this->json(200, $this->User->complete('User.name'));
    }

	/**
     * Send invitiational email
     * @param array data
     * @param token   a valid activation token
     */
	public function sendInviteEmail($data,$token){
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
     * Send email to reset password.
     * @param string email
     * @param string token   a valid password reset token
     * @return void
     */
	public function sendEmailResetPassword($email,$token){
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->viewVars(array(
                    'reset' => $this->baseURL() . '/users/reset_password/' . $token
                ))
		->template('reset_password', 'default')
		->emailFormat('html')
		->subject('Reset Password');
		$Email->to($email);
		$Email->from(array('arcs@arcs.matrix.msu.edu' => 'ARCS'));
		$Email->send();
	}
	
	/**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
	public function display() {
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
}
