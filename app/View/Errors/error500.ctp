<?php
/**
 * The MissingControllerView
 */

echo $this->Html->meta ( 'favicon.ico', '/favicon.ico', array (
    'type' => 'icon'
) );

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


<div class="errormsg">
  <h2>We are very sorry!</h2>
  <p>Unfortunately, the page you are trying to view does not exist.</p>
  <p>Please double check your URL or head to the <a href="<?= "//" . $_SERVER["HTTP_HOST"] . "/" . BASE_URL; ?>">Home Page</a>.</p>
</div>

<script type="text/javascript">
  var icon = arcs.baseURL + '/favicon.ico';
  $('head').append('<link rel="shortcut icon" href="'+icon+'" />');
</script>
