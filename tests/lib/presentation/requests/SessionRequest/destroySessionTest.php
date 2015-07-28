<?php
namespace tests\lib\presentation\requests\SessionRequest;
use vsc\presentation\requests\SessionRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequest::destroySession()
 */
class destroySession extends \PHPUnit_Framework_TestCase
{
	public function testBasicDestroySession()
	{
		$o = new SessionRequest_underTest_destroySession();
		$this->assertNotEquals('', session_id());
		@SessionRequest_underTest_destroySession::destroySession();
		$this->assertEquals('', session_id());
		$this->assertEmpty(session_id());
	}
}

class SessionRequest_underTest_destroySession {
	use SessionRequest;
	public function __construct() {
		@session_start();
	}
}
