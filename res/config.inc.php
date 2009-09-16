<?php
if (!defined ('VSC_PATH')) {
	define ('VSC_PATH', realpath(dirname(__FILE__) . '/..') . DIRECTORY_SEPARATOR);
}

if (!defined ('VSC_LIB_PATH'))
	define ('VSC_LIB_PATH', VSC_PATH . 'lib' . DIRECTORY_SEPARATOR);

if (!defined ('VSC_RES_PATH'))
	define ('VSC_RES_PATH', VSC_PATH . 'res' . DIRECTORY_SEPARATOR);
