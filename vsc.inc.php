<?php
if (PHP_MAJOR_VERSION < 5) {
	echo 'LibVSC only works for versions of PHP >= 5. Your current version is: ' . phpversion() . nl();
	exit (0);
}
include ('res/config.inc.php');
include ('res/functions.inc.php');