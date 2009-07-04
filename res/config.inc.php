<?php
if (!defined ('VSC_PATH')) {
	$sCurrentPath = split(DIRECTORY_SEPARATOR, dirname(__FILE__));
	array_pop($sCurrentPath);
	define ('VSC_PATH', implode(DIRECTORY_SEPARATOR,$sCurrentPath) . DIRECTORY_SEPARATOR);
}

if (!defined ('LIB_PATH'))
	define ('LIB_PATH', VSC_PATH . 'lib' . DIRECTORY_SEPARATOR);
