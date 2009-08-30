<?php
class fooFunctions extends Snap_UnitTestCase {

	private $state;

	public function setUp () {
		$this->state = get_include_path();
		set_include_path ('.');
	}

	public function tearDown() {
		set_include_path($this->state);
	}

	public function testImportReturnPath () {
		import ('coreexceptions'); // this should exist at all times
		$sTestPath = LIB_PATH . 'coreexceptions' . DIRECTORY_SEPARATOR . PATH_SEPARATOR . '.';

		return $this->assertEqual (get_include_path(), $sTestPath);
	}

	public function testImportBadPackage () {
		$e = 0;
		$sPackageName = '...';
		try {
			import ($sPackageName);
		} catch (Exception $e) {
			return $this->assertIsA($e, 'vscExceptionPackageImport', 'The import function didn\'t throw the correct exception.');
		}
	}
}