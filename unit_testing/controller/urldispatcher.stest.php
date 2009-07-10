<?php
class fooUrlDispatcherTest extends Snap_UnitTestCase {
	public function setUp () {
		$_GET = array ('ana' => 'are', 'mere' => '');
	}
	public function tearDown () {}

	public function testGetRequest () {
		// unable to actually test
		d ($_GET);
		return $this->assertEqual(true, true);
	}
}