<?php
namespace tests\presentation\requests\SessionRequestTrait;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::destroySession()
 */
class destroySession extends \BaseUnitTest
{
	public function testBasicDestroySession()
	{
		if (session_status() == PHP_SESSION_ACTIVE) {
			$this->markTestSkipped('PHP7 fucked up sessions');
		}
		$o = new SessionRequest_underTest_destroySession();
		$this->assertNotEquals('', session_id());
		SessionRequest_underTest_destroySession::destroySession();
		$this->assertEquals('', session_id());
		$this->assertEmpty(session_id());
	}
}

class SessionRequest_underTest_destroySession {
	use SessionRequestTrait;
	public function __construct() {
		@session_start();
	}
}
