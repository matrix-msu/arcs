<?php

$username = isset($user['username'])
            ? $user['username']
            : "(Error) No Username";

$project = isset($project)
           ? $project
           : "Invalid Project";

$project = str_replace("_", " ", $project);
$project = ucwords($project)
?>

<p>User "<?=$username?>" has request access to the project "<?=$project?>"

<p>To permit the user to the project, visit the associated kora installation dashboard.<br>
