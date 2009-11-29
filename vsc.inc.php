<?php
$sVersion = phpversion();
if ((int)substr($sVersion, 0, 1) < 5) {
	$sMessage = 'LibVSC only works for versions of PHP >= 5. Your current version is: ' . $sVersion;
	if ((php_sapi_name() == 'cli')) {
		echo $sMessage . "\n";
		exit (0);
	} else {
		throw new Exception ($sMessage);
	}
}

include ('res/config.inc.php');
include ('res/functions.inc.php');

import (VSC_LIB_PATH);