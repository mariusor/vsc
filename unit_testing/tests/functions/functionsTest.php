<?php
import ('coreexceptions');

class fooFunctionsTest extends UnitTestCase {

	private $state;

	public function setUp () {
		$this->state = get_include_path();
		set_include_path ('.');
	}

	public function tearDown() {
		set_include_path($this->state);
	}

	public function test_importReturnPath () {
		import ('coreexceptions'); // this should exist at all times

		$this->assertEqual(get_include_path(), '.' . PATH_SEPARATOR . LIB_PATH.'coreexceptions/');
	}

	public function test_importBadPackage () {
		$e = 0;
		$sPackageName = '...';
		try {
			import ($sPackageName);
		} catch (Exception $e) {
			$this->assertIsA($e, 'tsExceptionPackageImport', 'The import function didn\'t throw the correct exception.');
		}
	}
}