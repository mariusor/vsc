<?php
namespace tests\lib\presentation\requests\SessionT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\SessionT::startSession()
 */
class startSession extends \PHPUnit_Framework_TestCase
{
	protected function tearDown() {
		@session_destroy();
	}

	public function testUseless()
	{
		$sSessionId = uniqid('test:');
		@HttpRequestA::startSession($sSessionId);
		$this->assertEquals($sSessionId, session_id());
	}
}
