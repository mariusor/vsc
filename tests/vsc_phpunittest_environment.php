<?php
/**
 * @package unit_tests
 * @subpackage PHPUnit
 *
 * Bolierplate code to make PHPUnit play nice with vsc *
 */

if (!defined('VSC_PATH')) {
	define ( 'VSC_PATH', realpath( dirname (__FILE__) . '/../') . DIRECTORY_SEPARATOR );
	define ( 'VSC_RES_PATH', VSC_PATH . 'res' . DIRECTORY_SEPARATOR);
	set_include_path (VSC_PATH . PATH_SEPARATOR . get_include_path());
	require ('vsc.inc.php');
}

if (defined ('VSC_TEST_PATH') && !defined ('VSC_FIXTURE_PATH')) {
	define ('VSC_FIXTURE_PATH', VSC_TEST_PATH . 'fixtures' . DIRECTORY_SEPARATOR);
}


chdir(dirname(__FILE__) . '/../');
// Composer autoloading.
if ( file_exists('vendor/autoload.php') ) {
    $loader = include_once 'vendor/autoload.php';
} else {
	throw new RuntimeException('Unable to load the autoloader. Run `php composer.phar install`.');
}
