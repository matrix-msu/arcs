<?php
/**
 * The MissingControllerView
 */

// Set up environment, like beforeFilter()
// function call in a controller.
$debug = Configure::read('debug');
$this->set([
  'user' => null, 
  'body_class' => 'default',
  'footer' => 'true',
  'debug' => $debug,
  'nobutton' => true
]);
?>


<div>
  <h2>We are very sorry!</h2>
  <p>The page you are trying to view does not exist, please check back later?</p>
</div>



