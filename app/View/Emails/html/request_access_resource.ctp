<?php

$username = isset($user['username'])
            ? $user['username']
            : "(Error) No Username";

$project = isset($project)
           ? $project
           : "Invalid Project";

$resource = isset($resource)
          ? $resource
          : "Invalid KID";

?>

<p>User "<?=$username?>" has request access to the resource "<?=$resource?>"
  on project "<?=$project?>"
<p>To permit the user to the project, visit the associated kora installation dashboard.<br>
