<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequest::hasSession()
 */
class hasSession extends \PHPUnit_Framework_TestCase
{
	public function testHasSession () {
		$this->assertFalse(SessionRequest::hasSession());

		@session_start();
		$this->assertTrue(SessionRequest::hasSession());

		session_destroy();
		$this->assertFalse(SessionRequest::hasSession());
	}
}
