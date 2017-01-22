<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::hasSession()
 */
class hasSession extends \PHPUnit_Framework_TestCase
{
	public function testHasSession () {
		$this->assertFalse(SessionRequestTrait::hasSession());

		@session_start();
		$this->assertTrue(SessionRequestTrait::hasSession());

		session_destroy();
		$this->assertFalse(SessionRequestTrait::hasSession());
	}
}
