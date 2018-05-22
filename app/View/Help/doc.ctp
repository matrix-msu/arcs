<?php
    $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $lastChar = substr($url,-1);
    if ($lastChar != '0' && $lastChar != '1' && $lastChar != '2'){
        echo $this->Session->flash();
        $this->set('index_toolbar', true);
    }
    else{
        echo $this->Session->flash();
        $this->set('index_toolbar', false);

    }
?>

<h1>Uploading</h1>
