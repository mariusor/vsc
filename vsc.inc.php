<?php
if (!defined ('VSC_PATH')) {
	define ('VSC_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
}

require (VSC_PATH . 'res'. DIRECTORY_SEPARATOR .'config.inc.php');
require (VSC_PATH . 'res'. DIRECTORY_SEPARATOR .'functions.inc.php');

$sVersion = phpversion();
$iMajorVersion = (int)substr($sVersion, 0, 1);
$iMinorVersion = (int)substr($sVersion, 2, 1);
if ($iMajorVersion < 5 || $iMinorVersion < 3) {
	$sMessage = 'libVSC requires PHP version >= 5.3. Your current version is: ' . $sVersion;

	throw new ErrorException ($sMessage, E_USER_ERROR);
} else {
	import (VSC_LIB_PATH);
	import (VSC_RES_PATH);

	// including the infrastructure folder
	import ('infrastructure');
	require ('vsc.class.php');
}
if (!defined ('ROOT_MAIL')) {
	if (!isCli()) {
		define ('ROOT_MAIL', 'root@' . $_SERVER['HTTP_HOST']);
	} else {
		define ('ROOT_MAIL', 'root@localhost');
	}
}
