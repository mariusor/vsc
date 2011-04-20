<?php
$sVersion = phpversion();
$iMajorVersion = (int)substr($sVersion, 0, 1);
$iMinorVersion = (int)substr($sVersion, 2, 1);

if (!defined ('VSC_PATH')) {
	define ('VSC_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
}

if (!defined ('ROOT_MAIL')) {
	define ('ROOT_MAIL', 'root@' . $_SERVER['HTTP_HOST']);
}

require (VSC_PATH . 'res'. DIRECTORY_SEPARATOR .'config.inc.php');
require (VSC_PATH . 'res'. DIRECTORY_SEPARATOR .'functions.inc.php');

import (VSC_LIB_PATH);
import (VSC_RES_PATH);

// including the infrastructure folder
import (VSC_RES_PATH . 'infrastructure');
require ('vsc.class.php');

if ($iMajorVersion < 5 || $iMinorVersion < 3) {
	$sMessage = 'libVSC requires PHP version >= 5.3. Your current version is: ' . $sVersion;

	throw new ErrorException ($sMessage, E_USER_ERROR);
}