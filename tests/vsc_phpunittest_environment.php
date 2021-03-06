<?php
/**
 * @package unit_tests
 * @subpackage PHPUnit
 *
 * Bolierplate code to make PHPUnit play nice with vsc *
 */

$_GET		= array ('cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123);
$_POST		= array ('postone' => 'are', 'ana' => '');
$_COOKIE	= array ('user' => 'asddsasdad234');

$_SERVER	= array (
	'SERVER_SOFTWARE' => 'lighttpd',
	'PHP_SELF' => '/',
	'REQUEST_URI' => '/test/ana:are/test:123/',
	'HTTP_ACCEPT' => 'application/html,text/html;charset=UTF8,image/*',
	'REQUEST_TIME' => time()
);

if (!defined('VSC_PATH')) {
	define ( 'VSC_PATH', realpath( dirname (__FILE__) . '/../') . DIRECTORY_SEPARATOR );
	define ( 'VSC_SRC_PATH', VSC_PATH . 'src' . DIRECTORY_SEPARATOR);
	set_include_path (VSC_PATH . PATH_SEPARATOR . get_include_path());
	require_once ('vsc.inc.php');
	require_once ('BaseUnitTest.php');
}

if (defined ('VSC_TEST_PATH') && !defined ('VSC_MOCK_PATH')) {
	define ('VSC_MOCK_PATH', VSC_TEST_PATH . 'mocks' . DIRECTORY_SEPARATOR);
}

date_default_timezone_set('UTC');
chdir(dirname(__FILE__) . '/../');
// Composer autoloading.
if ( file_exists('vendor/autoload.php') ) {
	$loader = include_once 'vendor/autoload.php';
} else {
	throw new RuntimeException('Unable to load the autoloader. Run `php composer.phar install`.');
}
