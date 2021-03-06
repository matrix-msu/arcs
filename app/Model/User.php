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
     * Return a UUID suitable for account activation and reset tokens.
     */
    function getToken() {
        App::uses('String', 'Utility');
        return CakeText::uuid();
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
