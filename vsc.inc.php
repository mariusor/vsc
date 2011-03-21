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
if (!defined ('VSC_PATH')) {
	define ('VSC_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
}

require (VSC_PATH . 'res'. DIRECTORY_SEPARATOR .'config.inc.php');
require (VSC_PATH . 'res'. DIRECTORY_SEPARATOR .'functions.inc.php');

import (VSC_LIB_PATH);
import (VSC_RES_PATH);

// including the infrastructure folder
import ('infrastructure');
include_once ('vsc.class.php');