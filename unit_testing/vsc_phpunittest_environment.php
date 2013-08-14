<?php
/**
 * @package unit_tests
 * @subpackage PHPUnit
 * 
 * Bolierplate code to make PHPUnit play nice with vsc * 
 */


define ( 'VSC_PATH', realpath( dirname (__FILE__) . '/../') . DIRECTORY_SEPARATOR );

set_include_path (VSC_PATH . PATH_SEPARATOR . get_include_path());

require ('vsc.inc.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

// d (getPaths());
define ('PHPUNIT_PATH', '/usr/share/pear/PHPUnit/');

set_include_path (PHPUNIT_PATH . PATH_SEPARATOR . get_include_path());
require (PHPUNIT_PATH . 'Autoload.php');
