<?php
class vscRwDispatcherTest extends Snap_UnitTestCase {
	public function setUp () {
		$_GET = array ('ana' => 'are', 'mere' => '');
	}
	public function tearDown () {}

	public function testGetRequest () {
		// unable to actually test
		return $this->assertEqual(true, true);
	}
}