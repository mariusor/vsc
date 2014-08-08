<?php
class functionsTest extends \PHPUnit_Framework_TestCase {

	private $state;

	public function setUp () {
		$this->state = get_include_path();
	}

	public function tearDown() {
		set_include_path($this->state);
	}

	public function testIsDebug () {
		$this->assertTrue (\vsc\isDebug());
	}

}
