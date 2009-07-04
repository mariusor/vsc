<?php
import ('coreexceptions');

class fooFunctions extends Snap_UnitTestCase {

	private $state;

	public function setUp () {
		$this->state = get_include_path();
		set_include_path (realpath('.'));
	}

	public function tearDown() {
		set_include_path($this->state);
	}

	public function testImportReturnPath () {
		import ('coreexceptions'); // this should exist at all times

		return $this->assertEqual(get_include_path(), realpath('.') . PATH_SEPARATOR . LIB_PATH.'coreexceptions' . DIRECTORY_SEPARATOR);
	}

	public function testImportBadPackage () {
		$e = 0;
		$sPackageName = '...';
		try {
			import ($sPackageName);
		} catch (Exception $e) {
			return $this->assertIsA($e, 'tsExceptionPackageImport', 'The import function didn\'t throw the correct exception.');
		}
	}
}