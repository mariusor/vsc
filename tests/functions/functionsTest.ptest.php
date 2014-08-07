<?php
class functionsTest extends \PHPUnit_Framework_TestCase {

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
		\vsc\import (VSC_LIB_PATH); // this should exist at all times
		$sTestPath = '.' . PATH_SEPARATOR . substr (VSC_LIB_PATH,0,-1);

		$this->assertEquals (get_include_path(), $sTestPath);
	}


	public function testImportWithExceptionsReturnPath () {
		$this->markTestSkipped('Dropping exceptions in separate folder');
		set_include_path ('.');
		\vsc\import (VSC_LIB_PATH); // this should exist at all times
		$sLocalPackage = 'exceptions';
		try {
			\vsc\import ($sLocalPackage); // this should exist at all times and have exceptions
		} catch (Exception $e) {

		}
		$sTestPath = '.' . PATH_SEPARATOR . substr (VSC_LIB_PATH,0,-1) . PATH_SEPARATOR . VSC_LIB_PATH . $sLocalPackage;
		return $this->assertEquals ($sTestPath, get_include_path());
	}

	public function testImportBadPackage () {
		$e = 0;
		$sPackageName = uniqid(':#~');
		try {
			\vsc\import ($sPackageName);
		} catch (\Exception $e) {
			return $this->assertInstanceOf ('\\vsc\\vscExceptionPackageImport', $e, 'The import function didn\'t throw the correct exception.');
		}
	}
}
