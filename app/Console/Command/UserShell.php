<?php
class UserShell extends AppShell {
      public $uses = array('User');

      public function reset () {
      	     $username = $this->in('Enter username to reset password for:');
	     $user = $this->User->findByUsername($username);
	     if ($user === false) {
	     	$this->out('User not found');
		return;	     
	     }
	     $new_pw = $this->in('New password: ');
	     
	     $confirm_pw = $this->in('Confirm password: ');

	     if ($new_pw != $confirm_pw) {
	     	$this->out('Password does not match.');
		return;
	     }
	     $data['User']['id'] = $user['User']['id'];
	     $data['User']['password'] = $new_pw;
	     if ($this->User->save($data)) {
	     	$this->out('Password saved.');
	     } else {
	        $this->out('Unable to save password.');
             }
     } 
	     
	     
		
}