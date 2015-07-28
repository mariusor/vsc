<?php
namespace tests\lib\presentation\requests\SessionRequest;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequest::startSession()
 */
class startSession extends \PHPUnit_Framework_TestCase
{
	protected function tearDown() {
		@session_destroy();
	}

	public function testUseless()
	{
		$sSessionId = uniqid('test:');
		@SessionRequest::startSession($sSessionId);
		$this->assertEquals($sSessionId, session_id());
	}
}
