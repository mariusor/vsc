<?php
class vscPHPUnitTest extends PHPUnit_Framework_TestCase {

	public function __construct () {
		// this file resides in <vsc_dir>/unit_tests and we require the path to <vsc_dir>
		set_include_path (realpath (dirname(__FILE__) . '/../') . PATH_SEPARATOR . get_include_path());
		require ('vsc.inc.php');

// 		error_reporting(E_ALL);
// 		ini_set('display_errors', '1');
	}
}