<?php

// Move to test directory
chdir("../../vendors/TestSuite/");

$cmd = "phpunit --testdox --configuration phpunit.xml --testsuite AllTests --testdox-html test.html";

echo file_get_contents("test.html");
