<?php
if (!defined('VSC_PATH')) {
	define('VSC_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
}
if (!defined('VSC_SRC_PATH')) {
	define('VSC_SRC_PATH', VSC_PATH.'src'.DIRECTORY_SEPARATOR);
}
require_once(VSC_SRC_PATH . 'config.inc.php');
require_once(VSC_SRC_PATH . 'functions.inc.php');

$sVersion = phpversion();
$iMajorVersion = (int)substr($sVersion, 0, 1);
$iMinorVersion = (int)substr($sVersion, 2, 1);
if ($iMajorVersion < 5 || ($iMajorVersion == 6 && $iMinorVersion < 0)) {
	$sMessage = 'libVSC requires PHP version >= 5.5. Your current version is: '.$sVersion;

	throw new ErrorException($sMessage, E_USER_ERROR);
}
