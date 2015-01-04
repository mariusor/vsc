<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::hasSession()
 */
class hasSession extends \PHPUnit_Framework_TestCase
{
	public function testHasSession () {
		$this->assertFalse(HttpRequestA::hasSession());

		@session_start();
		$this->assertTrue(HttpRequestA::hasSession());

		session_destroy();
		$this->assertFalse(HttpRequestA::hasSession());
	}
}
