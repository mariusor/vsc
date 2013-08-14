<?php
class functions extends PHPUnit_Framework_TestCase {

	private $state;

	public function setUp () {
		$this->state = get_include_path();
	}

	public function tearDown() {
		set_include_path($this->state);
	}

	/**
	 * This tests the importing of a package without exceptions
	 * @return unknown_type
	 */
	public function testImportWithOutExceptionsReturnPath () {
		set_include_path ('.');
		import (VSC_LIB_PATH); // this should exist at all times
		$sTestPath = substr (VSC_LIB_PATH,0,-1). PATH_SEPARATOR . '.';
		
		$this->assertEquals (get_include_path(), $sTestPath);
	}

//
//	public function testImportWithExceptionsReturnPath () {
//		return $this->todo('some problems with the exceptions importing');
//		set_include_path ('.');
//		import (VSC_LIB_PATH); // this should exist at all times
//		import ('application/sitemaps'); // this should exist at all times and have exceptions
//		$sTestPath = VSC_LIB_PATH . 'application/sitemaps'. PATH_SEPARATOR . substr (VSC_LIB_PATH,0,-1).PATH_SEPARATOR.'.';
//		return $this->assertEqual (get_include_path(), $sTestPath);
//	}

	public function testImportBadPackage () {
		$e = 0;
		$sPackageName = '...';
		try {
			import ($sPackageName);
		} catch (Exception $e) {
			return $this->assertInstanceOf ('vscExceptionPackageImport', $e, 'The import function didn\'t throw the correct exception.');
		}
	}
}