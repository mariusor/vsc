<?php
namespace tests\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::hasSession()
 */
class hasSession extends \BaseUnitTest
{
	public function testHasSession () {
		$this->assertFalse(SessionRequestTrait::hasSession());

		@session_start();
		$this->assertTrue(SessionRequestTrait::hasSession());

		session_destroy();
		$this->assertFalse(SessionRequestTrait::hasSession());
	}
}
