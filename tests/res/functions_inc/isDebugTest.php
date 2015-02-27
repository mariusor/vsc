<?php
namespace res\functions_inc;


class isDebugTest extends \PHPUnit_Framework_TestCase {

	public function testIsDebug () {
		$this->assertTrue (\vsc\isDebug());
	}
}
